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
      <div class="flex-grow-1">
        <div class="products-grid row row-cols-2 row-cols-md-4" id="products-grid">   
            @forelse ($results as $product)        
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
                    <form name="addtocart-form" method="post" action="{{route('cart.add')}}">
                        @csrf
                        <input type="hidden" name="id" value="{{$product->id}}" />
                        <input type="hidden" name="name" value="{{$product->name}}" />
                        <input type="hidden" name="price" value="{{$product->sale_price == ''?$product->regular_price: $product->sale_price}}" />
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit"
                        class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-mediumt" data-aside="cartDrawer" title="Add To Cart">Add To Cart</button>
                    </form>
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
            @empty
              <h5>No Results Found.</h5>
            @endforelse     
        </div>

        <div class="divider"></div>
        <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
            {{$results->withQueryString()->links('pagination::bootstrap-5')}}
        </div>
      </div>
    </section>
</main>


@endsection

