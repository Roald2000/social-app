@extends('layout.layout')
@section('title', 'Edit Post')
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
                        placeholder="Write something....">{{ $post->content }}</textarea>
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
                            <input hidden type="file"
                                name="file" id="file_post">
                        </label>

                        <img src="{{ $post->file ? asset('/post_files/' . $post->file) : '' }}" alt=""
                            class="hidden w-[150px] h-[150px]" id="img">

                    </div>
                    <button type="submit" class="p-1 rounded w-fit border-black border self-end">Post</button>
                </form>
            @else
                <p><a class="font-bold text-blue-600" href="{{ route('view.login') }}">Login</a> to create posts</p>
            @endauth
        </div>
    </section>
    @push('scripts')
        <script>
            document.getElementById('file_post').onchange = function() {
                var src = URL.createObjectURL(this.files[0])

                if (src) {
                    document.getElementById('img').classList.toggle('hidden');
                }

                document.getElementById('img').src = src
            }
        </script>
    @endpush
@endsection
