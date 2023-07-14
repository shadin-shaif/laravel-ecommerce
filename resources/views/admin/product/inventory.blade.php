@extends('layouts.deshboard')
@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-primary">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item"><a href="#">Product</a></li>
      <li class="breadcrumb-item active" aria-current="page">Product inventory</li>
    </ol>
</nav>
<div class="row">
    <div class="col-lg-8">
        <div class="card table-responsive">
            <div class="card-header"><h4>Product Inventory</h4></div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Color Name</th>
                        <th>Product Size</th>
                        <th>Quantity</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($inventories as $inventory)
                        <tr>
                            <td>{{ $inventory->color_id == null?'NA':$inventory->rel_to_color->color_name }}</td>
                            <td>{{ $inventory->size_id == null?'NA':$inventory->rel_to_size->size_name }}</td>
                            <td>{{ $inventory->quantity }}</td>
                            <td>
                                <a href="{{ route('inventory.delete',$inventory->id) }}" class="btn btn-danger btn-icon">
                                    <i data-feather="trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header"><h4>Add Inventory</h4></div>
            <div class="card-body">
                <form action="{{ route('inventory.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Product Name</label>
                        <input readonly type="text" class="form-control" value="{{ $product_info->product_name }}">
                        <input name="product_id" type="hidden"value="{{ $product_info->id }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Select Color</label>
                        <select value=" " name="color_id">
                            <option value=" ">--Select Color--</option>
                            @foreach ($colors as $color)
                                <option value="{{ $color->id }}">{{ $color->color_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Select Size</label>
                        <select name="size_id">
                            <option value="">--Select Size--</option>
                            <option value="1">NA</option>
                            @foreach ($sizes as $size)
                                <option value="{{ $size->id }}">{{ $size->size_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Product Quantity</label>
                        <input type="number" class="form-control" name="quantity">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary">Add Inventory</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
