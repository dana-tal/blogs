@props(['article','page_id','article_ind','back_to'=>'articles'])

@php

  $bg_color = $article_ind %2===0 ? 'bg-camelBrown':'bg-tan';
  $image_path =   str_starts_with($article->image, 'http')? $article->image: 'storage/'.$article->image;
@endphp

<div class="flex h-[140px] {{ $bg_color }}" >

    <div class="flex items-center justify-center  w-1/4 h-full  py-3 px-2">
        @if (!empty($article->image))
            <image src="{{ asset($image_path) }}"  class="rounded-xl !h-32 " width="220px" />
        @else
             <div class="bg-white  rounded-xl h-[126px] w-[220px] flex items-center justify-center" >No image available</div>
        @endif
    </div>

    <div class="grid grid-cols-1 ms-0 mb-2   px-5 py-5 text-white w-3/4 h-full ">
        <div><span class="font-bold ">Title:</span> <a href="{{ env('APP_URL') }}/front/article/{{ $article->id }}/{{ $page_id }}/{{ $back_to}}">{{ $article->title }}</a></div>
        <div><span class="font-bold">Category:</span> {{ $article->category->name }} </div>
        <div><span class="font-bold">By: </span>{{$article->blog->user->name  }} </div>
        <div><span class="font-bold">Created at: </span>{{$article->created_at  }} </div>
    </div>
</div>


