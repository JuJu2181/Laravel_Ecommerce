<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.partials._head')
</head>

<body>

    @include('admin.partials._header')

    @include('partials._flash_messages')
    {{-- This is equivalent to @section('content') --}}
    {{ $slot }}

    @include('admin.partials._footer')


    @include('admin.partials._scripts')
</body>

</html>
