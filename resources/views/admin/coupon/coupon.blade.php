@extends('layouts.deshboard')
@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-primary">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item"><a href="#">Product</a></li>
      <li class="breadcrumb-item active" aria-current="page">Coupon</li>
    </ol>
</nav>

<div class="row my-3">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3>Coupon List</h3>               
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Coupon Name</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Expire</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($coupons as $coupon)
                        <tr>
                            <td>{{ $coupon->coupon_name }}</td>
                            <td>{{ $coupon->type=='1'?'Percentage':'Fixed' }}</td>
                            <td>{{ $coupon->amount }}</td>
                            <td>{{ Carbon\Carbon::now()->diffInDays($coupon->expire_date, false);
                            }} Days Remaining</td>
                            <td>
                                <a href="{{ route('coupon.delete',$coupon->id) }}" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>   
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3>Add New Coupon</h3>               
            </div>
            <div class="card-body">
                <form action="{{ route('coupon.store') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="coupon_name" placeholder="Coupon Name" class="form-control">
                    </div>
                    <div class="form-group">
                        <select name="type" class="form-control">
                            <option value="">--Select Type--</option>
                            <option value="1">Percentage</option>
                            <option value="2">Fixed</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="number" name="amount" placeholder="Amount" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="date" name="expire_date" placeholder="Expire Date" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Add Coupon" class="form-control">
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection