<?php

namespace App\Livewire\StockTransfers;

use App\Models\Branch;
use App\Models\Product;
use App\Services\StockTransferService;
use Livewire\Component;

class StockTransferForm extends Component
{
    public ?int $from_branch_id = null;
    public ?int $to_branch_id = null;
    public string $notes = '';
    public array $items = [];

    public function mount()
    {
        $admin = auth('admin')->user();
        if ($admin->branch_id) {
            $this->from_branch_id = $admin->branch_id;
        }
        $this->addItem();
    }

    public function addItem()
    {
        $this->items[] = ['product_id' => '', 'quantity' => 1];
    }

    public function removeItem(int $index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    protected function rules(): array
    {
        return [
            'from_branch_id' => 'required|exists:branches,id',
            'to_branch_id' => 'required|exists:branches,id|different:from_branch_id',
            'notes' => 'nullable|string|max:500',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ];
    }

    protected function messages(): array
    {
        return [
            'from_branch_id.required' => 'فرع المصدر مطلوب',
            'to_branch_id.required' => 'فرع الوجهة مطلوب',
            'to_branch_id.different' => 'فرع الوجهة يجب أن يختلف عن المصدر',
            'items.required' => 'يجب إضافة منتج واحد على الأقل',
            'items.*.product_id.required' => 'يجب اختيار المنتج',
            'items.*.quantity.required' => 'الكمية مطلوبة',
            'items.*.quantity.min' => 'الكمية يجب أن تكون 1 على الأقل',
        ];
    }

    public function save(StockTransferService $service)
    {
        $this->validate();

        $admin = auth('admin')->user();

        $service->createTransfer([
            'from_branch_id' => $this->from_branch_id,
            'to_branch_id' => $this->to_branch_id,
            'requested_by' => $admin->id,
            'status' => 'pending',
            'notes' => $this->notes ?: null,
        ], $this->items);

        session()->flash('success', 'تم إنشاء طلب التحويل بنجاح');
        return redirect()->route('stock-transfers.index');
    }

    public function render()
    {
        $products = collect();
        if ($this->from_branch_id) {
            $products = Product::whereHas('branches', function ($q) {
                $q->where('branch_id', $this->from_branch_id)->where('quantity', '>', 0);
            })->with(['unit', 'branches' => function ($q) {
                $q->where('branch_id', $this->from_branch_id);
            }])->where('is_active', true)->get();
        }

        return view('livewire.stock-transfers.stock-transfer-form', [
            'branches' => Branch::where('is_active', true)->get(),
            'products' => $products,
        ]);
    }
}
