<header class="bg-card shadow-sm border-b border-primary-100 px-6 py-4 flex items-center justify-between">
    <div>
        <h2 class="text-lg font-bold text-primary-700">{{ $title ?? 'لوحة التحكم' }}</h2>
    </div>
    <div class="flex items-center gap-4">
        <span class="text-sm text-gray-600">{{ auth('admin')->user()?->name ?? 'مدير' }}</span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center gap-1 text-sm text-red-600 hover:text-red-800 transition-colors">
                <x-icon name="logout" class="w-4 h-4" />
                <span>خروج</span>
            </button>
        </form>
    </div>
</header>
