@php
    $mainLinks = [
        ['route' => 'dashboard', 'icon' => 'home', 'label' => 'الرئيسية', 'permission' => null],
    ];

    $settingsLinks = [
        ['route' => 'branches.index', 'icon' => 'building', 'label' => 'الفروع', 'permission' => 'branches.view'],
        ['route' => 'vehicles.index', 'icon' => 'truck', 'label' => 'المركبات', 'permission' => 'vehicles.view'],
        ['route' => 'categories.index', 'icon' => 'folder', 'label' => 'التصنيفات', 'permission' => 'categories.view'],
        ['route' => 'units.index', 'icon' => 'ruler', 'label' => 'وحدات القياس', 'permission' => 'units.view'],
        ['route' => 'areas.index', 'icon' => 'map-pin', 'label' => 'المناطق', 'permission' => 'areas.view'],
        ['route' => 'customers.index', 'icon' => 'user-circle', 'label' => 'العملاء', 'permission' => 'customers.view'],
        ['route' => 'delegates.index', 'icon' => 'delegate', 'label' => 'المناديب', 'permission' => 'delegates.view'],
        ['route' => 'suppliers.index', 'icon' => 'supplier', 'label' => 'الموردين', 'permission' => 'suppliers.view'],
        ['route' => 'admins.index', 'icon' => 'users', 'label' => 'المدراء', 'permission' => 'admins.view'],
        ['route' => 'roles.index', 'icon' => 'shield', 'label' => 'الأدوار', 'permission' => 'roles.view'],
        ['route' => 'permissions.index', 'icon' => 'key', 'label' => 'الصلاحيات', 'permission' => 'permissions.view'],
        ['route' => 'taxes.index', 'icon' => 'receipt-tax', 'label' => 'الضرائب', 'permission' => 'taxes.view'],
    ];

    $accountingLinks = [
        ['route' => 'accounts.index', 'icon' => 'banknotes', 'label' => 'الحسابات', 'permission' => 'accounts.view'],
        ['route' => 'treasuries.index', 'icon' => 'lock-closed', 'label' => 'الخزن', 'permission' => 'treasuries.view'],
        ['route' => 'treasury-transactions.index', 'icon' => 'arrows-right-left', 'label' => 'حركات الخزن', 'permission' => 'treasury-transactions.view'],
        ['route' => 'financial-transactions.index', 'icon' => 'calculator', 'label' => 'المصروفات والإيرادات', 'permission' => 'financial-transactions.view'],
        ['route' => 'reports.index', 'icon' => 'chart-bar', 'label' => 'التقارير', 'permission' => 'reports.view'],
    ];

    $inventoryLinks = [
        ['route' => 'products.index', 'icon' => 'cube', 'label' => 'المنتجات', 'permission' => 'products.view'],
        ['route' => 'stock-transfers.index', 'icon' => 'arrow-path', 'label' => 'تحويلات المخزون', 'permission' => 'stock-transfers.view'],
        ['route' => 'inventory-dispatches.index', 'icon' => 'clipboard-document-list', 'label' => 'أوامر الصرف', 'permission' => 'inventory-dispatches.view'],
        ['route' => 'product-depreciations.index', 'icon' => 'archive-box-x-mark', 'label' => 'إهلاك المنتجات', 'permission' => 'product-depreciations.view'],
    ];

    $purchaseLinks = [
        ['route' => 'purchase-invoices.index', 'icon' => 'document-text', 'label' => 'فواتير المشتريات', 'permission' => 'purchase-invoices.view'],
        ['route' => 'purchase-returns.index', 'icon' => 'arrow-uturn-left', 'label' => 'مرتجعات المشتريات', 'permission' => 'purchase-returns.view'],
    ];

    $salesLinks = [
        ['route' => 'sale-quotations.index', 'icon' => 'document-text', 'label' => 'عروض الأسعار', 'permission' => 'sale-quotations.view'],
        ['route' => 'sale-orders.index', 'icon' => 'shopping-cart', 'label' => 'طلبات المبيعات', 'permission' => 'sale-orders.view'],
        ['route' => 'sale-returns.index', 'icon' => 'arrow-uturn-left', 'label' => 'مرتجعات المبيعات', 'permission' => 'sale-returns.view'],
    ];

    $branchReportLinks = [
        ['route' => 'reports.branch-inventory', 'icon' => 'chart-bar-square', 'label' => 'تقرير المخازن', 'permission' => 'reports.view'],
        ['route' => 'reports.branch-movements', 'icon' => 'chart-bar-square', 'label' => 'حركة المخزون', 'permission' => 'reports.view'],
    ];

    $installmentLinks = [
        ['route' => 'installments.index', 'icon' => 'credit-card', 'label' => 'التقسيط', 'permission' => 'installments.view'],
    ];

    $settingsActive = collect($settingsLinks)->contains(fn($l) => request()->routeIs($l['route'] . '*'));
    $accountingActive = collect($accountingLinks)->contains(fn($l) => request()->routeIs($l['route'] . '*'));
    $inventoryActive = collect($inventoryLinks)->contains(fn($l) => request()->routeIs($l['route'] . '*'));
    $purchaseActive = collect($purchaseLinks)->contains(fn($l) => request()->routeIs($l['route'] . '*'));
    $salesActive = collect($salesLinks)->contains(fn($l) => request()->routeIs($l['route'] . '*'));
    $branchReportActive = collect($branchReportLinks)->contains(fn($l) => request()->routeIs($l['route'] . '*'));
    $installmentActive = collect($installmentLinks)->contains(fn($l) => request()->routeIs($l['route'] . '*'));
@endphp

@php
    $inventoryLinks = [
        ['route' => 'products.index', 'icon' => 'cube', 'label' => 'المنتجات', 'permission' => 'products.view'],
        ['route' => 'stock-transfers.index', 'icon' => 'arrow-path', 'label' => 'تحويلات المخزون', 'permission' => 'stock-transfers.view'],
        ['route' => 'inventory-dispatches.index', 'icon' => 'clipboard-document-list', 'label' => 'أوامر الصرف', 'permission' => 'inventory-dispatches.view'],
        ['route' => 'product-depreciations.index', 'icon' => 'archive-box-x-mark', 'label' => 'إهلاك المنتجات', 'permission' => 'product-depreciations.view'],
    ];

    $installmentLinks = [
        ['route' => 'installments.index', 'icon' => 'credit-card', 'label' => 'التقسيط', 'permission' => 'installments.view'],
    ];

    $settingsActive = collect($settingsLinks)->contains(fn($l) => request()->routeIs($l['route'] . '*'));
    $accountingActive = collect($accountingLinks)->contains(fn($l) => request()->routeIs($l['route'] . '*'));
    $inventoryActive = collect($inventoryLinks)->contains(fn($l) => request()->routeIs($l['route'] . '*'));
    $purchaseActive = collect($purchaseLinks)->contains(fn($l) => request()->routeIs($l['route'] . '*'));
    $salesActive = collect($salesLinks)->contains(fn($l) => request()->routeIs($l['route'] . '*'));
    $branchReportActive = collect($branchReportLinks)->contains(fn($l) => request()->routeIs($l['route'] . '*'));
    $installmentActive = collect($installmentLinks)->contains(fn($l) => request()->routeIs($l['route'] . '*'));
@endphp

<aside class="fixed right-0 top-0 h-screen w-[270px] bg-gradient-to-b from-[#6B4F3A] via-[#5a3f2e] to-[#4a3426] text-white flex flex-col z-50 shadow-2xl">
    {{-- Brand --}}
    <div class="px-6 py-5 border-b border-white/10">
        <div class="flex items-center justify-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-white/15 backdrop-blur-sm flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-amber-300">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72M6.75 18h3.75a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75H6.75a.75.75 0 0 0-.75.75v3.75c0 .414.336.75.75.75Z" />
                </svg>
            </div>
            <div>
                <h1 class="text-lg font-bold leading-tight">بن عز اليمن</h1>
                <p class="text-[10px] text-amber-200/60 leading-tight">لوحة إدارة المناديب والمخزون</p>
            </div>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 py-3 overflow-y-auto sidebar-scroll">
        {{-- الرئيسية --}}
        <div class="px-3 mb-1">
            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm transition-all duration-200
                      {{ request()->routeIs('dashboard') ? 'bg-white/20 text-white font-bold shadow-lg shadow-black/10' : 'text-white/75 hover:bg-white/10 hover:text-white' }}">
                <div class="w-8 h-8 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-amber-400/25' : 'bg-white/10' }} flex items-center justify-center flex-shrink-0 transition-colors">
                    <x-icon name="home" class="w-[18px] h-[18px] {{ request()->routeIs('dashboard') ? 'text-amber-300' : '' }}" />
                </div>
                <span>الرئيسية</span>
            </a>
        </div>

        {{-- Divider --}}
        <div class="mx-5 my-2 border-t border-white/8"></div>

        {{-- الإعدادات الأساسية --}}
        <div x-data="{ open: {{ $settingsActive ? 'true' : 'false' }} }" class="px-3 mb-1">
            <button @click="open = !open"
                class="flex items-center justify-between w-full px-4 py-2.5 rounded-xl text-sm transition-all duration-200
                       {{ $settingsActive ? 'bg-white/20 text-white font-bold shadow-lg shadow-black/10' : 'text-white/75 hover:bg-white/10 hover:text-white' }}">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg {{ $settingsActive ? 'bg-amber-400/25' : 'bg-white/10' }} flex items-center justify-center flex-shrink-0">
                        <x-icon name="cog" class="w-[18px] h-[18px] {{ $settingsActive ? 'text-amber-300' : '' }}" />
                    </div>
                    <span>الإعدادات الأساسية</span>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"
                     class="w-3.5 h-3.5 transition-transform duration-300 text-white/50" :class="open ? 'rotate-180' : ''">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                </svg>
            </button>
            <div x-show="open"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 max-h-0"
                 x-transition:enter-end="opacity-100 max-h-[600px]"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 x-cloak
                 class="mt-1 mr-6 border-r-2 border-white/10 pr-2 space-y-0.5">
                @foreach ($settingsLinks as $link)
                    @if (auth('admin')->user()?->hasPermission($link['permission']))
                        <a href="{{ route($link['route']) }}"
                           class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] transition-all duration-200
                                  {{ request()->routeIs($link['route'] . '*') ? 'bg-white/15 text-white font-semibold' : 'text-white/55 hover:bg-white/8 hover:text-white/90' }}">
                            <x-icon :name="$link['icon']" class="w-4 h-4 flex-shrink-0 {{ request()->routeIs($link['route'] . '*') ? 'text-amber-300' : '' }}" />
                            <span>{{ $link['label'] }}</span>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>

        {{-- المحاسبة --}}
        <div x-data="{ open: {{ $accountingActive ? 'true' : 'false' }} }" class="px-3 mb-1">
            <button @click="open = !open"
                class="flex items-center justify-between w-full px-4 py-2.5 rounded-xl text-sm transition-all duration-200
                       {{ $accountingActive ? 'bg-white/20 text-white font-bold shadow-lg shadow-black/10' : 'text-white/75 hover:bg-white/10 hover:text-white' }}">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg {{ $accountingActive ? 'bg-amber-400/25' : 'bg-white/10' }} flex items-center justify-center flex-shrink-0">
                        <x-icon name="banknotes" class="w-[18px] h-[18px] {{ $accountingActive ? 'text-amber-300' : '' }}" />
                    </div>
                    <span>المحاسبة</span>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"
                     class="w-3.5 h-3.5 transition-transform duration-300 text-white/50" :class="open ? 'rotate-180' : ''">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                </svg>
            </button>
            <div x-show="open"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 max-h-0"
                 x-transition:enter-end="opacity-100 max-h-[400px]"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 x-cloak
                 class="mt-1 mr-6 border-r-2 border-white/10 pr-2 space-y-0.5">
                @foreach ($accountingLinks as $link)
                    @if (auth('admin')->user()?->hasPermission($link['permission']))
                        <a href="{{ route($link['route']) }}"
                           class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] transition-all duration-200
                                  {{ request()->routeIs($link['route'] . '*') ? 'bg-white/15 text-white font-semibold' : 'text-white/55 hover:bg-white/8 hover:text-white/90' }}">
                            <x-icon :name="$link['icon']" class="w-4 h-4 flex-shrink-0 {{ request()->routeIs($link['route'] . '*') ? 'text-amber-300' : '' }}" />
                            <span>{{ $link['label'] }}</span>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>

        {{-- المخزون --}}
        <div x-data="{ open: {{ $inventoryActive ? 'true' : 'false' }} }" class="px-3 mb-1">
            <button @click="open = !open"
                class="flex items-center justify-between w-full px-4 py-2.5 rounded-xl text-sm transition-all duration-200
                       {{ $inventoryActive ? 'bg-white/20 text-white font-bold shadow-lg shadow-black/10' : 'text-white/75 hover:bg-white/10 hover:text-white' }}">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg {{ $inventoryActive ? 'bg-amber-400/25' : 'bg-white/10' }} flex items-center justify-center flex-shrink-0">
                        <x-icon name="cube" class="w-[18px] h-[18px] {{ $inventoryActive ? 'text-amber-300' : '' }}" />
                    </div>
                    <span>المخزون</span>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"
                     class="w-3.5 h-3.5 transition-transform duration-300 text-white/50" :class="open ? 'rotate-180' : ''">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                </svg>
            </button>
            <div x-show="open"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 max-h-0"
                 x-transition:enter-end="opacity-100 max-h-[400px]"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 x-cloak
                 class="mt-1 mr-6 border-r-2 border-white/10 pr-2 space-y-0.5">
                @foreach ($inventoryLinks as $link)
                    @if (auth('admin')->user()?->hasPermission($link['permission']))
                        <a href="{{ route($link['route']) }}"
                           class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] transition-all duration-200
                                  {{ request()->routeIs($link['route'] . '*') ? 'bg-white/15 text-white font-semibold' : 'text-white/55 hover:bg-white/8 hover:text-white/90' }}">
                            <x-icon :name="$link['icon']" class="w-4 h-4 flex-shrink-0 {{ request()->routeIs($link['route'] . '*') ? 'text-amber-300' : '' }}" />
                            <span>{{ $link['label'] }}</span>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>

        {{-- المشتريات --}}
        <div x-data="{ open: {{ $purchaseActive ? 'true' : 'false' }} }" class="px-3 mb-1">
            <button @click="open = !open"
                class="flex items-center justify-between w-full px-4 py-2.5 rounded-xl text-sm transition-all duration-200
                       {{ $purchaseActive ? 'bg-white/20 text-white font-bold shadow-lg shadow-black/10' : 'text-white/75 hover:bg-white/10 hover:text-white' }}">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg {{ $purchaseActive ? 'bg-amber-400/25' : 'bg-white/10' }} flex items-center justify-center flex-shrink-0">
                        <x-icon name="document-text" class="w-[18px] h-[18px] {{ $purchaseActive ? 'text-amber-300' : '' }}" />
                    </div>
                    <span>المشتريات</span>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"
                     class="w-3.5 h-3.5 transition-transform duration-300 text-white/50" :class="open ? 'rotate-180' : ''">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                </svg>
            </button>
            <div x-show="open"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 max-h-0"
                 x-transition:enter-end="opacity-100 max-h-[400px]"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 x-cloak
                 class="mt-1 mr-6 border-r-2 border-white/10 pr-2 space-y-0.5">
                @foreach ($purchaseLinks as $link)
                    @if (auth('admin')->user()?->hasPermission($link['permission']))
                        <a href="{{ route($link['route']) }}"
                           class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] transition-all duration-200
                                  {{ request()->routeIs($link['route'] . '*') ? 'bg-white/15 text-white font-semibold' : 'text-white/55 hover:bg-white/8 hover:text-white/90' }}">
                            <x-icon :name="$link['icon']" class="w-4 h-4 flex-shrink-0 {{ request()->routeIs($link['route'] . '*') ? 'text-amber-300' : '' }}" />
                            <span>{{ $link['label'] }}</span>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>

        {{-- المبيعات --}}
        <div x-data="{ open: {{ $salesActive ? 'true' : 'false' }} }" class="px-3 mb-1">
            <button @click="open = !open"
                class="flex items-center justify-between w-full px-4 py-2.5 rounded-xl text-sm transition-all duration-200
                       {{ $salesActive ? 'bg-white/20 text-white font-bold shadow-lg shadow-black/10' : 'text-white/75 hover:bg-white/10 hover:text-white' }}">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg {{ $salesActive ? 'bg-amber-400/25' : 'bg-white/10' }} flex items-center justify-center flex-shrink-0">
                        <x-icon name="shopping-cart" class="w-[18px] h-[18px] {{ $salesActive ? 'text-amber-300' : '' }}" />
                    </div>
                    <span>المبيعات</span>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"
                     class="w-3.5 h-3.5 transition-transform duration-300 text-white/50" :class="open ? 'rotate-180' : ''">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                </svg>
            </button>
            <div x-show="open"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 max-h-0"
                 x-transition:enter-end="opacity-100 max-h-[400px]"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 x-cloak
                 class="mt-1 mr-6 border-r-2 border-white/10 pr-2 space-y-0.5">
                @foreach ($salesLinks as $link)
                    @if (auth('admin')->user()?->hasPermission($link['permission']))
                        <a href="{{ route($link['route']) }}"
                           class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] transition-all duration-200
                                  {{ request()->routeIs($link['route'] . '*') ? 'bg-white/15 text-white font-semibold' : 'text-white/55 hover:bg-white/8 hover:text-white/90' }}">
                            <x-icon :name="$link['icon']" class="w-4 h-4 flex-shrink-0 {{ request()->routeIs($link['route'] . '*') ? 'text-amber-300' : '' }}" />
                            <span>{{ $link['label'] }}</span>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>

        {{-- التقسيط --}}
        @if(collect($installmentLinks)->filter(fn($l) => auth('admin')->user()?->hasPermission($l['permission']))->isNotEmpty())
        <div class="px-3 mb-1">
            @foreach($installmentLinks as $link)
                @if(auth('admin')->user()?->hasPermission($link['permission']))
                    <a href="{{ route($link['route']) }}"
                       class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm transition-all duration-200
                              {{ $installmentActive ? 'bg-white/20 text-white font-bold shadow-lg shadow-black/10' : 'text-white/75 hover:bg-white/10 hover:text-white' }}">
                        <div class="w-8 h-8 rounded-lg {{ $installmentActive ? 'bg-amber-400/25' : 'bg-white/10' }} flex items-center justify-center flex-shrink-0">
                            <x-icon name="credit-card" class="w-[18px] h-[18px] {{ $installmentActive ? 'text-amber-300' : '' }}" />
                        </div>
                        <span>{{ $link['label'] }}</span>
                    </a>
                @endif
            @endforeach
        </div>
        @endif

        {{-- تقارير المخازن --}}
        <div x-data="{ open: {{ $branchReportActive ? 'true' : 'false' }} }" class="px-3 mb-1">
            <button @click="open = !open"
                class="flex items-center justify-between w-full px-4 py-2.5 rounded-xl text-sm transition-all duration-200
                       {{ $branchReportActive ? 'bg-white/20 text-white font-bold shadow-lg shadow-black/10' : 'text-white/75 hover:bg-white/10 hover:text-white' }}">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg {{ $branchReportActive ? 'bg-amber-400/25' : 'bg-white/10' }} flex items-center justify-center flex-shrink-0">
                        <x-icon name="chart-bar-square" class="w-[18px] h-[18px] {{ $branchReportActive ? 'text-amber-300' : '' }}" />
                    </div>
                    <span>تقارير المخازن</span>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"
                     class="w-3.5 h-3.5 transition-transform duration-300 text-white/50" :class="open ? 'rotate-180' : ''">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                </svg>
            </button>
            <div x-show="open"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 max-h-0"
                 x-transition:enter-end="opacity-100 max-h-[400px]"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 x-cloak
                 class="mt-1 mr-6 border-r-2 border-white/10 pr-2 space-y-0.5">
                @foreach ($branchReportLinks as $link)
                    @if (auth('admin')->user()?->hasPermission($link['permission']))
                        <a href="{{ route($link['route']) }}"
                           class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] transition-all duration-200
                                  {{ request()->routeIs($link['route'] . '*') ? 'bg-white/15 text-white font-semibold' : 'text-white/55 hover:bg-white/8 hover:text-white/90' }}">
                            <x-icon :name="$link['icon']" class="w-4 h-4 flex-shrink-0 {{ request()->routeIs($link['route'] . '*') ? 'text-amber-300' : '' }}" />
                            <span>{{ $link['label'] }}</span>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </nav>

    {{-- Footer --}}
    <div class="px-4 py-3 border-t border-white/8 text-center">
        <p class="text-[10px] text-white/30">&copy; {{ date('Y') }} بن عز اليمن — جميع الحقوق محفوظة</p>
    </div>
</aside>
