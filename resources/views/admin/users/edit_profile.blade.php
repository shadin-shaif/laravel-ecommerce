@extends('layouts.deshboard')
@section('content')
<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h4 class="pt-1">Edit Profile Info</h4>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <form class="forms-sample" method="POST" action="{{ route('update.profile.info') }}">
                    @csrf
                    <div class="form-group">
                        <label for="name1">Username</label>
                        <input type="text" class="form-control" value="{{ Auth::user()->name }}" name="name" id="name1" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" name="email" value="{{ Auth::user()->email }} ">
                    </div>                   
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button class="btn btn-light">Cancel</button>
                </form>
            </div>
          </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h4 class="pt-1">Edit Profile Info</h4>
            </div>
            <div class="card-body">
                @if (session('pass_update'))
                    <div class="alert alert-success">{{ session('pass_update') }}</div>
                @endif
                <form class="forms-sample" method="POST" action="{{ route('update.password') }}">
                    @csrf
                    <div class="form-group">
                        <label for="pas-01">Old Password</label>
                        <input type="password" class="form-control" name="old_password" id="pas-01" autocomplete="off">
                        @if (session('wrong_pass'))
                            <span class="text-danger">{{ session('wrong_pass') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="pas-02">New Password</label>
                        <input type="password" class="form-control" id="pas-02" name="password">
                        @error('password')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="pas-0">Confurm Password</label>
                        <input type="password" class="form-control" id="pas-0" name="password_confirmation">
                        @error('password_confirmation')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn btn-primary mr-2">Update Password</button>
                </form>
            </div>
          </div>
    </div>


    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h4 class="pt-1">Edit Profile Image</h4>
            </div>
            <div class="card-body">
                @if (session('img_success'))
                    <div class="alert alert-success">{{ session('img_success') }}</div>
                @endif
                <form enctype="multipart/form-data" class="forms-sample" method="POST" action="{{ route('update.photo') }}">
                    @csrf
                    <div class="form-group">
                        <label for="photo">Upload Photo</label>
                        <input type="file" class="form-control" name="photo" id="photo" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                        <div class="mt-2">
                            <img src="" id="blah" alt="" width="200px">
                        </div>
                        @error('photo')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>                               
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                </form>
            </div>
          </div>
    </div>


</div>

@endsection