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
@endpush