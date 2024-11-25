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
     $jobs = new stdClass();
     $jobs->title = 'Home';
     $jobs->link  = '/';

     $careers = new stdClass();
     $careers->title = 'Careers';
     $careers->link  = '/careers';

     $salaries = new stdClass();
     $salaries->title = 'Salaries';
     $salaries->link  = '/salaries';
    @endphp
    <div class="px-10">
        <x-navbar :links="[$jobs,$careers,$salaries]"/>
        <main >


            <div class="grid grid-cols-5  gap-4 h-screen">
                <div class="col-span-1 bg-camelBrown ">
                    <div class="flex justify-center mt-4 font-bold text-white">
                        <ul >
                            <x-sidebar_li  link="/blogs" :active="request()->is('blogs')">Manage Blogs</x-sidebar_li>
                            <x-sidebar_li  link="/categories" :active="request()->is('categories')">Manage Categories</x-sidebar_li>
                            <x-sidebar_li  link="/tags" :active="request()->is('tags')">Manage Tags</x-sidebar_li>
                            <x-sidebar_li  link="/articles" :active="request()->is('articles')">Manage Articles</x-sidebar_li>
                            <x-sidebar_li  link="/images" :active="request()->is('images')">Manage Images</x-sidebar_li>
                        </ul>
                    </div>
                </div>
                <div class="col-span-4 "><div class="flex justify-center mt-4">{{ $slot }}</div></div>
            </div>






        </main>
    </div>
</body>
</html>
