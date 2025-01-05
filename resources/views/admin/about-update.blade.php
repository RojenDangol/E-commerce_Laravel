@extends('layouts.admin')
@section('content')

<div class="main-content-inner">
    <!-- main-content-wrap -->
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Edit Slide</h3>
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
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">About Us</div>
                </li>
            </ul>
        </div>
        <!-- new-category -->
        <div class="wg-box">
            @if(Session::has('status'))
                <p class="alert alert-success">{{Session::get('status')}}</p>
            @endif
            <form class="form-new-product form-style-1" method="POST" action="{{route('admin.about.store')}}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{$about->id}}">
                <fieldset class="name">
                    <div class="body-title">Main Description <span class="tf-color-1">*</span></div>
                    <textarea class="flex-grow" placeholder="Main Description" name="main_intro" tabindex="0" value="{{$about->main_intro}}" aria-required="true" required=""></textarea>
                </fieldset>
                @error('main_intro')
                    <span class="alert alert-danger text-center">{{$message}}</span>
                @enderror

                <fieldset class="name">
                    <div class="body-title">Description <span class="tf-color-1">*</span></div>
                    <textarea class="flex-grow" placeholder="Description" name="intro" tabindex="0" value="{{$about->intro}}" aria-required="true" required=""></textarea>
                </fieldset>
                @error('intro')
                    <span class="alert alert-danger text-center">{{$message}}</span>
                @enderror

                <fieldset class="name">
                    <div class="body-title">Mission <span class="tf-color-1">*</span></div>
                    <textarea class="flex-grow" placeholder="Mission" name="mission" tabindex="0" value="{{$about->mission}}" aria-required="true" required=""></textarea>
                </fieldset>
                @error('mission')
                    <span class="alert alert-danger text-center">{{$message}}</span>
                @enderror

                <fieldset class="name">
                    <div class="body-title">Vision <span class="tf-color-1">*</span></div>
                    <textarea class="flex-grow" placeholder="Vision" name="vision" tabindex="0" value="{{$about->vision}}" aria-required="true" required=""></textarea>
                </fieldset>
                @error('vision')
                    <span class="alert alert-danger text-center">{{$message}}</span>
                @enderror

                <fieldset class="name">
                    <div class="body-title">About Company <span class="tf-color-1">*</span></div>
                    <textarea class="flex-grow" placeholder="About Company" name="company" tabindex="0" value="{{$about->company}}" aria-required="true" required=""></textarea>
                </fieldset>
                @error('company')
                    <span class="alert alert-danger text-center">{{$message}}</span>
                @enderror


                <fieldset>
                    <div class="body-title">Cover images <span class="tf-color-1">*</span>
                    </div>
                    <div class="upload-image flex-grow">
                        @if ($about->cover_image) 
                        <div class="item" id="imgpreview">
                            <img src="{{asset('uploads/about')}}/{{$about->cover_image}}" alt="" class="effect8" />
                        </div>
                        @else
                        <div class="item" id="imgpreview">
                            <img src="" alt="" class="effect8" />
                        </div>
                        @endif
                        <div class="item up-load">
                            <label class="uploadfile" for="myFile">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="body-text">Drop your images here or select <span
                                        class="tf-color">click to browse</span></span>
                                <input type="file" id="myFile" name="cover_image">
                            </label>
                        </div>
                    </div>
                </fieldset>

                <fieldset>
                    <div class="body-title">Company images <span class="tf-color-1">*</span>
                    </div>
                    <div class="upload-image flex-grow">
                        @if ($about->company_image) 
                        <div class="item" id="imgpreview1">
                            <img src="{{asset('uploads/about')}}/{{$about->company_image}}" alt="" class="effect8" />
                        </div>
                        @else
                        <div class="item" id="imgpreview1">
                            <img src="" alt="" class="effect8" />
                        </div>
                        @endif
                        <div class="item up-load">
                            <label class="uploadfile" for="myFile1">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="body-text">Drop your images here or select <span
                                        class="tf-color">click to browse</span></span>
                                <input type="file" id="myFile1" name="company_image">
                            </label>
                        </div>
                    </div>
                </fieldset>



                <div class="bot">
                    <div></div>
                    <button class="tf-button w208" type="submit">Save</button>
                </div>
            </form>
        </div>
        <!-- /new-category -->
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

        $("#myFile1").on("change",function(e){
            const photoInp = $("#myFile");
            const [file] = this.files;
            if(file){
                $("#imgpreview1 img").attr('src', URL.createObjectURL(file));
                $("#imgpreview1").show();
            }
        });
    });
</script>
@endpush