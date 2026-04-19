<div>
    {{-- Page Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-primary-700">إدارة المدراء</h1>
            <p class="text-sm text-gray-500 mt-1">عرض وإدارة حسابات المدراء</p>
        </div>
        @if(auth('admin')->user()?->hasPermission('admins.create'))
            <x-button variant="primary" href="{{ route('admins.create') }}">
                <x-icon name="plus" class="w-4 h-4" />
                إضافة مدير
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
                placeholder="بحث بالاسم أو البريد..."
                class="w-full pr-10 pl-4 py-3 border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition-all text-sm"
            >
        </div>
    </div>

    {{-- Table --}}
    <x-data-table :headers="['#', 'الاسم', 'البريد الإلكتروني', 'الأدوار', 'تاريخ الإنشاء', 'الإجراءات']">
        @forelse($admins as $adminItem)
            <tr class="hover:bg-primary-50/50 transition-colors">
                <td class="px-6 py-4 text-gray-500">{{ $adminItem->id }}</td>
                <td class="px-6 py-4 font-medium text-gray-800">{{ $adminItem->name }}</td>
                <td class="px-6 py-4 text-gray-600" dir="ltr">{{ $adminItem->email }}</td>
                <td class="px-6 py-4">
                    <div class="flex flex-wrap gap-1">
                        @foreach($adminItem->roles as $role)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-700">
                                {{ $role->display_name }}
                            </span>
                        @endforeach
                    </div>
                </td>
                <td class="px-6 py-4 text-gray-500 text-xs">{{ $adminItem->created_at->format('Y/m/d') }}</td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        @if(auth('admin')->user()?->hasPermission('admins.edit'))
                            <a href="{{ route('admins.edit', $adminItem) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="تعديل">
                                <x-icon name="pencil" class="w-4 h-4" />
                            </a>
                        @endif
                        @if(auth('admin')->user()?->hasPermission('admins.delete'))
                            <button
                                wire:click="delete({{ $adminItem->id }})"
                                wire:confirm="هل أنت متأكد من حذف هذا المدير؟"
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
                <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                    <x-icon name="users" class="w-12 h-12 mx-auto mb-3 text-gray-300" />
                    <p>لا يوجد مدراء مسجلون</p>
                </td>
            </tr>
        @endforelse

        <x-slot:pagination>
            {{ $admins->links() }}
        </x-slot:pagination>
    </x-data-table>
</div>
