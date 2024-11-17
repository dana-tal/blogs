<x-layout>
    <x-page-heading>Create A New Category</x-page-heading>
    <x-forms.form method="POST" action="/categories" >
        <x-forms.input label="Name" name="name" />

        <x-forms.button>Create Category</x-forms.button>
    </x-forms.form>

</x-layout>
