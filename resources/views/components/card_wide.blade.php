
@props(['blog','page'])

<div class="flex flex-row gap-4 ">
    <div ><image src="{{ asset($blog->image) }}"  class="rounded-xl !h-32" width="220px" /></div>
    <div  class="flex-1 flex flex-col ">
            <h3 class="font-bold text-xl  group-hover:text-red-800 transition-colors duration-300">
                <a href="/front/blog/{{$blog->id}}/{{ $page }}"  class="underline"> {{ $blog->subject }}</a>
            </h3>
            <span class=" text-amber-850">By: <a href="#" class="self-start text-md">{{ $blog->user->name }}</a>, {{ $blog->created_at }}</span>
            <p class="text-md text-amber-950  ">{{ $blog->description }}</p>
    </div>


</div>
