<x-admin_layout>
    <div class="grid grid-cols-1 w-full">
        <x-page-heading>Create A New Article</x-page-heading>
        <x-forms.form method="POST" action="/articles/{{ $blog->id }}" class="w-full">
            <x-forms.input label="Title" name="title" />
            <div class="grid grid-cols-5 gap-3">
                <span ><label class="font-bold" for="cat_id">Category:</label></span>
                <div class="col-span-4">
                    <select  name="category_id" id="category_id" class="w-full bg-white">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" >{{ $category->name }}</option>
                        @endforeach
                    <select>
                </div>
            </div>
            <x-forms.input label="Body" name="body"  type="textarea"   rows="20"/>
            <x-forms.button>Create Article</x-forms.button> <span class="px-5"><a href="/articles/{{ $blog->id }}">Back to Blog Articles</a></span>
        </x-forms.form>
    </div>
</x-admin_layout>
