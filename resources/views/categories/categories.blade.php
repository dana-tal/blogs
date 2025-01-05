<x-admin_layout>
    <div class="grid grid-col-1 mt-6">

        <div class="flex justify-center">
            <h1 class="text-xl font-bold ">Categories Page</h1>

        </div>

        <a href="{{ env('APP_URL') }}/categories/add" class="flex justify-center my-5  underline px-5">Add new Category </a>




        <div class="flex justify-center mt-3">
            <ul >
                @foreach($categories as $cat)
                    <li class="mb-2 underline"> <a href="{{ env('APP_URL') }}/categories/edit/{{ $cat->id }}">{{ $cat->name }}</a></li>
                @endforeach
            </ul>
        </div>

        <div class="flex justify-center mt-5">
            {{ $categories->links() }}
        </div>


    </div>
</x-admin_layout>
