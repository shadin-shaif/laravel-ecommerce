@extends('frontend.master')
@section('content')
    <div class="row">
        <div class="col-lg-6 m-auto">
            <div class="card my-5">
                <div class="card-header">
                    <h4>Password Reset Request</h4>
                </div>
                <div class="card-body">
                    @if (session('invalid'))
                        <div class="alert alert-danger">{{ session('invalid') }}</div>
                    @endif
                    <form action="{{ route('pass.reset.req.send') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="reset">Your Email Address</label>
                            <input type="email" name="email" id="reset" class="form-control">
                            @error('email')
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