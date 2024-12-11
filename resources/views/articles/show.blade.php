<x-layout>
    <div class="flex justify-center ">
        <div class="grid grid-col-1">
            <div class="flex justify-center text-xl font-bold mb-3">{{ $article->title }}</div>
            <div>By: {{ $article->blog->user->name }}</div>
            <div>Cagetory: {{ $article->category->name }}</div>

            <div class="mt-5 mb-5">{{ $article->body }}</div>
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
                        <a class="bg-green-600 mx-5 rounded-xl px-3 py-3 hover:bg-green-300">{{ $tag->name }}</a>
                @endforeach
            </div>
            <div class="mt-5"><a href="/front/blog/{{ $article->blog->id }}">Back to this Article's blog </a></div>
        </div>
    </div>
</x-layout>
