
@props(
[
'link'=>'',
'active'=>false,
'mb'=>'mb-6'
])

<li class="flex justify-center w-60 mx-auto {{ $mb }} py-3 px-4 rounded-xl hover:bg-darkBrown"><a  href="{{ $link }}" class="{{ $active? 'underline':''}}" >{{ $slot }}</a></li>
