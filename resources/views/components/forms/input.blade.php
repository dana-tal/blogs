@props(['label', 'name', 'size'=>''])

@php
    $width='w-full';
    if ($size==='small')
    {
        $width ="w-2/5";
    }

    $defaults = [
        'type' => 'text',
        'id' => $name,
        'name' => $name,
        'class' => 'rounded-xl bg-white border border-white/10 '.$width,
        'value' => old($name),
    ];
@endphp

<div class="grid grid-cols-5 gap-3">
    @if ($label)
        <div ><label class="font-bold" for="{{ $name }}">{{ $label }}:</label></div>
    @endif
    <div class="col-span-4">
        <input {{ $attributes($defaults) }} />
        <x-forms.error :error="$errors->first($name)" />
    </div>
</div>

