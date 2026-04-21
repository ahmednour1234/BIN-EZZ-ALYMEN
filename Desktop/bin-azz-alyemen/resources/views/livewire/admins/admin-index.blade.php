<div>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-primary-700 tracking-tight">إدارة المدراء</h1>
            <p class="text-sm text-gray-400 mt-0.5">عرض وإدارة حسابات المدراء</p>
        </div>
        @if(auth('admin')->user()?->hasPermission('admins.create'))
            <x-button variant="primary" href="{{ route('admins.create') }}">
                <x-icon name="plus" class="w-4 h-4" />إضافة مدير
            </x-button>
        @endif
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 mb-5">
        <div class="relative">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 absolute right-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="بحث بالاسم أو البريد..."
                class="w-full pr-9 pl-4 py-2.5 border border-gray-200 rounded-xl bg-gray-50 text-sm focus:bg-white focus:ring-2 focus:ring-primary-300 transition-all">
        </div>
    </div>
    @php $avatarGradients = ['from-violet-400 to-purple-600','from-blue-400 to-cyan-600','from-green-400 to-teal-600','from-amber-400 to-orange-600','from-rose-400 to-pink-600','from-indigo-400 to-blue-600']; @endphp
    <div class="space-y-2.5">
        @forelse($admins as $i => $adminItem)
            @php $grad = $avatarGradients[$adminItem->id % count($avatarGradients)]; @endphp
            <div class="flex items-center gap-4 bg-white rounded-2xl border border-gray-100 shadow-sm px-5 py-4 hover:shadow-md hover:border-primary-100 transition-all">
                <div class="w-11 h-11 rounded-xl bg-gradient-to-br {{ $grad }} flex items-center justify-center text-white font-extrabold text-base flex-shrink-0 shadow-sm">
                    {{ mb_substr($adminItem->name, 0, 1) }}
                </div>
                <div class="w-48 min-w-0">
                    <p class="font-bold text-gray-800 truncate text-sm">{{ $adminItem->name }}</p>
                    <p class="text-xs text-gray-400 truncate" dir="ltr">{{ $adminItem->email }}</p>
                </div>
                <div class="flex-1 flex flex-wrap gap-1.5">
                    @foreach($adminItem->roles as $role)
                        <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold bg-primary-100 text-primary-700">{{ $role->display_name }}</span>
                    @endforeach
                    @if($adminItem->roles->isEmpty())
                        <span class="text-xs text-gray-400">بدون أدوار</span>
                    @endif
                </div>
                <div class="hidden md:block text-xs text-gray-400">{{ $adminItem->created_at->format('Y/m/d') }}</div>
                <div class="flex items-center gap-1.5 flex-shrink-0">
                    @if(auth('admin')->user()?->hasPermission('admins.edit'))
                        <a href="{{ route('admins.edit', $adminItem) }}" class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 flex items-center justify-center transition-colors" title="تعديل">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125" /></svg>
                        </a>
                    @endif
                    @if(auth('admin')->user()?->hasPermission('admins.delete'))
                        <button wire:click="delete({{ $adminItem->id }})" wire:confirm="هل أنت متأكد من حذف هذا المدير؟" class="w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 flex items-center justify-center transition-colors" title="حذف">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg>
                        </button>
                    @endif
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl border border-gray-100 py-16 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-14 h-14 mx-auto mb-3 text-gray-200" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" /></svg>
                <p class="text-gray-400 text-sm">لا يوجد مدراء مسجلون</p>
            </div>
        @endforelse
    </div>
    @if($admins->hasPages())<div class="mt-4">{{ $admins->links() }}</div>@endif
</div>