
        <x-layout>
            <div class="flex justify-center ">
                <div class="grid grid-cols-1">
                    <h1 class="mb-2 flex justify-center text-3xl font-bold text-green-700">Newest Blogs</h1>
                    <ul>
                        @foreach ($blogs as $blog)
                            <li class="mb-2">
                                <x-card_wide :$blog :page="$blogs->currentPage()"/>
                            </li>
                        @endforeach
                    </ul>

                    <div class="flex justify-center mt-5">
                        {{ $blogs->links() }}
                    </div>
                </div>


            </div>
        </x-layout>
