@section('title','Create New Category')
<x-admin.layout>
<div class="az-content az-content-dashboard">
    <div class="container">
        <div class="az-content-body">
            <h2>Create Category</h2>
            <form action={{ route('admin.categories.store') }} method="post" enctype="multipart/form-data">
                @csrf
                <label for="name" class="m-1">Category Name: </label> 
                <input type="text" name="name" id="" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                @error('name')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
                <label for="description" class="m-1">Category Description: </label>
                <textarea name="description" id="" cols="30" rows="10" class="form-control @error('description') is-invalid @enderror" >{{ old('description') }}</textarea>
                @error('description')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
                {{-- for images --}}
                <input type="file" name="image_upload" id="" class="form-control mt-3">
                <input type="submit" value="Create Category" name="submit" class="btn btn-success btn-block mt-4">
            </form>
        </div>
    </div>
</div>
@section('scripts')
    <script>
        document.getElementById("categories").classList.add("active");
    </script>
@stop
</x-admin.layout>