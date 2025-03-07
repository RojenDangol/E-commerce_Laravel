@extends('layouts.admin')
@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>All Products</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{route('admin.index')}}">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">All Products</div>
                </li>
            </ul>
        </div>

        <div class="wg-box">
            <div class="flex items-center justify-between gap10 flex-wrap">
                <div class="wg-filter flex-grow">
                    <form class="form-search" method="GET" action="{{route('admin.search.show')}}">
                        @csrf
                        <fieldset class="name">
                            <input type="text" placeholder="Search here..." class="" name="name"
                                tabindex="2" value="" aria-required="true" required="">
                                <input type="hidden" name="url" value="products">
                        </fieldset>
                        <div class="button-submit">
                            <button class="" type="submit"><i class="icon-search"></i></button>
                        </div>
                    </form>
                </div>
                <a class="tf-button style-1 w208" href="{{route('admin.product.add')}}"><i
                        class="icon-plus"></i>Add new</a>
            </div>
            <div class="table-responsive">
                @if(Session::has('status'))
                    <p class="alert alert-success">{{Session::get('status')}}</p>
                @endif
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 50px">#</th>
                            <th style="width: 250px">Name</th>
                            <th style="width: 120px">Price</th>
                            <th style="width: 120px">SalePrice</th>
                            <th  style="width: 120px">Wardrobe</th>
                            <th  style="width: 120px">Category</th>
                            <th  style="width: 120px">Brand</th>
                            <th style="width: 120px">Qty</th>
                            <th  style="width: 120px">Sizes</th>
                            <th style="width: 130px">Color</th>
                            <th  style="width: 120px">Featured</th>
                            <th  style="width: 120px">Stock</th>
                            <th  style="width: 120px">SKU</th>
                            <th style="width: 120px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $count = 1;
                        @endphp
                        @php
                        if($results){
                            $products = $results;
                        }else{
                            $products = $products;
                        }
                        @endphp
                        @foreach ($products as $product)                     
                        <tr>
                            <td>{{$count}}</td>
                            <td class="pname">
                                <div class="image">
                                    <img src="{{asset('uploads/products/thumbnails')}}/{{$product->image}}" alt="{{$product->name}}" class="image">
                                </div>
                                <div class="name">
                                    <a href="#" class="body-title-2">{{$product->name}}</a>
                                    <div class="text-tiny mt-3">{{$product->slug}}</div>
                                </div>
                            </td>
                            <td>Rs.{{$product->regular_price}}</td>
                            <td>Rs.{{$product->sale_price}}</td>
                            <td>{{$product->wardrobe}}</td>
                            <td>{{$product->category->name}}</td>
                            <td>{{$product->brand->name}}</td>
                            @php
                                $sizes = App\Models\ProductMeta::where('product_id', $product->id)->pluck('value', 'key')->toArray();
                                $filteredSizes = [];

                                foreach ($sizes as $key => $value) {
                                    if (str_contains($key, '_')) { 
                                        list($size, $color) = explode('_', $key); 
                                        $filteredSizes[] = [
                                            'size' => $size,
                                            'color' => $color,
                                            'quantity' => $value
                                        ];
                                    } else {
                                        $filteredSizes[] = [ 'size' => '', 'color' => '', 'quantity' => '' ];
                                    }
                                }
                                $totalQuantity = 0;
                            @endphp
                            <td>
                            @foreach($filteredSizes as $item)
                                @if($item['quantity'] !== '')
                                @php
                                    $totalQuantity += (int) $item['quantity'];
                                @endphp
                                @endif
                            @endforeach
                            {{ $totalQuantity }}
                            </td>
                            <td>
                            @php
                                $uniqueSizes = [];
                            @endphp
                            @foreach($filteredSizes as $item)
                            @if($item['size'] !== '' && !in_array($item['size'], $uniqueSizes))
                                {{ $item['size'] }},
                                @php
                                    $uniqueSizes[] = $item['size'];
                                @endphp
                            @endif
                            @endforeach
                            </td>
                            <td>
                            @php
                                $uniqueColor = [];
                            @endphp
                            @foreach($filteredSizes as $item)
                                @if($item['color'] !== '' && !in_array($item['color'], $uniqueColor))
                                <button class="p-2 m-2" style="background-color: {{$item['color'] }}" disabled></button>,
                                    @php
                                        $uniqueColor[] = $item['color'];
                                    @endphp
                                @endif
                            @endforeach
                            </td>
                            <td>{{$product->featured == 0?"No":"Yes"}}</td>
                            <td>{{$product->stock_status}}</td>
                            <td>{{$product->SKU}}</td>
                            <td>
                                <div class="list-icon-function">
                                    <a href="{{route('admin.product.edit',['id'=>$product->id])}}">
                                        <div class="item edit">
                                            <i class="icon-edit-3"></i>
                                        </div>
                                    </a>
                                    <form action="{{route('admin.product.delete',['id'=>$product->id])}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="item text-danger delete">
                                            <i class="icon-trash-2"></i>
                                        </div>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @php
                            $count++;
                        @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="divider"></div>
            <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
            {{$products->links('pagination::bootstrap-5')}}

            </div>
        </div>
    </div>
</div>   
@endsection

@push('scripts')
    <script>
        $(function(){
            $('.delete').on('click',function(e){
                e.preventDefault();
                var form =$(this).closest('form');
                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this data",
                    type: "warning",
                    buttons: ["No","Yes"],
                    confirmButtonCOlor: "#dc3545"
                }).then(function(result){
                    if(result){
                        form.submit();
                    }
                });
            })
        });
    </script>    
@endpush