@props(['bgColor'=>'bg-darkBrown'])

@php
 $defaults = [
        'class' => 'text-white rounded py-2 px-6 font-bold '.$bgColor,
    ];
@endphp

<button {{ $attributes($defaults) }}>{{ $slot }}</button>
