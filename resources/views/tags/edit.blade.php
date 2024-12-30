<x-admin_layout>
    <div class="grid grid-cols-1">
        <x-page-heading>Edit Tag</x-page-heading>
        <x-forms.form method="POST" action="/tags/{{ $tag->id}}" >
            @method('PATCH')
            <x-forms.input label="Name" name="name" value="{{ old('name',$tag->name) }}"/>
            <x-forms.button>Update Tag</x-forms.button>
        </x-forms.form>
    </div>

</x-admin_layout>
