@extends('layouts.backend')
@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between">
            <h5 class="text-primary">Admin-User Edit</h5>
            <a href="{{route('admin-managements')}}" class="btn btn-danger mb-3">Cancel</a>
        </div>
        <div class="card py-3">
            <form method="POST" action="{{ route('admin-users-update',$admin_user->id)}}">
                @csrf
                <div class="row mb-3">
                    <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>
    
                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $admin_user->name }}" required autocomplete="name" autofocus>
    
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
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $admin_user->email }}" required autocomplete="email">
    
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
                        <input id="phone" type="number" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $admin_user->phone }}" required autocomplete="email">
    
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
                            {{ __('Save') }}
                        </button>
                    </div>
                </div>
            </form>
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