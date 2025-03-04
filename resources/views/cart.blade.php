@extends('layouts.app')
@section('content')
<style>
  .text-success{
    color: #278c04 !important;
  }
  .text-danger {
    color: #dd1100 !important;
  }
</style>
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="shop-checkout container">
      <h2 class="page-title">Cart</h2>
      <div class="checkout-steps">
        <a href="javascript:void:(0)" class="checkout-steps__item active">
          <span class="checkout-steps__item-number">01</span>
          <span class="checkout-steps__item-title">
            <span>Shopping Bag</span>
            <em>Manage Your Items List</em>
          </span>
        </a>
        <a href="javascript:void:(0)" class="checkout-steps__item">
          <span class="checkout-steps__item-number">02</span>
          <span class="checkout-steps__item-title">
            <span>Shipping and Checkout</span>
            <em>Checkout Your Items List</em>
          </span>
        </a>
        <a href="javascript:void:(0)" class="checkout-steps__item">
          <span class="checkout-steps__item-number">03</span>
          <span class="checkout-steps__item-title">
            <span>Confirmation</span>
            <em>Review And Submit Your Order</em>
          </span>
        </a>
      </div>
      <div class="shopping-cart">
        @if ($items->count()>0) 
        <div class="cart-table__wrapper">
          <table class="cart-table">
            <thead>
              <tr>
                <th>Product</th>
                <th></th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              {{-- @dd($items) --}}
              @foreach ($items as $item)  
                @php
                  $product = \App\Models\Product::where('id',$item->id)->first();
                  $productMeta = \App\Models\ProductMeta::where('product_id', $item->id)->where('key', $item->options->size.'_'.$item->options->color)->first();
                  $product_qty = $productMeta->value;
                  if($item->qty > $product_qty){
                    $item->qty = $product_qty;
                  }
                @endphp  

                <tr>
                    <td>
                    <div class="shopping-cart__product-item">
                        <img loading="lazy" src="{{asset('uploads/products/thumbnails')}}/{{$item->model->image}}" width="120" height="120" alt="{{$item->name}}" />
                    </div>
                    </td>
                    <td>
                    
                    <div class="shopping-cart__product-item__detail">
                      <h4>{{$item->name}}</h4>
                      <ul class="shopping-cart__product-item__options">
                        <div class="meta-item">
                          {{-- @php
                            $productMeta = App\Models\ProductMeta::where('product_id', $item->id)->where('key', 'sizes')->first();
                            if ($productMeta) {
                                $sizes = explode(',', $productMeta->value);  
                            } else {
                                $sizes = [];
                            }
                            $count = 1;
                          @endphp --}}
                          {{-- @forelse ($sizes as $size)
                            <input class="form-check-input form-check-input_fill size-selector" type="radio" 
                            name="size_{{$item->id}}" data-id="{{$item->id}}" value="{{$size}}" >            
                            <label class="form-check-label" for="size1">{{$size}}</label>
                            @php
                              $count++;
                            @endphp --}}
                            {{-- @empty
                                <p>No Sizes Available.</p>
                          @endforelse --}}
                          <label>Size:</label>
                          {{$item->options->size}}
                          <br>
                          <label>Color:</label><button class="p-2 m-2" style="background-color: {{$item->options->color}}" disabled></button>
                        </div>
                      </ul>
                    </div>
        
                    </td>
                    <td>
                    <span class="shopping-cart__product-price">Rs.{{$item->price}}</span>
                    </td>
                    <td>
                    <div class="qty-control position-relative">
                          <input type="number" name="quantity" value="{{$item->qty}}" min="1" class="qty-control__number text-center" readonly>
                          <form action="{{route('card.qty.decrease',['rowId'=>$item->rowId])}}" method="POST">
                              @csrf
                              @method('PUT')
                              <div class="qty-control__reduce">-</div>
                          </form>

                          @if ($product_qty > $item->qty)
                            <form action="{{route('card.qty.increase',['rowId'=>$item->rowId])}}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="qty-control__increase">+</div>
                            </form>                             
                         @endif                         
                    </div>
                    </td>
                    <td>
                    <span class="shopping-cart__subtotal">Rs.{{$item->subTotal()}}</span>
                    </td>
                    <td>
                    <form action="{{route('cart.item.remove',['rowId'=>$item->rowId])}}" method="POST">
                        <a href="javascript:void(0)" class="remove-cart">
                            @csrf
                            @method('DELETE')
                            X
                        </a>
                    </form>
                    </td>
                </tr>
              @endforeach
            </tbody>
          </table>
          <div class="cart-table-footer">
            @if (!Session::has('coupon'))
              <form action="{{route('cart.coupon.apply')}}" class="position-relative bg-body" method="POST">
                @csrf
                <input class="form-control" type="text" name="coupon_code" placeholder="Promo Code" value="">
                <input class="btn-link fw-medium position-absolute top-0 end-0 h-100 px-4" type="submit"
                  value="APPLY PROMO CODE">
              </form> 
            @else           
              <form action="{{route('cart.coupon.remove')}}" class="position-relative bg-body" method="POST">
                @csrf
                @method('DELETE')
                <input class="form-control" type="text" name="coupon_code" placeholder="Coupon Code" value="@if(Session::has('coupon')) {{Session::get('coupon')['code']}} Applied! @endif">
                <input class="btn-link fw-medium position-absolute top-0 end-0 h-100 px-4" type="submit"
                  value="REMOVE PROMO CODE">
              </form> 
            @endif

            <form action="{{route('cart.empty')}}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-light">CLEAR CART</button>
            </form>
          </div>
          <div>
            @if(Session::has('success'))
              <p class="text-success">{{Session::get('success')}}</p>
            @elseif(Session::has('error'))
              <p class="text-danger">{{Session::get('error')}}</p>
            @endif
          </div>
        </div>
  
        <div class="shopping-cart__totals-wrapper">
          <div class="sticky-content">
            <div class="shopping-cart__totals">
              <h3>Cart Totals</h3>
              @if (Session::has('discounts'))
              <table class="cart-totals">
                <tbody>
                  <tr>
                    <th>Subtotal</th>
                    <td>Rs.{{Cart::instance('cart')->subtotal()}}</td>
                  </tr>
                  <tr>
                    <th>Discount {{Session::get('coupon')['code']}}</th>
                    <td>Rs.{{Session::get('discounts')['discount']}}</td>
                  </tr>
                  <tr>
                    <th>Subtotal After Discount</th>
                    <td>Rs.{{Session::get('discounts')['subtotal']}}</td>
                  </tr>
                  <tr>
                    <th>Shipping</th>
                    <td>Free</td>
                  </tr>
                  {{-- <tr>
                    <th>VAT</th>
                    <td>Rs.{{Session::get('discounts')['tax']}}</td>
                  </tr> --}}
                  <tr>
                    <th>Total</th>
                    <td>Rs.{{Session::get('discounts')['total']}}</td>
                  </tr>
                </tbody>
              </table> 
              @else
              <table class="cart-totals">
                <tbody>
                  <tr>
                    <th>Subtotal</th>
                    <td>Rs.{{Cart::instance('cart')->subtotal()}}</td>
                  </tr>
                  <tr>
                    <th>Shipping</th>
                    <td>Free</td>
                  </tr>
                  {{-- <tr>
                    <th>VAT</th>
                    <td>Rs.{{Cart::instance('cart')->tax()}}</td>
                  </tr> --}}
                  <tr>
                    <th>Total</th>
                    <td>Rs.{{Cart::instance('cart')->total()}}</td>
                  </tr>
                </tbody>
              </table>
              @endif
            </div>
            <div class="mobile_fixed-btn_wrapper">
              <form name="checkout-form" action="{{ route('cart.checkout') }}" method="POST">
                @csrf
                <div id="selected-sizes-container"></div> 
                <button class="btn btn-primary btn-checkout">PLACE ORDER</button>
            </form>
            
              

            </div>
          </div>
        </div>
        @else
        <div class="row">
            <div class="col-md-12 text-center pt-5 bp-5">
                <p>No item found in your cart.</p>
                <a href="{{route('shop.index')}}" class="btn btn-info">Shop Now</a>
            </div>
        </div>
        @endif
      </div>
    </section>
</main>   
@endsection

@push('scripts')
    <script>
        $(function(){
            $(".qty-control__increase").on("click",function(){
                $(this).closest('form').submit();
            });

            $(".qty-control__reduce").on("click",function(){
                $(this).closest('form').submit();
            });

            $(".remove-cart").on("click",function(){
                $(this).closest('form').submit();
            })
        });       
      
    </script>
    
    {{-- <script>
      document.addEventListener("DOMContentLoaded", function () {
        const sizeSelectors = document.querySelectorAll(".size-selector");
        const container = document.getElementById("selected-sizes-container");
    
        sizeSelectors.forEach(radio => {
          radio.addEventListener("change", function () {
            const itemId = this.getAttribute("data-id");
            const selectedSize = this.value;
    
            // Check if hidden input for this item already exists
            let existingInput = document.querySelector(`input[name="sizes[${itemId}]"]`);
    
            if (existingInput) {
              // Update existing hidden input
              existingInput.value = selectedSize;
            } else {
              // Create a new hidden input field for this item
              const sizeInput = document.createElement("input");
              sizeInput.type = "hidden";
              sizeInput.name = `sizes[${itemId}]`; // Array format (sizes[item_id] = size)
              sizeInput.value = selectedSize;
              container.appendChild(sizeInput);
            }
          });
        });
      });
    </script> --}}
    {{-- <script>
      document.addEventListener("DOMContentLoaded", function () {
          const sizeSelectors = document.querySelectorAll(".size-selector");
          const container = document.getElementById("selected-sizes-container");
          const form = document.querySelector("form[name='checkout-form']"); 

          // Event listener for each radio button change
          sizeSelectors.forEach(radio => {
              radio.addEventListener("change", function () {
                  const itemId = this.getAttribute("data-id");
                  const selectedSize = this.value;

                  // Check if hidden input for this item already exists
                  let existingInput = document.querySelector(`input[name="sizes[${itemId}]"]`);

                  if (existingInput) {
                      // Update existing hidden input
                      existingInput.value = selectedSize;
                  } else {
                      // Create a new hidden input field for this item
                      const sizeInput = document.createElement("input");
                      sizeInput.type = "hidden";
                      sizeInput.name = `sizes[${itemId}]`; // Array format (sizes[item_id] = size)
                      sizeInput.value = selectedSize;
                      container.appendChild(sizeInput);
                  }
              });
          });

          // Form validation on submit
          form.addEventListener("submit", function (e) {
              const itemIds = [...document.querySelectorAll(".size-selector")].map(radio => radio.getAttribute("data-id"));
              let isValid = true;

              // Check if hidden inputs for each item are present
              itemIds.forEach(itemId => {
                  const hiddenInput = document.querySelector(`input[name="sizes[${itemId}]"]`);
                  if (!hiddenInput || hiddenInput.value === "") {
                      isValid = false;
                  }
              });

              if (!isValid) {
                  e.preventDefault(); // Prevent form submission
                  swal({
                  title: "Select Sizes!",
                  text: "Please select the sizes for further transaction.",
                  icon: "info",
                  buttons: "OK",
              });
              }
          });
      });
    </script> --}}
@endpush