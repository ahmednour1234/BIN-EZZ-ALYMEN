<div>
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-primary-700 tracking-tight">إدارة العملاء</h1>
            <p class="text-sm text-gray-400 mt-0.5">عرض وإدارة جميع العملاء</p>
        </div>
        @if(auth('admin')->user()?->hasPermission('customers.create'))
            <x-button variant="primary" href="{{ route('customers.create') }}">
                <x-icon name="plus" class="w-4 h-4" />
                إضافة عميل
            </x-button>
        @endif
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 mb-5">
        <div class="flex flex-wrap gap-3">
            <div class="flex-1 min-w-[200px] relative">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 absolute right-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="بحث بالاسم أو الهاتف أو البريد..."
                    class="w-full pr-9 pl-4 py-2.5 border border-gray-200 rounded-xl bg-gray-50 text-sm focus:bg-white focus:ring-2 focus:ring-primary-300 transition-all">
            </div>
            <select wire:model.live="classificationFilter" class="min-w-[160px] px-4 py-2.5 border border-gray-200 rounded-xl bg-gray-50 text-sm focus:bg-white focus:ring-2 focus:ring-primary-300">
                <option value="">كل التصنيفات</option>
                @foreach($classificationLabels as $key => $label)
                    <option value="{{ $key }}">{{ $label }}</option>
                @endforeach
            </select>
            <select wire:model.live="areaFilter" class="min-w-[160px] px-4 py-2.5 border border-gray-200 rounded-xl bg-gray-50 text-sm focus:bg-white focus:ring-2 focus:ring-primary-300">
                <option value="">كل المناطق</option>
                @foreach($areas as $area)
                    <option value="{{ $area->id }}">{{ $area->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Card Rows --}}
    <div class="space-y-2.5">
        @forelse($customers as $customer)
            @php
                $classColors = [
                    'premium' => ['from-yellow-400','to-amber-500','border-amber-300','bg-amber-100 text-amber-700'],
                    'medium'  => ['from-blue-400','to-blue-600','border-blue-300','bg-blue-100 text-blue-700'],
                    'regular' => ['from-gray-400','to-gray-500','border-gray-300','bg-gray-100 text-gray-600'],
                ];
                $cc = $classColors[$customer->classification] ?? $classColors['regular'];
            @endphp
            <div class="flex items-center gap-4 bg-white rounded-2xl border border-gray-100 border-r-4 {{ str_replace('from-','border-r-',$cc[0]) }} shadow-sm px-5 py-4 hover:shadow-md hover:border-gray-200 transition-all group">
                {{-- Avatar --}}
                <div class="w-11 h-11 rounded-xl bg-gradient-to-br {{ $cc[0] }} {{ $cc[1] }} flex items-center justify-center text-white font-extrabold text-base flex-shrink-0 shadow-sm">
                    {{ mb_substr($customer->name, 0, 1) }}
                </div>
                {{-- Name --}}
                <div class="w-44 min-w-0">
                    <p class="font-bold text-gray-800 truncate text-sm">{{ $customer->name }}</p>
                    <p class="text-xs text-gray-400 truncate" dir="ltr">{{ $customer->email ?? $customer->phone ?? '—' }}</p>
                </div>
                {{-- Phone --}}
                <div class="hidden md:flex flex-col w-32 min-w-0">
                    <p class="text-xs text-gray-400 mb-0.5">الهاتف</p>
                    <p class="text-sm text-gray-700 font-medium" dir="ltr">{{ $customer->phone ?? '—' }}</p>
                </div>
                {{-- Area --}}
                <div class="hidden lg:flex flex-col w-28 min-w-0">
                    <p class="text-xs text-gray-400 mb-0.5">المنطقة</p>
                    <p class="text-sm text-gray-600 truncate">{{ $customer->area?->name ?? '—' }}</p>
                </div>
                {{-- Classification --}}
                <div class="hidden md:block">
                    <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold {{ $cc[3] }}">
                        {{ $classificationLabels[$customer->classification] ?? $customer->classification }}
                    </span>
                </div>
                {{-- Credit --}}
                <div class="hidden xl:flex flex-col w-32 min-w-0">
                    <p class="text-xs text-gray-400 mb-0.5">الحد الائتماني</p>
                    <p class="text-sm font-semibold text-gray-700" dir="ltr">{{ number_format($customer->credit_limit, 0) }}</p>
                </div>
                {{-- Status --}}
                <div class="flex-1 flex justify-end">
                    @if($customer->is_active)
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500 inline-block"></span>نشط
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-600">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-400 inline-block"></span>معطل
                        </span>
                    @endif
                </div>
                {{-- Actions --}}
                <div class="flex items-center gap-1.5 flex-shrink-0">
                    @if(auth('admin')->user()?->hasPermission('customers.edit'))
                        <button wire:click="toggleActive({{ $customer->id }})"
                            class="w-8 h-8 rounded-lg {{ $customer->is_active ? 'bg-orange-50 text-orange-600 hover:bg-orange-100' : 'bg-green-50 text-green-600 hover:bg-green-100' }} flex items-center justify-center transition-colors"
                            title="{{ $customer->is_active ? 'تعطيل' : 'تفعيل' }}">
                            @if($customer->is_active)
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" /></svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                            @endif
                        </button>
                        <a href="{{ route('customers.edit', $customer) }}"
                            class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 flex items-center justify-center transition-colors" title="تعديل">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125" /></svg>
                        </a>
                    @endif
                    @if(auth('admin')->user()?->hasPermission('customers.delete'))
                        <button wire:click="delete({{ $customer->id }})" wire:confirm="هل أنت متأكد من حذف هذا العميل؟"
                            class="w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 flex items-center justify-center transition-colors" title="حذف">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg>
                        </button>
                    @endif
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl border border-gray-100 py-16 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-14 h-14 mx-auto mb-3 text-gray-200" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" /></svg>
                <p class="text-gray-400 text-sm">لا يوجد عملاء مسجلون</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($customers->hasPages())
        <div class="mt-4">{{ $customers->links() }}</div>
    @endif
</div>