<div>
    @php $netProfit = $saleOrdersTotal - $saleReturnsTotal - $purchaseTotal + $purchaseReturnsTotal; @endphp

    {{-- ═══════════════ ROW 1: 3 STAT CARDS ═══════════════ --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">

        {{-- Card: إجمالي المبيعات --}}
        <div class="bg-white rounded-2xl shadow-sm p-6 text-right border border-gray-100/80">
            <p class="text-sm text-gray-400 font-medium mb-3">إجمالي المبيعات</p>
            <p class="text-4xl font-extrabold text-primary-700 leading-none">
                {{ number_format($saleOrdersTotal, 0) }}
                <span class="text-xl font-semibold text-primary-400">ر.ي</span>
            </p>
            <p class="text-sm text-gray-400 mt-3">
                المحصّل: <span class="text-green-600 font-bold">{{ number_format($saleOrdersPaid, 0) }} ر.ي</span>
            </p>
        </div>

        {{-- Card: رصيد الخزائن --}}
        <div class="bg-white rounded-2xl shadow-sm p-6 text-right border border-gray-100/80">
            <p class="text-sm text-gray-400 font-medium mb-3">رصيد الخزائن</p>
            <p class="text-4xl font-extrabold text-primary-700 leading-none">
                {{ number_format($totalTreasuryBalance, 0) }}
                <span class="text-xl font-semibold text-primary-400">ر.ي</span>
            </p>
            <p class="text-sm text-gray-400 mt-3">
                {{ $financialTransactionsCount }} معاملة مالية
            </p>
        </div>

        {{-- Card: عهدة المناديب --}}
        <div class="bg-white rounded-2xl shadow-sm p-6 text-right border border-gray-100/80">
            <p class="text-sm text-gray-400 font-medium mb-3">عهدة المناديب</p>
            <p class="text-4xl font-extrabold text-primary-700 leading-none">
                {{ $delegatesCount }}
                <span class="text-xl font-semibold text-primary-400">مندوب</span>
            </p>
            <p class="text-sm text-gray-400 mt-3">
                عهدة نقدية: <span class="text-amber-600 font-bold">{{ number_format($totalDelegatesCustody, 0) }} ر.ي</span>
            </p>
        </div>
    </div>

    {{-- ═══════════════ ROW 2: 3 STAT CARDS ═══════════════ --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">

        {{-- Card: طلبات المبيعات --}}
        <div class="bg-white rounded-2xl shadow-sm p-6 text-right border border-gray-100/80">
            <p class="text-sm text-gray-400 font-medium mb-3">طلبات المبيعات</p>
            <p class="text-5xl font-extrabold text-primary-700 leading-none">
                {{ $saleOrdersCount }}
            </p>
            <p class="text-sm text-gray-400 mt-3">
                {{ $pendingSaleOrdersCount }} <span class="text-amber-600 font-semibold">بانتظار التأكيد</span>
            </p>
        </div>

        {{-- Card: المشتريات --}}
        <div class="bg-white rounded-2xl shadow-sm p-6 text-right border border-gray-100/80">
            <p class="text-sm text-gray-400 font-medium mb-3">إجمالي المشتريات</p>
            <p class="text-4xl font-extrabold text-primary-700 leading-none">
                {{ number_format($purchaseTotal, 0) }}
                <span class="text-xl font-semibold text-primary-400">ر.ي</span>
            </p>
            <p class="text-sm text-gray-400 mt-3">
                {{ $unpaidPurchasesCount }} <span class="text-red-500 font-semibold">فاتورة غير مسددة</span>
            </p>
        </div>

        {{-- Card: قيمة المخزون --}}
        <div class="bg-white rounded-2xl shadow-sm p-6 text-right border border-gray-100/80">
            <p class="text-sm text-gray-400 font-medium mb-3">قيمة المخزون</p>
            <p class="text-4xl font-extrabold text-primary-700 leading-none">
                {{ number_format($totalStockValue, 0) }}
                <span class="text-xl font-semibold text-primary-400">ر.ي</span>
            </p>
            <p class="text-sm text-gray-400 mt-3">
                {{ $productsCount }} منتج &bull;
                @if($lowStockCount > 0)
                    <span class="text-red-500 font-semibold">{{ $lowStockCount }} منخفض</span>
                @else
                    <span class="text-green-600">جميع المنتجات كافية</span>
                @endif
            </p>
        </div>
    </div>

    {{-- ═══════════════ BOTTOM: ALERTS + TABLE ═══════════════ --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-4">

        {{-- LEFT: Alerts + Summary (2/5) --}}
        <div class="lg:col-span-2 flex flex-col gap-4">

            {{-- تنبيهات مهمة --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-5">
                <h3 class="text-base font-extrabold text-gray-700 mb-4 text-right">تنبيهات مهمة</h3>
                <div class="space-y-2.5">

                    @if($lowStockCount > 0)
                    <div class="bg-red-50 border border-red-100 rounded-xl px-4 py-3 text-right">
                        <p class="text-sm text-red-700 font-medium">يوجد {{ $lowStockCount }} منتج مخزونه منخفض</p>
                    </div>
                    @endif

                    @if($pendingSaleOrdersCount > 0)
                    <div class="bg-amber-50 border border-amber-100 rounded-xl px-4 py-3 text-right">
                        <p class="text-sm text-amber-700 font-medium">{{ $pendingSaleOrdersCount }} طلب مبيعات بانتظار التأكيد</p>
                    </div>
                    @endif

                    @if($unpaidPurchasesCount > 0)
                    <div class="bg-orange-50 border border-orange-100 rounded-xl px-4 py-3 text-right">
                        <p class="text-sm text-orange-700 font-medium">{{ $unpaidPurchasesCount }} فاتورة مشتريات لم تُسدَّد بالكامل</p>
                    </div>
                    @endif

                    @if($saleOrdersRemaining > 0)
                    <div class="bg-blue-50 border border-blue-100 rounded-xl px-4 py-3 text-right">
                        <p class="text-sm text-blue-700 font-medium">مبالغ غير محصّلة: <span class="font-bold">{{ number_format($saleOrdersRemaining, 0) }} ر.ي</span></p>
                    </div>
                    @endif

                    @if($lowStockCount === 0 && $pendingSaleOrdersCount === 0 && $unpaidPurchasesCount === 0 && $saleOrdersRemaining <= 0)
                    <div class="bg-green-50 border border-green-100 rounded-xl px-4 py-3 text-right">
                        <p class="text-sm text-green-700 font-medium">لا توجد تنبيهات — كل شيء على ما يرام</p>
                    </div>
                    @endif

                </div>
            </div>

            {{-- ملخص التشغيل (dark box) --}}
            <div class="bg-primary-800 rounded-2xl p-5 text-right shadow-md">
                <h3 class="text-base font-extrabold text-white mb-4">ملخص التشغيل</h3>
                <ul class="space-y-2.5 text-sm">
                    <li class="flex items-center justify-between text-white/80">
                        <span class="text-white font-bold">{{ $confirmedSaleOrdersCount }}</span>
                        <span>أوامر المبيعات المؤكدة</span>
                    </li>
                    <li class="flex items-center justify-between text-white/80">
                        <span class="text-white font-bold">{{ number_format($saleOrdersPaid, 0) }} ر.ي</span>
                        <span>إجمالي المحصّل</span>
                    </li>
                    <li class="flex items-center justify-between text-white/80">
                        <span class="text-white font-bold">{{ $purchaseCount }}</span>
                        <span>فواتير المشتريات</span>
                    </li>
                    <li class="flex items-center justify-between text-white/80">
                        <span class="text-white font-bold">{{ number_format($purchasePaid, 0) }} ر.ي</span>
                        <span>مدفوع للموردين</span>
                    </li>
                    <li class="flex items-center justify-between text-white/80 pt-2 border-t border-white/10">
                        <span class="text-white font-bold">{{ number_format($totalTreasuryBalance, 0) }} ر.ي</span>
                        <span>رصيد الخزائن</span>
                    </li>
                    <li class="flex items-center justify-between text-white/80">
                        <span class="{{ $netProfit >= 0 ? 'text-green-400' : 'text-red-400' }} font-bold">{{ number_format($netProfit, 0) }} ر.ي</span>
                        <span>صافي الربح التقديري</span>
                    </li>
                </ul>
            </div>

        </div>

        {{-- RIGHT: Delegates Performance (3/5) --}}
        <div class="lg:col-span-3 bg-white rounded-2xl shadow-sm border border-gray-100/80 overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                <span class="bg-primary-100 text-primary-700 text-xs font-bold px-3 py-1 rounded-full">اليوم</span>
                <h3 class="text-base font-extrabold text-gray-700">أداء المناديب</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-right">
                    <thead>
                        <tr class="bg-gray-50/70 border-b border-gray-100">
                            <th class="px-5 py-3 text-xs font-bold text-gray-400 text-right">المندوب</th>
                            <th class="px-4 py-3 text-xs font-bold text-gray-400 text-right">المبيعات</th>
                            <th class="px-4 py-3 text-xs font-bold text-gray-400 text-right">التحصيلات</th>
                            <th class="px-4 py-3 text-xs font-bold text-gray-400 text-right">الحالة</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($delegatesPerformance as $delegate)
                        <tr class="hover:bg-gray-50/60 transition-colors">
                            <td class="px-5 py-3.5 font-bold text-gray-800">{{ $delegate->name }}</td>
                            <td class="px-4 py-3.5 text-gray-600">
                                {{ number_format($delegate->total_due, 0) }}
                                <span class="text-xs text-gray-400">ر.ي</span>
                            </td>
                            <td class="px-4 py-3.5 text-gray-600">
                                {{ number_format($delegate->total_collected, 0) }}
                                <span class="text-xs text-gray-400">ر.ي</span>
                            </td>
                            <td class="px-4 py-3.5">
                                @if($delegate->is_active)
                                    <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 text-xs font-semibold px-3 py-1 rounded-full">
                                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                                        نشط
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 bg-amber-100 text-amber-700 text-xs font-semibold px-3 py-1 rounded-full">
                                        <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span>
                                        بحاجة متابعة
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-5 py-12 text-center text-gray-300 text-sm">لا يوجد مناديب نشطون</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{-- Recent sale orders below delegates --}}
            @if($recentSaleOrders->isNotEmpty())
            <div class="border-t border-gray-100 px-5 pt-4 pb-3">
                <div class="flex items-center justify-between mb-3">
                    <a href="{{ route('sale-orders.index') }}" class="text-xs text-primary-600 hover:underline font-medium">عرض الكل</a>
                    <h4 class="text-sm font-bold text-gray-600">أحدث الطلبات</h4>
                </div>
                <div class="space-y-2">
                    @foreach($recentSaleOrders->take(3) as $order)
                    @php
                        $sc = ['draft'=>['bg-gray-100','text-gray-600','مسودة'],'confirmed'=>['bg-blue-100','text-blue-700','مؤكد'],'partial_paid'=>['bg-yellow-100','text-yellow-700','جزئي'],'paid'=>['bg-green-100','text-green-700','مدفوع'],'cancelled'=>['bg-red-100','text-red-600','ملغي']];
                        $s = $sc[$order->status] ?? ['bg-gray-100','text-gray-600',$order->status];
                    @endphp
                    <div class="flex items-center justify-between py-2 px-1">
                        <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $s[0] }} {{ $s[1] }}">{{ $s[2] }}</span>
                        <div class="text-right">
                            <span class="text-xs font-bold text-primary-700 font-mono">{{ $order->order_number }}</span>
                            <span class="text-xs text-gray-400 mx-1">—</span>
                            <span class="text-xs text-gray-500">{{ $order->customer?->name ?? '—' }}</span>
                        </div>
                        <span class="text-sm font-bold text-gray-700">{{ number_format($order->total_amount, 0) }} <span class="text-xs text-gray-400 font-normal">ر.ي</span></span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

    </div>

    {{-- ═══════════════ CHARTS ═══════════════ --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mt-6">
        <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100/80 shadow-sm p-5">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs text-gray-400 bg-gray-50 rounded-xl px-3 py-1 border border-gray-100">آخر 6 أشهر</span>
                <h3 class="text-sm font-bold text-gray-700">المبيعات والمشتريات</h3>
            </div>
            <canvas id="salesPurchasesChart" height="100"></canvas>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100/80 shadow-sm p-5">
            <h3 class="text-sm font-bold text-gray-700 text-right mb-4">حالة طلبات المبيعات</h3>
            <canvas id="saleStatusChart" height="160"></canvas>
        </div>
    </div>

    {{-- ═══════════════ SYSTEM COUNTS ═══════════════ --}}
    <div class="grid grid-cols-3 sm:grid-cols-6 gap-3 mt-4">
        @foreach([
            ['العملاء', $customersCount],
            ['الموردون', $suppliersCount],
            ['المناديب', $delegatesCount],
            ['المدراء', $adminsCount],
            ['التصنيفات', $categoriesCount],
            ['المركبات', $vehiclesCount],
        ] as [$label, $count])
        <div class="bg-white rounded-2xl border border-gray-100/80 shadow-sm p-4 text-center hover:shadow-md hover:-translate-y-0.5 transition-all">
            <p class="text-2xl font-extrabold text-primary-700">{{ $count }}</p>
            <p class="text-xs text-gray-400 mt-1">{{ $label }}</p>
        </div>
        @endforeach
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
    <script>
        (function() {
            const ctx = document.getElementById('salesPurchasesChart');
            if (!ctx) return;
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($chartLabels),
                    datasets: [
                        { label: 'المبيعات', data: @json($chartSales), backgroundColor: 'rgba(120,85,45,0.75)', borderRadius: 8, borderSkipped: false },
                        { label: 'المشتريات', data: @json($chartPurchases), backgroundColor: 'rgba(180,150,110,0.65)', borderRadius: 8, borderSkipped: false }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { position: 'bottom', labels: { font: { size: 11 }, padding: 14 } } },
                    scales: {
                        x: { grid: { display: false }, ticks: { font: { size: 11 } } },
                        y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.04)' }, ticks: { font: { size: 11 } } }
                    }
                }
            });
        })();
        (function() {
            const ctx = document.getElementById('saleStatusChart');
            if (!ctx) return;
            const statusData = @json($saleStatusCounts);
            const labelMap = { draft: 'مسودة', confirmed: 'مؤكد', partial_paid: 'جزئي', paid: 'مدفوع', cancelled: 'ملغي' };
            const colorMap = { draft: '#d1d5db', confirmed: '#93c5fd', partial_paid: '#fcd34d', paid: '#6ee7b7', cancelled: '#fca5a5' };
            const keys = Object.keys(statusData);
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: keys.map(k => labelMap[k] || k),
                    datasets: [{ data: Object.values(statusData), backgroundColor: keys.map(k => colorMap[k] || '#e5e7eb'), borderWidth: 3, borderColor: '#fff' }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { position: 'bottom', labels: { font: { size: 11 }, padding: 10 } } },
                    cutout: '70%'
                }
            });
        })();
    </script>
    @endpush
</div>