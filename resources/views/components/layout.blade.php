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
        <main class="mt-10 max-w-[986px] mx-auto">
            {{ $slot }}
        </main>
    </div>
</body>
</html>
