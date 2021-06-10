@section('title',Auth::user()->name.' - Edit Category')
<x-admin.layout>
    <div class="az-content az-content-dashboard">
        <div class="container">
            @can('authorize-category')
            <div class="az-content-body">
                <h2>Edit Category</h2>
                <form action={{ route('admin.categories.update',$category1->id) }} method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    {{-- for name --}}
                    <label for="name" class="m-1">Category Name: </label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                        value="{{ $category1->name }}">
                    @error('name')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                    {{-- for slug --}}
                    <label for="slug" class="m-1">Category Slug: </label>
                    <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror"
                        value="{{ $category1->slug }}">
                    @error('slug')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                    {{-- for description --}}
                    <label for="description" class="m-1">Category Description: </label>
                    <textarea name="description" id="" cols="30" rows="10"
                        class="form-control @error('description') is-invalid @enderror">{{ $category1->description }}</textarea>
                    @error('description')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                    {{-- for category --}}
                    <label for="parent_id" class="m-1">Parent Category:</label>
                    <x-forms.select name="parent_id" class="form-control ">
                        {{-- implementing for all categories using recursion --}}
                        <?php
                        function generateCategoryList($category,$category1,$spaceCount=0){
                        ?> 
                    {{-- '&nbsp;' is for printing space --}}
                        <option value="{{ $category->id }}" {{ $category->id == $category1->id?"selected":"" }}>{!!str_repeat('&nbsp;',$spaceCount)!!}>
                            {{ $category->name }}</option>
                        <?php    
                            // * for categories with children
                            if ($category->children->count() > 0)
                            {  
                            $spaceCount +=4;
                            foreach ($category->children as $subcategory){
                            generateCategoryList($subcategory,$category1,$spaceCount);
                            }
                        }
                        
                    }
                    ?>
                        <option value="0"> Select A Category</option>
                        @foreach ($categories as $category)
                        {{ generateCategoryList($category,$category1)}}
                        @endforeach
                    </x-forms.select>
                    @error('category_id')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                    {{-- for images --}}
                    <input type="file" name="image_upload" id="" class="form-control mt-3">
                    <p class="m-2 text-sm text-warning">If you want the previous image to be used don't choose a new file.</p>
                    {{-- submit  --}}
                    <input type="submit" value="Update Category" name="submit" class="btn btn-primary btn-block mt-4">
                </form>
                <a href={{ route('admin.categories.index') }} class="btn btn-warning btn-block mt-2">Discard Changes</a>
            </div>
            @else 
            <h3 class="text-danger">You are unauthorized</h3>
            @endcan
        </div>
    </div>
    @section('scripts')
    <script>
        document.getElementById("categories").classList.add("active");
        // for auto generating title based on input 
        $(document).ready(($) => {
            $('#name').on('change', () => {
                let name = $('#name').val();
                console.log('name: ', name);
                // using regular expression to remove space with -
                let slug = name.replace(/\s+/g, '-').toLowerCase();
                console.log('slug', slug);
                $('#slug').val(slug);
            });
        });

    </script>
    @stop
</x-admin.layout>
