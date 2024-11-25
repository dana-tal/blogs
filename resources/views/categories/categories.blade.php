<x-admin_layout>
    <div class="grid grid-col-1 mt-6">

        <h1 class="text-xl font-bold flex justify-center">Categories Page</h1>

        <a href="/categories/add" class="flex justify-center mt-10 mb-4 underline">Add new Category </a>

        <div class="flex justify-center mt-3">
            <ul >
                @foreach($categories as $cat)
                    <li class="mb-2 underline"> <a href="/categories/edit/{{ $cat->id }}">{{ $cat->name }}</a></li>
                @endforeach
            </ul>
        </div>

        <div class="flex justify-center mt-5">
            {{ $categories->links() }}
        </div>


    </div>
</x-admin_layout>
