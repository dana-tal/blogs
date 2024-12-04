<x-admin_layout>
    <div class="grid grid-cols-1 w-full">
        <x-page-heading>Edit Article</x-page-heading>
        <x-forms.form method="POST" action="/articles/{{ $article->id }}" class="w-full">
            @method('PATCH')
            <x-forms.input label="Title" name="title" value="{{ $article->title}}" />
            <x-forms.input label="Body" name="body"  type="textarea"   rows="30" value="{{ $article->body }}"/>
            <x-forms.button>Update Article</x-forms.button>
        </x-forms.form>
    </div>
</x-admin_layout>
