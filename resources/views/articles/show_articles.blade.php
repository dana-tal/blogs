<x-layout>
    <div class="flex justify-center ">
        <div class="grid grid-cols-1">
            <h1 class="mb-2 flex justify-center text-3xl font-bold text-green-700">Newest Articles</h1>
            <ul>
                @foreach ($articles as $article)
                    <li class="mb-2">
                        <x-article_card :$article  :page_id="$articles->currentPage()"/>
                    </li>
                @endforeach
            </ul>

            <div class="flex justify-center mt-5">
                {{ $articles->links() }}
            </div>
        </div>


    </div>
</x-layout>
