<x-admin_layout>
    <div class="grid grid-cols-1">
        <x-page-heading>Edit Blog</x-page-heading>
        <x-forms.form method="POST" action="{{ env('APP_URL') }}/blogs/{{ $blog->id}}" enctype="multipart/form-data">
            @method('PATCH')
            <x-forms.input label="Subject" name="subject" value="{{ old('subject',$blog->subject) }}"/>
            <x-forms.input label="Description" name="description" type="textarea"  rows="5" value="{{ old('description',$blog->description) }}"/>
            <x-forms.input label="Upload Image" name="image" type="file" />
            <div class="flex justify-center" ><img src="{{ asset('storage/'.$blog->image) }}" alt="" class="rounded-xl" width="250"></div>

            <div class="mt-6 flex flex-row justify-between ">
                <div >
                    <x-forms.button type="button" id="delete_button" bgColor="bg-red-800" class=" text-sm font-bold">Delete</x-forms.button>
                </div>

                <div class="flex flex-row justify-evenly">
                    <div class="mr-4 pt-2"><a href="{{ env('APP_URL') }}/blogs" >Cancel</a></div>
                    <div>
                        <x-forms.button >Update Blog</x-forms.button>
                    </div>
                </div>

            </div>



            <!-- <x-forms.button>Update Blog</x-forms.button> -->
        </x-forms.form>
    </div>

    <script type="module">
        $("#delete_button").click(function(){

            let text = "Are you sure you want to delete this blog (all related articles will be also deleted) ?  Press O.K or Cancel ";
            if (confirm(text) == true )
            {
                    $('#delete-form').submit();
            }

        });
    </script>


</x-admin_layout>

<form method="POST" action="{{ env('APP_URL') }}/blogs/{{ $blog->id}}" id="delete-form" class="hidden">
    @csrf
    @method('DELETE');
  </form>
