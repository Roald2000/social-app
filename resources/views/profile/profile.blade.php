@extends('layout.layout')
@section('title', auth()->user()->name)
@section('content')
    <section class="mt-6 p-3">

        <form class="relative max-w-lg border mx-auto shadow-lg rounded p-5" method="POST" enctype="multipart/form-data"
            action="{{ route('user.save-profile') }}">
            @csrf
            <div class="flex justify-between items-center">
                <h1 class="text-3xl">Profile</h1>
                @auth
                    <div>
                        <button class="p-2 rounded bg-black text-white" id="setEdit" type="button">Edit</button>
                        @if ($profile)
                            <a href="{{ route('user.delete-profile', ['profile_id' => $profile->id]) }}"
                                class="p-2 rounded bg-red-600 text-white">Delete</a>
                        @endif
                    </div>
                @endauth
            </div>
            <hr class="my-3 border-red-700">
            <div
                class="relative mx-auto overflow-hidden rounded-[100%] max-w-[150px] h-[150px] outline outline-offset-2 outline-purple-600">
                <img id="image" class="select-none"
                    src="{{ asset($profile ? '/profile_images/' . $profile->pfp : '') }}" alt="">
                @auth
                    <label class="absolute  bottom-0 p-3 text-center left-1/2 -translate-x-1/2 bg-[#ccc9] w-full cursor-pointer"
                        for="file">Edit</label>
                    <input disabled class="edit-inputs" type="file" name="pfp" id="file" hidden>
                @endauth
            </div>
            <p class="my-3 text-center">{{ auth()->user()->email }}</p>
            <hr class="my-3 border-red-700">
            <table class="w-full">
                <tr class="">
                    <th class="text-end p-2 w-1/5">Name</th>
                    <td class=" w-4/5">
                        <input disabled value="{{ auth()->user()->name }}"
                            class="edit-inputs p-2 w-full border-b-2 border-black" value="" type="text"
                            name="name" id="">
                    </td>
                </tr>
                <tr>
                    <th class="text-end p-2 w-1/5">Contact</th>
                    <td class=" w-4/5">
                        <input disabled value="{{ $profile ? $profile->contact : '' }}"
                            class="edit-inputs p-2 w-full border-b-2 border-black" type="text" name="contact"
                            id="">
                    </td>
                </tr>
                <tr>
                    <th class="text-end p-2 w-1/5">Address</th>
                    <td class=" w-4/5">
                        <input disabled value="{{ $profile ? $profile->address : '' }}"
                            class="edit-inputs p-2 w-full border-b-2 border-black" type="text" name="address"
                            id="">
                    </td>
                </tr>
                <tr>
                    <th class="text-end p-2 w-1/5">Status</th>
                    <td class=" w-4/5">
                        <select disabled class="edit-inputs" name="status" id="status">
                            @if ($profile)
                                @if ($profile->status == 1)
                                    <option value="1">Public</option>
                                    <option value="0">Private</option>
                                @else
                                    <option value="0">Private</option>
                                    <option value="1">Public</option>
                                @endif
                            @else
                                <option value="0">Private</option>
                                <option value="1">Public</option>
                            @endif
                        </select>
                    </td>
                </tr>
            </table>
            <hr class="my-3 border-red-700">
            <div class="w-fit mx-auto submit-div hidden">
                <button class="bg-blue-600 text-white font-semibold p-2 rounded-md" type="submit">Save</button>
            </div>
        </form>
        @include('layout.messages')
    </section>

    @push('scripts')
        <script>
            document.getElementById('file').onchange = function() {
                var src = URL.createObjectURL(this.files[0])
                document.getElementById('image').src = src
            }

            document.querySelector("#setEdit").addEventListener('click', () => {

                if (document.querySelector("#setEdit").innerText == "Edit") {
                    document.querySelector("#setEdit").innerText = "Cancel";
                } else {
                    document.querySelector("#setEdit").innerText = "Edit";
                }

                document.querySelectorAll('.edit-inputs').forEach(element => {
                    if (element.disabled == true) {
                        element.disabled = false;
                        document.querySelector('.submit-div').classList.remove('hidden')
                    } else {
                        document.querySelector('.submit-div').classList.add('hidden')
                        element.disabled = true
                    }
                });

            })
        </script>
    @endpush
@endsection
