
@php
    $article_q = session('article_q')??'';
    $cat = session('cat')??'';

    $back_url = "/front/articles";
    $params = array();
    if (!empty($article_q))
    {
        $params[] = "q=".$article_q;
    }
    if (!empty($cat))
    {
        $params[] = "cat=".$cat;
    }
    if(!empty($params))
    {
        $back_url .= '/search?';
        $query_str = implode('&',$params);
        $back_url .= $query_str;
        $back_url .="&page=".$page_id;
    }
    else {
         $back_url .= "?page=".$page_id;
    }
@endphp

<x-layout>
    <div class="flex justify-center ">
        <div class="grid grid-col-1">
            <div class="flex justify-center text-xl font-bold mb-3">{{ $article->title }}</div>
            <div>By: {{ $article->blog->user->name }}</div>
            <div>Cagetory: {{ $article->category->name }}</div>

            <div class="mt-5 mb-5">{{ $article->body }}</div>


            <div>
                @auth
                    <form method="POST" action="/front/add_comment">
                        @csrf
                        <div class="flex flex-row mb-3  ">
                            <div ><label class="font-bold" for="comment">Comment:</label></div>
                            <input type="text" name="comment" value="{{ old('comment') }}" class="ml-5 w-2/5" />
                        </div>
                        <x-forms.error :error="$errors->first('comment')" class="mb-2"/>
                        <x-forms.input label=""  type="hidden" name="user_id" value="{{  Auth::user()->id }}" />
                        <x-forms.input label="" type="hidden" name="page_id" value="{{ $page_id }}" />
                        <x-forms.input label="" type="hidden" name="article_id" value="{{ $article->id }}" />
                        <x-forms.button class="mb-5">Add Comment</x-forms.button>
                    </form>
                @endauth
            </div>

            @if ( count($comments) >0)
                <div class="font bold text-l underline">Comments</div>
                <ul>
                    @foreach($comments as $comment)
                        <li><span class="font-bold">{{  $comment->user->name }}</span>:  {{ $comment->comment }}</li>
                    @endforeach
                </ul>
            @endif

            <div class="flex justify-center mt-5">
                @foreach($tags as $tag)
                        <a href="/front/articles/search?q={{ $tag->name}}"  class="bg-green-600 mx-5 rounded-xl px-3 py-3 hover:bg-green-300">{{ $tag->name }}</a>
                @endforeach
            </div>
            @if ($parent==='blogs')
                <div class="mt-5"><a href="/front/blog/{{ $article->blog->id }}/{{ $page_id }}">Back to this Article's blog </a></div>
            @else
                <div class="mt-5"><a href="{{ $back_url }}">Back to Articles </a></div>
            @endif
        </div>
    </div>
</x-layout>
