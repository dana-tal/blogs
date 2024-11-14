<x-layout>
    <div class="grid-col-1">
        <h1 class="text-xl font-bold flex justify-center">Categories Page</h1>
        <div class="flex justify-center mt-3">
            <ul >
                @foreach($categories as $cat)
                    <li class="mb-2">{{ $cat->name }}</li>
                @endforeach
            </ul>
        </div>

        <div class="flex justify-center mt-5">
            {{ $categories->links() }}
        </div>


    </div>
</x-layout>
