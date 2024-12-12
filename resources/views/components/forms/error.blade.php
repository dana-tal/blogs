@props(['error' => false])

@php
    $defaults = [
        'class' => 'text-sm text-red-500 mt-1 ',

    ];


@endphp

@if ($error)
    <p  {{  $attributes($defaults) }}>{{ $error }}</p>
@endif
