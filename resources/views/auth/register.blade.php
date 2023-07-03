@extends('layout.layout')

@section('title', 'Register')
@section('content')
    <section class="mt-6 p-3">
        <form action="{{ route('post.register') }}" method="POST"
            class="w-full max-w-md m-3 p-3 rounded-md border border-slate-400 mx-auto">
            @csrf
            @method('POST')
            <h1 class="text-3xl font-semibold">Register</h1>
            <hr class="my-3 border">
            <div class="flex flex-col gap-3">
                <label class="flex flex-col gap-2" for="">
                    <span>Name</span>
                    <input value="{{ old('name') }}" class="p-2 rounded-md bg-slate-300" type="text" name="name"
                        id="">
                </label>
                <label class="flex flex-col gap-2" for="">
                    <span>Email</span>
                    <input value="{{ old('email') }}" class="p-2 rounded-md bg-slate-300" type="email" name="email"
                        id="">
                </label>
                <label class="flex flex-col gap-2" for="">
                    <span>Password</span>
                    <input class="p-2 rounded-md bg-slate-300" type="password" name="password" id="">
                </label>
            </div>
            <hr class="my-3 border">
            <div>
                <button class="p-2 rounded bg-blue-600 hover:bg-blue-400 text-white" type="submit">Register</button>
            </div>
        </form>
        @include('layout.messages')
    </section>
@endsection
