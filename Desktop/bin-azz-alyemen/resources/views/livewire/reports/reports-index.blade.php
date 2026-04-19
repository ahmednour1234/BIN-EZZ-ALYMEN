<div>
    {{-- Page Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-primary-700">التقارير المالية</h1>
            <p class="text-sm text-gray-500 mt-1">عرض ملخص الحالة المالية</p>
        </div>
        <div class="flex items-center gap-2">
            <x-button variant="secondary" size="sm" href="{{ route('reports.export.pdf', ['date_from' => $dateFrom, 'date_to' => $dateTo]) }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18.75 7.5H5.25" /></svg>
                طباعة PDF
            </x-button>
        </div>
    </div>

    {{-- Date Filters --}}
    <div class="bg-card rounded-2xl shadow-sm border border-primary-100 p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">من تاريخ</label>
                <input type="date" wire:model.live="dateFrom"
                    class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition-all text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">إلى تاريخ</label>
                <input type="date" wire:model.live="dateTo"
                    class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition-all text-sm">
            </div>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
        <div class="bg-card rounded-2xl shadow-sm border border-primary-100 p-4 text-center">
            <p class="text-xs text-gray-500 mb-1">إجمالي أرصدة الخزن</p>
            <p class="text-xl font-bold text-primary-700" dir="ltr">{{ number_format($totalTreasuryBalance, 2) }}</p>
        </div>
        <div class="bg-card rounded-2xl shadow-sm border border-green-200 p-4 text-center">
            <p class="text-xs text-gray-500 mb-1">إجمالي الإيرادات</p>
            <p class="text-xl font-bold text-green-700" dir="ltr">{{ number_format($totalRevenues, 2) }}</p>
        </div>
        <div class="bg-card rounded-2xl shadow-sm border border-red-200 p-4 text-center">
            <p class="text-xs text-gray-500 mb-1">إجمالي المصروفات</p>
            <p class="text-xl font-bold text-red-700" dir="ltr">{{ number_format($totalExpenses, 2) }}</p>
        </div>
        <div class="bg-card rounded-2xl shadow-sm border border-green-200 p-4 text-center">
            <p class="text-xs text-gray-500 mb-1">إجمالي الإيداعات</p>
            <p class="text-xl font-bold text-green-600" dir="ltr">{{ number_format($totalDeposits, 2) }}</p>
        </div>
        <div class="bg-card rounded-2xl shadow-sm border border-red-200 p-4 text-center">
            <p class="text-xs text-gray-500 mb-1">إجمالي السحوبات</p>
            <p class="text-xl font-bold text-red-600" dir="ltr">{{ number_format($totalWithdrawals, 2) }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        {{-- Treasury Balances --}}
        <div class="bg-card rounded-2xl shadow-sm border border-primary-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-bold text-primary-700">أرصدة الخزن</h3>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($treasuryBalances as $treasury)
                    <div class="px-6 py-3 flex items-center justify-between">
                        <span class="text-sm text-gray-700">{{ $treasury->name }}</span>
                        <span class="text-sm font-mono font-bold {{ $treasury->balance >= 0 ? 'text-green-700' : 'text-red-700' }}" dir="ltr">{{ number_format($treasury->balance, 2) }}</span>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-gray-400 text-sm">لا يوجد خزن</div>
                @endforelse
            </div>
        </div>

        {{-- Expenses By Account --}}
        <div class="bg-card rounded-2xl shadow-sm border border-primary-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-bold text-primary-700">المصروفات حسب الحساب</h3>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($expensesByAccount as $item)
                    <div class="px-6 py-3 flex items-center justify-between">
                        <span class="text-sm text-gray-700">{{ $item->account?->name ?? '—' }}</span>
                        <span class="text-sm font-mono font-bold text-red-700" dir="ltr">{{ number_format($item->total, 2) }}</span>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-gray-400 text-sm">لا يوجد مصروفات</div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        {{-- Revenues By Account --}}
        <div class="bg-card rounded-2xl shadow-sm border border-primary-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-bold text-primary-700">الإيرادات حسب الحساب</h3>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($revenuesByAccount as $item)
                    <div class="px-6 py-3 flex items-center justify-between">
                        <span class="text-sm text-gray-700">{{ $item->account?->name ?? '—' }}</span>
                        <span class="text-sm font-mono font-bold text-green-700" dir="ltr">{{ number_format($item->total, 2) }}</span>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-gray-400 text-sm">لا يوجد إيرادات</div>
                @endforelse
            </div>
        </div>

        {{-- Recent Transactions --}}
        <div class="bg-card rounded-2xl shadow-sm border border-primary-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-bold text-primary-700">آخر المعاملات</h3>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($recentTransactions as $tx)
                    <div class="px-6 py-3 flex items-center justify-between">
                        <div>
                            <span class="text-sm text-gray-700">{{ $tx->account?->name }}</span>
                            @if($tx->description)
                                <p class="text-xs text-gray-400">{{ Str::limit($tx->description, 30) }}</p>
                            @endif
                        </div>
                        <div class="text-left">
                            <span class="text-sm font-mono font-bold {{ $tx->type === 'revenue' ? 'text-green-700' : 'text-red-700' }}" dir="ltr">
                                {{ $tx->type === 'revenue' ? '+' : '-' }}{{ number_format($tx->amount, 2) }}
                            </span>
                            <p class="text-xs text-gray-400" dir="ltr">{{ $tx->date->format('Y-m-d') }}</p>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-gray-400 text-sm">لا يوجد معاملات</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
