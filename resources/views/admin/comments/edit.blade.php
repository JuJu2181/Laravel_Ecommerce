@section('title',Auth::user()->name.' - Edit Comment For '.$comment->post->title)
<x-admin.layout>
    <div class="az-content az-content-dashboard">
        <div class="container">
            <div class="az-content-body">
                <h2>Edit Comment For: {{ $comment->post->title }}</h2>
                <form action={{ route('admin.comments.update',$comment->id) }} method='POST' >
                    {{-- here we need to use POST instead of put in html as html forms only support post and get--}}
                    {{-- Then we need to add the put method as hiden field --}}
                    @method('PUT')
                    @csrf
                    <label for="body" class="mt-4">Edit Comment: </label>
                    <textarea name="body" id="comment" cols="30" rows="10" class="form-control @error('body') is-invalid @enderror" required>{{$comment->body}}</textarea>
                    @error('body')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                {{-- for submit btn --}}
                <input type="submit" value="Update Comment" name="submit" class="btn btn-primary btn-block mt-4">
                </form>
                <a href={{ route('admin.comments.show',$comment->id) }} class="btn btn-warning btn-block mt-2">Discard Changes</a>
            </div>
        </div>
    </div>

    @section('scripts')
    <script>
        document.getElementById("comments").classList.add("active");
    </script>
    @stop
    </x-admin.layout>