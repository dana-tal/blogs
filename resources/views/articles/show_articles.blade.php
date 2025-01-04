@php
   $article_q = session('article_q')??'';
   $cat = session('cat')??'';
   $ind =0;
@endphp

<x-layout>
    <div class="flex justify-center w-full ">
        <div class="grid grid-cols-1 w-full ">
            <h1 class="mb-2 flex justify-center text-3xl font-bold text-green-700">Newest Articles</h1>

            <x-forms.form action="/front/articles/search" class="mt-6 mb-6 w-full">
                <x-forms.input label="Search" name="q" placeholder="Info..."  value="{{ $article_q }}"/>
                <div class="grid grid-cols-5 gap-3">
                    <span ><label class="font-bold" for="cat_id">Category:</label></span>
                    <div class="col-span-4">
                        <select  name="cat" id="cat" class="w-full bg-white">
                            <option value="">Select a category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id',$cat)==$category->id ? 'selected':'' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <x-forms.button type="submit">Submit</x-forms.button>
            </x-forms.form>

            <ul>
                @foreach ($articles as $article)
                    <li class="mb-2">
                        <x-article_card :$article :article_ind="$ind"  :page_id="$articles->currentPage()"/>
                    </li>
                    @php
                     $ind++;
                    @endphp
                @endforeach
            </ul>

            <div class="flex justify-center mt-5">
                {{ $articles->withQueryString()->links() }}
            </div>
        </div>


    </div>
</x-layout>
