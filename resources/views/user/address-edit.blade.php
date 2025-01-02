@extends('layouts.app')
@section('content')
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="my-account container">
        <h2 class="page-title">Edit Address</h2>
        <div class="row">
            <div class="col-lg-3">
                @include('user.account-nav')
            </div>
            <div class="col-lg-9">
                <div class="page-content my-account__edit">
                  <div class="my-account__edit-form">
                    <form name="account_edit_form" action="{{route('user.address.update')}}" method="POST" class="needs-validation" novalidate="">
                        @csrf
                        @method('PUT')
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-floating my-3">
                            <input type="text" class="form-control" placeholder="Full Name" name="name" value="{{$address->name}}" required="" readonly>
                            <label for="name">Name</label>
                          </div>
                        </div>
                        @error('name')
                        <span class="text-danger">{{$message}}</span>
                        @enderror

                        <div class="col-md-6">
                          <div class="form-floating my-3">
                            <input type="text" class="form-control" placeholder="Mobile Number" name="phone" value="{{$address->phone}}"
                              required="">
                            <label for="phone">Mobile Number</label>
                          </div>
                        </div>
                        @error('phone')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        
                        <div class="col-md-6">
                          <div class="form-floating my-3">
                            <input type="text" class="form-control" placeholder="Locality" name="locality" value="{{$address->locality}}"
                              required="">
                            <label for="account_email">Locality</label>
                          </div>
                        </div>
                        @error('locality')
                        <span class="text-danger">{{$message}}</span>
                        @enderror

                        <div class="col-md-6">
                          <div class="form-floating my-3">
                            <input type="text" class="form-control" placeholder="City" name="city" value="{{$address->city}}"
                              required="">
                            <label for="account_email">City</label>
                          </div>
                        </div>
                        @error('city')
                        <span class="text-danger">{{$message}}</span>
                        @enderror

                        <div class="col-md-6">
                          <div class="form-floating my-3">
                            <input type="text" class="form-control" placeholder="State" name="state" value="{{$address->state}}"
                              required="">
                            <label for="account_email">State</label>
                          </div>
                        </div>
                        @error('state')
                        <span class="text-danger">{{$message}}</span>
                        @enderror

                        <div class="col-md-6">
                          <div class="form-floating my-3">
                            <input type="text" class="form-control" placeholder="Landmark" name="landmark" value="{{$address->landmark}}"
                              required="">
                            <label for="account_email">Landmark</label>
                          </div>
                        </div>
                        @error('landmark')
                        <span class="text-danger">{{$message}}</span>
                        @enderror

                        <div class="col-md-6">
                          <div class="form-floating my-3">
                            <input type="text" class="form-control" placeholder="House No" name="address" value="{{$address->address}}"
                              required="">
                            <label for="account_email">House No</label>
                          </div>
                        </div>
                        @error('address')
                  <span class="text-danger">{{$message}}</span>
                  @enderror

                        <div class="col-md-6">
                          <div class="form-floating my-3">
                            <input type="text" class="form-control" placeholder="Zip" name="zip" value="{{$address->zip}}"
                              required="">
                            <label for="account_email">Zip</label>
                          </div>
                        </div>
                        @error('zip')
                  <span class="text-danger">{{$message}}</span>
                  @enderror

                        <div class="col-md-6">
                            <div class="form-floating my-3">
                                <select class="form-control" style="line-height: 1;" name="isdefault" placeholder="IsDefault">
                                    <option value="1" {{$address->isdefault == "1" ?"selected":""}}>Default</option>
                                    <option value="0" {{$address->isdefault == "0" ?"selected":""}}>Not default</option>
                                </select>
                            </div>
                        </div>
                        @error('isdefault')
                  <span class="text-danger">{{$message}}</span>
                  @enderror

                        <input type="hidden" name="id" value="{{$address->id}}">

                        <div class="col-md-12">
                          <div class="my-3">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                          </div>
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
