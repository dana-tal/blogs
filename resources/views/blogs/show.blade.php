@php
    $blog_q = session('blog_q')??'';
    if (empty($blog_q))
    {
        $back_url = "/front/blogs?page=".$page_id;
    }
    else {
        $back_url = "/front/blogs/search?q=".$blog_q."&page=".$page_id;
    }
@endphp

<x-layout>
    <div class="flex justify-center ">

        <div class="grid grid-cols-1">
            <x-card_wide :$blog :page="$page_id"/>

        <div class="flex justify-start mt-5">
           <div class="grid grid-cols-1">
                <div class="text-xl mb-3 font-bold">Articles</div>
                <ul>
                    @foreach ($articles as $article)
                        <li class="my-5"><a href="/front/article/{{ $article->id }}/{{ $page_id }}">{{ $article->title }}</a></li>
                    @endforeach
                </ul>
                <div class="flex justify-center mt-5">
                    {{ $articles->links() }}
                </div>
                <div class="mt-5"><a href="{{ $back_url }}">Back to blogs page</a></div>
            </div>
        </div>

        </div>
    </div>
</x-layout>
