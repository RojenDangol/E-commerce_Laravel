@extends('layouts.admin')
@section('content')
<div class="main-content-inner">
    <!-- main-content-wrap -->
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Edit Product</h3>
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
                    <a href="{{route('admin.products')}}">
                        <div class="text-tiny">Products</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">Edit product</div>
                </li>
            </ul>
        </div>
        <!-- form-add-product -->
        <form class="tf-section-2 form-add-product" method="POST" enctype="multipart/form-data"
            action="{{route('admin.product.update')}}">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{$product->id}}"/>
            <div class="wg-box">
                <fieldset class="name">
                    <div class="body-title mb-10">Product name <span class="tf-color-1">*</span>
                    </div>
                    <input class="mb-10" type="text" placeholder="Enter product name"
                        name="name" tabindex="0" value="{{$product->name}}" aria-required="true" required="">
                    <div class="text-tiny">Do not exceed 100 characters when entering the
                        product name.</div>
                </fieldset>
                @error('name')
                    <span class="alert alert-danger text-center">{{$message}}</span>
                @enderror

                <div class="gap22 cols">
                    <fieldset class="name">
                        <div class="body-title mb-10">Slug <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Enter product slug"
                            name="slug" tabindex="0" value="{{$product->slug}}" aria-required="true" required="">
                        <div class="text-tiny">Do not exceed 100 characters when entering the
                            product slug.</div>
                    </fieldset>
                    @error('slug')
                        <span class="alert alert-danger text-center">{{$message}}</span>
                    @enderror

                    <fieldset class="wardrobe">
                        <div class="body-title mb-10">Wardrobe <span class="tf-color-1">*</span>
                        </div>
                        <div class="select">
                            <select class="" name="wardrobe">
                                <option value="men" {{$product->wardrobe == "men"?"selected":""}}>Men</option>
                                <option value="women" {{$product->wardrobe == "women"?"selected":""}}>Women</option>
                                <option value="kid" {{$product->wardrobe == "kid"?"selected":""}}>Kid</option>
                            </select>
                        </div>
                    </fieldset>
                    @error('wardrobe')
                        <span class="alert alert-danger text-center">{{$message}}</span>
                    @enderror
                </div>

                <div class="gap22 cols">
                    <fieldset class="category">
                        <div class="body-title mb-10">Category <span class="tf-color-1">*</span>
                        </div>
                        <div class="select">
                            <select class="" name="category_id">
                                <option>Choose category</option>
                                @foreach ($categories as $category)    
                                    <option value="{{$category->id}}" {{$product->category_id == $category->id?"selected":""}}>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </fieldset>
                    @error('category_id')
                        <span class="alert alert-danger text-center">{{$message}}</span>
                    @enderror
                    <fieldset class="brand">
                        <div class="body-title mb-10">Brand <span class="tf-color-1">*</span>
                        </div>
                        <div class="select">
                            <select class="" name="brand_id">
                                <option>Choose Brand</option>
                                @foreach ($brands as $brand)    
                                    <option value="{{$brand->id}}" {{$product->brand_id == $brand->id?"selected":""}}>{{$brand->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </fieldset>
                    @error('brand_id')
                        <span class="alert alert-danger text-center">{{$message}}</span>
                    @enderror
                </div>

                <fieldset class="shortdescription">
                    <div class="body-title mb-10">Short Description <span
                            class="tf-color-1">*</span></div>
                    <textarea class="mb-10 ht-150" name="short_description"
                        placeholder="Short Description" tabindex="0" aria-required="true"
                        required="">{{$product->short_description}}</textarea>
                    <div class="text-tiny">Do not exceed 100 characters when entering the
                        product name.</div>
                </fieldset>
                @error('short_description')
                    <span class="alert alert-danger text-center">{{$message}}</span>
                @enderror

                <fieldset class="description">
                    <div class="body-title mb-10">Description <span class="tf-color-1">*</span>
                    </div>
                    <textarea class="mb-10" name="description" placeholder="Description"
                        tabindex="0" aria-required="true" required="">{{$product->description}}</textarea>
                    <div class="text-tiny">Do not exceed 100 characters when entering the
                        product name.</div>
                </fieldset>
                @error('description')
                    <span class="alert alert-danger text-center">{{$message}}</span>
                @enderror
            </div>
            <div class="wg-box">
                <fieldset>
                    <div class="body-title">Upload images <span class="tf-color-1">*</span>
                    </div>
                    <div class="upload-image flex-grow">
                        @if ($product->image)                      
                        <div class="item" id="imgpreview">
                            <img src="{{asset('uploads/products')}}/{{$product->image}}"
                                class="effect8" alt="{{$product->name}}">
                        </div>
                        @endif
                        <div id="upload-file" class="item up-load">
                            <label class="uploadfile" for="myFile">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="body-text">Drop your images here or select <span
                                        class="tf-color">click to browse</span></span>
                                <input type="file" id="myFile" name="image" accept="image/*">
                            </label>
                        </div>
                    </div>
                </fieldset>
                @error('image')
                    <span class="alert alert-danger text-center">{{$message}}</span>
                @enderror

                <fieldset>
                    <div class="body-title mb-10">Upload Gallery Images</div>
                    <div class="upload-image mb-16">
                        @if ($product->images)
                            @foreach (explode(',',$product->images) as $img)
                            <div class="item gitems">
                                <img src="{{asset('uploads/products')}}/{{trim($img)}}" alt="">
                            </div>     
                            @endforeach
                        @endif
                                                                       
                        <div id="galUpload" class="item up-load">
                            <label class="uploadfile" for="gFile">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="text-tiny">Drop your images here or select <span
                                        class="tf-color">click to browse</span></span>
                                <input type="file" id="gFile" name="images[]" accept="image/*"
                                    multiple="">
                            </label>
                        </div>
                    </div>
                </fieldset>
                {{-- <input type="file" id="gFilee" name="photos[]" accept="image/*"
                multiple=""> --}}
                @error('images')
                    <span class="alert alert-danger text-center">{{$message}}</span>
                @enderror

                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">Regular Price <span
                                class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Enter regular price"
                            name="regular_price" tabindex="0" value="{{$product->regular_price}}" aria-required="true"
                            required="">
                    </fieldset>
                    @error('regular_price')
                        <span class="alert alert-danger text-center">{{$message}}</span>
                    @enderror
                    <fieldset class="name">
                        <div class="body-title mb-10">Sale Price <span
                                class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Enter sale price"
                            name="sale_price" tabindex="0" value="{{$product->sale_price}}" aria-required="true"
                            required="">
                    </fieldset>
                    @error('sale_price')
                        <span class="alert alert-danger text-center">{{$message}}</span>
                    @enderror
                </div>


                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">SKU <span class="tf-color-1">*</span>
                        </div>
                        <input class="mb-10" type="text" placeholder="Enter SKU" name="SKU"
                            tabindex="0" value="{{$product->SKU}}" aria-required="true" required="">
                    </fieldset>
                    @error('SKU')
                        <span class="alert alert-danger text-center">{{$message}}</span>
                    @enderror
                    <fieldset class="name">
                        <div class="body-title mb-10">Quantity <span class="tf-color-1">*</span>
                        </div>
                        <input class="mb-10" type="text" placeholder="Enter quantity"
                            name="quantity" tabindex="0" value="{{$product->quantity}}" aria-required="true"
                            required="">
                    </fieldset>
                    @error('quantity')
                        <span class="alert alert-danger text-center">{{$message}}</span>
                    @enderror
                </div>

                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">Stock</div>
                        <div class="select mb-10">
                            <select class="" name="stock_status">
                                <option value="instock" {{$product->stock_status == "instock"?"selected":""}}>InStock</option>
                                <option value="outofstock" {{$product->stock_status == "outofstock"?"selected":""}}>Out of Stock</option>
                            </select>
                        </div>
                    </fieldset>
                    @error('stock_status')
                        <span class="alert alert-danger text-center">{{$message}}</span>
                    @enderror

                    {{-- <fieldset class="name">
                        <div class="body-title mb-10">Available Sizes</div>
                        <div class="mb-10">
                            <label><input type="checkbox" name="sizes[]" value="S" {{ in_array('S', $sizes) ? 'checked' : '' }}> Small (S)</label>
                            <label><input type="checkbox" name="sizes[]" value="M" {{ in_array('M', $sizes) ? 'checked' : '' }}> Medium (M)</label>
                            <label><input type="checkbox" name="sizes[]" value="L" {{ in_array('L', $sizes) ? 'checked' : '' }}> Large (L)</label>
                            <label><input type="checkbox" name="sizes[]" value="XL" {{ in_array('XL', $sizes) ? 'checked' : '' }}> Extra Large (XL)</label>
                        </div>
                    </fieldset>
                    @error('sizes')
                        <span class="alert alert-danger text-center">{{$message}}</span>
                    @enderror --}}

                    <fieldset class="name">
                        <div class="body-title mb-10">Featured</div>
                        <div class="select mb-10">
                            <select class="" name="featured">
                                <option value="0" {{$product->featured == "0"?"selected":""}}>No</option>
                                <option value="1" {{$product->featured == "1"?"selected":""}}>Yes</option>
                            </select>
                        </div>
                    </fieldset>
                    @error('featured')
                        <span class="alert alert-danger text-center">{{$message}}</span>
                    @enderror
                </div>

                {{-- <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">Available Sizes, Colors, and Quantities</div>
                
                        <div id="sizesColorsQuantities" style="max-height: 300px; overflow-y: auto; border: 1px solid #ddd; padding: 10px; border-radius: 5px;">
                            @php $sizeGroups = []; @endphp
                            @foreach($sizes as $key => $value)
                                @php
                                    list($size, $color) = explode('_', $key);
                                    $sizeGroups[$size][] = ['color' => $color, 'quantity' => $value];
                                @endphp
                            @endforeach
                
                            @foreach($sizeGroups as $size => $colors)
                                <div class="sizeRow" style="margin-bottom: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; background-color: #f9f9f9;">
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <label>
                                            Size:
                                            <select name="size_color_quantity[][size]" class="sizeSelect" required style="padding: 5px; margin-right: 10px;">
                                                <option value="S" @if($size == 'S') selected @endif>Small (S)</option>
                                                <option value="M" @if($size == 'M') selected @endif>Medium (M)</option>
                                                <option value="L" @if($size == 'L') selected @endif>Large (L)</option>
                                                <option value="XL" @if($size == 'XL') selected @endif>Extra Large (XL)</option>
                                            </select>
                                        </label>
                                        <button type="button" class="addColorRow" style="padding: 5px 10px; background-color: #28A745; color: #fff; border: none; border-radius: 5px; cursor: pointer;">Add Color</button>
                                        <button type="button" class="removeSizeRow" style="padding: 5px 10px; background-color: #DC3545; color: #fff; border: none; border-radius: 5px; cursor: pointer;">Remove Size</button>
                                    </div>
                                    <div class="colorRows" style="margin-top: 10px;">
                                        @foreach($colors as $colorData)
                                            <div class="colorRow" style="margin-bottom: 5px; display: flex; align-items: center; gap: 10px;">
                                                <label>
                                                    Color:
                                                    <select name="size_color_quantity[][color][]" required style="padding: 5px;">
                                                        <option value="red" @if($colorData['color'] == 'red') selected @endif>Red</option>
                                                        <option value="blue" @if($colorData['color'] == 'blue') selected @endif>Blue</option>
                                                        <option value="green" @if($colorData['color'] == 'green') selected @endif>Green</option>
                                                        <option value="yellow" @if($colorData['color'] == 'yellow') selected @endif>Yellow</option>
                                                    </select>
                                                </label>
                                                <label>
                                                    Quantity:
                                                    <input type="number" name="size_color_quantity[][quantity][]" value="{{ $colorData['quantity'] }}" min="1" style="padding: 5px; width: 80px;" required>
                                                </label>
                                                <button type="button" class="removeColorRow" style="padding: 5px 10px; background-color: #DC3545; color: #fff; border: none; border-radius: 5px; cursor: pointer;">Remove</button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                
                        <button type="button" id="addSizeRow" style="margin-top: 10px; padding: 8px 15px; background-color: #007BFF; color: #fff; border: none; border-radius: 5px; cursor: pointer;">
                            Add Size
                        </button>
                    </fieldset>
                    @error('size_color_quantity')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror
                </div> --}}
                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">Available Sizes, Colors, and Quantities</div>
                
                        <!-- Scrollable container for dynamic rows -->
                        <div id="sizesColorsQuantities" style="max-height: 300px; overflow-y: auto; border: 1px solid #ddd; padding: 10px; border-radius: 5px;">
                            <!-- Dynamic rows will be added here -->
                        </div>
                
                        <!-- Add size button -->
                        <button type="button" id="addSizeRow" style="margin-top: 10px; padding: 8px 15px; background-color: #007BFF; color: #fff; border: none; border-radius: 5px; cursor: pointer;">
                            Add Size
                        </button>
                    </fieldset>
                    @error('size_color_quantity')
                    <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror
                </div>

                <div class="cols gap10">
                    <button class="tf-button w-full" type="submit">Update product</button>
                </div>
            </div>
        </form>
        <!-- /form-add-product -->
    </div>
    <!-- /main-content-wrap -->
</div>
@endsection

@push('scripts')
    <script>
        $(function(){
            $("#myFile").on("change",function(e){
                const photoInp = $("#myFile");
                const [file] = this.files;
                if(file){
                    $("#imgpreview img").attr('src', URL.createObjectURL(file));
                    $("#imgpreview").show();
                }
            });

            $("#gFile").on("change",function(e){
                const photoInp = $("#gFile");
                const gphotos = this.files;
                $.each(gphotos, function(key,val){
                    $("#galUpload").prepend(`<div class="item gitems"><img src="${URL.createObjectURL(val)}" /></div>`);
                });
            });

            $("input[name='name']").on("change",function(){
                $("input[name='slug']").val(StringToSlug($(this).val()));
            });

            function StringToSlug(Text){
                return Text.toLowerCase()
                .replace(/[^\w ]+/g,"")
                .replace(/ +/g,"-");
            }
        });
    </script>

    {{-- <script>
        const container = document.getElementById('sizesColorsQuantities');
        const addSizeRowBtn = document.getElementById('addSizeRow');
        let sizeIndex = 0; // Track index for nested inputs
    
        addSizeRowBtn.addEventListener('click', function () {
            const sizeRowId = `sizeRow_${sizeIndex}`; // Unique ID for each size row
            const sizeRow = `
                <div id="${sizeRowId}" class="sizeRow" style="margin-bottom: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; background-color: #f9f9f9;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <label>
                            Size:
                            <select name="size_color_quantity[${sizeIndex}][size]" class="sizeSelect" required style="padding: 5px; margin-right: 10px;">
                                <option value="S">Small (S)</option>
                                <option value="M">Medium (M)</option>
                                <option value="L">Large (L)</option>
                                <option value="XL">Extra Large (XL)</option>
                            </select>
                        </label>
                        <button type="button" class="addColorRow" style="padding: 5px 10px; background-color: #28A745; color: #fff; border: none; border-radius: 5px; cursor: pointer;">Add Color</button>
                        <button type="button" class="removeSizeRow" style="padding: 5px 10px; background-color: #DC3545; color: #fff; border: none; border-radius: 5px; cursor: pointer;">Remove Size</button>
                    </div>
                    <div class="colorRows" style="margin-top: 10px;"></div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', sizeRow);
            sizeIndex++; // Increment index for next row
        });
    
        container.addEventListener('click', function (event) {
            if (event.target.classList.contains('addColorRow')) {
                const parentSizeRow = event.target.closest('.sizeRow');
                const sizeRowIndex = Array.from(container.children).indexOf(parentSizeRow);
                const colorRow = `
                    <div class="colorRow" style="margin-bottom: 5px; display: flex; align-items: center; gap: 10px;">
                        <label>
                            Color:
                            <select name="size_color_quantity[${sizeRowIndex}][color][]" required style="padding: 5px;">
                                <option value="red">Red</option>
                                <option value="blue">Blue</option>
                                <option value="green">Green</option>
                                <option value="yellow">Yellow</option>
                            </select>
                        </label>
                        <label>
                            Quantity:
                            <input type="number" name="size_color_quantity[${sizeRowIndex}][quantity][]" min="1" style="padding: 5px; width: 80px;" required>
                        </label>
                        <button type="button" class="removeColorRow" style="padding: 5px 10px; background-color: #DC3545; color: #fff; border: none; border-radius: 5px; cursor: pointer;">Remove</button>
                    </div>
                `;
                parentSizeRow.querySelector('.colorRows').insertAdjacentHTML('beforeend', colorRow);
            }
    
            // Remove color row
            if (event.target.classList.contains('removeColorRow')) {
                event.target.closest('.colorRow').remove();
            }
    
            // Remove size row
            if (event.target.classList.contains('removeSizeRow')) {
                event.target.closest('.sizeRow').remove();
            }
        });
    </script> --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
    const container = document.getElementById("sizesColorsQuantities");
    const addSizeRowBtn = document.getElementById("addSizeRow");
    let sizeIndex = container.children.length; // Start index based on existing elements

    // Function to create a size row
    function createSizeRow(size = "", colors = []) {
        const sizeRowId = `sizeRow_${sizeIndex}`;
        let sizeOptions = ["S", "M", "L", "XL"]
            .map((s) => `<option value="${s}" ${s === size ? "selected" : ""}>${s}</option>`)
            .join("");

        let colorRows = colors
            .map(
                (colorData, colorIndex) => `
                <div class="colorRow" style="margin-bottom: 5px; display: flex; align-items: center; gap: 10px;">
                    <label>
                        Color:
                        <select name="size_color_quantity[${sizeIndex}][color][]" required style="padding: 5px;">
                            <option value="red" ${colorData.color === "red" ? "selected" : ""}>Red</option>
                            <option value="blue" ${colorData.color === "blue" ? "selected" : ""}>Blue</option>
                            <option value="green" ${colorData.color === "green" ? "selected" : ""}>Green</option>
                            <option value="yellow" ${colorData.color === "yellow" ? "selected" : ""}>Yellow</option>
                        </select>
                    </label>
                    <label>
                        Quantity:
                        <input type="number" name="size_color_quantity[${sizeIndex}][quantity][]" value="${colorData.quantity}" min="1" style="padding: 5px; width: 80px;" required>
                    </label>
                    <button type="button" class="removeColorRow" style="padding: 5px 10px; background-color: #DC3545; color: #fff; border: none; border-radius: 5px; cursor: pointer;">Remove</button>
                </div>`
            )
            .join("");

        const sizeRow = `
            <div id="${sizeRowId}" class="sizeRow" style="margin-bottom: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; background-color: #f9f9f9;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <label>
                        Size:
                        <select name="size_color_quantity[${sizeIndex}][size]" class="sizeSelect" required style="padding: 5px; margin-right: 10px;">
                            ${sizeOptions}
                        </select>
                    </label>
                    <button type="button" class="addColorRow" style="padding: 5px 10px; background-color: #28A745; color: #fff; border: none; border-radius: 5px; cursor: pointer;">Add Color</button>
                    <button type="button" class="removeSizeRow" style="padding: 5px 10px; background-color: #DC3545; color: #fff; border: none; border-radius: 5px; cursor: pointer;">Remove Size</button>
                </div>
                <div class="colorRows" style="margin-top: 10px;">
                    ${colorRows}
                </div>
            </div>
        `;

        container.insertAdjacentHTML("beforeend", sizeRow);
        sizeIndex++;
    }

    // Load existing data on page load
    const existingSizes = @json($sizes);
    if (Object.keys(existingSizes).length > 0) {
        let sizeGroups = {};
        Object.entries(existingSizes).forEach(([key, quantity]) => {
            let [size, color] = key.split("_");
            if (!sizeGroups[size]) {
                sizeGroups[size] = [];
            }
            sizeGroups[size].push({ color, quantity });
        });

        Object.entries(sizeGroups).forEach(([size, colors]) => {
            createSizeRow(size, colors);
        });
    }

    // Event listener for adding new size rows
    addSizeRowBtn.addEventListener("click", function () {
        createSizeRow();
    });

    // Event delegation for dynamically added elements
    container.addEventListener("click", function (event) {
        if (event.target.classList.contains("addColorRow")) {
            const parentSizeRow = event.target.closest(".sizeRow");
            const sizeRowIndex = Array.from(container.children).indexOf(parentSizeRow);

            const colorRow = `
                <div class="colorRow" style="margin-bottom: 5px; display: flex; align-items: center; gap: 10px;">
                    <label>
                        Color:
                        <select name="size_color_quantity[${sizeRowIndex}][color][]" required style="padding: 5px;">
                            <option value="red">Red</option>
                            <option value="blue">Blue</option>
                            <option value="green">Green</option>
                            <option value="yellow">Yellow</option>
                        </select>
                    </label>
                    <label>
                        Quantity:
                        <input type="number" name="size_color_quantity[${sizeRowIndex}][quantity][]" min="1" style="padding: 5px; width: 80px;" required>
                    </label>
                    <button type="button" class="removeColorRow" style="padding: 5px 10px; background-color: #DC3545; color: #fff; border: none; border-radius: 5px; cursor: pointer;">Remove</button>
                </div>
            `;
            parentSizeRow.querySelector(".colorRows").insertAdjacentHTML("beforeend", colorRow);
        }

        // Remove color row
        if (event.target.classList.contains("removeColorRow")) {
            event.target.closest(".colorRow").remove();
        }

        // Remove size row
        if (event.target.classList.contains("removeSizeRow")) {
            event.target.closest(".sizeRow").remove();
        }
    });
});

    </script>
@endpush