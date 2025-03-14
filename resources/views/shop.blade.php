@extends('layouts.app')
@section('content')
<style>
  .brand-list li, .category-list li{
    line-height: 40px;
  }
  .brand-list li .chk-brand, .category-list li .chk-category{
    width: 1rem;
    height: 1rem;
    color: #e4e4e4;
    border: 0.125rem solid currentColor;
    border-radius: 0;
    margin-right: 0.75rem;
  }

  .filled-heart{
    color: red;
  }
</style>
<main class="pt-90">
    <section class="shop-main container d-flex pt-4 pt-xl-5">
      <div class="shop-sidebar side-sticky bg-body" id="shopFilter">
        <div class="aside-header d-flex d-lg-none align-items-center">
          <h3 class="text-uppercase fs-6 mb-0">Filter By</h3>
          <button class="btn-close-lg js-close-aside btn-close-aside ms-auto"></button>
        </div>

        <div class="pt-4 pt-lg-0"></div>

        <div class="accordion" id="categories-list">
          <div class="accordion-item mb-4 pb-3">
            <h5 class="accordion-header" id="accordion-heading-1">
              <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button" data-bs-toggle="collapse"
                data-bs-target="#accordion-filter-1" aria-expanded="true" aria-controls="accordion-filter-1">
                Product Categories
                <svg class="accordion-button__icon type2" viewBox="0 0 10 6" xmlns="http://www.w3.org/2000/svg">
                  <path d="M5.36.16a.5.5 0 0 0-.72 0L.15 5.06a.5.5 0 0 0 .71.78L5 1.33l4.14 4.51a.5.5 0 0 0 .71-.78L5.36.16z"/>
                </svg>
              </button>
            </h5>
            <div id="accordion-filter-1" class="accordion-collapse collapse show border-0"
              aria-labelledby="accordion-heading-1" data-bs-parent="#categories-list">
              <div class="accordion-body px-0 pb-0 pt-3 category-list">
                <ul class="list list-inline mb-0">
                  @foreach ($categories as $category)
                  <li class="list-item">
                    <span class="menu-link py-1">
                      <input type="checkbox" class="chk-category" name="categories" value="{{$category->id}}" 
                      @if (in_array($category->id,explode(',',$f_categories))) checked="checked"
                     @endif
                      />    
                      {{$category->name}}
                    </span>
                    <span class="text-right float-end">{{($category->products)->count()}}</span>
                  </li> 
                  @endforeach     
                </ul>
              </div>
            </div>
          </div>
        </div>

        <div class="accordion" id="brand-filters">
          <div class="accordion-item mb-4 pb-3">
            <h5 class="accordion-header" id="accordion-heading-brand">
              <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button" data-bs-toggle="collapse"
                data-bs-target="#accordion-filter-brand" aria-expanded="true" aria-controls="accordion-filter-brand">
                Brands
                <svg class="accordion-button__icon type2" viewBox="0 0 10 6" xmlns="http://www.w3.org/2000/svg">
                  <path d="M5.36.16a.5.5 0 0 0-.72 0L.15 5.06a.5.5 0 0 0 .71.78L5 1.33l4.14 4.51a.5.5 0 0 0 .71-.78L5.36.16z"/>
                </svg>
              </button>
            </h5>
            <div id="accordion-filter-brand" class="accordion-collapse collapse show border-0"
              aria-labelledby="accordion-heading-brand" data-bs-parent="#brand-filters">
              <div class="search-field multi-select accordion-body px-0 pb-0">
                <ul class="list list-inline mb-0 brand-list">
                  @foreach($brands as $brand)
                    <li class="list-item">
                      <span class="menu-link py-1">
                        <input type="checkbox" name="brands" value="{{$brand->id}}" class="chk-brand"
                        @if (in_array($brand->id,explode(',',$f_brands))) checked="checked" @endif>
                        {{$brand->name}}
                      </span>
                      <span class="text-right float-end">
                        {{$brand->products->count()}}
                      </span>
                    </li>
                  @endforeach
                </ul>
                
              </div>
            </div>
          </div>
        </div>
        
        <div class="accordion" id="price-filters">
          <div class="accordion-item mb-4">
            <h5 class="accordion-header mb-2" id="accordion-heading-price">
              <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button" data-bs-toggle="collapse"
                data-bs-target="#accordion-filter-price" aria-expanded="true" aria-controls="accordion-filter-price">
                Price
                <svg class="accordion-button__icon type2" viewBox="0 0 10 6" xmlns="http://www.w3.org/2000/svg">
                  <path d="M5.36.16a.5.5 0 0 0-.72 0L.15 5.06a.5.5 0 0 0 .71.78L5 1.33l4.14 4.51a.5.5 0 0 0 .71-.78L5.36.16z"/>
                </svg>
              </button>
            </h5>
            <div id="accordion-filter-price" class="accordion-collapse collapse show border-0"
              aria-labelledby="accordion-heading-price" data-bs-parent="#price-filters">
              <input class="price-range-slider" type="text" name="price_range" value="" data-slider-min="100"
                data-slider-max="10000" data-slider-step="5" data-slider-value="[{{$min_price}},{{$max_price}}]" data-currency="Rs." />
              <div class="price-range__info d-flex align-items-center mt-2">
                <div class="me-auto">
                  <span class="text-secondary">Min Price: </span>
                  <span class="price-range__min">Rs.{{$min_price}}</span>
                </div>
                <div>
                  <span class="text-secondary">Max Price: </span>
                  <span class="price-range__max">Rs.{{$max_price}}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="shop-list flex-grow-1">
        <div class="d-flex justify-content-between mb-4 pb-md-2">
          <div class="breadcrumb mb-0 d-none d-md-block flex-grow-1">
            <a href="{{route('home.index')}}" class="menu-link menu-link_us-s text-uppercase fw-medium">Home</a>
            <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
            <a href="{{route('shop.index')}}" class="menu-link menu-link_us-s text-uppercase fw-medium">Shop</a>
          </div>

          <div class="shop-acs d-flex align-items-center justify-content-between justify-content-md-end flex-grow-1" >
            <select class="shop-acs__select form-select w-auto border-0 py-0 order-1 order-md-0 ml-2" aria-label="Page Size" id="pagesize"
              name="pagesize" style="margin-right:10px">
              <option value="6" {{$pageshow == 6?'selected':''}}>Show</option>
              <option value="12" {{$pageshow == 12?'selected':''}}>12</option>
              <option value="24" {{$pageshow == 24?'selected':''}}>24</option>
              <option value="48" {{$pageshow == 48?'selected':''}}>48</option>
            </select>
            <select class="shop-acs__select form-select w-auto border-0 py-0 order-1 order-md-0 m-2" aria-label="Sort Items"
              name="orderby" id="orderby">
              <option value="-1" {{$order == -1?'selected':''}}>Default Sorting</option>
              <option value="1" {{$order == 1?'selected':''}}>Date: New To Old</option>
              <option value="2" {{$order == 2?'selected':''}}>Date: Old To New</option>
              <option value="3" {{$order == 3?'selected':''}}>Price: Low To High</option>
              <option value="4" {{$order == 4?'selected':''}}>Price: high To Low</option>
            </select>

            <select class="shop-acs__select form-select w-auto border-0 py-0 order-1 order-md-0" aria-label="Sort Items"
              name="wardrobe" id="wardrobe">
              <option value="-1" {{$wardrobe == -1?'selected':''}}>Wardrobe</option>
              <option value="men" {{$wardrobe == 'men'?'selected':''}}>Men</option>
              <option value="women" {{$wardrobe == 'women'?'selected':''}}>Women</option>
              <option value="kid" {{$wardrobe == 'kid'?'selected':''}}>Kids</option>
            </select>

            <div class="shop-filter d-flex align-items-center order-0 order-md-3 d-lg-none m-2">
              <button class="btn-link btn-link_f d-flex align-items-center ps-0 js-open-aside" data-aside="shopFilter">
                <span class="text-uppercase fw-medium d-inline-block align-middle">Filter</span>
              </button>
            </div>
          </div>
        </div>

        <div class="products-grid row row-cols-2 row-cols-md-3" id="products-grid">
            @foreach ($products as $product)        
            <div class="product-card-wrapper">
                <div class="product-card mb-3 mb-md-4 mb-xxl-5">
                <div class="pc__img-wrapper">
                    <div class="swiper-container background-img js-swiper-slider" data-settings='{"resizeObserver": true}'>
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                        <a href="{{route('shop.product.details',['product_slug'=>$product->slug])}}"><img loading="lazy" src="{{asset('uploads/products')}}/{{$product->image}}" width="330"
                            height="400" alt="{{$product->name}}" class="pc__img"></a>
                        </div>
                        <div class="swiper-slide">
                            @foreach (explode(',',$product->images) as $gimg)            
                                <a href="{{route('shop.product.details',['product_slug'=>$product->slug])}}"><img loading="lazy" src="{{asset('uploads/products')}}/{{$gimg}}"
                                width="330" height="400" alt="{{$product->name}}" class="pc__img"></a>
                            @endforeach
                        </div>
                    </div>
                    <span class="pc__img-prev"><svg width="7" height="11" viewBox="0 0 7 11"
                        xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_prev_sm" />
                        </svg></span>
                    <span class="pc__img-next"><svg width="7" height="11" viewBox="0 0 7 11"
                        xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_next_sm" />
                        </svg></span>
                    </div>
                    @if (Cart::instance('cart')->content()->where('id',$product->id)->count()>0)
                        <a href="{{route('cart.index')}}" class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-mediumt btn-warning ">Go to Cart</a>
                    @elseif($product->quantity == 0 )
                        <a href="javascript:void(0)" class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-mediumt btn-warning ">Out of Stock</a>
                    @else
                    {{-- <form name="addtocart-form" method="post" action="{{route('cart.add')}}">
                        @csrf
                        <input type="hidden" name="id" value="{{$product->id}}" />
                        <input type="hidden" name="name" value="{{$product->name}}" />
                        <input type="hidden" name="price" value="{{$product->sale_price == ''?$product->regular_price: $product->sale_price}}" />
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit"
                        class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-mediumt" data-aside="cartDrawer" title="Add To Cart">Add To Cart</button>
                    </form> --}}

                    @php
                      $sizes = App\Models\ProductMeta::where('product_id', $product->id)->pluck('value', 'key')->toArray();
                      
                      $filteredSizes = [];
                      $sizeList = [];
                      $sizeColorMap = [];

                      // Process the sizes and colors
                      foreach ($sizes as $key => $value) {
                          if (is_string($key) && str_contains($key, '_')) { 
                              list($size, $color) = explode('_', $key); 
                              
                              // Build unique size list
                              if (!in_array($size, $sizeList)) {
                                  $sizeList[] = $size;
                              }

                              // Build size-color map
                              if (!isset($sizeColorMap[$size])) {
                                  $sizeColorMap[$size] = [];
                              }
                              if (!in_array($color, $sizeColorMap[$size])) {
                                  $sizeColorMap[$size][] = $color;
                              }
                          }
                      }
                    @endphp
                    <button
                        class="view-btn pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-mediumt" data-aside="cartDrawer"
                        onclick="showProductDetails('{{$product->name}}', '{{$product->sale_price == ''?$product->regular_price: $product->sale_price}}', '{{$product->category->name}}', {{json_encode($sizeList)}}, {{json_encode($sizeColorMap)}}, '{{asset('uploads/products')}}/{{$product->image}}','{{$product->id}}')">
                        View Item
                    </button>
                    @endif
                </div>

                <div class="pc__info position-relative">
                    <p class="pc__category">{{$product->category->name}}</p>
                    <h6 class="pc__title"><a href="{{route('shop.product.details',['product_slug'=>$product->slug])}}">{{$product->name}}</a></h6>
                    <div class="product-card__price d-flex">
                    <span class="money price">
                        @if ($product->sale_price)
                            <s>Rs.{{$product->regular_price}} </s>Rs.{{$product->sale_price}}
                        @else
                            Rs.{{$product->sale_price}}
                        @endif
                    </span>
                    </div>
                    <div class="product-card__review d-flex align-items-center">
                    
                    </div>

                    @if (Cart::instance('wishlist')->content()->where('id',$product->id)->count() > 0)
                    <form action="{{route('wishlist.item.remove',['rowId'=>Cart::instance('wishlist')->content()->where('id',$product->id)->first()->rowId])}}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="pc__btn-wl position-absolute top-0 end-0 bg-transparent border-0 js-add-wishlist filled-heart"
                      title="Remove From Wishlist">
                      <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <use href="#icon_heart" />
                      </svg>
                      </button>
                    </form>
                    @else                
                    <form action="{{route('wishlist.add')}}" method="POST">
                      @csrf   
                      <input type="hidden" name="id" value="{{$product->id}}" />      
                      <input type="hidden" name="name" value="{{$product->name}}" />      
                      <input type="hidden" name="price" value="{{$product->sale_price == ''? $product->regular_price:$product->sale_price}}" />      
                      <input type="hidden" name="quantity" value="1" />
                      <button type="submit" class="pc__btn-wl position-absolute top-0 end-0 bg-transparent border-0 js-add-wishlist"
                      title="Add To Wishlist">
                      <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <use href="#icon_heart" />
                      </svg>
                      </button>
                    </form>
                    @endif
                </div>
                </div>
            </div>
            @endforeach

          
        </div>

        <div class="divider"></div>
        <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
            {{$products->withQueryString()->links('pagination::bootstrap-5')}}
        </div>
      </div>
    </section>
</main>

<!-- Popup Modal for Product Details -->
<div id="popup-modal" class="popup-modal">
  <div class="popup-content">
      <span class="close-btn" onclick="closePopup()">&times;</span>
      <div class="popup-left">
          <img id="popup-image" src="" alt="Product Image" />
      </div>
      <div class="popup-right">
          <h3 id="popup-title"></h3>
          <h3 id="popup-productId" style="display: none;"></h3>
          <h4>PRICE: <span id="popup-price"></span></h4>
          <h4>Category: <span id="popup-category"></span></h4>

          <h4>SIZES</h4>
          <div id="popup-sizes" class="popup-options"></div>

          <h4>COLORS</h4>
          <div id="popup-colors" class="popup-options"></div>

          <!-- Quantity Selector -->
          <h4>QUANTITY</h4>
          <div>
              <button onclick="decreaseQuantity()">-</button>
              <input
                  type="number"
                  id="quantity-input"
                  value="1"
                  min="1"
                  style="width: 50px; text-align: center"
              />
              <button onclick="increaseQuantity()">+</button>
          </div>
          <button class="add-to-cart-btn btn btn-primary btn-addtocart mt-2" onclick="addToCart()">
              ADD TO CART
          </button>
      </div>
  </div>
</div>
<!-- Hidden Form to Submit to Cart -->
<form id="cart-form" action="{{route('cart.add')}}" method="POST" style="display: none;">
  @csrf
  <input type="hidden" name="id" id="productId">
  <input type="hidden" name="name" id="productTitle">
  <input type="hidden" name="price" id="productPrice">
  <input type="hidden" name="size" id="productSize">
  <input type="hidden" name="color" id="productColor">
  <input type="hidden" name="quantity" id="quantity">
</form>

<form action="{{route('shop.index')}}" id="frmfilter" method="GET">
  @csrf
  <input type="hidden" name="page" value="{{$products->currentPage()}}">
  <input type="hidden" name="pageshow" id="pageshow" value="{{$pageshow}}">
  <input type="hidden" name="order" id="order" value="{{$order}}"> 
  <input type="hidden" name="wardrobe" id="wardrobeid" value="{{$wardrobe}}"> 
  <input type="hidden" name="brands" id="hdnBrands">
  <input type="hidden" name="categories" id="hdnCategories" />
  <input type="hidden" name="min" id="hdnMinPrice" value="{{$min_price}}" />
  <input type="hidden" name="max" id="hdnMaxPrice" value="{{$max_price}}" />
</form>
@endsection

@push('scripts')
  <script>
    $(function(){
      $("#pagesize").on("change", function(){
        $("#pageshow").val($("#pagesize option:selected").val());
        $("#frmfilter").submit();
      });

      $("#orderby").on("change",function(){
        $("#order").val($("#orderby option:selected").val());
        $("#frmfilter").submit();
      });

      $("#wardrobe").on("change",function(){
        $("#wardrobeid").val($("#wardrobe option:selected").val());
        $("#frmfilter").submit();
      });

      $("input[name='brands']").on("change",function(){
        var brands="";
        $("input[name='brands']:checked").each(function(){
          if(brands == ""){
            brands += $(this).val();
          }
          else{
            brands += "," + $(this).val();
          }
        });
        $("#hdnBrands").val(brands);
        $("#frmfilter").submit();
      });

      $("input[name='categories']").on("change",function(){
        var categories="";
        $("input[name='categories']:checked").each(function(){
          if(categories == ""){
            categories += $(this).val();
          }
          else{
            categories += "," + $(this).val();
          }
        });
        $("#hdnCategories").val(categories);
        $("#frmfilter").submit();
      });

      $("[name='price_range']").on("change", function(){
        var min = $(this).val().split(',')[0];
        var max = $(this).val().split(',')[1];
        $('#hdnMinPrice').val(min);
        $('#hdnMaxPrice').val(max);
        setTimeout(() => {       
          $("#frmfilter").submit();
        }, 1000);
      });
    });
  </script>

  <script>
      let selectedSize = null;
      let selectedColor = null;
      let colorMap = {};

      function showProductDetails(
          title,
          price,
          category,
          sizes,
          colorsBySize,
          imageSrc,
          productId
        ) {
          document.getElementById("popup-title").textContent = title;
          document.getElementById("popup-productId").textContent = productId;
          document.getElementById("popup-price").textContent = price;
          document.getElementById("popup-category").textContent =
              category;
          document.getElementById("popup-image").src = imageSrc;

          colorMap = colorsBySize; // Store color map
          const sizeContainer = document.getElementById("popup-sizes");
          sizeContainer.innerHTML = "";
          sizes.forEach((size) => {
              const btn = document.createElement("button");
              btn.textContent = size;
              btn.onclick = () => selectSize(size);
              sizeContainer.appendChild(btn);
          });

          updateColors([]); // Initially clear colors

          selectedSize = null;
          selectedColor = null;
          showPopup();
      }

      function selectSize(size) {
          selectedSize = size;
          document
              .querySelectorAll("#popup-sizes button")
              .forEach((btn) => btn.classList.remove("active"));
          event.target.classList.add("active");

          const availableColors = colorMap[size] || [];
          updateColors(availableColors);
      }

        function updateColors(colors) {
          const colorContainer = document.getElementById("popup-colors");
          colorContainer.innerHTML = "";
          colors.forEach((color) => {
              const btn = document.createElement("button");
              btn.style.backgroundColor = color;
              btn.style.width = "30px";
              btn.style.height = "30px";
              btn.style.borderRadius = "50%";  // Make it a circle (remove this line if you want squares)
              btn.style.border = "2px solid #000"; // White border for visibility
              btn.style.margin = "2px";
              btn.style.cursor = "pointer";

              // Adding a distinctive style when a color is selected
              btn.onclick = () => {
                  // Remove "selected" class from all buttons
                  const selectedButton = colorContainer.querySelector(".selected");
                  if (selectedButton) {
                      selectedButton.classList.remove("selected");
                      selectedButton.style.border = "2px solid #fff"; // Reset the border
                      selectedButton.style.transform = "scale(1)"; // Reset the size
                  }
                  
                  // Add "selected" class to the clicked button
                  btn.classList.add("selected");
                  btn.style.border = "2px solid #000"; // Add a white border to highlight the selected color
                  btn.style.transform = "scale(1.2)"; // Increase size of the selected button
                  selectColor(color);
              };

              colorContainer.appendChild(btn);
          });
      }

      function selectColor(color) {
          selectedColor = color;
          document
              .querySelectorAll("#popup-colors button")
              .forEach((btn) => btn.classList.remove("active"));
          event.target.classList.add("active");
      }

      // Function to increase quantity
      function increaseQuantity() {
          const quantityInput = document.getElementById("quantity-input");
          quantityInput.value = parseInt(quantityInput.value) + 1;
      }

      // Function to decrease quantity
      function decreaseQuantity() {
          const quantityInput = document.getElementById("quantity-input");
          if (quantityInput.value > 1) {
              quantityInput.value = parseInt(quantityInput.value) - 1;
          }
      }

      // Modified addToCart function to include quantity
      function addToCart() {
          const quantity =
              document.getElementById("quantity-input").value;
          if (!selectedSize || !selectedColor) {
              // alert("Please select size and color.");
              Swal.fire({
                    title: "Info!",
                    text: "Color or Size Not Selected. Please Select to Continue.",
                    icon: "warning",
                    confirmButtonColor: "#fbc20c", // Change button color
                    confirmButtonText: "OK",
                    allowOutsideClick: false,
                });
              return;
          }
          Swal.fire({
                title: "Success!",
                text: "Item Added to Cart Successfully.",
                icon: "Success",
                confirmButtonColor: "#fbc20c", // Change button color
                confirmButtonText: "OK",
                allowOutsideClick: false,
            }).then((willContinue) => {
                if (willContinue) {
                    // Populate hidden form inputs
                    document.getElementById("productTitle").value = document.getElementById("popup-title").textContent;
                    document.getElementById("productPrice").value = document.getElementById("popup-price").textContent;
                    // document.getElementById("productCategory").value = document.getElementById("popup-category").textContent;
                    document.getElementById("productSize").value = selectedSize;
                    document.getElementById("productColor").value = selectedColor;
                    document.getElementById("quantity").value = quantity;
                    document.getElementById("productId").value = document.getElementById("popup-productId").textContent;

                    // Submit the form
                    document.getElementById("cart-form").submit();
                }
            });
          
      }

      function showPopup() {
          document.getElementById("popup-modal").style.display = "flex";
      }

      function closePopup() {
          document.getElementById("popup-modal").style.display = "none";
      }
  </script>
@endpush