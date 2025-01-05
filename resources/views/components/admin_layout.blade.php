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
     $item1->link  = env('APP_URL').'/front/blogs';

     $item2 = new stdClass();
     $item2->title = 'Articles';
     $item2->link  = env('APP_URL').'/front/articles';

    @endphp
    <div class="px-10">
        <x-navbar :links="[$item1,$item2]"/>
        <main >


            <div class="grid grid-cols-5  gap-4 h-screen">
                <div class="col-span-1 bg-camelBrown ">
                    <div class="flex justify-center mt-4 font-bold text-white">
                        <ul >
                            <x-sidebar_li  link="{{ env('APP_URL') }}/blogs" :active="request()->is('blogs')">Manage Blogs</x-sidebar_li>
                            @can('viewAny',App\Models\Category::class)
                                <x-sidebar_li  link="/categories" :active="request()->is('categories')">Manage Categories</x-sidebar_li>
                            @endcan

                            @can('viewAny',App\Models\Tag::class)
                                <x-sidebar_li   link="{{ env('APP_URL') }}/tags" :active="request()->is('tags')">Manage Tags</x-sidebar_li>
                            @endcan


                            <x-sidebar_li link="#" mb="mb-0">
                                <button type="button" id="manage">Manage Articles </button>
                            </x-sidebar_li >
                            <ul id="blogs_list" class="list-disc mx-auto ms-12 w-60 justify-center mt-0 hidden">
                                @foreach(Auth::user()->blogs as $blog)
                                    <li><a href="{{ env('APP_URL') }}/articles/{{$blog->id}}" class="hover:bg-brownBear">{{ $blog->subject }}</a></li>
                                @endforeach
                            </ul>






                        </ul>
                    </div>
                </div>
                <div class="col-span-4 "><div class="flex justify-center mt-4">{{ $slot }}</div></div>
            </div>






        </main>
    </div>
</body>
<script type="module">
        $("#manage").click(function(){

            $('#blogs_list').toggle();
        });
</script>
</html>
