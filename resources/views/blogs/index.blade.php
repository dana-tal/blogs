<x-admin_layout>
    <div class="grid grid-col-1 mt-6">

        <h1 class="text-xl font-bold flex justify-center">Manage Your Blogs</h1>

        <a href="/blogs/add" class="flex justify-center mt-10 mb-4 underline">Add a New Blog </a>

        <div class="flex justify-center mt-7">
            <table >
                @foreach($blogs as $blog)
                    <tr class="mb-2">
                        <td>{{ $blog->id }}.</td>
                        <td class="px-5">{{ $blog->created_at }}</td>
                        <td class="px-5"><a href="/blogs/edit/{{ $blog->id }}" class="underline">{{ $blog->subject }}</a></td>
                        <td><a class="underline" href="/articles/{{ $blog->id}}">Manage Articles</a></td>
                    </tr>
                @endforeach
                </table>
        </div>

        <div class="flex justify-center mt-5">
            {{ $blogs->links() }}
        </div>


    </div>
</x-admin_layout>
