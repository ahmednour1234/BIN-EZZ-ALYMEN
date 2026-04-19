<div>
    {{-- Page Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-primary-700">إدارة الأدوار</h1>
            <p class="text-sm text-gray-500 mt-1">إنشاء وإدارة أدوار المدراء وصلاحياتهم</p>
        </div>
        @if(auth('admin')->user()?->hasPermission('roles.create'))
            <x-button variant="primary" href="{{ route('roles.create') }}">
                <x-icon name="plus" class="w-4 h-4" />
                إضافة دور
            </x-button>
        @endif
    </div>

    {{-- Search --}}
    <div class="bg-card rounded-2xl shadow-sm border border-primary-100 p-4 mb-6">
        <div class="relative">
            <x-icon name="search" class="w-5 h-5 text-gray-400 absolute right-3 top-1/2 -translate-y-1/2" />
            <input
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="بحث بالاسم..."
                class="w-full pr-10 pl-4 py-3 border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition-all text-sm"
            >
        </div>
    </div>

    {{-- Table --}}
    <x-data-table :headers="['#', 'الاسم', 'الاسم المعروض', 'الوصف', 'عدد الصلاحيات', 'عدد المدراء', 'الإجراءات']">
        @forelse($roles as $role)
            <tr class="hover:bg-primary-50/50 transition-colors">
                <td class="px-6 py-4 text-gray-500">{{ $role->id }}</td>
                <td class="px-6 py-4 font-medium text-gray-800">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-700">
                        {{ $role->name }}
                    </span>
                </td>
                <td class="px-6 py-4 text-gray-700">{{ $role->display_name }}</td>
                <td class="px-6 py-4 text-gray-500 text-xs">{{ $role->description ?? '-' }}</td>
                <td class="px-6 py-4 text-gray-600">{{ $role->permissions_count ?? $role->permissions->count() }}</td>
                <td class="px-6 py-4 text-gray-600">{{ $role->admins_count ?? $role->admins->count() }}</td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        @if(auth('admin')->user()?->hasPermission('roles.edit'))
                            <a href="{{ route('roles.edit', $role) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="تعديل">
                                <x-icon name="pencil" class="w-4 h-4" />
                            </a>
                        @endif
                        @if(auth('admin')->user()?->hasPermission('roles.delete') && $role->name !== 'super-admin')
                            <button
                                wire:click="delete({{ $role->id }})"
                                wire:confirm="هل أنت متأكد من حذف هذا الدور؟"
                                class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                title="حذف"
                            >
                                <x-icon name="trash" class="w-4 h-4" />
                            </button>
                        @endif
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                    <x-icon name="shield" class="w-12 h-12 mx-auto mb-3 text-gray-300" />
                    <p>لا توجد أدوار مسجلة</p>
                </td>
            </tr>
        @endforelse

        <x-slot:pagination>
            {{ $roles->links() }}
        </x-slot:pagination>
    </x-data-table>
</div>
