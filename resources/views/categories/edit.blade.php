<x-admin_layout>
    <div class="grid grid-cols-1">
        <x-page-heading>Edit Category</x-page-heading>
        <x-forms.form method="POST" action="/categories/{{ $cat->id}}" >
            @method('PATCH')
            <x-forms.input label="Name" name="name" value="{{ old('name',$cat->name) }}"/>
            <x-forms.button>Update Category</x-forms.button>
        </x-forms.form>
    </div>

</x-admin_layout>
