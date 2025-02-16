@extends('layouts.app')

@section('content')
<main class="pt-90 register-page">
    <div class="mb-4 pb-4"></div>

    <section class="login-register container">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-6">
                <img src="assets/images/login-img.png" alt="register">
            </div>
    
            <div class="col-lg-6">
                <div class="d-flex justify-content-center align-items-center">
                    <div class="toggle-container active">
                        <div class="toggle-btn"></div>
                        <a href="{{route('login')}}" class="toggle-option login">LOGIN</a>
                        <a href="{{route('register')}}" class="toggle-option register active">REGISTER</a>
                    </div>
                </div>
    
                <div class="form-container active">
                    <form method="POST" action="{{ route('register') }}" name="register-form" class="needs-validation" novalidate="">
                        @csrf
                        <div class="form-floating">
                            <input class="form-control form-control_gray @error('name') is-invalid @enderror" name="name" value="{{old('name')}}" required="" autocomplete="name"
                            autofocus="">
                            <label for="name">Name</label>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-floating">
                            <input id="email" type="email" class="form-control form-control_gray @error('email') is-invalid @enderror" name="email" value="{{old('email')}}" required="" autocomplete="email">
                            <label for="email">Email address *</label>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-floating">
                            <input id="mobile" type="text" class="form-control form-control_gray "@error('mobile') is-invalid @enderror name="mobile" value="{{old('mobile')}}"
                            required="" autocomplete="mobile">
                            <label for="mobile">Mobile *</label>
                            @error('mobile')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-floating">
                            <input id="password" type="password" class="form-control form-control_gray @error('password') is-invalid @enderror" name="password" required=""
                                autocomplete="new-password">
                            <label for="password">Password *</label>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-floating">
                            <input id="password-confirm" type="password" class="form-control form-control_gray"
                            name="password_confirmation" required="" autocomplete="new-password">
                            <label for="password">Confirm Password *</label>
                        </div>

                        <div class="privacy-consent">
                            <p>Your personal data will be used to support your experience throughout this website, to manage access to your account, and for other purposes described in our privacy policy.</p>
                        </div>
                        <button class="btn btn-primary w-100 text-uppercase" type="submit">Register</button>
                        <div class="customer-option mt-4 text-center">
                            <span>Have an account?</span>
                            <a href="{{route('login')}}">Login to your Account</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
