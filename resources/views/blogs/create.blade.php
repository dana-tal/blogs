<x-admin_layout>
    <div class="grid grid-cols-1">
        <x-page-heading>Create A New Blog</x-page-heading>
        <x-forms.form method="POST" action="/blogs" enctype="multipart/form-data">
            <x-forms.input label="Subject" name="subject" />
            <x-forms.input label="Description" name="description"  type="textarea"   rows="5"/>
            <x-forms.input label="Upload Image" name="image" type="file" />
            <x-forms.button>Create Blog</x-forms.button>
        </x-forms.form>
    </div>
</x-admin_layout>
