<div>
    {{-- Page Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-primary-700">إدارة العملاء</h1>
            <p class="text-sm text-gray-500 mt-1">عرض وإدارة جميع العملاء</p>
        </div>
        @if(auth('admin')->user()?->hasPermission('customers.create'))
            <x-button variant="primary" href="{{ route('customers.create') }}">
                <x-icon name="plus" class="w-4 h-4" />
                إضافة عميل
            </x-button>
        @endif
    </div>

    {{-- Filters --}}
    <div class="bg-card rounded-2xl shadow-sm border border-primary-100 p-4 mb-6">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="flex-1 relative">
                <x-icon name="search" class="w-5 h-5 text-gray-400 absolute right-3 top-1/2 -translate-y-1/2" />
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="بحث بالاسم أو الهاتف أو البريد..."
                    class="w-full pr-10 pl-4 py-3 border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition-all text-sm">
            </div>
            <div class="w-full md:w-48">
                <select wire:model.live="classificationFilter"
                    class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition-all text-sm">
                    <option value="">كل التصنيفات</option>
                    @foreach($classificationLabels as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-full md:w-48">
                <select wire:model.live="areaFilter"
                    class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition-all text-sm">
                    <option value="">كل المناطق</option>
                    @foreach($areas as $area)
                        <option value="{{ $area->id }}">{{ $area->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <x-data-table :headers="['#', 'الاسم', 'الهاتف', 'المنطقة', 'التصنيف', 'الحد الائتماني', 'الرصيد الافتتاحي', 'الحالة', 'الإجراءات']">
        @forelse($customers as $customer)
            <tr class="hover:bg-primary-50/50 transition-colors">
                <td class="px-6 py-4 text-gray-500">{{ $customer->id }}</td>
                <td class="px-6 py-4">
                    <div>
                        <p class="font-medium text-gray-800">{{ $customer->name }}</p>
                        @if($customer->email)
                            <p class="text-xs text-gray-400" dir="ltr">{{ $customer->email }}</p>
                        @endif
                    </div>
                </td>
                <td class="px-6 py-4 text-gray-600 text-sm" dir="ltr">{{ $customer->phone ?? '—' }}</td>
                <td class="px-6 py-4 text-gray-600 text-sm">{{ $customer->area?->name ?? '—' }}</td>
                <td class="px-6 py-4">
                    @php
                        $classColors = [
                            'premium' => 'bg-yellow-100 text-yellow-700',
                            'regular' => 'bg-gray-100 text-gray-700',
                            'medium' => 'bg-blue-100 text-blue-700',
                        ];
                    @endphp
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $classColors[$customer->classification] ?? 'bg-gray-100 text-gray-700' }}">
                        {{ $classificationLabels[$customer->classification] ?? $customer->classification }}
                    </span>
                </td>
                <td class="px-6 py-4 text-sm font-mono text-center" dir="ltr">{{ number_format($customer->credit_limit, 2) }}</td>
                <td class="px-6 py-4 text-sm font-mono text-center" dir="ltr">{{ number_format($customer->opening_balance, 2) }}</td>
                <td class="px-6 py-4">
                    @if($customer->is_active)
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">نشط</span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">معطل</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        @if(auth('admin')->user()?->hasPermission('customers.edit'))
                            <button wire:click="toggleActive({{ $customer->id }})"
                                class="p-2 {{ $customer->is_active ? 'text-orange-600 hover:bg-orange-50' : 'text-green-600 hover:bg-green-50' }} rounded-lg transition-colors"
                                title="{{ $customer->is_active ? 'تعطيل' : 'تفعيل' }}">
                                @if($customer->is_active)
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" /></svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                                @endif
                            </button>
                            <a href="{{ route('customers.edit', $customer) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="تعديل">
                                <x-icon name="pencil" class="w-4 h-4" />
                            </a>
                        @endif
                        @if(auth('admin')->user()?->hasPermission('customers.delete'))
                            <button wire:click="delete({{ $customer->id }})" wire:confirm="هل أنت متأكد من حذف هذا العميل؟" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="حذف">
                                <x-icon name="trash" class="w-4 h-4" />
                            </button>
                        @endif
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9" class="px-6 py-12 text-center text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 mx-auto mb-3 text-gray-300"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" /></svg>
                    <p>لا يوجد عملاء مسجلين</p>
                </td>
            </tr>
        @endforelse

        <x-slot:pagination>
            {{ $customers->links() }}
        </x-slot:pagination>
    </x-data-table>
</div>
