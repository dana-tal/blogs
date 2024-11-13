@props(['label', 'name'])

<div>
    @if ($label)
        <x-forms.label :$name :$label />
    @endif

    <span class="mt-1">
        {{ $slot }}

        <x-forms.error :error="$errors->first($name)" />
    </span>
</div>
