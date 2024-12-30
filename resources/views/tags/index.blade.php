<x-admin_layout>
    <div class="grid grid-col-1 mt-6">

        <div class="flex justify-center">
            <h1 class="text-xl font-bold ">Tags Page</h1>
            <x-forms.button form="delete-form" class="bg-red-600 mx-5 px-5 text-white font-bold rounded">Delete</x-forms.button>
        </div>

        <form method="POST" action="/tags" id="delete-form" >
            @csrf
            @method('DELETE');
            <div class="flex justify-center mt-3">
                <ul >
                    @foreach($tags as $tag)
                        <li class="mb-2 underline">
                            <span class="mr-2"><input type="checkbox" name="tags[]" value="{{ $tag->id }}"/></span>
                            <a href="/tags/edit/{{ $tag->id }}">{{$tag->name}}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </form>

        <div class="flex justify-center mt-5">
            {{ $tags->links() }}
        </div>


    </div>
</x-admin_layout>
