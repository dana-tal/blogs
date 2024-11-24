<x-admin_layout>
    <div class="grid grid-col-1">

        <h1 class="text-xl font-bold flex justify-center">Manage Your Blogs</h1>

        <a href="/blogs/add" class="flex justify-center mt-3 underline">Add a New Blog </a>

        <div class="flex justify-center mt-7">
            <ul >
                @foreach($blogs as $blog)
                    <li class="mb-2"><span>{{ $blog->id }}.</span> <span class="px-5">{{ $blog->created_at }}</span> <a href="/blogs/edit/{{ $blog->id }}" class="underline">{{ $blog->subject }}</a></li>
                @endforeach
            </ul>
        </div>

        <div class="flex justify-center mt-5">
            {{ $blogs->links() }}
        </div>


    </div>
</x-admin_layout>
