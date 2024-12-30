<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Blogs</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])


</head>
<body class="bg-antiqueWhite text-brownBear  pb-20">
    @php
     $item1 = new stdClass();
     $item1->title = 'Blogs';
     $item1->link  = '/front/blogs';

     $item2 = new stdClass();
     $item2->title = 'Articles';
     $item2->link  = '/front/articles';

    @endphp
    <div class="px-10">
        <x-navbar :links="[$item1,$item2]"/>
        <main >


            <div class="grid grid-cols-5  gap-4 h-screen">
                <div class="col-span-1 bg-camelBrown ">
                    <div class="flex justify-center mt-4 font-bold text-white">
                        <ul >
                            <x-sidebar_li  link="/blogs" :active="request()->is('blogs')">Manage Blogs</x-sidebar_li>
                            @can('viewAny',App\Models\Category::class)
                                <x-sidebar_li  link="/categories" :active="request()->is('categories')">Manage Categories</x-sidebar_li>
                            @endcan

                            @can('viewAny',App\Models\Tag::class)
                                <x-sidebar_li  link="/tags" :active="request()->is('tags')">Manage Tags</x-sidebar_li>
                            @endcan

                            <x-sidebar_li  link="/articles" :active="request()->is('articles')">Manage Articles</x-sidebar_li>
                        </ul>
                    </div>
                </div>
                <div class="col-span-4 "><div class="flex justify-center mt-4">{{ $slot }}</div></div>
            </div>






        </main>
    </div>
</body>
</html>
