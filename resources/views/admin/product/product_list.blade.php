@extends('layouts.deshboard')
@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-primary">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item"><a href="#">Product</a></li>
      <li class="breadcrumb-item active" aria-current="page">Product List</li>
    </ol>
</nav>
  
     

    <div class="row">
        <div class="card">
            <div class="card-header">
                <h4>Product list</h4>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered scrollbar">
                    <tr>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Discount</th>
                        <th>After Discoun</th>
                        <th>Preview</th>
                        <th>Action</th>
                    </tr>

                    @foreach ($all_products as $product)
                        <tr>
                            <td>{{ $product->product_name }}</td>
                            <td>&#2547;{{ $product->price }}</td>
                            <td>{{ $product->discount=='NULL'?'0':$product->discount}}%</td>
                            <td>&#2547;{{ $product->after_discount}}</td>
                            <td><img src="{{ asset('uploads/product/preview') }}/{{ $product->preview }}" alt=""></td>
                            <td>                               
                                <form action="{{ route('product.inventory') }}" method="GET" class="d-inline">
                                    @csrf
                                    <button name="product_id" value="{{ $product->id }}" class="btn btn-info btn-icon">
                                        <i data-feather="layers"></i>
                                    </button>
                                </form>

                                <form action="{{ route('product.edit') }}" method="GET" class="d-inline">
                                    @csrf
                                    <button name="product_id" value="{{ $product->id }}" class="btn btn-info btn-icon">
                                        <i data-feather="edit"></i>
                                    </button>
                                </form>

                                <a href="{{ route('product.delete',$product->id) }}" class="btn btn-danger btn-icon">
                                    <i data-feather="trash"></i>
                                </a>
                            </td>
                        </tr>

                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection