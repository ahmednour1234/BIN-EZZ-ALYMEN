<div>
    {{-- Page Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-primary-700">طلب تحويل مخزون جديد</h1>
        <p class="text-sm text-gray-500 mt-1">إنشاء طلب تحويل منتجات بين الفروع</p>
    </div>

    <div class="bg-card rounded-2xl shadow-sm border border-primary-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-bold text-primary-700">بيانات التحويل</h3>
        </div>

        <form wire:submit="save" class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- From Branch --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        من فرع <span class="text-red-500">*</span>
                    </label>
                    <select wire:model.live="from_branch_id"
                        class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition-all text-sm {{ $errors->has('from_branch_id') ? 'border-red-400 ring-1 ring-red-300' : '' }}">
                        <option value="">-- اختر الفرع --</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                    </select>
                    @error('from_branch_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- To Branch --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        إلى فرع <span class="text-red-500">*</span>
                    </label>
                    <select wire:model="to_branch_id"
                        class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition-all text-sm {{ $errors->has('to_branch_id') ? 'border-red-400 ring-1 ring-red-300' : '' }}">
                        <option value="">-- اختر الفرع --</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                    </select>
                    @error('to_branch_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Notes --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">ملاحظات</label>
                <textarea wire:model="notes" rows="2"
                    class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition-all text-sm"
                    placeholder="ملاحظات إضافية..."></textarea>
            </div>

            {{-- Items --}}
            <div class="mt-6 pt-6 border-t border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-primary-700">المنتجات المراد تحويلها</h3>
                    <button type="button" wire:click="addItem" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-primary-700 bg-primary-50 rounded-lg hover:bg-primary-100 transition-colors">
                        <x-icon name="plus" class="w-3.5 h-3.5" />
                        إضافة منتج
                    </button>
                </div>

                @error('items') <p class="text-red-500 text-xs mb-3">{{ $message }}</p> @enderror

                <div class="space-y-3">
                    @foreach($items as $index => $item)
                        <div class="flex items-start gap-3 bg-gray-50 rounded-xl p-4 border border-gray-100">
                            <div class="flex-1">
                                <label class="block text-xs text-gray-500 mb-1">المنتج</label>
                                <select wire:model="items.{{ $index }}.product_id"
                                    class="w-full px-3 py-2 border border-gray-200 rounded-lg bg-white text-sm">
                                    <option value="">-- اختر --</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">
                                            {{ $product->name }} (متاح: {{ $product->branches->first()?->pivot->quantity ?? 0 }} {{ $product->unit->symbol ?? '' }})
                                        </option>
                                    @endforeach
                                </select>
                                @error("items.{$index}.product_id") <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="w-40">
                                <label class="block text-xs text-gray-500 mb-1">الكمية</label>
                                <div class="relative">
                                    <input type="number" wire:model="items.{{ $index }}.quantity" min="1"
                                        class="w-full px-3 py-2 pl-14 border border-gray-200 rounded-lg bg-white text-sm">
                                    @php
                                        $selectedProduct = $products->firstWhere('id', $item['product_id'] ?? null);
                                    @endphp
                                    @if($selectedProduct && $selectedProduct->unit)
                                        <span class="absolute left-2 top-1/2 -translate-y-1/2 text-xs font-medium text-primary-600 bg-primary-50 px-1.5 py-0.5 rounded">{{ $selectedProduct->unit->symbol }}</span>
                                    @endif
                                </div>
                                @error("items.{$index}.quantity") <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            @if(count($items) > 1)
                                <button type="button" wire:click="removeItem({{ $index }})" class="mt-6 p-2 text-red-500 hover:bg-red-50 rounded-lg">
                                    <x-icon name="trash" class="w-4 h-4" />
                                </button>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3 mt-6 pt-6 border-t border-gray-100">
                <x-button type="submit" variant="primary">
                    إرسال طلب التحويل
                </x-button>
                <x-button variant="secondary" href="{{ route('stock-transfers.index') }}">
                    إلغاء
                </x-button>
            </div>
        </form>
    </div>
</div>
