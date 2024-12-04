<x-admin_layout>
    <div class="grid grid-cols-1 w-full">
        <x-page-heading>Create A New Article</x-page-heading>
        <x-forms.form method="POST" action="/articles/{{ $blog->id }}" class="w-full">
            <x-forms.input label="Title" name="title" />
            <x-forms.input label="Body" name="body"  type="textarea"   rows="30"/>
            <x-forms.button>Create Article</x-forms.button>
        </x-forms.form>
    </div>
</x-admin_layout>
