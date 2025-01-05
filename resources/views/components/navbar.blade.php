@props(['links'=>array()])

<nav class="flex justify-between items-center py-4 border-b border-white/10 bg-brownBear  text-white px-3">
    <div class="ml-4">
        <a href="/">
            <img src="{{ Vite::asset('resources/images/pencil.svg') }}" alt="" width="35px">
        </a>
    </div>
    <div class="space-x-6 font-bold">
        @foreach($links as $link)
        <a href="{{ $link->link }}" class="hover:bg-darkBrown px-3 py-3 rounded-xl {{ request()->is(substr($link->link,1)) ? 'underline':'' }} ">
            {{$link->title}}</a>
        @endforeach

        <div class="relative"  style="display:inline-flex" data-twe-dropdown-ref>
            <button
              class="flex items-center rounded bg-primary px-6 pb-2 pt-2.5  font-bold  leading-normal text-white shadow-primary-3 transition duration-150 ease-in-out hover:bg-primary-accent-300 hover:shadow-primary-2 focus:bg-primary-accent-300 focus:shadow-primary-2 focus:outline-none focus:ring-0 active:bg-primary-600 active:shadow-primary-2 motion-reduce:transition-none dark:shadow-black/30 dark:hover:shadow-dark-strong dark:focus:shadow-dark-strong dark:active:shadow-dark-strong"
              type="button"
              id="dropdownMenuButton1"
              data-twe-dropdown-toggle-ref
              aria-expanded="false"
              data-twe-ripple-init
              data-twe-ripple-color="light">
              Articles By Category
              <span class="ms-2 w-2 [&>svg]:h-5 [&>svg]:w-5">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 20 20"
                  fill="currentColor">
                  <path
                    fill-rule="evenodd"
                    d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                    clip-rule="evenodd" />
                </svg>
              </span>
            </button>
            <ul
              class="w-full absolute z-[1000] float-left m-0 hidden min-w-max list-none overflow-hidden rounded-lg border-none bg-orange-100 bg-clip-padding text-base shadow-lg data-[twe-dropdown-show]:block dark:bg-surface-dark"
              aria-labelledby="dropdownMenuButton1"
              data-twe-dropdown-menu-ref>

                @foreach($lay_categories as $cat)
                    <li >
                        <a
                        class="text-center block w-full whitespace-nowrap bg-orange-100 px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-deerBrown focus:bg-zinc-200/60 focus:outline-none active:bg-zinc-200/60 active:no-underline dark:bg-surface-dark dark:text-white dark:hover:bg-neutral-800/25 dark:focus:bg-neutral-800/25 dark:active:bg-neutral-800/25"
                        href="{{ env('APP_URL') }}/front/articles/search?q=&cat={{ $cat->id }}"
                        data-twe-dropdown-item-ref
                        >
                        {{ $cat->name }}
                    </a>
                    </li>
                @endforeach
            </ul>
        </div>





  </div>

    @auth
        <div class="space-x-6 font-bold flex">
             <span class="py-3">Hello, {{ Auth::user()->name }}</span>
             <a href="{{ env('APP_URL') }}/blogs" class="hover:bg-darkBrown px-3 py-3 rounded-xl {{ request()->is('blogs')? 'underline':'' }}">Manage Your Blog</a>
            <form method="POST" action="{{ env('APP_URL') }}/logout">
                @csrf
                @method('DELETE')
                <button class="hover:bg-darkBrown px-3 py-3 rounded-xl">Log Out</button>
            </form>
        </div>
    @endauth

    @guest
    <div class="space-x-6 font-bold">
        <a href="{{ env('APP_URL') }}/register" class="hover:bg-darkBrown px-3 py-3 rounded-xl">Sign Up</a>
        <a href="{{ env('APP_URL') }}/login" class="hover:bg-darkBrown px-3 py-3 rounded-xl">Log In</a>
    </div>
    @endguest
</nav>
