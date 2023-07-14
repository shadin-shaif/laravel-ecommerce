@extends('frontend.master')
@section('content')
    <div class="row">
        <div class="col-lg-6 m-auto">
            <div class="card my-5">
                <div class="card-header">
                    <h4>Email Verify Request</h4>
                </div>
                <div class="card-body">
                    @if (session('verify'))
                        <div class=" my-2 text-danger">{{ session('verify') }}</div>
                    @endif
                    <form action="{{ route('email.verify.form.req') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" name="email" id="email" class="form-control">
                            @if (session('wrong'))
                                <div class=" my-2 text-danger">{{ session('wrong') }}</div>
                            @endif
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