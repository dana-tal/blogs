<x-admin_layout>
    <div class="grid grid-col-1 mt-6">

        <h1 class="text-xl font-bold flex justify-center">{{ $blog->subject }} - Articles </h1>

        <div class="flex flex-cols-2 gap-16 mt-10 mb-4 justify-center">
            <a href="{{ env('APP_URL') }}/blogs" class="underline">Manage Blogs</a>
            <a href="{{ env('APP_URL') }}/articles/add/{{ $blog->id }}" class="underline">Add a New Article </a>
        </div>

        <form method="POST" action="{{ env('APP_URL') }}/articles/{{ $blog->id}}" id="delete-form" >
            @csrf
            @method('DELETE')
            <div class="flex justify-center ">
                <table >
                    <thead >
                        <tr ><th class="px-3 py-3">Select</th><th class="px-3">Category</th> <th class="px-3">Article Id</th><th class="px-3">Created At</th><th class="px-3">Edit</th> </tr>
                    </thead>
                    <tbody>
                    @foreach($articles as $article)
                        <tr class="mb-2">
                            <td class="px-3 flex justify-center"><input name="delete_articles[]" id={{ $article->id }} value={{ $article->id }} type="checkbox" /></td>
                            <td class="px-3">{{ $article->category->name }}</td>
                            <td class="px-3">{{ $article->id }}.</td>
                            <td class="px-3">{{ $article->created_at }}</td>
                            <td class="px-3"><a href="{{ env('APP_URL') }}/articles/edit/{{ $article->id }}" class="underline">{{ $article->title }}</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <input type="hidden" id="blog_id" value="{{ $blog->id }}}" />
            <x-forms.button type="button" id="delete_button" bgColor="bg-red-800" class=" text-sm font-bold mt-10">Delete</x-forms.button>
        </form>

        <div class="flex justify-center mt-5">
            {{ $articles->links() }}
        </div>

    </div>

    <script type="module">
        $("#delete_button").click(function(){

           let text='';
           let all_checked = [];

           $('input[name="delete_articles[]"]:checked').each(function () {
              all_checked.push( $(this).val());
            });

            let all_checked_str = "";
           if (all_checked.length >0 )
           {
                all_checked_str = all_checked.join(",");
                text = "Are you sure you want to delete "+all_checked_str+"  ? Press O.K or Cancel ";
                if (confirm(text) == true )
                {
                    $('#delete-form').submit();
                }
           }
           else
            {
                alert("Please select articles to delete");
            }


        });
    </script>
</x-admin_layout>

