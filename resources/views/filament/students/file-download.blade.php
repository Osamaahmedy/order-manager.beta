@php
    $filePath = $record?->{$field} ?? null;
@endphp

@if ($filePath)
    <a href="{{ asset('storage/' . $filePath) }}"
       download
       class="inline-flex items-center justify-center px-4 py-2 bg-{{ $color }}-600 text-white rounded-lg shadow hover:bg-{{ $color }}-700 transition">
        تحميل {{ $label }}
    </a>
@else
    <span class="text-gray-500">لا يوجد {{ $label }}</span>
@endif
