{{-- resources/views/filament/components/subscription-details.blade.php --}}

<div class="space-y-6">
    {{-- الخطة الحالية --}}
    <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-6 bg-white dark:bg-gray-800">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                📦 الخطة الحالية
            </h3>
            @if($subscription->onTrial())
                <span class="px-3 py-1 text-xs font-medium rounded-full bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">
                    🎁 فترة تجريبية
                </span>
            @endif
        </div>

        <div class="space-y-3">
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600 dark:text-gray-400">اسم الخطة:</span>
                <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $subscription->plan->name }}</span>
            </div>

            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600 dark:text-gray-400">السعر:</span>
                <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $subscription->plan->price }} ر.ي</span>
            </div>

            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600 dark:text-gray-400">نوع الاشتراك:</span>
                <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $subscription->plan->getIntervalInArabic() }}</span>
            </div>
        </div>
    </div>

    {{-- حالة الاشتراك --}}
    <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-6 bg-white dark:bg-gray-800">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
            📊 حالة الاشتراك
        </h3>

        <div class="space-y-3">
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600 dark:text-gray-400">الحالة:</span>
                @php
                    $statusConfig = match($subscription->status) {
                        'active' => ['text' => 'نشط', 'color' => 'green'],
                        'canceled' => ['text' => 'ملغي', 'color' => 'red'],
                        'expired' => ['text' => 'منتهي', 'color' => 'red'],
                        'suspended' => ['text' => 'معلق', 'color' => 'yellow'],
                        default => ['text' => $subscription->status, 'color' => 'gray'],
                    };
                @endphp
                <span class="px-3 py-1 text-xs font-medium rounded-full bg-{{ $statusConfig['color'] }}-100 text-{{ $statusConfig['color'] }}-800 dark:bg-{{ $statusConfig['color'] }}-900 dark:text-{{ $statusConfig['color'] }}-200">
                    {{ $statusConfig['text'] }}
                </span>
            </div>
        </div>
    </div>

    {{-- فترة الاشتراك --}}
    <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-6 bg-white dark:bg-gray-800">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
            📅 فترة الاشتراك
        </h3>


    </div>

    {{-- استخدام الموارد --}}
    <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-6 bg-white dark:bg-gray-800">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
            📊 استخدام الموارد
        </h3>

        <div class="space-y-4">
            {{-- الفروع --}}
            <div>
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm text-gray-600 dark:text-gray-400">الفروع</span>
                    @php
                        $branchesUsed = $admin->branches()->count();
                        $branchesLimit = $subscription->plan->max_branches ?? '∞';
                        $branchesPercent = is_numeric($branchesLimit) ? ($branchesUsed / $branchesLimit * 100) : 0;
                    @endphp
                    <span class="text-sm font-medium text-gray-900 dark:text-white">
                        {{ $branchesUsed }} / {{ $branchesLimit }}
                    </span>
                </div>
                @if(is_numeric($branchesLimit))
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ min($branchesPercent, 100) }}%"></div>
                    </div>
                @else
                    <div class="text-xs text-gray-500 dark:text-gray-400">غير محدود</div>
                @endif
            </div>

            {{-- المقيمين --}}
            <div>
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm text-gray-600 dark:text-gray-400">المقيمين</span>
                    @php
                        $residentsUsed = $admin->residents()->count();
                        $residentsLimit = $subscription->plan->max_residents ?? '∞';
                        $residentsPercent = is_numeric($residentsLimit) ? ($residentsUsed / $residentsLimit * 100) : 0;
                    @endphp
                    <span class="text-sm font-medium text-gray-900 dark:text-white">
                        {{ $residentsUsed }} / {{ $residentsLimit }}
                    </span>
                </div>
                @if(is_numeric($residentsLimit))
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                        <div class="bg-green-600 h-2 rounded-full" style="width: {{ min($residentsPercent, 100) }}%"></div>
                    </div>
                @else
                    <div class="text-xs text-gray-500 dark:text-gray-400">غير محدود</div>
                @endif
            </div>
        </div>
    </div>

    {{-- الميزات --}}
    @if($subscription->plan->features && count($subscription->plan->features) > 0)
        <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-6 bg-white dark:bg-gray-800">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                ✨ الميزات المتاحة
            </h3>

            <ul class="space-y-2">
                @foreach($subscription->plan->features as $feature)
                    <li class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-sm text-gray-700 dark:text-gray-300">{{ $feature }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
