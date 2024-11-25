
@props(['link'=>'','active'=>false])

<li class="flex justify-center mb-6 py-3 px-4 rounded-xl hover:bg-darkBrown"><a  href="{{ $link }}" class="{{ $active? 'underline':''}}" >{{ $slot }}</a></li>
