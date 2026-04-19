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
use App\Models\Supplier;
use App\Models\Treasury;
use App\Models\Unit;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Vehicle;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.dashboard', [
            'branchesCount' => Branch::count(),
            'vehiclesCount' => Vehicle::count(),
            'categoriesCount' => Category::count(),
            'unitsCount' => Unit::count(),
            'adminsCount' => Admin::count(),
            'rolesCount' => Role::count(),
            'permissionsCount' => Permission::count(),
            'areasCount' => Area::count(),
            'customersCount' => Customer::count(),
            'delegatesCount' => Delegate::count(),
            'suppliersCount' => Supplier::count(),
            'accountsCount' => Account::count(),
            'treasuriesCount' => Treasury::count(),
            'financialTransactionsCount' => FinancialTransaction::count(),
        ]);
    }
}
