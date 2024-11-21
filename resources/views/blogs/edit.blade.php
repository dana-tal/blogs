<x-layout>
    <x-page-heading>Edit Blog</x-page-heading>
    <x-forms.form method="POST" action="/blogs/{{ $blog->id}}" enctype="multipart/form-data">
        @method('PATCH')
        <x-forms.input label="Subject" name="subject" value="{{ $blog->subject }}"/>
        <x-forms.input label="Description" name="description" type="textarea"  rows="5" value="{{ $blog->description }}"/>
        <x-forms.input label="Upload Image" name="image" type="file" />
        <div class="flex justify-center" ><img src="{{ asset($blog->image) }}" alt="" class="rounded-xl" width="250"></div>

        <div class="mt-6 flex flex-row justify-between ">
            <div >
                 <x-forms.button form="delete-form" bgColor="bg-red-800" class=" text-sm font-bold">Delete</x-forms.button>
            </div>

            <div class="flex flex-row justify-evenly">
                <div class="mr-4 pt-2"><a href="/blogs" >Cancel</a></div>
                <div>
                    <x-forms.button >Update Blog</x-forms.button>
                </div>
            </div>

        </div>



        <!-- <x-forms.button>Update Blog</x-forms.button> -->
    </x-forms.form>

</x-layout>

<form method="POST" action="/blogs/{{ $blog->id}}" id="delete-form" class="hidden">
    @csrf
    @method('DELETE');
  </form>
