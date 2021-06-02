@section('title','Create New Category')
<x-admin.layout>
    <div class="az-content az-content-dashboard">
        <div class="container">
            <div class="az-content-body">
                <h2>Create Category</h2>
                <form action={{ route('admin.categories.store') }} method="post" enctype="multipart/form-data">
                    @csrf
                    {{-- for name --}}
                    <label for="name" class="m-1">Category Name: </label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}">
                    @error('name')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                    {{-- for slug --}}
                    <label for="slug" class="m-1">Category Slug: </label>
                    <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror"
                        value="{{ old('slug') }}">
                    @error('slug')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                    {{-- for description --}}
                    <label for="description" class="m-1">Category Description: </label>
                    <textarea name="description" id="" cols="30" rows="10"
                        class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                    @error('description')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                    {{-- for category --}}
                    <label for="parent_id" class="m-1">Parent Category:</label>
                    <x-forms.select name="parent_id" class="form-control ">
                        {{-- implementing for all categories using recursion --}}
                        <?php
                        function generateCategoryList($category,$spaceCount=0){
                        ?> 
                        <option value="{{ $category->id }}" {{ $category->id == old('category_id')?"selected":"" }}>{!!str_repeat('&nbsp;',$spaceCount)!!}>
                            {{ $category->name }}</option>
                        <?php    
                            // * for categories with children
                            if ($category->children->count() > 0)
                            {  
                            $spaceCount +=4;
                            foreach ($category->children as $subcategory){
                            generateCategoryList($subcategory,$spaceCount);
                            }
                        }
                        
                    }
                    ?>
                        <option value="0"> Select A Category</option>
                        @foreach (App\Models\Category::with('children')->where('parent_id',0)->get() as $category)
                        {{ generateCategoryList($category)}}
                        @endforeach
                    </x-forms.select>
                    @error('category_id')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                    {{-- for images --}}
                    <input type="file" name="image_upload" id="" class="form-control mt-3">
                    {{-- submit  --}}
                    <input type="submit" value="Create Category" name="submit" class="btn btn-success btn-block mt-4">
                </form>
            </div>
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
