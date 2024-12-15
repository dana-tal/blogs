@php
   $blog_q = session('blog_q')??'';
@endphp
        <x-layout>
            <div class="flex justify-center ">
                <div class="grid grid-cols-1 ">
                    <h1 class="mb-2 flex justify-center text-3xl font-bold text-green-700 ">Newest Blogs</h1>

                    <x-forms.form action="/front/blogs/search" class="mt-6 mb-6 w-full">
                        <x-forms.input label="Search" name="q" placeholder="Technology..."  value="{{ $blog_q }}"/>
                    </x-forms.form>

                    <ul >
                        @foreach ($blogs as $blog)
                            <li class="mb-2">
                                <x-card_wide :$blog :page="$blogs->currentPage()"/>
                            </li>
                        @endforeach
                    </ul>

                    <div class="flex justify-center mt-5">
                        {{ $blogs->withQueryString()->links() }}
                    </div>
                </div>


            </div>
        </x-layout>
