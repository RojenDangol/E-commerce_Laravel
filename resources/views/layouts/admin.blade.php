<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="ethereal ensemble" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/animate.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/animation.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('font/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('icon/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">
    <link rel="apple-touch-icon-precomposed" href="{{ asset('images/favicon.ico') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/sweetalert.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        .product-item{
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 15px;
            transition: all 0.3s ease;
            padding-right: 5px;
        }

        .product-item .image{
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            gap: 10px;
            flex-shrink: 0;
            padding: 5px;
            border-radius: 10px;
            background: #EFF4F8;
        }

        #box-content-search li{
            list-style: none;
        }

        #box-content-search .product-item{
            margin-bottom: 10px;
        }
    </style>

    @stack("styles")
</head>
<body class="body">
    <div id="wrapper">
        <div id="page" class="">
            <div class="layout-wrap">

                <div class="section-menu-left">
                    <div class="box-logo">
                        <a href="{{route('home.index')}}" id="site-logo-inner">
                            <img
                                class=""
                                id="logo_header_1"
                                alt=""
                                src="{{asset('images/logo/logo.png')}}"
                                data-light="{{asset('images/logo/logo.png')}}"
                                data-dark="{{asset('images/logo/logo.png')}}"
                            />
                        </a>
                        <div class="button-show-hide">
                            <i class="icon-menu-left"></i>
                        </div>
                    </div>
                    <div class="center">
                        <div class="center-item">
                            <div class="center-heading pt-2">Main Home</div>
                            <ul class="menu-list">
                                <li class="menu-item">
                                    <a href="{{route('admin.index')}}" class="">
                                        <div class="icon">
                                            <i class="icon-grid"></i>
                                        </div>
                                        <div class="text">Dashboard</div>
                                    </a>
                                </li>
                                <li class="menu-item has-children">
                                    <a
                                        href="javascript:void(0);"
                                        class="menu-item-button"
                                    >
                                        <div class="icon">
                                            <i
                                                class="icon-shopping-cart"
                                            ></i>
                                        </div>
                                        <div class="text">Products</div>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="sub-menu-item">
                                            <a
                                                href="{{route('admin.product.add')}}"
                                                class=""
                                            >
                                                <div class="text">
                                                    Add Product
                                                </div>
                                            </a>
                                        </li>
                                        <li class="sub-menu-item">
                                            <a
                                                href="{{route('admin.products')}}"
                                                class=""
                                            >
                                                <div class="text">
                                                    Products
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="menu-item has-children">
                                    <a
                                        href="javascript:void(0);"
                                        class="menu-item-button"
                                    >
                                        <div class="icon">
                                            <i class="icon-layers"></i>
                                        </div>
                                        <div class="text">Brand</div>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="sub-menu-item">
                                            <a
                                                href="{{route('admin.brand.add')}}"
                                                class=""
                                            >
                                                <div class="text">
                                                    New Brand
                                                </div>
                                            </a>
                                        </li>
                                        <li class="sub-menu-item">
                                            <a href="{{route('admin.brands')}}" class="">
                                                <div class="text">
                                                    Brands
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="menu-item has-children">
                                    <a
                                        href="javascript:void(0);"
                                        class="menu-item-button"
                                    >
                                        <div class="icon">
                                            {{-- <i class="icon-layers"></i> --}}
                                            <i class="fa-solid fa-palette"></i>
                                        </div>
                                        <div class="text">Colors</div>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="sub-menu-item">
                                            <a
                                                href="{{route('admin.color.add')}}"
                                                class=""
                                            >
                                                <div class="text">
                                                    New Color
                                                </div>
                                            </a>
                                        </li>
                                        <li class="sub-menu-item">
                                            <a href="{{route('admin.colors')}}" class="">
                                                <div class="text">
                                                    Colors
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="menu-item has-children">
                                    <a
                                        href="javascript:void(0);"
                                        class="menu-item-button"
                                    >
                                        <div class="icon">
                                            <i class="icon-layers"></i>
                                        </div>
                                        <div class="text">Category</div>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="sub-menu-item">
                                            <a
                                                href="{{route('admin.category.add')}}"
                                                class=""
                                            >
                                                <div class="text">
                                                    New Category
                                                </div>
                                            </a>
                                        </li>
                                        <li class="sub-menu-item">
                                            <a
                                                href="{{route('admin.categories')}}"
                                                class=""
                                            >
                                                <div class="text">
                                                    Categories
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                
                                <li class="menu-item">
                                    <a href="{{route('admin.orders')}}" class="">
                                        <div class="icon">
                                            {{-- <i class="icon-grid"></i> --}}
                                            <i class="fa-solid fa-truck"></i>
                                        </div>
                                        <div class="text">Orders</div>
                                    </a>
                                </li>

                                <li class="menu-item">
                                    <a href="{{route('admin.slides')}}" class="">
                                        <div class="icon">
                                            {{-- <i class="icon-image"></i> --}}
                                            <i class="fa-solid fa-sliders"></i>
                                        </div>
                                        <div class="text">Slider</div>
                                    </a>
                                </li>

                                <li class="menu-item">
                                    <a href="{{route('admin.about')}}" class="">
                                        <div class="icon">
                                            <i class="icon-image"></i>
                                        </div>
                                        <div class="text">About Us</div>
                                    </a>
                                </li>

                                <li class="menu-item">
                                    <a href="{{route('admin.coupons')}}" class="">
                                        <div class="icon">
                                            <i class="fa-solid fa-ticket"></i>
                                        </div>
                                        <div class="text">Coupons</div>
                                    </a>
                                </li>
                                
                                <li class="menu-item">
                                    <a href="{{route('admin.contacts')}}" class="">
                                        <div class="icon">
                                            <i class="icon-mail"></i>
                                        </div>
                                        <div class="text">Messages</div>
                                    </a>
                                </li>

                                <li class="menu-item">
                                    <a href="{{route('admin.users')}}" class="">
                                        <div class="icon">
                                            <i class="icon-user"></i>
                                        </div>
                                        <div class="text">User</div>
                                    </a>
                                </li>

                                <li class="menu-item">
                                    <a href="{{route('admin.contact.info')}}" class="">
                                        <div class="icon">
                                            {{-- <i class="icon-user"></i> --}}
                                            <i class="fa-regular fa-address-card"></i>
                                        </div>
                                        <div class="text">Contact Information</div>
                                    </a>
                                </li>

                                <li class="menu-item">
                                    <a href="{{route('admin.settings')}}" class="">
                                        <div class="icon">
                                            <i class="icon-settings"></i>
                                        </div>
                                        <div class="text">Settings</div>
                                    </a>
                                </li>

                                <li class="menu-item">
                                    <form action="{{route('logout')}}" id="logout-form" method="POST">
                                    @csrf
                                    <a href="{{route('logout')}}" class="" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                        <div class="icon">
                                            <i class="icon-log-out"></i>
                                        </div>
                                        <div class="text">Logout</div>
                                    </a>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="section-content-right">
                    <div class="header-dashboard">
                        <div class="wrap">
                            <div class="header-left">
                                <div class="button-show-hide">
                                    <i class="icon-menu-left"></i>
                                </div>

                                <form class="form-search flex-grow" method="GET" action="">
                                    @csrf
                                    <fieldset class="name">
                                        <input
                                            type="text"
                                            placeholder="Search here..."
                                            class="show-search"
                                            name="order"
                                            id="search-input"
                                            tabindex="2"
                                            value=""
                                            aria-required="true"
                                            required=""
                                            autocomplete="off"
                                        />
                                    </fieldset>
                                    <div class="button-submit">
                                        <button class="" type="submit">
                                            <i class="icon-search"></i>
                                        </button>
                                    </div>
                                    <div
                                        class="box-content-search"                                      
                                    >
                                    <ul id="box-content-search"></ul>
                                    </div>
                                </form>
                            </div>
                            <div class="header-grid">
                                <div class="popup-wrap message type-header">
                                    <div class="dropdown">
                                        <form action="{{ url('/clear-cache') }}" method="GET">
                                            <button type="submit" class="btn btn-danger">Clear Cache</button>
                                        </form>
                                        
                                        {{-- <form action="{{ url('/clear-cache') }}" method="GET">
                                        <button
                                            class="btn btn-secondary dropdown-toggle"
                                            type="submit"
                                            id="dropdownMenuButton2"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false"
                                        >
                                            <span class="header-item">
                                                <i class="icon-bell"></i>
                                            </span>
                                        </button>
                                        </form> --}}
                                    </div>
                                </div>

                                <div class="popup-wrap user type-header">
                                    <div class="dropdown">
                                        <a href="{{route('admin.settings')}}">
                                            <span
                                                class="header-user wg-user"
                                            >
                                                <span class="image">
                                                    @if (Auth::user()->profile_picture)                      
                                                
                                                    <img
                                                        src="{{asset('uploads/profile')}}/{{ Auth::user()->profile_picture}}"
                                                        alt="{{ Auth::user()->name}}" style="height: 36px; width: 36px;"
                                                    />
                                                    @endif
                                                </span>
                                                <span
                                                    class="flex flex-column"
                                                >
                                                    <span
                                                        class="body-title mb-2"
                                                        >{{ Auth::user()->name }}</span
                                                    >
                                                    <span class="text-tiny"
                                                        >{{ Auth::user()->utype == 'ADM' ? 'Admin':'' }}</span
                                                    >
                                                </span>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    

                    <div class="main-content">
                        @if(session('message'))
                        <div class="alert alert-success alert-dismissible fade show left-alert" role="alert">
                            {{ session('message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <style>
                            .left-alert {
                                position: fixed;
                                top: 100px;  /* Distance from the top */
                                right: 0;    /* Positioned to the left of the screen */
                                width: 250px;  /* Set your desired width */
                                height: auto;  /* Auto-adjust height based on content */
                                z-index: 1050; /* Ensure the alert appears above other content */
                                padding: 10px;  /* Padding inside the alert */
                                border-radius: 5px;  /* Optional, for rounded corners */
                            }
                        </style>
                        
                        @endif

                        @yield('content')                     

                        <div class="bottom-page">
                            <div class="body-text">
                                Copyright © 2024 Ethereal Ensemble
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/apexcharts/apexcharts.js') }}"></script>
    <!-- Bootstrap 4 JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(function(){
            $("#search-input").on("keyup",function(){
                var searchQuery = $(this).val();
                if(searchQuery.length> 2){
                    $.ajax({
                        type: "GET",
                        url: "{{route('admin.search')}}",
                        data: {query: searchQuery},
                        dataType: 'json',
                        success: function(data){
                            $("#box-content-search").html('');
                            $.each(data,function(index,item){
                                var url = "{{route('admin.product.edit',['id'=>'product_id'])}}";
                                var link = url.replace('product_id',item.id);

                                $("#box-content-search").append(`
                                    <li>
                                        <ul>
                                            <li class="product-item gap14 mb-10">
                                                <div class="image no-bg">
                                                    <img src="{{asset('uploads/products/thumbnails')}}/${item.image}" alt="${item.name}">
                                                </div>
                                                <div class="flex items-center justify-between gap20 flex-grow">
                                                    <div class="name">
                                                        <a href="${link}" class="body-text">${item.name}</a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="mb-10">
                                                <div class="divider"></div>
                                            </li>
                                        </ul>
                                    </li>
                                `);
                            });
                        }
                    });
                }
            });
        });
    </script>
    <script src="{{ asset('js/main.js') }}"></script>
    @stack("scripts")
</body>

</html>
