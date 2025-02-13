@extends('layouts.app')
@section('content')
<main>
    {{-- Banner Section --}}
    <!-- First Swiper (Hero Slider) -->
    <section class="hero">
        <div class="swiper hero-swiper">
            <div class="swiper-wrapper">
                <!-- Slide 1 -->
                @foreach ($slides as $slide)
                <div class="swiper-slide swiper-slider" style="background-image: url('{{asset('uploads/slides')}}/{{$slide->image}}');">
                    <div class="hero-overlay"></div>
                    <div class="hero-container">
                        <div class="hero-content">
                            <h1>{{$slide->tagline}}</h1>
                            <h2>{{$slide->title}}</h2>
                            <p>{{$slide->subtitle}}</p>
                            <a href="{{$slide->link}}">Place your Order →</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <!-- Swiper Pagination -->
            <div class="swiper-pagination"></div>
        </div>
    </section>
    <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>
    {{-- Category Section --}}
    
    <!-- about-style-four -->
    <section id="about-us" class="about-style-four pt_120 pb_120 container">
        <div class="auto-container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-12 col-sm-12 image-column">
                    <div class="image_block_two">
                        <div class="image-inner">
                            <div class="image-box mr_15">
                                <figure class="image image-1 mb_15">
                                    <img src="{{asset('uploads/about')}}/{{$about->cover_image}}" alt="About" />
                                </figure>
                                <figure class="image image-2">
                                    <img src="{{asset('uploads/about')}}/{{$about->company_image}}" alt="About" />
                                </figure>
                            </div>
                            <div class="image-box">
                                <figure class="image image-3 mb_15">
                                    <img src="{{asset('uploads/about')}}/{{$about->company_image}}" alt="About" />
                                </figure>
                                <figure class="image image-4">
                                    <img src="{{asset('uploads/about')}}/{{$about->cover_image}}" alt="About" />
                                </figure>
                            </div>
                            <div class="support-box">
                                <div class="icon-box"><img src="assets/images/icons/call-outline.svg" alt=""></div>
                                <span>Online Support</span>
                                <h4><a href="tel:{{$about->intro}}">{{$about->intro}}</a></h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12 content-column">
                    <div class="content_block_five">
                        <h2 class="section-title mb-3 pb-xl-2 mb-xl-4">About Us</h2>
                        <div class="content-box">
                            <p class="about-us__content">
                                {{$about->main_intro}}
                            </p>
                            <div class="button-wrapper">
                                <a href="{{route('home.about')}}" class="btn btn-primary btn-checkout">READ MORE</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>
    <!-- about-style-four end -->

    <section class="category-carousel container">
        <h2 class="section-title text-center mb-3 pb-xl-2 mb-xl-4">
            Our Categories
        </h2>
        <div class="position-relative">
            <div class="swiper-container js-swiper-slider" data-settings='{
                    "autoplay": {
                        "delay": 5000
                    },
                    "slidesPerView": 8,
                    "slidesPerGroup": 1,
                    "effect": "none",
                    "loop": true,
                    "navigation": {
                        "nextEl": ".products-carousel__next-1",
                        "prevEl": ".products-carousel__prev-1"
                    },
                    "breakpoints": {
                        "320": {
                        "slidesPerView": 2,
                        "slidesPerGroup": 2,
                        "spaceBetween": 15
                        },
                        "768": {
                        "slidesPerView": 4,
                        "slidesPerGroup": 4,
                        "spaceBetween": 30
                        },
                        "992": {
                        "slidesPerView": 6,
                        "slidesPerGroup": 1,
                        "spaceBetween": 45,
                        "pagination": false
                        },
                        "1200": {
                        "slidesPerView": 8,
                        "slidesPerGroup": 1,
                        "spaceBetween": 60,
                        "pagination": false
                        }
                    }
                    }'>
                <div class="swiper-wrapper">
                    @foreach ($categories as $category)
                    <div class="swiper-slide">
                        <a href="{{route('shop.index',['categories'=>$category->id])}}" class="menu-link fw-medium">
                            <img loading="lazy" class="w-100 h-auto mb-3" src="{{asset('uploads/categories') }}/{{$category->image}}" width="124" height="124" alt="{{$category->name}}" />
                            <div class="text-center">
                                {{$category->name}}
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="products-carousel__prev products-carousel__prev-1 position-absolute top-50 d-flex align-items-center justify-content-center">
                <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                    <use href="#icon_prev_md" />
                </svg>
            </div>
            <div class="products-carousel__next products-carousel__next-1 position-absolute top-50 d-flex align-items-center justify-content-center">
                <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                    <use href="#icon_next_md" />
                </svg>
            </div>
        </div>
    </section>
    <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

    <!-- Popular Section -->
    <section class="popular">
        <h2 class="section-title text-center mb-3 pb-xl-2 mb-xl-4">Popular This Week</h2>
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                <!-- Product Card 1 -->
                @foreach ($sproducts as $sproduct)
                <div class="swiper-slide product-card">
                    <a href="{{route('shop.product.details',['product_slug'=>$sproduct->slug])}}">
                    @foreach (explode(',',$sproduct->images) as $image)
                        <img src="{{asset('uploads/products') }}/{{$image}}" alt="{{$sproduct->name}}">
                    @php
                        break;
                    @endphp
                    @endforeach
                    </a>
                    <div class="product-details">
                        <h3>{{$sproduct->name}}</h3>
                        @if ($sproduct->sale_price)
                        <p><span class="old-price">Rs. {{$sproduct->regular_price}}</span> Rs. {{$sproduct->sale_price}}</p>
                        @else
                        <p>Rs. {{$sproduct->sale_price}}</p>
                        @endif
                        
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

    {{-- Featured Product Section --}}
    <!-- Manual Swipe Swiper -->
    <section class="featured">
        <h2 class="section-title text-center mb-3 pb-xl-2 mb-xl-4">Featured Products</h2>
        <div class="swiper mySwiper-manual">
            <div class="swiper-wrapper">
                <!-- Same Product Cards -->
                @foreach ($fproducts as $fproduct)
                <div class="swiper-slide featured-card">
                    <a href="{{route('shop.product.details',['product_slug'=>$fproduct->slug])}}"><img src="{{asset('uploads/products') }}/{{$fproduct->image}}" alt="{{$fproduct->name}}"></a>
                    <div class="product-details">
                        <a href="{{route('shop.product.details',['product_slug'=>$fproduct->slug])}}"><h3>{{$fproduct->name}}</h3></a>
                        @if ($fproduct->sale_price)
                        <p><span class="old-price">Rs. {{$fproduct->regular_price}}</span> Rs. {{$fproduct->sale_price}}</p>
                        @else
                        <p>Rs.{{$fproduct->sale_price}}</p>
                        @endif</span>
                        
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    {{-- </div> --}}
    <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>
</main>
@endsection
