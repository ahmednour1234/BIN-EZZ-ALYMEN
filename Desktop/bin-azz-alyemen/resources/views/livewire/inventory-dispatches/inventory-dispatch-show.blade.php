<div>
    {{-- Page Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-primary-700">تفاصيل أمر الصرف #{{ $dispatch->id }}</h1>
            <p class="text-sm text-gray-500 mt-1">عرض تفاصيل أمر الصرف المخزني</p>
        </div>
        <x-button variant="secondary" href="{{ route('inventory-dispatches.index') }}">
            رجوع
        </x-button>
    </div>

    {{-- Info Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-card rounded-2xl shadow-sm border border-primary-100 p-5">
            <p class="text-xs text-gray-500 mb-1">الفرع</p>
            <p class="text-lg font-bold text-primary-700">{{ $dispatch->branch->name }}</p>
        </div>
        <div class="bg-card rounded-2xl shadow-sm border border-primary-100 p-5">
            <p class="text-xs text-gray-500 mb-1">المندوب</p>
            <p class="text-lg font-bold text-primary-700">{{ $dispatch->delegate->name }}</p>
        </div>
        <div class="bg-card rounded-2xl shadow-sm border border-primary-100 p-5">
            <p class="text-xs text-gray-500 mb-1">المسؤول</p>
            <p class="text-lg font-bold text-gray-700">{{ $dispatch->admin->name }}</p>
        </div>
        <div class="bg-card rounded-2xl shadow-sm border border-primary-100 p-5">
            <p class="text-xs text-gray-500 mb-1">الحالة</p>
            @php
                $statusColors = [
                    'pending' => 'text-gray-700',
                    'dispatched' => 'text-blue-700',
                    'partial_return' => 'text-orange-700',
                    'returned' => 'text-yellow-700',
                    'settled' => 'text-green-700',
                ];
            @endphp
            <p class="text-lg font-bold {{ $statusColors[$dispatch->status] ?? 'text-gray-700' }}">{{ $dispatch->status_label }}</p>
        </div>
    </div>

    {{-- Financial Summary --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-red-50 rounded-2xl border border-red-100 p-5 text-center">
            <p class="text-xs text-red-500 mb-1">إجمالي التكلفة</p>
            <p class="text-2xl font-bold text-red-700" dir="ltr">{{ number_format($dispatch->total_cost, 2) }}</p>
        </div>
        <div class="bg-blue-50 rounded-2xl border border-blue-100 p-5 text-center">
            <p class="text-xs text-blue-500 mb-1">المبيعات المتوقعة</p>
            <p class="text-2xl font-bold text-blue-700" dir="ltr">{{ number_format($dispatch->expected_sales, 2) }}</p>
        </div>
        <div class="bg-green-50 rounded-2xl border border-green-100 p-5 text-center">
            <p class="text-xs text-green-500 mb-1">المبيعات الفعلية</p>
            <p class="text-2xl font-bold text-green-700" dir="ltr">{{ number_format($dispatch->actual_sales, 2) }}</p>
        </div>
    </div>

    {{-- Items Table --}}
    <div class="bg-card rounded-2xl shadow-sm border border-primary-100 overflow-hidden mb-6">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-bold text-primary-700">الأصناف</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-primary-50">
                    <tr>
                        <th class="px-6 py-3 text-right text-xs font-bold text-primary-700">المنتج</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-primary-700">الكمية</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-primary-700">سعر التكلفة</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-primary-700">سعر البيع</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-primary-700">المرتجع</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-primary-700">المباع</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($dispatch->items as $item)
                        <tr class="hover:bg-primary-50/50">
                            <td class="px-6 py-4 font-medium text-gray-800">{{ $item->product->name }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $item->quantity }}</td>
                            <td class="px-6 py-4 text-gray-600" dir="ltr">{{ number_format($item->cost_price, 2) }}</td>
                            <td class="px-6 py-4 text-gray-600" dir="ltr">{{ number_format($item->selling_price, 2) }}</td>
                            <td class="px-6 py-4 text-orange-600 font-medium">{{ $item->returned_quantity }}</td>
                            <td class="px-6 py-4 text-green-600 font-bold">{{ $item->sold_quantity }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Actions --}}
    @if(auth('admin')->user()?->hasPermission('inventory-dispatches.edit'))
        <div class="flex items-center gap-3 mb-6">
            @if(in_array($dispatch->status, ['dispatched', 'partial_return']))
                <x-button type="button" variant="secondary" wire:click="toggleReturnForm">
                    {{ $showReturnForm ? 'إخفاء نموذج المرتجع' : 'تسجيل مرتجعات' }}
                </x-button>
            @endif
            @if(in_array($dispatch->status, ['dispatched', 'partial_return', 'returned']))
                <x-button type="button" variant="success" wire:click="toggleSettleForm">
                    {{ $showSettleForm ? 'إخفاء نموذج التسوية' : 'تسوية الحساب' }}
                </x-button>
            @endif
        </div>

        {{-- Return Form --}}
        @if($showReturnForm)
            <div class="bg-orange-50 rounded-2xl border border-orange-200 p-6 mb-6">
                <h3 class="text-lg font-bold text-orange-700 mb-4">تسجيل كميات مرتجعة</h3>
                <div class="space-y-3">
                    @foreach($dispatch->items as $item)
                        <div class="flex items-center gap-4 bg-white rounded-xl p-4 border border-orange-100">
                            <span class="flex-1 font-medium text-gray-700">{{ $item->product->name }} (الكمية: {{ $item->quantity }})</span>
                            <div class="w-32">
                                <label class="text-xs text-gray-500">الكمية المرتجعة</label>
                                <input type="number" wire:model="returnQuantities.{{ $item->id }}" min="0" max="{{ $item->quantity }}"
                                    class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm">
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4">
                    <x-button type="button" variant="primary" wire:click="submitReturn">
                        حفظ المرتجعات
                    </x-button>
                </div>
            </div>
        @endif

        {{-- Settle Form --}}
        @if($showSettleForm)
            <div class="bg-green-50 rounded-2xl border border-green-200 p-6 mb-6">
                <h3 class="text-lg font-bold text-green-700 mb-4">تسوية الحساب</h3>
                <div class="max-w-md">
                    <x-form-input
                        label="المبيعات الفعلية"
                        name="actualSales"
                        type="number"
                        wire:model="actualSales"
                        placeholder="0.00"
                        required
                        :error="$errors->first('actualSales')"
                    />
                </div>
                <div class="mt-4">
                    <x-button type="button" variant="success" wire:click="submitSettle">
                        تأكيد التسوية
                    </x-button>
                </div>
            </div>
        @endif
    @endif

    {{-- Notes --}}
    @if($dispatch->notes)
        <div class="bg-card rounded-2xl shadow-sm border border-primary-100 p-6">
            <h3 class="text-lg font-bold text-primary-700 mb-2">ملاحظات</h3>
            <p class="text-gray-600">{{ $dispatch->notes }}</p>
        </div>
    @endif
</div>
