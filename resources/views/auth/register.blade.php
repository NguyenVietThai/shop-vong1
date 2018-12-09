@extends('auth.layout')

@section('content')
  <section class="signup">
    <div class="container">
      <div class="signup-content">
        <div class="signup-form">
          <h2 class="form-title">{{ __('Register') }}</h2>
          <form class="register-form" id="register-form" method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group">
              <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
              <input type="text" name="name" id="name" placeholder="Your Name"
                     class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}"
                     required autofocus/>
              @if ($errors->has('name'))
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('name') }}</strong>
                </span>
              @endif
            </div>
            <div class="form-group">
              <label for="email"><i class="zmdi zmdi-email"></i></label>
              <input type="email" name="email" id="email"
                     class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder=" Your Email"
                     value="{{ old('email') }}" required/>

              @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('email') }}</strong>
                </span>
              @endif
            </div>
            <div class="form-group">
              <label for="pass"><i class="zmdi zmdi-lock"></i></label>
              <input type="password" name="password" id="pass" placeholder="Password"
                     class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                     required/>
              @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('password') }}</strong>
                </span>
              @endif
            </div>
            <div class="form-group">
              <label for="re-pass"><i class="zmdi zmdi-lock-outline"></i></label>
              <input type="password" name="password_confirmation" id="re_pass" placeholder="Repeat your password"
                     required/>

            </div>
            <div class="form-group">
              <input type="checkbox" name="agree-term" id="agree-term" class="agree-term"/>
              <label for="agree-term" class="label-agree-term"><span><span></span></span>I agree all statements in <a
                  href="#" class="term-service">Terms of service</a></label>
            </div>
            <div class="form-group form-button">
              <input type="submit" name="signup" id="signup" class="form-submit" value="{{ __('Register') }}"/>
            </div>
          </form>
        </div>
        <div class="signup-image">
          <figure><img src="/auth/images/signup-image.jpg" alt="sing up image"></figure>
          <a href="#" class="signup-image-link">I am already member</a>
        </div>
      </div>
    </div>
  </section>
@endsection
