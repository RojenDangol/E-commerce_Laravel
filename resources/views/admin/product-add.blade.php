@extends('layouts.admin')
@section('content')
{{-- @dd($colors) --}}
<div class="main-content-inner">
    <!-- main-content-wrap -->
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Add Product</h3>
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
                    <div class="text-tiny">Add product</div>
                </li>
            </ul>
        </div>
        <!-- form-add-product -->
        <form class="tf-section-2 form-add-product" method="POST" enctype="multipart/form-data"
            action="{{route('admin.product.store')}}">
            @csrf
            <div class="wg-box">
                <fieldset class="name">
                    <div class="body-title mb-10">Product name <span class="tf-color-1">*</span>
                    </div>
                    <input class="mb-10" type="text" placeholder="Enter product name"
                        name="name" tabindex="0" value="{{old('name')}}" aria-required="true" required="">
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
                            name="slug" tabindex="0" value="{{old('slug')}}" aria-required="true" required="">
                    </fieldset>
                    @error('slug')
                        <span class="alert alert-danger text-center">{{$message}}</span>
                    @enderror

                    <fieldset class="wardrobe">
                        <div class="body-title mb-10">Wardrobe <span class="tf-color-1">*</span>
                        </div>
                        <div class="select">
                            <select class="" name="wardrobe">
                                <option value="men">Men</option>
                                <option value="women">Women</option>
                                <option value="kid">Kid</option>
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
                                    <option value="{{$category->id}}">{{$category->name}}</option>
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
                                    <option value="{{$brand->id}}">{{$brand->name}}</option>
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
                        required="">{{old('short_description')}}</textarea>
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
                        tabindex="0" aria-required="true" required="">{{old('description')}}</textarea>
                    <div class="text-tiny">Do not exceed 100 characters when entering the
                        product name.</div>
                </fieldset>
                @error('description')
                    <span class="alert alert-danger text-center">{{$message}}</span>
                @enderror
            </div>
            <div class="wg-box">
                <fieldset>
                    <div class="body-title">Upload image <span class="tf-color-1">*</span>
                    </div>
                    <div class="upload-image flex-grow">
                        <div class="item" id="imgpreview" style="display:none">
                            <img src="../../../localhost_8000/images/upload/upload-1.png"
                                class="effect8" alt="">
                        </div>
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
                
                @error('images')
                    <span class="alert alert-danger text-center">{{$message}}</span>
                @enderror

                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">Regular Price <span
                                class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Enter regular price"
                            name="regular_price" tabindex="0" value="{{old('regular_price')}}" aria-required="true"
                            required="">
                    </fieldset>
                    @error('regular_price')
                        <span class="alert alert-danger text-center">{{$message}}</span>
                    @enderror
                    <fieldset class="name">
                        <div class="body-title mb-10">Sale Price <span
                                class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Enter sale price"
                            name="sale_price" tabindex="0" value="{{old('sale_price')}}" aria-required="true"
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
                            tabindex="0" value="{{old('SKU')}}" aria-required="true" required="">
                    </fieldset>
                    @error('SKU')
                        <span class="alert alert-danger text-center">{{$message}}</span>
                    @enderror
                    <fieldset class="name">
                        <div class="body-title mb-10">Quantity <span class="tf-color-1">*</span>
                        </div>
                        <input class="mb-10" type="text" placeholder="Enter quantity"
                            name="quantity" tabindex="0" value="{{old('quantity')}}" aria-required="true"
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
                                <option value="instock">InStock</option>
                                <option value="outofstock">Out of Stock</option>
                            </select>
                        </div>
                    </fieldset>
                    @error('stock_status')
                        <span class="alert alert-danger text-center">{{$message}}</span>
                    @enderror
                    
                    {{-- <fieldset class="name">
                        <div class="body-title mb-10">Available Sizes</div>
                        <div class="mb-10">
                                    <label><input type="checkbox" name="sizes[]" value="S"> Small (S)</label>
                                    <label><input type="checkbox" name="sizes[]" value="M"> Medium (M)</label>
                                    <label><input type="checkbox" name="sizes[]" value="L"> Large (L)</label>
                                    <label><input type="checkbox" name="sizes[]" value="XL"> Extra Large (XL)</label>
                        </div>
                    </fieldset>
                    @error('sizes')
                        <span class="alert alert-danger text-center">{{$message}}</span>
                    @enderror --}}
                    
                    <fieldset class="name">
                        <div class="body-title mb-10">Featured</div>
                        <div class="select mb-10">
                            <select class="" name="featured">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>
                    </fieldset>
                    @error('featured')
                        <span class="alert alert-danger text-center">{{$message}}</span>
                    @enderror
                </div>

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
                    <button class="tf-button w-full" type="submit">Add product</button>
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

<script>
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
                            @foreach ($colors as $color)
                                <option value="{{$color->code}}">{{$color->name}}</option>
                            @endforeach
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
</script>

@endpush