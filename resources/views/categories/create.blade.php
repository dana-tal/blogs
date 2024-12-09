<x-admin_layout>

    <div class="grid grid-cols-1">
        <x-page-heading>Create A New Category</x-page-heading>
        <x-forms.form method="POST" action="/categories" >
            <x-forms.input label="Name" name="name" value="{{ old('name') }}"/>

            <x-forms.button>Create Category</x-forms.button>
        </x-forms.form>
    </div>

</x-admin_layout>
