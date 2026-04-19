@props(['headers' => [], 'empty' => 'لا توجد بيانات'])

<div class="bg-card rounded-2xl shadow-sm border border-primary-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-primary-50 border-b border-primary-100">
                    @foreach($headers as $header)
                        <th class="px-6 py-4 text-right font-bold text-primary-700 whitespace-nowrap">{{ $header }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                {{ $slot }}
            </tbody>
        </table>
    </div>

    @if(isset($pagination))
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $pagination }}
        </div>
    @endif
</div>
