@extends('layout.layout')
@section('title', 'Check Profile')
@section('content')
    <section class="mt-6 p-3">
        <div class="relative max-w-lg border mx-auto shadow-lg rounded p-5">
            <div class="flex flex-row gap-3 justify-between items-center">
                <h1 class="text-3xl">Profile</h1>
                @if (!$profile)
                    <p class="text-xs">This user has not setup their profile</p>
                @endif
            </div>
            <hr class="my-3 border-red-700">
            <div
                class="relative mx-auto overflow-hidden rounded-[100%] max-w-[150px] h-[150px] outline outline-offset-2 outline-purple-600">
                <img id="image" class="select-none" src="{{ asset($profile ? '/profile_images/' . $profile->pfp : '') }}"
                    alt="">
            </div>
            <p class="my-3 text-center">{{ $user->email }}</p>
            <hr class="my-3 border-red-700">
            @if ($profile->status == 1)
                <table class="w-full">
                    <tr>
                        <th class="text-end p-2 w-1/5">Name</th>
                        <td class=" w-4/5">{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th class="text-end p-2 w-1/5">Contact</th>
                        <td class=" w-4/5">{{ $profile ? $profile->contact : 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th class="text-end p-2 w-1/5">Address</th>
                        <td class=" w-4/5">{{ $profile ? $profile->address : 'N/A' }}</td>
                    </tr>
                </table>
            @else
                <p>This User is private</p>
            @endif
        </div>
    </section>
@endsection
