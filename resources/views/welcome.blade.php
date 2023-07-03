@extends('layout.layout')
@section('title', 'Welcome')
@section('content')

    <section class="w-full max-w-lg p-2 rounded mx-auto">
        <div class="">
            <h1 class="text-3xl font-semibold text-start my-3">Create Post</h1>
            @auth
                <form enctype="multipart/form-data" action="{{ route('create.post') }}" method="POST"
                    class=" flex flex-col gap-3 justify-stretch items-start">
                    @csrf
                    @method('POST')
                    <textarea name="content" rows="8" id="" class="border border-black p-2 rounded w-full resize-none"
                        placeholder="Write something...."></textarea>
                    <div class="text-xs flex flex-row justify-center items-center gap-3">
                        <span>Set Post Status as : </span>
                        <label class="flex items-center gap-1" for="post_status-public">
                            <input checked value="0" type="radio" name="status" id="post_status-public">
                            <span>Public</span>
                        </label>
                        <label class="flex items-center gap-1" for="post_status-private">
                            <input class="" value="1" type="radio" name="status" id="post_status-private">
                            <span class="">Private</span>
                        </label>
                    </div>
                    <div class="flex items-start justify-start gap-2 w-full border p-1 rounded">
                        <label for="file_post"
                            class="border border-black p-1 bg-black text-white hover:bg-white hover:text-black rounded-md outline-inherit w-fit cursor-pointer">
                            <span>Attach Picture</span>
                            <input hidden type="file" name="file" id="file_post">
                        </label>
                        <img src="" alt="" class="hidden w-[150px] h-[150px]" id="img">
                    </div>
                    <button type="submit" class="p-1 rounded w-fit border-black border self-end">Post</button>
                </form>
            @else
                <p><a class="font-bold text-blue-600" href="{{ route('view.login') }}">Login</a> to create posts</p>
            @endauth
        </div>
        @include('layout.messages')
    </section>
    <section class="w-full max-w-lg p-2 rounded mx-auto">
        <div class="">
            <h1 class="text-3xl font-semibold text-start my-3">Posts</h1>
        </div>

        @if (!$posts || count($posts) === 0)
            <p>No Posts Found</p>
        @else
            @foreach ($posts as $post)
                <div class="mt-3 border-2 border-black shadow-md p-3 rounded">
                    <div class="flex justify-between items-start">
                        <div>
                            <a href="{{ route('user.see-profile', ['id' => $post->user->id]) }}">{{ $post->user->name }}</a>
                            <ul class="text-xs ">
                                <li class="inline-flex">{{ $post->created_at->diffForHumans() }}</li>
                                <li class="inline-flex">{{ $post->updated_at->diffForHumans() }}</li>
                            </ul>
                        </div>
                        @if ($post->user_id == auth()->user()->id)
                            <div class="text-xs ">
                                <a href="#Edit">Edit</a>
                                <a href="#Delete">Delete</a>
                                <a href="#Private">Private</a>
                            </div>
                        @endif
                    </div>
                    <hr class="my-3 border border-red-600">
                    <div class="h-full">
                        <p class="w-full p-2 rounded bg-slate-100">{{ $post->content }}</p>
                        @if ($post->file)
                            <div class="w-full overflow-clip rounded">
                                <img class="w-full h-full" src="{{ asset('post_files/' . $post->file) }}" alt="">
                            </div>
                        @endif
                    </div>
                    <hr class="my-3 border border-red-600">
                    <div>
                        <button onclick="toggleComment({{ $post->id }})" type="button">Comments</button>
                        <ul id="comments_{{ $post->id }}" class="text-xs hidden overflow-y-scroll pr-3 h-[200px]">
                            <li class="p-2 bg-slate-200 rounded mt-2 ml-3">Comment1</li>
                            <li class="p-2 bg-slate-200 rounded mt-2 ml-3">Comment2</li>
                            <li class="p-2 bg-slate-200 rounded mt-2 ml-3">Comment3</li>
                            <li class="p-2 bg-slate-200 rounded mt-2 ml-3">Comment3</li>
                            <li class="p-2 bg-slate-200 rounded mt-2 ml-3">Comment3</li>
                            <li class="p-2 bg-slate-200 rounded mt-2 ml-3">Comment3</li>
                            <li class="p-2 bg-slate-200 rounded mt-2 ml-3">Comment3</li>
                            <li class="p-2 bg-slate-200 rounded mt-2 ml-3">Comment3</li>
                            <li class="p-2 bg-slate-200 rounded mt-2 ml-3">Comment3</li>
                            <li class="p-2 bg-slate-200 rounded mt-2 ml-3">Comment3</li>
                        </ul>
                    </div>
                </div>
            @endforeach

        @endif



    </section>

    @if (session()->has('message'))
        <p class="p-2 fixed bottom-3 right-3 bg-green-900 rounded text-white z-50" id="popup"> {{ session('message') }}
        </p>
    @endif
    @push('scripts')
        <script>
            document.getElementById('file_post').onchange = function() {
                var src = URL.createObjectURL(this.files[0])

                if (src) {
                    document.getElementById('img').classList.toggle('hidden');
                }

                document.getElementById('img').src = src
            }

            function toggleComment(id) {
                document.querySelector(`#comments_${id}`).classList.toggle('hidden')
            }

            setTimeout(() => {
                document.getElementById("popup").remove();
            }, 10000);
        </script>
    @endpush
@endsection
