@extends('layouts.backend')
@section('content')
 <div class="container mt-5">
    <div class="d-flex justify-content-between">
        <h5 class="text-start text-primary">Admin-User Lists</h5>
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#create_modal"><i class="fa fa-circle-plus"></i> Create</button>
    </div>
    <div class="card p-3">
        <div class="card-content">
            <table id="data-table" class="table table-striped table table-bordered" style="width:100%">
                <thead>
                    <tr class="bg-light">
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="tBody">
                    @foreach ($admin_users as $user)
                    <tr>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>_{{$user->phone}}</td>
                        <td>
                            <div class="d-flex">
                                <a href="{{route('admin-users-edit',$user->id)}}" class="btn btn-outline-warning mx-2">Edit</a>
                                <button class="btn btn-outline-danger delete" data-id="{{$user->id}}">Delete</button>
                            </div>
                        </td>
                    </tr>
                        
                    @endforeach

                </tbody>
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
 </div>
 {{-- create modal box --}}
<div class="modal fade" id="create_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary">Admin_Register</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('admin-register') }}">
                    @csrf
                    <div class="row mb-3">
                        <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="phone" class="col-md-4 col-form-label text-md-end">{{ __('Phone Number') }}</label>

                        <div class="col-md-6">
                            <input id="phone" type="number" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="email">

                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        
        </div>
    </div>
</div>
{{-- delete modal --}}
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-light">
            <h6 class="text-dark text-end mt-2 mb-0">
                <button type="button" class="btn-close pe-3" data-bs-dismiss="modal" aria-label="Close"></button>
            </h6>
            <div class="modal-body text-center">
                <p class="text-danger text-center">
                    <i class="fa-solid fa-minus"></i> Delete Category <i class="fa-solid fa-minus"></i>
                </p>
                <h1 class="text-danger"><i class="fa-solid fa-trash fa-bounce"></i></h1>
            </div>
            <form action="" method="POST" id="deleteForm">
                @csrf
                {{method_field('delete')}}
                <button type="submit" class="btn btn-danger w-100">Confirm</button>
            </form>
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
        new DataTable('#data-table');
        $(document).ready(function(){
            $('#tBody').on('click','.delete',function(){
                let id = $(this).data('id');
                $('#deleteForm').prop('action','admin-users-delete/'+id);
                $('#deleteModal').modal('show');
            });
        });
    </script>
    
@endsection