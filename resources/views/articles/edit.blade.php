<x-admin_layout>
    @php
        $image_path =   str_starts_with($article->image, 'http')? $article->image: 'storage/'.$article->image;
    @endphp
    <div class="grid grid-cols-1 w-full">
        <x-page-heading>Edit Article</x-page-heading>
        <x-forms.form method="POST" action="{{ env('APP_URL') }}/articles/{{ $article->id }}" class="w-full" enctype="multipart/form-data">
            @method('PATCH')
            <x-forms.input label="Title" name="title" value="{{old('title',$article->title) }}" enctype="multipart/form-data"/>

           <div class="grid grid-cols-5 gap-3">
                <span ><label class="font-bold" for="cat_id">Category:</label></span>
                <div class="col-span-4">
                    <select  name="category_id" id="category_id" class="w-full bg-white">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id',$article->category->id)==$category->id ? 'selected':'' }}>{{ $category->name }}</option>
                        @endforeach
                    <select>
                </div>
            </div>
            <x-forms.input label="Keywords" name="keywords"  type="textarea"   rows="3" value="{{old('keywords', $tags_list) }}"/>

            <x-forms.input label="Body" name="body"  type="textarea"   rows="20" value="{{ old('body',$article->body) }}"/>
            <x-forms.input label="Upload Image" name="image" type="file" />
            <div class="flex justify-center" ><img src="{{ asset($image_path) }}" alt="" class="rounded-xl" width="250"></div>

            <x-forms.button>Update Article</x-forms.button> <span class="px-5"><a href="{{ env('APP_URL') }}/articles/{{ $article->blog->id }}">Back to Blog Articles</a></span>
        </x-forms.form>
    </div>
</x-admin_layout>
