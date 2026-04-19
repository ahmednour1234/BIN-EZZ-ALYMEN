<div>
    {{-- Page Header --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-primary-700">لوحة التحكم الرئيسية</h1>
        <p class="text-sm text-gray-500 mt-1">تصميم عربي واضح وسهل الاستخدام لشركة بن عز اليمن</p>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <x-stat-card
            :value="$branchesCount"
            label="الفروع"
            icon="building"
            color="primary"
        />
        <x-stat-card
            :value="$vehiclesCount"
            label="المركبات"
            icon="truck"
            color="orange"
        />
        <x-stat-card
            :value="$categoriesCount"
            label="التصنيفات"
            icon="folder"
            color="blue"
        />
        <x-stat-card
            :value="$unitsCount"
            label="وحدات القياس"
            icon="ruler"
            color="green"
        />
        <x-stat-card
            :value="$adminsCount"
            label="المدراء"
            icon="users"
            color="primary"
        />
        <x-stat-card
            :value="$rolesCount"
            label="الأدوار"
            icon="shield"
            color="green"
        />
        <x-stat-card
            :value="$permissionsCount"
            label="الصلاحيات"
            icon="key"
            color="yellow"
        />
        <x-stat-card
            :value="$areasCount"
            label="المناطق"
            icon="map-pin"
            color="primary"
        />
        <x-stat-card
            :value="$customersCount"
            label="العملاء"
            icon="user-circle"
            color="blue"
        />
        <x-stat-card
            :value="$delegatesCount"
            label="المناديب"
            icon="delegate"
            color="orange"
        />
        <x-stat-card
            :value="$suppliersCount"
            label="الموردين"
            icon="supplier"
            color="green"
        />
        <x-stat-card
            :value="$accountsCount"
            label="الحسابات"
            icon="banknotes"
            color="primary"
        />
        <x-stat-card
            :value="$treasuriesCount"
            label="الخزن"
            icon="lock-closed"
            color="orange"
        />
        <x-stat-card
            :value="$financialTransactionsCount"
            label="المعاملات المالية"
            icon="calculator"
            color="blue"
        />
    </div>

    {{-- Quick Actions --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Quick Links --}}
        <div class="bg-card rounded-2xl shadow-sm border border-primary-100 p-6">
            <h3 class="text-lg font-bold text-primary-700 mb-4">إجراءات سريعة</h3>
            <div class="grid grid-cols-2 gap-3">
                @if(auth('admin')->user()?->hasPermission('branches.create'))
                    <a href="{{ route('branches.create') }}" class="flex items-center gap-3 p-4 rounded-xl bg-primary-50 hover:bg-primary-100 border border-primary-200 transition-colors group">
                        <x-icon name="building" class="w-5 h-5 text-primary-600" />
                        <span class="text-sm font-medium text-primary-700">إضافة فرع</span>
                    </a>
                @endif
                @if(auth('admin')->user()?->hasPermission('admins.create'))
                    <a href="{{ route('admins.create') }}" class="flex items-center gap-3 p-4 rounded-xl bg-blue-50 hover:bg-blue-100 border border-blue-200 transition-colors group">
                        <x-icon name="users" class="w-5 h-5 text-blue-600" />
                        <span class="text-sm font-medium text-blue-700">إضافة مدير</span>
                    </a>
                @endif
                @if(auth('admin')->user()?->hasPermission('roles.create'))
                    <a href="{{ route('roles.create') }}" class="flex items-center gap-3 p-4 rounded-xl bg-green-50 hover:bg-green-100 border border-green-200 transition-colors group">
                        <x-icon name="shield" class="w-5 h-5 text-green-600" />
                        <span class="text-sm font-medium text-green-700">إضافة دور</span>
                    </a>
                @endif
                @if(auth('admin')->user()?->hasPermission('permissions.view'))
                    <a href="{{ route('permissions.index') }}" class="flex items-center gap-3 p-4 rounded-xl bg-yellow-50 hover:bg-yellow-100 border border-yellow-200 transition-colors group">
                        <x-icon name="key" class="w-5 h-5 text-yellow-600" />
                        <span class="text-sm font-medium text-yellow-700">الصلاحيات</span>
                    </a>
                @endif
            </div>
        </div>

        {{-- System Info --}}
        <div class="bg-primary-600 rounded-2xl shadow-sm p-6 text-white">
            <h3 class="text-lg font-bold mb-4">ملخص التشغيل</h3>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between items-center">
                    <span class="text-white/70">عدد الفروع المسجلة</span>
                    <span class="font-bold">{{ $branchesCount }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-white/70">عدد المدراء النشطين</span>
                    <span class="font-bold">{{ $adminsCount }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-white/70">عدد الأدوار المتاحة</span>
                    <span class="font-bold">{{ $rolesCount }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-white/70">إجمالي الصلاحيات</span>
                    <span class="font-bold">{{ $permissionsCount }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
