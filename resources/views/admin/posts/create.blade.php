@section('title',Auth::user()->name.' - Create New Post')
<x-admin.layout>
<div class="az-content az-content-dashboard">
    <div class="container">
        @unless(Auth::user()->role == 'user')
        <div class="az-content-body">
            <h2>Create Product</h2>
            {{-- check if user is authorized to create a product --}}
            <form action={{ route('admin.posts.store') }} method="post" enctype="multipart/form-data">
                @csrf
                {{-- for name --}}
                <label for="title" class="m-1">Post Title: </label> 
                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}">
                @error('title')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
                {{-- for slug --}}
                <label for="slug" class="m-1">Post Slug: </label>
                <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror"
                    value="{{ old('slug') }}">
                @error('slug')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
                {{-- for description --}}
                <label for="body" class="m-1">Post Body: </label>
                <textarea name="body" id="" cols="30" rows="10" class="form-control @error('body') is-invalid @enderror" >{{ old('body') }}</textarea>
                @error('body')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
                {{-- for category select --}}
                <label for="category_id" class="m-1">Category:</label>
                <x-forms.select name="category_id" class="form-control ">
                    <option value="0"> Select A Category</option>
                    @foreach ($categories as $category)
                    <option value="{{$category->id}}" {{ $category->id == old('category_id')?"selected":"" }}>{{$category->name}}</option>
                    @endforeach
                </x-forms.select>
                @error('category_id')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
                {{-- for images --}}
                <input type="file" name="image_upload" id="" class="form-control mt-3" >
                {{-- submit btn --}}
                <input type="submit" value="Create Post" name="submit" class="btn btn-success btn-block mt-4">
            </form>
        </div>
        @else 
        <h3 class="text-danger">You are Not authorized</h3>
        @endunless
    </div>
</div>
@section('scripts')
    <script>
        document.getElementById("posts").classList.add("active");
        // for auto generating title based on input 
        $(document).ready(($) => {
        $('#title').on('change', () => {
            let title = $('#title').val();
            console.log('title: ', title);
            // using regular expression to remove space with -
            let slug = title.replace(/\s+/g, '-').toLowerCase();
            console.log('slug', slug);
            $('#slug').val(slug);
        });
    });

    </script>
@stop
</x-admin.layout>