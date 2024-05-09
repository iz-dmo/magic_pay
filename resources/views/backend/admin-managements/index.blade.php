@extends('layouts.backend')
@section("style")
    <style>
        body {
            font-family: "Crete Round", serif;
            font-style: normal;
            }

    </style>
@endsection
@section('content')
 <div class="container">
    <div class="d-flex justify-content-between">
        <h5 class="text-start text-primary">Admin-User Lists</h5>
        <a class="btn btn-primary mb-3" href="{{route('admin-register')}}"><i class="fa fa-circle-plus"></i> Create</a>
    </div>
    <div class="card p-3">
        <div class="card-content">
            <table id="example" class="table table-striped table table-bordered" style="width:100%">
                <thead>
                    <tr class="bg-light">
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>IP</th>
                        <th>User Agent</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($admin_users as $user)
                        <tr>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->phone}}</td>
                            <td>{{$user->ip}}</td>
                            <td>{{$user->user_agent}}</td>
                            <td>
                                <button class="btn btn-outline-warning" data-toggle="modal" data-target="#EditModal-{{$user->id}}">Edit</button>
                                <button class="btn btn-outline-danger" data-toggle="modal" data-target="#DeleteModal-{{$user->id}}">Delete</button>
                            </td>
                        </tr>
                        {{-- edit modal --}}
                        <div class="modal fade" id="EditModal-{{$user->id}}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-sm modal-dialog-centered">
                                <div class="modal-content modal-background">
                                    <div class="modal-header text-center">
                                        <h5 class="modal-title w-100 model-label">Edit - <strong>{{$user->name}}</strong></h5>
                                        <button type="button" class="btn close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <h6>Are you sure?</h6>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal" title="Close">Close</button>
                                        <a href="{{route('admin-users-edit',$user->id)}}" class="btn btn-dark">Yes</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- delete modal --}}
                        <div class="modal fade" id="DeleteModal-{{$user->id}}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-sm modal-dialog-centered">
                                <form action="{{route('admin-users-delete',$user->id)}}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <div class="modal-content modal-background">
                                        <div class="modal-header text-center">
                                            <h5 class="modal-title w-100 model-label">Delete Admin - <strong>{{ $user->name }}</strong></h5>
                                            <button type="button" class="btn close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <h6>Are you sure?</h6>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal" title="Close">Close</button>
                                            <button type="submit" class="btn btn-dark">Yes</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>IP</th>
                        <th>User Agent</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
 </div>


@endsection
@section('script')
    @if(session('success_msg'))
    <script>
        $(document).ready(function(){
            Swal.fire({
                icon: 'success',
                title: '{{ session('success_msg') }}',
            });
        });
    </script>
    @endif
    @if(session('error_msg'))
    <script>
        $(document).ready(function(){
            Swal.fire({
                icon: 'warning',
                title: '{{ session('error_msg') }}',
            });
        });
    </script>
    @endif
    <script>
        $(document).ready(function(){
            $('#example').DataTable({
                layout: {
                    topStart: {
                        buttons: ['excel', 'pdf', 'print']
                    }
                }
            });
        });

    </script>
    
@endsection