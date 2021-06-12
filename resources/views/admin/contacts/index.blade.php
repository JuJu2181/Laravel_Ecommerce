@section('title',Auth::user()->name.' - All Contact Messages')
<x-admin.layout>
<div class="az-content az-content-dashboard">
    <div class="container">
        <div class="az-content-body">
            <h2>All Contact Messages</h2>
            <div class="table-responsive">
                <table class="table table-hover table-bordered mg-b-0">
                    <tr>
                        <td>S.N.</td>
                        <td>Name</td>
                        <td>Subject</td>
                        <td>Email</td>
                        <td>Contact No</td>
                        <td>Message</td>
                        <td>Actions</td>
                    </tr>
                    @foreach ($contacts as $contact)
                    <tr id="contactId{{ $contact->id }}">
                        
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $contact->name }}</td>
                        <td>{{$contact->subject}}</td>
                        <td>{{$contact->email}}</td>
                        <td>{{$contact->number}}</td>
                        <td>  {{ Str::substr($contact->message, 0, 50) }} {{ strlen($contact->message) > 50 ? "...": "" }}</td>
                        <td>
                            <a href={{ route('admin.contacts.show',$contact->id) }} class="btn btn-info btn-block">  
                                View Details
                                <span><i class="typcn typcn-edit"></i></span>
                                </a>


                                 {{-- to directly delete the product instead of redirecting to the delete page --}}
                                <form action={{ route('admin.contacts.destroy',$contact->id) }} method="post" class="mt-2" id="deleteForm">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-danger btn-block" id="deleteButton">
                                    Delete
                                    <span><i class="typcn typcn-trash"></i></span>
                                </button>
                                </form>

                                {{-- to delete using ajax request --}}
                                {{-- <meta name="csrf-token" content="{{ csrf_token() }}">
                                <button id="deleteContact" data-id="{{ $contact->id }}" class="btn btn-danger btn-block mt-2" onclick="deleteContact({{ $contact->id }})">Delete
                                <span><i class="typcn typcn-trash"></i></span
                                </button> --}}
                        </td>
                        </tr>
                        @endforeach
                </table>
                <div class="mt-5 mx-auto">
                    {{ $contacts->links() }}
                </div>
            </div>
        </div>
    </div>
</div>    
@section('scripts')
    <script>
        // to toggle active state
        document.getElementById("contacts").classList.add("active");
        // for deleting by form
        const deleteButton = document.getElementById("deleteButton");
        deleteButton.addEventListener("click",(e)=>{
            e.preventDefault();
            if(confirm("Are you sure to delete this product?\n press 'OK' to confirm")){
                console.log("deleted");
                document.getElementById("deleteForm").submit();
            }else{
                console.log("cancelled");
            }
        });

        // for ajax delete
        // delete is working here but it is not removing row from table
        // function deleteContact(id){
        //     console.log(id);
        //     let token = $("meta[name='csrf-token']").attr("content");
        //     if(confirm("Are you sure to delete this contact message?\n press 'OK' to confirm")){
        //         $.ajax({
        //         url:"/admin/contacts/"+id,
        //         type: 'DELETE',
        //         data:{
        //             "id":id,
        //             "_token":token,
        //         },
        //         success:function(){
        //             console.log("deleted");
        //             $('#contactId'+id).remove();
        //         }
        //         });
        //     }else{
        //         console.log("cancelled");
        //     }
            
        // }
    </script>
@stop
</x-admin.layout>