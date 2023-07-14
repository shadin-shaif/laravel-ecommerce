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
                            <li class="breadcrumb-item"><a href="#">Support</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- ======================= Top Breadcrubms ======================== -->
    
    <!-- ======================= Product Detail ======================== -->
    <section class="middle">
        <div class="container">
        
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="text-center d-block mb-5">
                        <h2>Checkout</h2>
                    </div>
                </div>
            </div>
            
            <div class="row justify-content-between">
                <div class="col-12 col-lg-7 col-md-12">
                    <form action="{{ route('order.store') }}" method="POST">
                        @csrf
                        <h5 class="mb-4 ft-medium">Billing Details</h5>
                        <div class="row mb-2">
                            
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group">
                                    <label class="text-dark">Full Name *</label>
                                    <input name="name" readonly type="text" class="form-control" value="{{ Auth::guard('customerlogin')->user()->name }}"/>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label class="text-dark">Email *</label>
                                    <input name="email" readonly type="email" class="form-control" value="{{ Auth::guard('customerlogin')->user()->email }}" />
                                </div>
                            </div>
                            
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label class="text-dark">Company</label>
                                    <input name="company" type="text" class="form-control" placeholder="Company Name (optional)" />
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label class="text-dark">Mobile Number *</label>
                                    <input name="billing_phone" type="number" class="form-control" placeholder="Mobile Number" />
                                </div>
                            </div>
                            
                        </div>
                        <h5 class="mb-4 ft-medium">Shipping Details</h5>
                        <div class="row mb-2">
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                                <div class="form-group">
                                    <label class="text-dark">Full Name *</label>
                                    <input name="name" type="text" class="form-control" placeholder="Full Name"/>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label class="text-dark">Email *</label>
                                    <input name="shipping_email" type="email" class="form-control" placeholder="Email Address" />
                                </div>
                            </div>
                            
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label class="text-dark">Mobile Number *</label>
                                    <input type="number" name="shipping_mobile" class="form-control" placeholder="Mobile Number" />
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group">
                                    <label class="text-dark">Country *</label>
                                    <select class="custom-select country" name="country_id">
                                        <option value="">-- Select Country --</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label class="text-dark">City / Town *</label>
                                    <select class="custom-select city" name="city_id">
                                        <option value="">-- City / Town --</option>

                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
                                <div class="form-group">
                                    <label class="text-dark">Address *</label>
                                    <input name="address" type="text" class="form-control" placeholder="Address" />
                                </div>
                            </div>

                            
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label class="text-dark">ZIP / Postcode *</label>
                                    <input name="zip" type="text" class="form-control" placeholder="Zip / Postcode" />
                                </div>
                            </div>
                            
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label class="text-dark">Additional Information</label>
                                    <textarea name="notes" class="form-control ht-50"></textarea>
                                </div>
                            </div>
                        </div>
                </div>
                
                <!-- Sidebar -->
                <div class="col-12 col-lg-4 col-md-12">
                    <div class="d-block mb-3">
                        <h5 class="mb-4">Order Items ({{ $carts->count() }})</h5>
                        <ul class="list-group list-group-sm list-group-flush-y list-group-flush-x mb-4">
                            @foreach ($carts as $cart) 
                                <li class="list-group-item">
                                    <div class="row align-items-center">
                                        <div class="col-3">
                                            <!-- Image -->
                                            <a href="{{ route('details',$cart->rel_to_product->id) }}"><img src="{{ asset('uploads/product/preview') }}/{{ $cart->rel_to_product->preview }}" alt="..." class="img-fluid"></a>
                                        </div>
                                        <div class="col d-flex align-items-center">
                                            <div class="cart_single_caption pl-2">
                                                <h4 class="product_title fs-md ft-medium mb-1 lh-1">{{ $cart->rel_to_product->product_name }}</h4>
                                                <p class="mb-1 lh-1"><span class="text-dark">Size: {{ $cart->rel_to_size->size_name }}</span></p>
                                                <p class="mb-3 lh-1"><span class="text-dark">Color: {{ $cart->rel_to_color->color_name }}</span></p>
                                                <h4 class="fs-md ft-medium mb-3 lh-1">&#2547;{{ $cart->rel_to_product->after_discount }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                            
                            
                        </ul>
                    </div>
                    
                    <div class="mb-4">
                        <div class="form-group">
                            <h6>Delivery Location</h6>
                            <ul class="no-ul-list">
                                <li>
                                    <input id="c1" class="radio-custom charge" name="charge" type="radio" value="60">
                                    <label for="c1" class="radio-custom-label">Inside City</label>
                                </li>
                                <li>
                                    <input id="c2" class="radio-custom charge" name="charge" type="radio" value="120">
                                    <label for="c2" class="radio-custom-label">Outside City</label>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="form-group">
                            <h6>Select Payment Method</h6>
                            <ul class="no-ul-list">
                                <li>
                                    <input value="1" id="c3" class="radio-custom" name="payment_method" type="radio">
                                    <label for="c3" class="radio-custom-label">Cash on Delivery</label>
                                </li>
                                <li>
                                    <input value="2" id="c4" class="radio-custom" name="payment_method" type="radio">
                                    <label for="c4" class="radio-custom-label">Pay With SSLCommerz</label>
                                </li>
                                <li>
                                    <input value="3" id="c5" class="radio-custom" name="payment_method" type="radio">
                                    <label for="c5" class="radio-custom-label">Pay With Stripe</label>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="card mb-4 gray">
                        <div class="card-body">
                        <ul class="list-group list-group-sm list-group-flush-y list-group-flush-x">
                            <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                            <span>Subtotal</span> <span class="ml-auto text-dark ft-medium">&#2547;{{ session('total') }}</span>
                            </li>
                            <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                            <span>Charge</span> <span class="ml-auto text-dark ft-medium">&#2547;
                                <span id="charge">0</span>
                            </span>
                            </li>
                            <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                            <span>Discount</span> <span class="ml-auto text-dark ft-medium">&#2547;{{ session('discount') }}</span>
                            </li>
                            <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                            <span>Total</span>
                            <span class="ml-auto text-dark ft-medium">
                                &#2547;
                                <span id="grand_total"> {{ session('total') }}</span>
                            </span>
                            </li>
                        </ul>
                        </div>
                    </div>

                    <input type="hidden" class="sub_total" name="sub_total" value="{{ session('total') }}">
                    <input type="hidden" class="discount" name="discount" value="{{ session('discount') }}">
                    <input type="hidden" name="customer_id" value="{{ Auth::guard('customerlogin')->id() }}">

                    
                    <button class="btn btn-block btn-dark mb-3">Place Your Order</button>
                </form>
                </div>
                
            </div>
            
        </div>
    </section>
@endsection

@section('footer_script')
   <script>
         $('.charge').click(function(){
            var charge = parseInt($(this).val());
            var sub_total = parseInt($('.sub_total').val());
            var discount = $('.discount').val();
            var grand_total = sub_total + charge;
            
            $('#grand_total').html(grand_total);
            $('#charge').html(charge);
         });

         //select2
         $(document).ready(function() {
            $('.country').select2();
        });
         $(document).ready(function() {
            $('.city').select2();
        });
   </script>
    
    <script>
        //ajax request
        $('.country').change(function(){
            var country_id = $(this).val();
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type:'POST',
                url:'/getcity',
                data:{'country_id':country_id},
                success: function(data){
                    $('.city').html(data);
                }
            })
        })

    </script>
@endsection
