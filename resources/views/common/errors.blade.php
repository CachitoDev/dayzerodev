@if($errors->any())
    @foreach($errors->all() as $error)
        <span
            class="mb-2 px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">
            {{ $error }}
        </span>
    @endforeach
@endif
