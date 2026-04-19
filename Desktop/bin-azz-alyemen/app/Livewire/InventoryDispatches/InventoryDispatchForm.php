<?php

namespace App\Livewire\InventoryDispatches;

use App\Models\Branch;
use App\Models\Delegate;
use App\Models\Product;
use App\Services\InventoryDispatchService;
use Livewire\Component;

class InventoryDispatchForm extends Component
{
    public ?int $branch_id = null;
    public ?int $delegate_id = null;
    public string $notes = '';
    public string $date = '';
    public array $items = [];

    public function mount()
    {
        $admin = auth('admin')->user();
        if ($admin->branch_id) {
            $this->branch_id = $admin->branch_id;
        }
        $this->date = now()->format('Y-m-d');
        $this->addItem();
    }

    public function addItem()
    {
        $this->items[] = ['product_id' => '', 'quantity' => 1, 'cost_price' => '0', 'selling_price' => '0'];
    }

    public function removeItem(int $index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    public function updatedItems($value, $key)
    {
        // Auto-fill prices when product is selected
        $parts = explode('.', $key);
        if (count($parts) === 2 && $parts[1] === 'product_id' && $value) {
            $product = Product::find($value);
            if ($product) {
                $index = $parts[0];
                $this->items[$index]['cost_price'] = (string) $product->cost_price;
                $this->items[$index]['selling_price'] = (string) $product->selling_price;
            }
        }
    }

    protected function rules(): array
    {
        return [
            'branch_id' => 'required|exists:branches,id',
            'delegate_id' => 'required|exists:delegates,id',
            'date' => 'required|date',
            'notes' => 'nullable|string|max:500',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.cost_price' => 'required|numeric|min:0',
            'items.*.selling_price' => 'required|numeric|min:0',
        ];
    }

    protected function messages(): array
    {
        return [
            'branch_id.required' => 'الفرع مطلوب',
            'delegate_id.required' => 'المندوب مطلوب',
            'date.required' => 'التاريخ مطلوب',
            'items.required' => 'يجب إضافة منتج واحد على الأقل',
            'items.*.product_id.required' => 'يجب اختيار المنتج',
            'items.*.quantity.required' => 'الكمية مطلوبة',
        ];
    }

    public function save(InventoryDispatchService $service)
    {
        $this->validate();

        $admin = auth('admin')->user();

        $service->createDispatch([
            'branch_id' => $this->branch_id,
            'delegate_id' => $this->delegate_id,
            'admin_id' => $admin->id,
            'date' => $this->date,
            'notes' => $this->notes ?: null,
        ], $this->items);

        session()->flash('success', 'تم إنشاء أمر الصرف بنجاح');
        return redirect()->route('inventory-dispatches.index');
    }

    public function render()
    {
        $products = collect();
        if ($this->branch_id) {
            $products = Product::whereHas('branches', function ($q) {
                $q->where('branch_id', $this->branch_id)->where('quantity', '>', 0);
            })->with(['unit', 'branches' => function ($q) {
                $q->where('branch_id', $this->branch_id);
            }])->where('is_active', true)->get();
        }

        return view('livewire.inventory-dispatches.inventory-dispatch-form', [
            'branches' => Branch::where('is_active', true)->get(),
            'delegates' => Delegate::where('is_active', true)->get(),
            'products' => $products,
        ]);
    }
}
