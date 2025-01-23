<x-admin_layout>
    <div class="grid grid-cols-1 w-full">
        <x-page-heading>Create A New Article</x-page-heading>
        <x-forms.form method="POST" action="{{ env('APP_URL') }}/articles/{{ $blog->id }}" class="w-full" enctype="multipart/form-data">
            <x-forms.input label="Title" name="title" value="{{ old('title') }}"/>
            <div class="grid grid-cols-5 gap-3">
                <span ><label class="font-bold" for="cat_id">Category:</label></span>
                <div class="col-span-4">
                    <select  name="category_id" id="category_id" class="w-full bg-white" >
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id',$category->id)==$category->id ? 'selected':'' }}>{{ $category->name }}</option>
                        @endforeach
                    <select>
                </div>
            </div>
            <x-forms.input label="Keywords" name="keywords"  type="textarea"   rows="3" value="{{ old('keywords')}}"/>
            <x-forms.input label="Body" name="body"  type="textarea"   rows="20" value="{{ old('body')}}"/>
            <x-forms.input label="Upload Image" name="image" type="file" />
            <x-forms.button>Create Article</x-forms.button> <span class="px-5"><a href="{{ env('APP_URL') }}/articles/{{ $blog->id }}">Back to Blog Articles</a></span>
        </x-forms.form>
    </div>
</x-admin_layout>
