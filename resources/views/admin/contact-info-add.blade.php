@extends('layouts.admin')
@section('content')
<div class="main-content-inner">
    <!-- main-content-wrap -->
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Slide</h3>
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
                    <a href="{{route('admin.contact.info')}}">
                        <div class="text-tiny">Contact Info</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">New Contact Info</div>
                </li>
            </ul>
        </div>
        <!-- new-category -->
        <div class="wg-box">
            <form class="form-new-product form-style-1" method="POST" action="{{route('admin.contact.info.store')}}" enctype="multipart/form-data">
                @csrf
                <fieldset>
                    <div class="body-title">Site Logo <span class="tf-color-1">*</span>
                    </div>
                    <div class="upload-image flex-grow">
                        <div class="item" id="imgpreview" style="display:none">
                            <img src="upload-1.html" class="effect8" alt="">
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

                <fieldset class="name">
                    <div class="body-title">Location <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="Location" name="address"
                        tabindex="0" value="{{old('address')}}" aria-required="true" required="">
                </fieldset>
                @error('address')
                    <span class="alert alert-danger text-center">{{$message}}</span>
                @enderror

                <fieldset class="name">
                    <div class="body-title">Email <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="Email" name="email"
                        tabindex="0" value="{{old('email')}}" aria-required="true" required="">
                </fieldset>
                @error('email')
                    <span class="alert alert-danger text-center">{{$message}}</span>
                @enderror

                <fieldset class="name">
                    <div class="body-title">Phone Number <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="Phone Number" name="phone"
                        tabindex="0" value="{{old('phone')}}" aria-required="true" required="">
                </fieldset>
                @error('phone')
                    <span class="alert alert-danger text-center">{{$message}}</span>
                @enderror


                <fieldset class="name">
                    <div class="body-title">Social Media <span class="tf-color-1">*</span></div>
                    <div id="repeater" class="sortable-container">
                        <div class="repeater-item row" data-index="0">
                            <div>
                                <span class="repeater-number">1</span>
                                <span class="separator">:::</span>
                            </div>
                            <div class="col-md-4 select">
                                <select name="items[0][title]" id="title-0" required>
                                    <option value="facebook">Facebook</option>
                                    <option value="instagram">Instagram</option>
                                    <option value="x">X</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <input type="text" id="code-0" name="items[0][link]" class="form-control color-code" placeholder="Enter Link" required>
                            </div>

                            <!-- Controls -->
                            <div class="repeater-controls col-md-4">
                                <button type="button" class="btn-add btn-success">+</button>
                                <button type="button" class="btn-remove btn-danger">-</button>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <div class="bot">
                    <div></div>
                    <button class="tf-button w208" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>

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
    });
</script>

<script>
    let index = 1;

    // Add new repeater item below the current one
    const addRepeaterItem = (currentIndex, currentItem) => {
        const repeater = document.getElementById('repeater');
        const newItem = document.createElement('div');
        newItem.classList.add('repeater-item', 'row');
        newItem.setAttribute('data-index', currentIndex);
        newItem.innerHTML = `
            <div>
                <span class="repeater-number">${currentIndex + 1}</span>
                <span class="separator">:::</span>
            </div>
            <div class="col-md-4 select">
                <select name="items[${currentIndex}][title]" id="title-${currentIndex}">
                    <option value="facebook">Facebook</option>
                    <option value="instagram">Instagram</option>
                    <option value="x-twitter">X</option>
                    <option value="tiktok">Tiktok</option>
                    <option value="linkedin">LinkedIn</option>
                </select>
            </div>     
            <div class="col-md-4">
                <input type="text" id="code-${currentIndex}" name="items[${currentIndex}][link]" class="form-control color-code" placeholder="Enter Link" required>
            </div> 
            <div class="repeater-controls col-md-4">
                <button type="button" class="btn-add btn-success">+</button>
                <button type="button" class="btn-remove btn-danger">-</button>
            </div>
        `;

        repeater.insertBefore(newItem, currentItem.nextSibling);
        setupControls(newItem);
        updateNumbers();
    };

    // Remove a repeater item
    const removeRepeaterItem = (item) => {
        const repeater = document.getElementById('repeater');
        if (repeater.childElementCount > 1) {
            item.remove();
            updateNumbers();
        } else {
            swal({
                    title: "Note!",
                    text: "At least one item is required.",
                    type: "warning",
                    buttons: "OK",
                    confirmButtonCOlor: "#dc3545"
                });
        }
    };

    const updateNumbers = () => {
        document.querySelectorAll('.repeater-item').forEach((item, index) => {
            item.querySelector('.repeater-number').textContent = index + 1;
        });
    };

    const setupControls = (item) => {
        item.querySelector('.btn-add').addEventListener('click', () => {
            addRepeaterItem(index++, item);
        });

        item.querySelector('.btn-remove').addEventListener('click', () => {
            removeRepeaterItem(item);
        });
    };

    document.querySelectorAll('.repeater-item').forEach(setupControls);

    const sortable = new Sortable(document.getElementById('repeater'), {
        handle: '.repeater-item',
        animation: 150,
        onEnd(evt) {
            // Handle the reordering of the repeater fields if necessary
            updateNumbers();
            console.log('Reorder complete');
        }
    });
</script>
@endpush
