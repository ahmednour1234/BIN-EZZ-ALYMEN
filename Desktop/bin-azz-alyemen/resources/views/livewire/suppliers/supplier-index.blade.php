<div>
    {{-- Page Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-primary-700">إدارة الموردين</h1>
            <p class="text-sm text-gray-500 mt-1">عرض وإدارة جميع الموردين</p>
        </div>
        @if(auth('admin')->user()?->hasPermission('suppliers.create'))
            <x-button variant="primary" href="{{ route('suppliers.create') }}">
                <x-icon name="plus" class="w-4 h-4" />
                إضافة مورد
            </x-button>
        @endif
    </div>

    {{-- Search --}}
    <div class="bg-card rounded-2xl shadow-sm border border-primary-100 p-4 mb-6">
        <div class="relative">
            <x-icon name="search" class="w-5 h-5 text-gray-400 absolute right-3 top-1/2 -translate-y-1/2" />
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="بحث بالاسم أو الهاتف أو الشركة أو الرقم الضريبي..."
                class="w-full pr-10 pl-4 py-3 border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition-all text-sm">
        </div>
    </div>

    {{-- Table --}}
    <x-data-table :headers="['#', 'المورد', 'الهاتف', 'الشركة', 'الرقم الضريبي', 'الحد الائتماني', 'الرصيد الافتتاحي', 'الحالة', 'الإجراءات']">
        @forelse($suppliers as $supplier)
            <tr class="hover:bg-primary-50/50 transition-colors">
                <td class="px-6 py-4 text-gray-500">{{ $supplier->id }}</td>
                <td class="px-6 py-4">
                    <div>
                        <p class="font-medium text-gray-800">{{ $supplier->name }}</p>
                        @if($supplier->email)
                            <p class="text-xs text-gray-400" dir="ltr">{{ $supplier->email }}</p>
                        @endif
                    </div>
                </td>
                <td class="px-6 py-4 text-gray-600 text-sm" dir="ltr">{{ $supplier->phone ?? '—' }}</td>
                <td class="px-6 py-4 text-gray-600 text-sm">{{ $supplier->company_name ?? '—' }}</td>
                <td class="px-6 py-4 text-gray-600 text-sm" dir="ltr">{{ $supplier->tax_number ?? '—' }}</td>
                <td class="px-6 py-4 text-sm font-mono text-center" dir="ltr">{{ number_format($supplier->credit_limit, 2) }}</td>
                <td class="px-6 py-4 text-sm font-mono text-center" dir="ltr">{{ number_format($supplier->opening_balance, 2) }}</td>
                <td class="px-6 py-4">
                    @if($supplier->is_active)
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">نشط</span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">معطل</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        @if(auth('admin')->user()?->hasPermission('suppliers.edit'))
                            <button wire:click="toggleActive({{ $supplier->id }})"
                                class="p-2 {{ $supplier->is_active ? 'text-orange-600 hover:bg-orange-50' : 'text-green-600 hover:bg-green-50' }} rounded-lg transition-colors"
                                title="{{ $supplier->is_active ? 'تعطيل' : 'تفعيل' }}">
                                @if($supplier->is_active)
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" /></svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                                @endif
                            </button>
                            <a href="{{ route('suppliers.edit', $supplier) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="تعديل">
                                <x-icon name="pencil" class="w-4 h-4" />
                            </a>
                        @endif
                        @if(auth('admin')->user()?->hasPermission('suppliers.delete'))
                            <button wire:click="delete({{ $supplier->id }})" wire:confirm="هل أنت متأكد من حذف هذا المورد؟" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="حذف">
                                <x-icon name="trash" class="w-4 h-4" />
                            </button>
                        @endif
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9" class="px-6 py-12 text-center text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 mx-auto mb-3 text-gray-300"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0H6.375c-.621 0-1.125-.504-1.125-1.125V14.25m17.25 0V4.125c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v10.125m17.25 0h-1.5m-15.75 0h-1.5" /></svg>
                    <p>لا يوجد موردين مسجلين</p>
                </td>
            </tr>
        @endforelse

        <x-slot:pagination>
            {{ $suppliers->links() }}
        </x-slot:pagination>
    </x-data-table>
</div>
