@extends('frontend.master')
@section('content')
    <div class="row">
        <div class="col-lg-6 m-auto">
            <div class="card my-5">
                <div class="card-header">
                    <h4>Password Reset Request</h4>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <form action="{{ route('pass.reset.confirm') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <input type="hidden" name="token" value="{{ $token }}">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control">
                            <label for="cpassword">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="cpassword" class="form-control">
                            @error('password')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Send Request" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection