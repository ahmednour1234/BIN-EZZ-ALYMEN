<?php

namespace App\Livewire\InventoryDispatches;

use App\Services\InventoryDispatchService;
use Livewire\Component;

class InventoryDispatchShow extends Component
{
    public int $dispatchId;
    public array $returnQuantities = [];
    public string $actualSales = '';
    public bool $showReturnForm = false;
    public bool $showSettleForm = false;

    public function mount(int $id, InventoryDispatchService $service)
    {
        $this->dispatchId = $id;
        $dispatch = $service->getById($id);

        foreach ($dispatch->items as $item) {
            $this->returnQuantities[$item->id] = 0;
        }
    }

    public function toggleReturnForm()
    {
        $this->showReturnForm = !$this->showReturnForm;
        $this->showSettleForm = false;
    }

    public function toggleSettleForm()
    {
        $this->showSettleForm = !$this->showSettleForm;
        $this->showReturnForm = false;
    }

    public function submitReturn(InventoryDispatchService $service)
    {
        $admin = auth('admin')->user();
        if (!$admin->hasPermission('inventory-dispatches.edit')) {
            session()->flash('error', 'ليس لديك صلاحية التعديل');
            return;
        }

        try {
            $service->returnItems($this->dispatchId, $this->returnQuantities);
            session()->flash('success', 'تم تسجيل المرتجعات بنجاح');
            $this->showReturnForm = false;
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function submitSettle(InventoryDispatchService $service)
    {
        $admin = auth('admin')->user();
        if (!$admin->hasPermission('inventory-dispatches.edit')) {
            session()->flash('error', 'ليس لديك صلاحية التعديل');
            return;
        }

        $this->validate([
            'actualSales' => 'required|numeric|min:0',
        ], [
            'actualSales.required' => 'المبيعات الفعلية مطلوبة',
        ]);

        try {
            $service->settleDispatch($this->dispatchId, (float) $this->actualSales);
            session()->flash('success', 'تمت تسوية أمر الصرف بنجاح');
            $this->showSettleForm = false;
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function render(InventoryDispatchService $service)
    {
        return view('livewire.inventory-dispatches.inventory-dispatch-show', [
            'dispatch' => $service->getById($this->dispatchId),
        ]);
    }
}
