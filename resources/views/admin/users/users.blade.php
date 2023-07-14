@extends('layouts.deshboard')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 m-auto">
                <div class="card">
                    <div class="card-header">
                        <h3>List Of Users <span class="float-end">Total: {{ $total_user - 1}}</span></h3>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        <table class="table table-striped">
                            <tr>
                                <th>SL</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Photo</th>
                                <th>Created at</th>
                                <th>Action</th>
                            </tr>

                            @foreach ($users as $key=>$user)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if ($user->photo == null)
											<img src="{{ Avatar::create($user->name)->toBase64() }}" />
										@else 
											<img src="{{ asset('uploads/user') }}/{{ $user->photo }}" alt="profile">
										@endif
                                    </td>
                                    <td>{{ $user->created_at->diffForHumans() }}</td>
                                    <td>
                                        <a class="btn btn-danger" href="{{ Route('delete.user', $user->id) }}">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                            
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection