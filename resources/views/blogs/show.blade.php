@php
    $blog_q = session('blog_q')??'';
    if (empty($blog_q))
    {
        $back_url = env('APP_URL')."/front/blogs?page=".$page_id;
    }
    else {
        $back_url = env('APP_URL')."/front/blogs/search?q=".$blog_q."&page=".$page_id;
    }
    $num = count($articles);
@endphp

<x-layout>
    <div class="flex justify-center ">

        <div class="grid grid-cols-1">
            <x-card_wide :$blog :page="$page_id"/>

        <div class="flex justify-start mt-5">
           <div class="grid grid-cols-1 w-full">
                <div class="text-xl mb-3 font-bold">Articles</div>
                <ul class="w-full">
                    @for ($i=0; $i<$num;$i++)
                      @php
                        $article = $articles[$i];
                      @endphp
                        <li class="my-5">
                             <!-- <a href="{{ env('APP_URL') }}/front/article/{{ $article->id }}/{{ $page_id }}">{{ $article->title }}</a>-->
                             <x-article_card :$article :article_ind="$i"  :page_id="$page_id"  :back_to="''" />
                        </li>
                    @endfor
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
