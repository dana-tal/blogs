@props([ 'method2'=>''])

<form {{ $attributes(["class" => "max-w-2xl mx-auto space-y-6", "method" => "GET"]) }}>
    @if ($attributes->get('method', 'GET') !== 'GET')
        @csrf

    @endif

    {{ $slot }}
</form>
