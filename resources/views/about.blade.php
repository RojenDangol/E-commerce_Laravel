@extends('layouts.app')
@section('content')

<main class="pt-90">
  <div class="mb-4 pb-4"></div>
  <section id="about-us" class="about-style-four pt_120 pb_120 container">
    <div class="auto-container">
      <div class="row align-items-center">
        <div class="col-lg-6 col-md-12 col-sm-12 image-column">
          <div class="image_block_two">
            <div class="image-inner">
              <div class="image-box mr_15">
                <figure class="image image-1 mb_15">
                  <img
                    src="{{asset('uploads/about')}}/{{$about->cover_image}}"
                    alt="About"
                  />
                </figure>
                <figure class="image image-2">
                  <img
                    src="{{asset('uploads/about')}}/{{$about->company_image}}"
                    alt="About"
                  />
                </figure>
              </div>
              <div class="image-box">
                <figure class="image image-3 mb_15">
                  <img
                    src="{{asset('uploads/about')}}/{{$about->company_image}}"
                    alt="About"
                  />
                </figure>
                <figure class="image image-4">
                  <img
                    src="{{asset('uploads/about')}}/{{$about->cover_image}}"
                    alt="About"
                  />
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
            </div>
          </div>
        </div>
      </div>

      <div class="about-section-col">

        <div class="row section-padding justify-content-center">
          <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".4s">
            <a href="about.html">
              <div class="about-card-items">
                  
                  <div class="about-thumb">
                      <img src="assets/images/icons/objectives.png" alt="service-img">
                      
                  </div>
                   
                  <h3>
                    Our Objectives
            </h3> 
            <div class="overflow-auto">
            <p>{{$about->company}}</p>
                </div>
              </div>
               
                </a>
          </div>

          
          <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".4s">
            <a href="about.html">
              <div class="about-card-items">
                  
                  <div class="about-thumb">
                      <img src="assets/images/icons/mission.png" alt="service-img">
                      
                  </div>
                   
                  <h3>
                    Our Mission
            </h3> 
            <div class="overflow-auto">
            <p>{{$about->mission}} </p>
                </div>
              </div>
               
                </a>
          </div>

          <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".4s">
            <a href="about.html">
              <div class="about-card-items">
                  
                  <div class="about-thumb">
                      <img src="assets/images/icons/vision.png" alt="service-img">
                      
                  </div>
                   
                  <h3>
                    Our Vision
            </h3> 
            <div class="overflow-auto">
            <p>{{$about->vision}}</p>
                </div>
              </div>
               
                </a>
          </div>


           
      </div>
    </div>
    </div>
  </section>

</main>

{{-- <main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="contact-us container">
      <div class="mw-930">
        <h2 class="page-title">About Us</h2>
      </div>

      <div class="about-us__content pb-5 mb-5">
        <p class="mb-5">
          <img loading="lazy" class="w-100 h-auto d-block" src="{{asset('uploads/about')}}/{{$about->cover_image}}" width="1410"
            height="550" alt="" />
        </p>
        <div class="mw-930">
          <h3 class="mb-4">OUR STORY</h3>
          <p class="fs-6 fw-medium mb-4">{{$about->main_intro}}</p>
          <p class="mb-4">{{$about->intro}}</p>
          <div class="row mb-3">
            <div class="col-md-6">
              <h5 class="mb-3">Our Mission</h5>
              <p class="mb-3">{{$about->mission}}</p>
            </div>
            <div class="col-md-6">
              <h5 class="mb-3">Our Vision</h5>
              <p class="mb-3">{{$about->vision}}</p>
            </div>
          </div>
        </div>
        <div class="mw-930 d-lg-flex align-items-lg-center">
          <div class="image-wrapper col-lg-6">
            <img class="h-auto" loading="lazy" src="{{asset('uploads/about')}}/{{$about->company_image}}" width="450" height="500" alt="">
          </div>
          <div class="content-wrapper col-lg-6 px-lg-4">
            <h5 class="mb-3">The Company</h5>
            <p>{{$about->company}}</p>
          </div>
        </div>
      </div>
    </section>
</main> --}}
@endsection