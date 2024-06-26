@extends('layouts.backend')
@section('content')
    <div class="container">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <a href="{{route('admin-managements')}}" class="btn btn-danger m-3 float-right">Cancel</a>
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Update <strong>{{$admin_user->name}}</strong></h1>
                            </div>
                            <form class="user" action="{{ route('admin-users-update',$admin_user->id)}}" method="POST">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user @error('name') is-invalid @enderror" name="name" value="{{$admin_user->name}}"  id="exampleFirstName"
                                            placeholder="User Name" name="name">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="number" class="form-control form-control-user @error('phone') is-invalid @enderror"  value="{{ $admin_user->phone }}" id="exampleLastName"
                                            placeholder="Phone Number" name="phone">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user @error('email') is-invalid @enderror"  value="{{ $admin_user->email }}" id="exampleInputEmail"
                                        placeholder="Email Address" name="email">
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" name="password" class="form-control form-control-user @error('password') is-invalid @enderror" value="{{old('password')}}"
                                            id="exampleInputPassword" placeholder="Password">
                                    </div>
                                        
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control form-control-user @error('password_confirmation') is-invalid @enderror"
                                            id="exampleRepeatPassword" placeholder="Repeat Password" name="password_confirmation">
                                    </div>
                                </div>
                                <button class="btn btn-primary btn-user btn-block" type="submit">Submit</button>
                                <hr>
                            </form>
                        </div>
                    </div>
                </div>
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
@endsection