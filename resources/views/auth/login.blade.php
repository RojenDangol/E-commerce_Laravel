@extends('layouts.app')

@section('content')
<main class="pt-90 login-page">
    <div class="mb-4 pb-4"></div>
    <section class="login-register container">
      <div class="row justify-content-center align-items-center">
          <div class="col-lg-6">
              <img src="assets/images/login-img.png" alt="login">
          </div>
  
          <div class="col-lg-6">
              <div class="d-flex justify-content-center align-items-center">
                  <div class="toggle-container">
                      <div class="toggle-btn"></div>
                      <a href="{{route('login')}}" class="toggle-option login active">LOGIN</a>
                      <a href="{{route('register')}}" class="toggle-option register">REGISTER</a>
                  </div>
              </div>
  
              <div class="form-container active">
                  <form method="POST" action="{{route('login')}}" name="login-form" class="needs-validation"
                  novalidate="">
                  @csrf
                      <div class="form-floating">
                        <input
                            class="form-control form-control_gray @error('email') is-invalid @enderror"
                            name="email"
                            value="{{old('email')}}"
                            required=""
                            autocomplete="email"
                            autofocus=""
                        />
                          <label for="email">Email address *</label>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                      </div>
                      <div class="form-floating">
                        <input
                            id="password"
                            type="password"
                            class="form-control form-control_gray @error('password') is-invalid @enderror"
                            name="password"
                            required=""
                            autocomplete="current-password"
                        />
                        <label for="customerPasswodInput">Password *</label>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                      </div>
                      <button class="btn btn-primary w-100 text-uppercase" type="submit">Login</button>
                      <div class="customer-option mt-4 text-center">
                          <span>Don't have an account?</span>
                          <a href="{{route('register')}}">Register Now</a>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </section>
  </main>
@endsection
