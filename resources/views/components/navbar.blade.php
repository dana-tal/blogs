@props(['links'=>array()])

<nav class="flex justify-between items-center py-4 border-b border-white/10 bg-brownBear  text-white px-3">
    <div class="ml-4">
        <a href="/">
            <img src="{{ Vite::asset('resources/images/pencil.svg') }}" alt="" width="35px">
        </a>
    </div>
    <div class="space-x-6 font-bold">
    @foreach($links as $link)
    <a href="{{ $link->link }}" class="hover:bg-darkBrown px-3 py-3 rounded-xl">{{$link->title}}</a>
    @endforeach

  </div>
    @auth
        <div class="space-x-6 font-bold flex">
             <span class="py-3">Hello, {{ Auth::user()->name }}</span>
             <a href="/manage_blog" class="hover:bg-darkBrown px-3 py-3 rounded-xl">Manage Your Blog</a>
            <form method="POST" action="/logout">
                @csrf
                @method('DELETE')
                <button class="hover:bg-darkBrown px-3 py-3 rounded-xl">Log Out</button>
            </form>
        </div>
    @endauth

    @guest
    <div class="space-x-6 font-bold">
        <a href="/register" class="hover:bg-darkBrown px-3 py-3 rounded-xl">Sign Up</a>
        <a href="/login" class="hover:bg-darkBrown px-3 py-3 rounded-xl">Log In</a>
    </div>
    @endguest
</nav>
