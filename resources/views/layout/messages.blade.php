<ul class="max-w-lg mx-auto mt-4">
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <li class="text-xs mt-3  rounded-md text-red-950 bg-red-200 p-2">
                {{ $error }}
            </li>
        @endforeach
    @endif
    @if (session()->has('message'))
        <li class="text-xs mt-3  rounded-md text-lime-600 bg-lime-200 p-2">
            {{ session('message') }}
        </li>
    @endif
</ul>
