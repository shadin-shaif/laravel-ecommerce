@extends('frontend.master')
@section('content')
    <!-- ======================= Top Breadcrubms ======================== -->
			<div class="gray py-3">
				<div class="container">
					<div class="row">
						<div class="colxl-12 col-lg-12 col-md-12">
							<nav aria-label="breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#">Home</a></li>
									<li class="breadcrumb-item"><a href="#">Dashboard</a></li>
									<li class="breadcrumb-item active" aria-current="page">My Order</li>
								</ol>
							</nav>
						</div>
					</div>
				</div>
			</div>
			<!-- ======================= Top Breadcrubms ======================== -->
			
			<!-- ======================= Dashboard Detail ======================== -->
			<section class="middle">
				<div class="container">
					<div class="row align-items-start justify-content-between">
					
						<div class="col-12 col-md-12 col-lg-4 col-xl-4 text-center miliods">
							<div class="d-block border rounded">
								<div class="dashboard_author px-2 py-5">
									<div class="dash_auth_thumb circle p-1 border d-inline-flex mx-auto mb-2">

                                        @if (Auth::guard('customerlogin')->user()->photo == null)
                                        <img src="{{ Avatar::create(Auth::guard('customerlogin')->user()->name)->toBase64() }}" />
                                        @else   
                                        <img src="{{ asset('uploads/customer') }}/{{ Auth::guard('customerlogin')->user()->photo }}" class="img-fluid circle" width="100" alt=""/>
                                        @endif

									</div>
									<div class="dash_caption">
										<h4 class="fs-md ft-medium mb-0 lh-1">{{ Auth::guard('customerlogin')->user()->name }}</h4>
										<span class="text-muted smalls">{{ Auth::guard('customerlogin')->user()->country }}</span>
									</div>
								</div>
								
								<div class="dashboard_author">
									<h4 class="px-3 py-2 mb-0 lh-2 gray fs-sm ft-medium text-muted text-uppercase text-left">Dashboard Navigation</h4>
									<ul class="dahs_navbar">
										<li><a href="my-orders.html" class="active"><i class="lni lni-shopping-basket mr-2"></i>My Order</a></li>
										<li><a href="wishlist.html"><i class="lni lni-heart mr-2"></i>Wishlist</a></li>
										<li><a href="profile-info.html"><i class="lni lni-user mr-2"></i>Profile Info</a></li>
										<li><a href="login.html"><i class="lni lni-power-switch mr-2"></i>Log Out</a></li>
									</ul>
								</div>
								
							</div>
						</div>
						
						<div class="col-12 col-md-12 col-lg-8 col-xl-8 text-center">
                            @foreach ($myorders as $order)
                                
                                <!-- Single Order List -->
                                <div class="ord_list_wrap border mb-4">
                                    <div class="ord_list_head gray d-flex align-items-center justify-content-between px-3 py-3">
                                        <div class="olh_flex">
                                            <p class="m-0 p-0"><span class="text-muted">Order Number</span></p>
                                            <h6 class="mb-0 ft-medium">{{ $order->order_id }}</h6>
                                        </div>	
                                        <div class="">
                                            <p class="mb-1 p-0"><span class="text-muted">Status</span></p>
                                            <div class="delv_status">
                                                                                        
                                                @if ($order->status == 0)
                                                    <div class="badge badge-info">Placed</div>
                                                @elseif($order->status == 1)
                                                    <div class="badge badge-primary">Processing</div>
                                                @elseif($order->status == 2)
                                                    <div class="badge badge-primary">Pick Up</div>
                                                @elseif($order->status == 3)
                                                    <div class="badge badge-warning">Ready to Deliver</div>
                                                @elseif($order->status == 4)
                                                    <div class="badge badge-success">Delivered</div>
                                                @elseif($order->status == 5)
                                                    <div class="badge badge-danger">Canceled</div>
                                                @else
                                                    <div class="badge badge-danger">NA</div>
                                                @endif
                                               
                                            
                                          </div>
                                        </div>	
                                    </div>
                                    <div class="ord_list_body text-left">
                                        <!-- Order Products -->
                                        @foreach (App\Models\OrderProduct::where('order_id', $order->order_id)->get() as $product) 
                                            <div class="row align-items-center justify-content-center m-0 py-4 br-bottom">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                                    <div class="cart_single d-flex align-items-start mfliud-bot">
                                                        <div class="cart_selected_single_thumb">
                                                            <a href="{{ route('details', $product->rel_to_product->id) }}"><img width="100" src="{{ asset('uploads/product/preview') }}/{{ $product->rel_to_product->preview }}" class="img-fluid rounded" alt=""></a>
                                                        </div>
                                                        <div class="cart_single_caption pl-3">
                                                            <p class="mb-0"><span class="text-muted small">{{ $product->rel_to_product->rel_to_category->category_name }}</span></p>
                                                            <h4 class="product_title fs-sm ft-medium mb-1 lh-1">{{ $product->rel_to_product->product_name }}</h4>
                                                            <p class="mb-2"><span class="text-dark medium">Size: {{ $product->rel_to_size->size_name }}</span>, <span class="text-dark medium">Color: {{ $product->rel_to_color->color_name }}</span></p>
                                                            <h4 class="fs-sm ft-bold mb-0 lh-1">&#2547;{{ $product->price }}</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                
                                            </div>
                                        @endforeach
                                    </div>
                                    
                                    <div class="ord_list_footer d-flex align-items-center justify-content-between br-top px-3">
                                        <div class="col-xl-12 col-lg-12 col-md-12 pl-0 py-2 olf_flex d-flex align-items-center justify-content-between">
                                            <div class="olf_flex_inner"><p class="m-0 p-0"><span class="text-muted medium text-left">Order Date: {{ $order->created_at->format('d-M-Y') }}</span></p></div>
                                            <!-- Order Invoice -->
                                            <div class="invoice">
                                                <a href="{{ route('download.invoice', $order->id) }}" class="btn btn-light">Download Invoice</a>
                                            </div>
                                            <div class="olf_inner_right"><h5 class="mb-0 fs-sm ft-bold">Total: &#2547; {{ $order->total }}</h5></div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <!-- End Order List -->
                            @endforeach
						</div>
						
					</div>
				</div>
			</section>
			<!-- ======================= Dashboard Detail End ======================== -->
@endsection