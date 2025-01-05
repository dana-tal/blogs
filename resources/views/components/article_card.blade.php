@props(['article','page_id','article_ind'])

@php

  $bg_color = $article_ind %2===0 ? 'bg-camelBrown':'bg-tan';

@endphp

<div class="grid grid-cols-1 mb-2  {{ $bg_color }} px-5 py-5 text-white ">
    <div><span class="font-bold ">Title:</span> <a href="{{ env('APP_URL') }}/front/article/{{ $article->id }}/{{ $page_id }}/articles">{{ $article->title }}</a></div>
    <div><span class="font-bold">Category:</span> {{ $article->category->name }} </div>
    <div><span class="font-bold">By: </span>{{$article->blog->user->name  }} </div>
    <div><span class="font-bold">Created at: </span>{{$article->created_at  }} </div>
</div>


