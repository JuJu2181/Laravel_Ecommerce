@section('title',Auth::user()->name.' - Edit Post')
<x-admin.layout>
    <div class="az-content az-content-dashboard">
        <div class="container">
            <div class="az-content-body">
                <h2>Edit Post: {{ $post->name }}</h2>
                @can('update',$post)
                <form action={{ route('admin.posts.update',$post->id) }} method='POST' enctype="multipart/form-data">
                    {{-- here we need to use POST instead of put in html as html forms only support post and get--}}
                    {{-- Then we need to add the put method as hiden field --}}
                    @method('PUT')
                    @csrf
                    {{-- for name --}}
                    <label for="title" class="m-1">Post Title: </label> 
                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"  value="{{$post->title}}">
                    @error('title')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                    {{-- for slug --}}
                <label for="slug" class="m-1">Post Slug: </label>
                <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror"
                    value="{{ $post->slug }}">
                @error('slug')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
                    {{-- for body --}}
                    <label for="body" class="m-1">Post Body: </label>
                    
                    <textarea name="body" id="" cols="30" rows="10" class="form-control @error('body') is-invalid @enderror" >{{ $post->body}}</textarea>
                    @error('body')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                {{-- for category select --}}
                {{-- for category select --}}
                <label for="category_id" class="m-1">Category:</label>
                <x-forms.select name="category_id" class="form-control ">
                    <option value="0" disabled> Select A Category</option>
                    @foreach ($categories as $category)
                    <option value="{{$category->id}}" {{ $category->id == $post->category_id?"selected":"" }}>{{$category->name}}</option>
                    @endforeach
                </x-forms.select>
                @error('category_id')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
                {{-- for images --}}
                <input type="file" name="image_upload" id="" class="form-control mt-3"  >
                <p class="m-2 text-sm text-warning">If you want the previous image to be used don't choose a new file.</p>
                {{-- for submit btn --}}
                <input type="submit" value="Update Post" name="submit" class="btn btn-primary btn-block mt-4">
                </form>
                <a href={{ route('admin.posts.index') }} class="btn btn-warning btn-block mt-2">Discard Changes</a>
                @else 
                <p class="text-danger">You are not authorized to edit this product</p>
                @endcan
            </div>
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