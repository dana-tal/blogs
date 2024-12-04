<x-admin_layout>
    <div class="grid grid-col-1 mt-6">

        <h1 class="text-xl font-bold flex justify-center">{{ $blog->subject }} - Articles </h1>

        <div class="flex flex-cols-2 gap-16 mt-10 mb-4 justify-center">
            <a href="/blogs" class="underline">Blogs</a>
            <a href="/articles/add/{{ $blog->id }}" class="underline">Add a New Article </a>
        </div>

        <div class="flex justify-center mt-7">
            <ul >
                @foreach($articles as $article)
                    <li class="mb-2"><span>{{ $article->id }}.</span> <span class="px-5">{{ $article->created_at }}</span> <a href="/articles/edit/{{ $article->id }}" class="underline">{{ $article->title }}</a></li>
                @endforeach
            </ul>
        </div>

        <div class="flex justify-center mt-5">
            {{ $articles->links() }}
        </div>

    </div>
</x-admin_layout>
