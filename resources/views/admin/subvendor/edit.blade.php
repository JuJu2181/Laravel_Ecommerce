@section('title',Auth::user()->name.' - Edit Sub-Vendor')
<x-admin.layout>
<div class="az-content az-content-dashboard">
    <div class="container">
        @unless(Auth::user()->role == 'user' || Auth::user()->vendor_staus == 'not_verified')
        <div class="az-content-body">
            <h2>Edit {{$subvendor->name}} Details for <span id="vendor_name">{{Auth::user()->name}}</span></h2>
            {{-- check if user is authorized to create a product --}}
            <form action={{ route('admin.subvendors.update',$subvendor->id) }} method="post" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                {{-- for name --}}
                <label for="name" class="m-1">Sub-Vendor Name: </label> 
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="sub-vendor name" value="{{$subvendor->name}}">
                @error('name')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
                {{-- for email --}}
                <label for="email" class="m-1">Sub Vendor Email: </label>
                <input type="text" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="sub-vendor email"
                value="{{$subvendor->email}}">
                @error('email')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
                {{-- password --}}
                <label for="password" class="m-1">Password: </label>
                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required value="test1234">
                @error('password')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
                {{-- hidden vendor_id field --}}
                <input type="hidden" name="vendor_id" id="vendor_id" value="{{Auth::id()}}">
                {{-- multiple select checkboxes for responsibilities --}}
                <div class="form-group mt-3">
                    <label><strong>Responsibilites: </strong></label>
                    @php
                        $responsibilities = ['Products','Posts','Orders','Reviews','Comments'];
                    @endphp
                    @foreach ($responsibilities as $responsibility)
                    <label class="mr-3"><input type="checkbox" name="responsibility[]" value="{{strtolower($responsibility)}}" {{in_array(strtolower($responsibility),json_decode($subvendor->responsibility))?"checked":""}}> {{$responsibility}} 
                    </label>
                    @endforeach
                </div>
                @error('responsibility')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
                {{-- submit btn --}}
                <input type="submit" value="Edit {{$subvendor->name}} Details" name="submit" class="btn btn-info btn-block mt-4">
            </form>
        </div>
        @else 
        <h3 class="text-danger">You are Not authorized</h3>
        @endunless
    </div>
</div>
@section('scripts')
    <script>
        document.getElementById("subvendors").classList.add("active");
        // for auto generating sub_vendor email based on sub_vendor name 
        $(document).ready(($) => {
        $('#name').on('change', () => {
            let name = $('#name').val();
            console.log('name: ', name);
            let vendor_name = $('#vendor_name').html();
            console.log(vendor_name);
            // using regular expression to remove space with -
            let name_formatted = name.replace(/\s+/g, '_').toLowerCase();
            let vendor_name_formatted = vendor_name.replace(/\s+/g,'_').toLowerCase();
            let email = name_formatted+'_'+vendor_name_formatted+'@mail.com'
            $('#email').val(email);
        });
    });
    </script>
@stop
</x-admin.layout>