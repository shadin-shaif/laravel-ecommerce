@extends('layouts.deshboard')
@section('content')
    <div class="rwo">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header"><h3>Order List</h3></div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Order ID</th>
                            <th>Total</th>
                            <th>Order Date</th>
                            <th>Payment Method</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->order_id }}</td>
                                <td>{{ $order->total }} &#2547;</td>
                                <td>{{ $order->created_at->format('Y-M-d | H:i:s') }}</td>
                                <td>
                                    @if ($order->payment_method == 1)
                                        <div class="badge badge-primary">Cach On Delivery</div>
                                    @elseif($order->payment_method == 2)
                                        <div class="badge badge-primary">sslcommerz</div>
                                    @else
                                        <div class="badge badge-primary">Stripe</div>
                                    @endif
                                </td>
                                <td>
                                    @if ($order->status == 0)
                                        <div class="badge badge-primary">Placed</div>
                                    @elseif($order->status == 1)
                                        <div class="badge badge-primary">Processing</div>
                                    @elseif($order->status == 2)
                                        <div class="badge badge-primary">Pick Up</div>
                                    @elseif($order->status == 3)
                                        <div class="badge badge-primary">Ready to Deliver</div>
                                    @elseif($order->status == 4)
                                        <div class="badge badge-primary">Delivered</div>
                                    @elseif($order->status == 5)
                                        <div class="badge badge-primary">Canceled</div>
                                    @else
                                        <div class="badge badge-primary">NA</div>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown mb-2">
                                        <button class="btn p-0" type="button" id="dropdownMenuButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton4">

                                        <form action="{{ route('status.update') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="order_id" value="{{ $order->order_id }}">
                                            <button value="0" name="status" class="dropdown-item d-flex align-items-center">Placed</button>
                                            <button value="1" name="status" class="dropdown-item d-flex align-items-center">Processing</button>
                                            <button value="2" name="status" class="dropdown-item d-flex align-items-center">Pick Up</button>
                                            <button value="3" name="status" class="dropdown-item d-flex align-items-center">Ready to Deliver</button>
                                            <button value="4" name="status" class="dropdown-item d-flex align-items-center">Delivered</button>
                                            <button value="5" name="status" class="dropdown-item d-flex align-items-center">Canceled</button>
                                        </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection