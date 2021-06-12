@section('title','Details For Message '.$contact->id)
<x-admin.layout>
<div class="az-content az-content-dashboard">
    <div class="container">
        <div class="az-content-body">
            <div class="jumbotron">
                <h2>Details For Message {{$contact->id}}</h2>
                <div class="text-info" style="font-size: 1.1rem;">Sender Name: {{$contact->name}}</div>
                <div class="text-info" style="font-size: 1.1rem;">Sender Email: {{$contact->email}}</div>
                <div class="text-info" style="font-size: 1.1rem;">Sender Contact No. : {{$contact->number}}</div>
                <div class="text-black text-bold" style="font-size: 1.1rem;">Subject: {{$contact->subject}}</div>
                <div class="text-gray-500" style="font-size: 1.1rem;">Message: {{$contact->message}}</div>
                
                 {{-- to directly delete the product instead of redirecting to the delete page --}}
                <form action={{ route('admin.contacts.destroy',$contact->id) }} method="post" class="mt-2" id="deleteForm">
                @method('DELETE')
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-block mt-5" id="deleteButton">
                    <span><i class="typcn typcn-trash mr-3"></i></span>
                    Delete This Message
                </button>
                </form>
                <a href="{{route('admin.contacts.index')}}" class="btn btn-outline-dark btn-block mt-5">View All Messages</a>
            </div>
        </div>
    </div>
</div>    
@section('scripts')
    <script>
        // to toggle active state
        document.getElementById("contacts").classList.add("active");
    </script>
@stop
</x-admin.layout>