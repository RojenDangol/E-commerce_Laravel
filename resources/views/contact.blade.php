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
        <h2 class="page-title">CONTACT US</h2>
      </div>
    </section>

    <hr class="mt-2 text-secondary " />
    <div class="mb-4 pb-4"></div>

    <section class="contact-us container">
      <div class="mw-930">
        <div class="contact-us__form">
            @if (Session::has('success'))
                <p class="alert alert-success">{{Session::get('success')}}</p>
            @endif
            <form name="contact-us-form" class="needs-validation" novalidate="" method="POST" action="{{route('home.contact.store')}}">
            @csrf
                <h3 class="mb-5">Get In Touch</h3>
            
                <div class="form-floating my-4">
                    <input type="text" class="form-control" name="name" placeholder="Name *" value="{{old('name')}}" required="">
                    <label for="contact_us_name">Name *</label>
                </div>
                @error('name')
                    <span class="text-danger">{{$message}}</span>
                @enderror       
                <div class="form-floating my-4">
                    <input type="text" class="form-control" name="phone" placeholder="Phone *" value="{{old('phone')}}" required="">
                    <label for="contact_us_name">Phone *</label>
                </div>
                @error('phone')
                    <span class="text-danger">{{$message}}</span>
                @enderror
                <div class="form-floating my-4">
                    <input type="email" class="form-control" name="email" placeholder="Email address *" value="{{old('email')}}" required="">
                    <label for="contact_us_name">Email address *</label>
                </div>
                @error('email')
                    <span class="text-danger">{{$message}}</span>
                @enderror
                <div class="my-4">
                    <textarea class="form-control form-control_gray" name="comment" placeholder="Your Message" cols="30"
                    rows="8" value="{{old('comment')}}" required=""></textarea>
                </div>
                @error('comment')
                    <span class="text-danger">{{$message}}</span>
                @enderror
                <div class="my-4">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
      </div>
    </section>
</main>   
@endsection