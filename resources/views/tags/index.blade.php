<x-admin_layout>
    <div class="grid grid-col-1 mt-6">

        <div class="flex justify-center">
            <h1 class="text-xl font-bold ">Tags Page</h1>

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
            <x-forms.button type="button" id="delete_button" class="bg-red-600 mx-5 px-5 text-white font-bold rounded">Delete</x-forms.button>   {{ $tags->links() }}
        </div>


    </div>


    <script type="module">
        $("#delete_button").click(function(){

           let text='';
           let all_checked = [];

           $('input[name="tags[]"]:checked').each(function () {
              all_checked.push( $(this).val());
            });

            let all_checked_str = "";
           if (all_checked.length >0 )
           {
                all_checked_str = all_checked.join(",");
                text = "Are you sure you want to delete "+all_checked_str+" ? Press O.K or Cancel ";
                if (confirm(text) == true )
                {
                    $('#delete-form').submit();
                }
           }
           else
            {
                alert("Please select tags to delete");
            }


        });
    </script>

</x-admin_layout>
