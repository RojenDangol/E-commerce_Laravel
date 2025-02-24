@extends('layouts.app')
@section('content')
<style>
  .filled-heart{
    color: red;
    /* stroke: red; */
  }
</style>
<!-- CSS Styling -->
<main class="pt-90">
    <div class="mb-md-1 pb-md-3"></div>
    <section class="product-single container">
      <div class="row">
        <div class="col-lg-7">
          <div class="product-single__media" data-media-type="vertical-thumbnail">
            <div class="product-single__image">
              <div class="swiper-container">
                <div class="swiper-wrapper">

                  <div class="swiper-slide product-single__image-item">
                    <img loading="lazy" class="h-auto" src="{{asset('uploads/products')}}/{{$product->image}}" width="674"
                      height="674" alt="" />
                    <a data-fancybox="gallery" href="{{asset('uploads/products')}}/{{$product->image}}" data-bs-toggle="tooltip"
                      data-bs-placement="left" title="Zoom">
                      <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_zoom" />
                      </svg>
                    </a>
                  </div>
                  @foreach (explode(',',$product->images) as $gimg)  
                  <div class="swiper-slide product-single__image-item">
                    <img loading="lazy" class="h-auto" src="{{asset('uploads/products')}}/{{$gimg}}" width="674"
                      height="674" alt="" />
                    <a data-fancybox="gallery" href="{{asset('uploads/products')}}/{{$gimg}}" data-bs-toggle="tooltip"
                      data-bs-placement="left" title="Zoom">
                      <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_zoom" />
                      </svg>
                    </a>
                  </div>
                  @endforeach
                </div>
                <div class="swiper-button-prev"><svg width="7" height="11" viewBox="0 0 7 11"
                    xmlns="http://www.w3.org/2000/svg">
                    <use href="#icon_prev_sm" />
                  </svg></div>
                <div class="swiper-button-next"><svg width="7" height="11" viewBox="0 0 7 11"
                    xmlns="http://www.w3.org/2000/svg">
                    <use href="#icon_next_sm" />
                  </svg></div>
              </div>
            </div>
            <div class="product-single__thumbnail">
              <div class="swiper-container">
                <div class="swiper-wrapper">
                  <div class="swiper-slide product-single__image-item"><img loading="lazy" class="h-auto"
                    src="{{asset('uploads/products/thumbnails')}}/{{$product->image}}" width="104" height="104" alt="" /></div>
                  @foreach (explode(',',$product->images) as $gimg)
                  <div class="swiper-slide product-single__image-item"><img loading="lazy" class="h-auto"
                    src="{{asset('uploads/products/thumbnails')}}/{{$gimg}}" width="104" height="104" alt="" /></div>
                  @endforeach
                  
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-5">
          <div class="d-flex justify-content-between mb-4 pb-md-2">
            <div class="breadcrumb mb-0 d-none d-md-block flex-grow-1">
              <a href="{{route('home.index')}}" class="menu-link menu-link_us-s text-uppercase fw-medium">Home</a>
              <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
              <a href="{{route('shop.index')}}" class="menu-link menu-link_us-s text-uppercase fw-medium">Shop</a>
            </div><!-- /.breadcrumb -->
          </div>
          <h1 class="product-single__name">{{$product->name}}</h1>
          <div class="product-single__rating">
            <div class="reviews-group d-flex">
              <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                <use href="#icon_star" />
              </svg>
              <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                <use href="#icon_star" />
              </svg>
              <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                <use href="#icon_star" />
              </svg>
              <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                <use href="#icon_star" />
              </svg>
              <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                <use href="#icon_star" />
              </svg>
            </div>
            
          </div>
          <div class="product-single__price">
            <span class="current-price">
              @if ($product->sale_price)
                  <s>Rs.{{$product->regular_price}} </s>Rs.{{$product->sale_price}}
              @else
                  Rs.{{$product->sale_price}}
              @endif
            </span>
          </div>
          <div class="product-single__short-desc">
            <p>{{$product->short_description}}</p>
          </div>

          @if($product->quantity == 0 )
                        <a href="javascript:void(0)" class="btn btn-warning mb-3">Out of Stock</a>
          @else
          <form name="addtocart-form" method="post" action="{{route('cart.add')}}" class="addtocart">
            @csrf
            @php
              $sizes = App\Models\ProductMeta::where('product_id', $product->id)->pluck('value', 'key')->toArray();
              // dd($sizes);
              $filteredSizes = [];

              foreach ($sizes as $key => $value) {
                  if (str_contains($key, '_')) { 
                      list($size, $color) = explode('_', $key); 
                      $filteredSizes[] = [
                          'size' => $size,
                          'color' => $color,
                          'quantity' => $value
                      ];
                  } 
                  // else {
                  //     $filteredSizes[] = [ 'size' => '', 'color' => '', 'quantity' => '' ];
                  // }
              }
              // dd($filteredSizes);
              $uniqueColors = array_unique(array_column($filteredSizes, 'color'));
              $uniqueSizes = array_unique(array_column($filteredSizes, 'size'));
          @endphp
            
            {{-- <div class="product-sizes mb-3">
              <label class="d-block fw-bold mb-2">SIZES</label>
              <div class="d-flex align-items-center gap-2" id="size-container">
                  @foreach($filteredSizes as $item)
                    @if ($item['quantity'] > 0)
                        <label class="size-option size-{{ str_replace('#', '', $item['color']) }}" style="display: none;">
                            <input type="radio" name="size" value="{{ $item['size'] }}" required>
                            <span class="size-box">{{ $item['size'] }}</span>
                        </label>
                    @endif
                  @endforeach
              </div>
            </div>
            <div class="product-colors mb-3">
              <label class="d-block fw-bold mb-2">COLORS</label>
              <div class="d-flex align-items-center">
                  @foreach($uniqueColors as $color)
                      <label class="color-option" style="margin-right: 10px;">
                          <input type="radio" name="color" value="{{ $color }}" class="color-selector" required>
                          <span class="color-swatch" style="background-color: {{ $color }};"></span>
                      </label>
                  @endforeach
              </div>
            </div> --}}
            <div class="product-sizes mb-3">
                <label class="d-block fw-bold mb-2">SIZES</label>
                <div class="d-flex align-items-center gap-2">
                    @foreach($uniqueSizes  as $size)
                    @php
                        // Find if there's at least one item with this size that has quantity > 0
                        $availableItem = collect($filteredSizes)->firstWhere('size', $size);
                    @endphp
            
                    @if ($availableItem && $availableItem['quantity'] > 0)
                        <label class="size-option">
                            <input type="radio" name="size" value="{{ $size }}" class="size-selector" required>
                            <span class="size-box">{{ $size }}</span>
                        </label>
                    @endif
                    @endforeach
                </div>
            </div>
            
            <div class="product-colors mb-3">
                <label class="d-block fw-bold mb-2">COLORS</label>
                <div class="d-flex align-items-center gap-2" id="color-container">
                    @foreach($filteredSizes as $item)
                        @if ($item['quantity'] > 0)
                            <label class="color-option color-{{ str_replace('#', '', $item['size']) }}" style="display: none;">
                                <input type="radio" name="color" value="{{ $item['color'] }}" required>
                                <span class="color-swatch" style="background-color: {{ $item['color'] }};"></span>
                            </label>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="product-single__addtocart">
              <div class="qty-control position-relative">
                <input type="number" name="quantity" value="1" min="1" class="qty-control__number text-center" readonly>
                <div class="qty-control__reduce">-</div>
                <div class="qty-control__increase">+</div>
              </div>
              <input type="hidden" name="id" value="{{$product->id}}" />
              <input type="hidden" name="name" value="{{$product->name}}" />
              <input type="hidden" name="price" value="{{$product->sale_price == ''?$product->regular_price: $product->sale_price}}" />
              <button type="submit" class="btn btn-primary btn-addtocart" data-aside="cartDrawer">Add to Cart</button>
            </div>
          </form>  
          @endif
          
          <div class="product-single__addtolinks">
            @if (Cart::instance('wishlist')->content()->where('id',$product->id)->count() > 0)
            <form action="{{route('wishlist.item.remove',['rowId'=>Cart::instance('wishlist')->content()->where('id',$product->id)->first()->rowId])}}" method="POST" id="frm-remove-item">
              @csrf
              @method('DELETE')
              <a href="javascript:void(0)" class="menu-link menu-link_us-s add-to-wishlist filled-heart" onclick="document.getElementById('frm-remove-item').submit()"><svg width="16" height="16" viewBox="0 0 20 20"
                  fill="none" xmlns="http://www.w3.org/2000/svg">
                  <use href="#icon_heart" />
                </svg><span>Remove from Wishlist</span></a>
            </form>
            @else
            <form action="{{route('wishlist.add')}}" id="wishlist-form" method="POST">
              @csrf   
              <input type="hidden" name="id" value="{{$product->id}}" />      
              <input type="hidden" name="name" value="{{$product->name}}" />      
              <input type="hidden" name="price" value="{{$product->sale_price == ''? $product->regular_price:$product->sale_price}}" />      
              <input type="hidden" name="quantity" value="1" />
              <a href="javascript:void(0)" class="menu-link menu-link_us-s add-to-wishlist" onclick="document.getElementById('wishlist-form').submit()"><svg width="16" height="16" viewBox="0 0 20 20"
                fill="none" xmlns="http://www.w3.org/2000/svg">
                <use href="#icon_heart" />
              </svg><span>Add to Wishlist</span></a>
            </form>
            @endif
          </div>
          <div class="product-single__meta-info">
            <div class="meta-item">
              <label>Quantity:</label>
              <span>{{$product->quantity}}</span>
            </div>
            <div class="meta-item">
              <label>Categories:</label>
              <span>{{$product->category->name}}</span>
            </div>
            <div class="meta-item">
              <label>Wardrobe:</label>
              <span>{{$product->wardrobe}}</span>
            </div>
          </div>
        </div>
      </div>

      {{-- additional information section --}}
      <div class="product-single__details-tab">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item" role="presentation">
            <a class="nav-link nav-link_underscore active" id="tab-description-tab" data-bs-toggle="tab"
              href="#tab-description" role="tab" aria-controls="tab-description" aria-selected="true">Description</a>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link nav-link_underscore" id="tab-additional-info-tab" data-bs-toggle="tab"
              href="#tab-additional-info" role="tab" aria-controls="tab-additional-info"
              aria-selected="false">Additional Information</a>
          </li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane fade show active" id="tab-description" role="tabpanel"
            aria-labelledby="tab-description-tab">
            <div class="product-single__description">
              {{$product->description}}
            </div>
          </div>
          <div class="tab-pane fade" id="tab-additional-info" role="tabpanel" aria-labelledby="tab-additional-info-tab">
            <div class="product-single__addtional-info">
              <div class="item">
                <label class="h6">Quantity</label>
                <span>{{$product->quantity}}</span>
              </div>
              <div class="item">
                <label class="h6">Size</label>
                {{-- <span>{{$sizes}}</span> --}}
              </div>
              <div class="item">
                <label class="h6">SKU</label>
                <span>{{$product->SKU}}</span>
              </div>
            </div>
          </div>
          
        </div>
      </div>
    </section>
    <section class="products-carousel container">
      <h2 class="h3 text-uppercase mb-4 pb-xl-2 mb-xl-4">Related <strong>Products</strong></h2>

      <div id="related_products" class="position-relative">
        <div class="swiper-container js-swiper-slider" data-settings='{
            "autoplay": false,
            "slidesPerView": 4,
            "slidesPerGroup": 4,
            "effect": "none",
            "loop": true,
            "pagination": {
              "el": "#related_products .products-pagination",
              "type": "bullets",
              "clickable": true
            },
            "navigation": {
              "nextEl": "#related_products .products-carousel__next",
              "prevEl": "#related_products .products-carousel__prev"
            },
            "breakpoints": {
              "320": {
                "slidesPerView": 2,
                "slidesPerGroup": 2,
                "spaceBetween": 14
              },
              "768": {
                "slidesPerView": 3,
                "slidesPerGroup": 3,
                "spaceBetween": 24
              },
              "992": {
                "slidesPerView": 4,
                "slidesPerGroup": 4,
                "spaceBetween": 30
              }
            }
          }'>
          <div class="swiper-wrapper">
            @foreach ($rproducts as $rproduct)   
            <div class="swiper-slide product-card">
              <div class="pc__img-wrapper">
                <a href="{{route('shop.product.details',['product_slug'=>$rproduct->slug])}}">
                  <img loading="lazy" src="{{asset('uploads/products')}}/{{$rproduct->image}}" width="330" height="400"
                    alt="{{$product->name}}" class="pc__img">
                    @foreach (explode(',',$rproduct->images) as $gimg)   
                  <img loading="lazy" src="{{asset('uploads/products')}}/{{$gimg}}" width="330" height="400"
                    alt="{{$product->name}}" class="pc__img pc__img-second">
                    @endforeach
                </a>
                @if (Cart::instance('cart')->content()->where('id',$rproduct->id)->count()>0)
                    <a href="{{route('cart.index')}}" class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-mediumt btn-warning ">Go to Cart</a>
                @else
                <form name="addtocart-form" method="post" action="{{route('cart.add')}}">
                    @csrf
                    <input type="hidden" name="id" value="{{$rproduct->id}}" />
                    <input type="hidden" name="name" value="{{$rproduct->name}}" />
                    <input type="hidden" name="price" value="{{$rproduct->sale_price == ''?$rproduct->regular_price: $rproduct->sale_price}}" />
                    
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit"
                    class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-mediumt" data-aside="cartDrawer" title="Add To Cart">Add To Cart</button>
                </form>
                @endif
              </div>

              <div class="pc__info position-relative">
                <p class="pc__category">{{$rproduct->category->name}}</p>
                <h6 class="pc__title"><a href="details.html">{{$rproduct->name}}</a></h6>
                <div class="product-card__price d-flex">
                  <span class="money price">
                    @if ($product->sale_price)
                        <s>Rs.{{$product->regular_price}} </s>Rs.{{$product->sale_price}}
                    @else
                        Rs.{{$product->sale_price}}
                    @endif
                  </span>
                </div>

                <button class="pc__btn-wl position-absolute top-0 end-0 bg-transparent border-0 js-add-wishlist"
                  title="Add To Wishlist">
                  <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <use href="#icon_heart" />
                  </svg>
                </button>
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>

    </section>
</main>    


@endsection

@push('scripts')
{{-- <script>
  document.addEventListener("DOMContentLoaded", function () {
      const colorSelectors = document.querySelectorAll(".color-selector");
      const sizeLabels = document.querySelectorAll(".size-option");

      colorSelectors.forEach(colorInput => {
          colorInput.addEventListener("change", function () {
              let selectedColor = this.value.replace("#", "");

              // Hide all size options first
              sizeLabels.forEach(label => {
                  label.style.display = "none";
              });

              // Show only sizes for the selected color
              document.querySelectorAll(".size-" + selectedColor).forEach(label => {
                  label.style.display = "inline-block";
              });

              // Uncheck all size options when color changes
              document.querySelectorAll("input[name='size']").forEach(sizeInput => {
                  sizeInput.checked = false;
              });
          });
      });
  });
</script> --}}
<script>
document.addEventListener("DOMContentLoaded", function () {
  const sizeSelectors = document.querySelectorAll(".size-selector");
  const colorLabels = document.querySelectorAll(".color-option");

  sizeSelectors.forEach(sizeInput => {
      sizeInput.addEventListener("change", function () {
          let selectedSize = this.value.replace("#", "");

          // Hide all color options first
          colorLabels.forEach(label => {
              label.style.display = "none";
          });

          // Show only colors for the selected size
          document.querySelectorAll(".color-" + selectedSize).forEach(label => {
              label.style.display = "inline-block";
          });

          // Uncheck all color options when size changes
          document.querySelectorAll("input[name='color']").forEach(colorInput => {
              colorInput.checked = false;
          });
      });
  });
});
</script>

<script>
  document.addEventListener("DOMContentLoaded", function () {
      document.querySelectorAll('.addtocart').forEach(form => {
          form.addEventListener('submit', function (event) {
              event.preventDefault(); // Prevent the default form submission
              
              var formData = new FormData(this);
              Swal.fire({
                  title: "Success!",
                  text: "Product added to cart.",
                  icon: "success",
                  confirmButtonColor: "#fbc20c", // Change button color
                  confirmButtonText: "OK",
                  allowOutsideClick: false,
              }).then((willContinue) => {
                  if (willContinue) {
                      this.submit(); // Submit the form after confirmation
                  }
              });
          });
      });
  });
</script>
@endpush