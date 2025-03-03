@extends('layouts.admin')
@section('content')

<div class="main-content-inner">
    <!-- main-content-wrap -->
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Edit Contact Information</h3>
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
                    <div class="text-tiny">Edit Contact Info</div>
                </li>
            </ul>
        </div>
        <!-- new-category -->
        <div class="wg-box">
            <form class="form-new-product form-style-1" method="POST" action="{{route('admin.contact.info.update')}}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{$contact_info->id}}">

                <fieldset>
                    <div class="body-title">Site Logo <span class="tf-color-1">*</span>
                    </div>
                    <div class="upload-image flex-grow">
                        @if ($contact_info->logo)                      
                        <div class="item" id="imgpreview">
                            <img src="{{asset('uploads/logo')}}/{{$contact_info->logo}}"
                                class="effect8" alt="{{$contact_info->address}}">
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

                <fieldset class="name">
                    <div class="body-title">Location <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="Location" name="address"
                        tabindex="0" value="{{$contact_info->address}}" aria-required="true" required="">
                </fieldset>
                @error('location')
                    <span class="alert alert-danger text-center">{{$message}}</span>
                @enderror

                <fieldset class="name">
                    <div class="body-title">Email <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="Email" name="email"
                        tabindex="0" value="{{$contact_info->email}}" aria-required="true" required="">
                </fieldset>
                @error('email')
                    <span class="alert alert-danger text-center">{{$message}}</span>
                @enderror
                
                <fieldset class="name">
                    <div class="body-title">Phone Number <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="Phone Number" name="phone"
                        tabindex="0" value="{{$contact_info->phone}}" aria-required="true" required="">
                </fieldset>
                @error('phone')
                    <span class="alert alert-danger text-center">{{$message}}</span>
                @enderror

                <fieldset class="name">
                    <div class="body-title">Social Media <span class="tf-color-1">*</span></div>
                    <div id="repeater" class="sortable-container">
                        @php
                                $index = 0;
                            @endphp
                            @foreach ($info_metas as $key => $value)
                        <div class="repeater-item row" data-index="{{$index}}">
                            <div>
                                <span class="repeater-number">{{$index+1}}</span>
                                <span class="separator">:::</span>
                            </div>
                            <div class="col-md-4 select ">
                                <select name="items[{{$index}}][title]" id="title-{{$index}}" required>
                                    <option value="facebook" {{$key == 'facebook' ? 'selected' : ''}}>Facebook</option>
                                    <option value="instagram" {{$key == 'instagram' ? 'selected' : ''}}>Instagram</option>
                                    <option value="x-twitter" {{$key == 'x-twitter' ? 'selected' : ''}}>X</option>
                                    <option value="tiktok" {{$key == 'tiktok' ? 'selected' : ''}}>Tiktok</option>
                                    <option value="linkedin" {{$key == 'linkedin' ? 'selected' : ''}}>LinkedIn</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <input type="text" id="code-{{$index}}" name="items[{{$index}}][link]" class="form-control color-code" placeholder="Enter Link" value="{{$value}}" required>
                            </div>

                            <!-- Controls -->
                            <div class="repeater-controls col-md-4">
                                <button type="button" class="btn-add btn-success">+</button>
                                <button type="button" class="btn-remove btn-danger">-</button>
                            </div>
                        </div>
                        @php
                            $index++;
                        @endphp
                        @endforeach
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
    document.addEventListener('DOMContentLoaded', function () {
    let index = {{$index}};

    // Function to add a new repeater item
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

        repeater.appendChild(newItem); // Append to the repeater div
        updateNumbers();
    };

    // Function to remove a repeater item
    const removeRepeaterItem = (item) => {
        if (document.querySelectorAll('.repeater-item').length > 1) {
            item.remove();
            updateNumbers();
        } else {
            swal({
                title: "Note!",
                text: "At least one item is required.",
                icon: "warning",
                buttons: "OK",
                confirmButtonColor: "#dc3545"
            });
        }
    };

    // Function to update the numbering of the repeater items
    const updateNumbers = () => {
        document.querySelectorAll('.repeater-item').forEach((item, index) => {
            item.querySelector('.repeater-number').textContent = index + 1;
            item.setAttribute('data-index', index);
        });
    };

    // Event delegation for dynamically added elements
    document.getElementById('repeater').addEventListener('click', function (event) {
        const target = event.target;
        if (target.classList.contains('btn-add')) {
            let currentItem = target.closest('.repeater-item');
            addRepeaterItem(++index, currentItem);
        } else if (target.classList.contains('btn-remove')) {
            let currentItem = target.closest('.repeater-item');
            removeRepeaterItem(currentItem);
        }
    });

    // Make the repeater items sortable
    new Sortable(document.getElementById('repeater'), {
        handle: '.repeater-item',
        animation: 150,
        onEnd(evt) {
            updateNumbers();
        }
    });
});

</script>
@endpush