<?php

namespace App\Livewire;

use App\Models\Admin;
use App\Models\Account;
use App\Models\Area;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Delegate;
use App\Models\FinancialTransaction;
use App\Models\Permission;
use App\Models\Product;
use App\Models\PurchaseInvoice;
use App\Models\PurchaseReturn;
use App\Models\Role;
use App\Models\SaleOrder;
use App\Models\SaleReturn;
use App\Models\Supplier;
use App\Models\Treasury;
use App\Models\Unit;
use App\Models\Vehicle;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        // ── Sales stats ─────────────────────────────────────────────
        $saleOrdersTotal  = SaleOrder::whereNotIn('status', ['cancelled'])->sum('total');
        $saleOrdersPaid   = SaleOrder::whereNotIn('status', ['cancelled'])->sum('paid_amount');
        $saleOrdersCount  = SaleOrder::whereNotIn('status', ['cancelled'])->count();
        $saleReturnsTotal = SaleReturn::whereNotIn('status', ['cancelled'])->sum('refund_amount');

        // ── Purchase stats ───────────────────────────────────────────
        $purchaseTotal      = PurchaseInvoice::whereNotIn('status', ['cancelled'])->sum('total');
        $purchasePaid       = PurchaseInvoice::whereNotIn('status', ['cancelled'])->sum('paid_amount');
        $purchaseCount      = PurchaseInvoice::whereNotIn('status', ['cancelled'])->count();
        $purchaseReturnsTotal = PurchaseReturn::whereNotIn('status', ['cancelled'])->sum('refund_amount');

        // ── Treasury / Accounting stats ──────────────────────────────
        $totalTreasuryBalance = Treasury::where('is_active', true)->sum('balance');
        $financialTransactionsCount = FinancialTransaction::count();
        $accountsCount = Account::count();

        // ── Inventory stats ──────────────────────────────────────────
        $productsCount       = Product::where('is_active', true)->count();
        $lowStockCount       = DB::table('branch_product')
            ->select('product_id')
            ->groupBy('product_id')
            ->havingRaw('SUM(quantity) <= 5')
            ->get()->count();
        $totalStockValue     = DB::table('branch_product')
            ->join('products', 'products.id', '=', 'branch_product.product_id')
            ->sum(DB::raw('branch_product.quantity * products.cost_price'));

        // ── Monthly chart data (last 6 months) ──────────────────────
        $months = collect(range(5, 0))->map(function ($i) {
            return now()->subMonths($i)->format('Y-m');
        });

        $salesByMonth = SaleOrder::whereNotIn('status', ['cancelled'])
            ->where('date', '>=', now()->subMonths(5)->startOfMonth())
            ->selectRaw("strftime('%Y-%m', date) as month, SUM(total) as total")
            ->groupBy('month')
            ->pluck('total', 'month');

        $purchasesByMonth = PurchaseInvoice::whereNotIn('status', ['cancelled'])
            ->where('date', '>=', now()->subMonths(5)->startOfMonth())
            ->selectRaw("strftime('%Y-%m', date) as month, SUM(total) as total")
            ->groupBy('month')
            ->pluck('total', 'month');

        $chartLabels   = $months->map(fn($m) => \Carbon\Carbon::parse($m . '-01')->translatedFormat('M Y'))->values()->toArray();
        $chartSales    = $months->map(fn($m) => round((float)($salesByMonth[$m] ?? 0), 2))->values()->toArray();
        $chartPurchases = $months->map(fn($m) => round((float)($purchasesByMonth[$m] ?? 0), 2))->values()->toArray();

        // ── Recent sale orders ───────────────────────────────────────
        $recentSaleOrders = SaleOrder::with('customer', 'branch')
            ->latest()
            ->take(5)
            ->get();

        // ── Recent purchase invoices ─────────────────────────────────
        $recentPurchaseInvoices = PurchaseInvoice::with('supplier', 'branch')
            ->latest()
            ->take(5)
            ->get();

        // ── Sale orders by status ─────────────────────────────────────
        $saleStatusCounts = SaleOrder::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // ── Delegate performance ─────────────────────────────────────
        $delegatesPerformance = Delegate::where('is_active', true)
            ->orderByDesc('total_collected')
            ->take(6)
            ->get(['id', 'name', 'total_collected', 'total_due', 'cash_custody', 'is_active']);

        $totalDelegatesCustody = Delegate::sum('cash_custody');

        // ── Pending / overdue helpers ────────────────────────────────
        $pendingSaleOrdersCount  = SaleOrder::whereIn('status', ['draft', 'confirmed'])->count();
        $unpaidPurchasesCount    = PurchaseInvoice::whereIn('status', ['confirmed', 'partial_paid'])->count();
        $saleOrdersRemaining     = $saleOrdersTotal - $saleOrdersPaid;
        $purchaseRemaining       = $purchaseTotal - $purchasePaid;
        $confirmedSaleOrdersCount = SaleOrder::where('status', 'confirmed')->count();

        return view('livewire.dashboard', [
            // legacy counts
            'branchesCount'              => Branch::count(),
            'vehiclesCount'              => Vehicle::count(),
            'categoriesCount'            => Category::count(),
            'unitsCount'                 => Unit::count(),
            'adminsCount'                => Admin::count(),
            'rolesCount'                 => Role::count(),
            'permissionsCount'           => Permission::count(),
            'areasCount'                 => Area::count(),
            'customersCount'             => Customer::count(),
            'delegatesCount'             => Delegate::count(),
            'suppliersCount'             => Supplier::count(),
            'treasuriesCount'            => Treasury::count(),
            // sales
            'saleOrdersTotal'            => $saleOrdersTotal,
            'saleOrdersPaid'             => $saleOrdersPaid,
            'saleOrdersCount'            => $saleOrdersCount,
            'saleReturnsTotal'           => $saleReturnsTotal,
            // purchases
            'purchaseTotal'              => $purchaseTotal,
            'purchasePaid'               => $purchasePaid,
            'purchaseCount'              => $purchaseCount,
            'purchaseReturnsTotal'       => $purchaseReturnsTotal,
            // treasury
            'totalTreasuryBalance'       => $totalTreasuryBalance,
            'financialTransactionsCount' => $financialTransactionsCount,
            'accountsCount'              => $accountsCount,
            // inventory
            'productsCount'              => $productsCount,
            'lowStockCount'              => $lowStockCount,
            'totalStockValue'            => $totalStockValue,
            // charts
            'chartLabels'                => $chartLabels,
            'chartSales'                 => $chartSales,
            'chartPurchases'             => $chartPurchases,
            // recent
            'recentSaleOrders'           => $recentSaleOrders,
            'recentPurchaseInvoices'     => $recentPurchaseInvoices,
            'saleStatusCounts'           => $saleStatusCounts,
            // delegates performance
            'delegatesPerformance'       => $delegatesPerformance,
            'totalDelegatesCustody'      => $totalDelegatesCustody,
            // extra helpers
            'pendingSaleOrdersCount'     => $pendingSaleOrdersCount,
            'unpaidPurchasesCount'       => $unpaidPurchasesCount,
            'saleOrdersRemaining'        => $saleOrdersRemaining,
            'purchaseRemaining'          => $purchaseRemaining,
            'confirmedSaleOrdersCount'   => $confirmedSaleOrdersCount,
        ]);
    }
}

