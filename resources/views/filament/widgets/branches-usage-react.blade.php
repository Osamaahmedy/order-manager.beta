@php
    $data = $this->getData();
@endphp

<x-filament-widgets::widget>
    <x-filament::section>
        <div
            id="branches-usage-chart"
            data-chart='@json($data)'
            class="min-h-[320px]"
        ></div>
    </x-filament::section>
</x-filament-widgets::widget>
