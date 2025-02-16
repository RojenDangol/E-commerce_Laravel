@extends('layouts.app')
@section('content')
<style>
    .text-danger{
        color: #e72010 !important;
    }
</style>
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="contact-us container">
      <div class="mw-930">
        <h2 class="page-title text-center">CONTACT US</h2>
      </div>
      <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-12">
          <div class="info-box">
            <h3>Contact Information</h3>
            <div class="single_contact_info">
              <img src="assets/images/icons/icon-27.png" alt="Location" />
              <p>
                <strong>Location </strong><br />
                {{$contact_info->address}}
              </p>
            </div>

            <div class="single_contact_info">
              <img src="assets/images/icons/icon-28.png" alt="Email" />

              <p>
                <strong>Email Address </strong><br />
                {{$contact_info->email}}
              </p>
            </div>
            <div class="single_contact_info">
              <img src="assets/images/icons/icon-29.png" alt="Phone" />

              <p>
                <strong>Phone Number </strong><br />
                {{$contact_info->phone}}
              </p>
            </div>
          </div>
        </div>

        <div class="col-lg-8 col-md-8 col-sm-12">
          <div class="mw-930">
            <div class="contact-us__form">
                @if (Session::has('success'))
                <p class="alert alert-success">{{Session::get('success')}}</p>
                @endif
                <form name="contact-us-form" class="needs-validation" novalidate="" method="POST" action="{{route('home.contact.store')}}">
                    @csrf
                <h3 class="mb-1">Get In Touch</h3>
                <div class="row">
                  <div class="form-floating my-4 col-lg-6">
                    <input type="text" class="form-control" name="name" placeholder="Name *" value="{{old('name')}}" required="">
                    <label for="contact_us_name">Name *</label>
                    @error('name')
                        <span class="text-danger">{{$message}}</span>
                    @enderror 
                  </div>
                  <div class="form-floating my-4 col-lg-6">
                    <input type="text" class="form-control" name="phone" placeholder="Phone *" value="{{old('phone')}}" required="">
                    <label for="contact_us_name">Phone *</label>
                    @error('phone')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                  </div>
                  <div class="form-floating my-4 col-lg-12">
                    <input type="email" class="form-control" name="email" placeholder="Email address *" value="{{old('email')}}" required="">
                    <label for="contact_us_name">Email address *</label>
                    @error('email')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                  </div>
                  <div class="my-4">
                    <textarea class="form-control form-control_gray" name="comment" placeholder="Your Message" cols="30" rows="8" value="{{old('comment')}}" required=""></textarea>
                    @error('comment')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                  </div>
                  <div class="my-4">
                    <button type="submit" class="btn btn-primary">
                      Submit
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
</main>
@endsection