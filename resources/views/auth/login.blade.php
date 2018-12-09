@extends('auth.layout')

@section('content')
  <section class="sign-in">
    <div class="container">
      <div class="signin-content">
        <div class="signin-image">
          <figure><img src="/auth/images/signin-image.jpg" alt="sing up image"></figure>
          <a href="{{ route('register') }}" class="signup-image-link">Create an account</a>
        </div>

        <div class="signin-form">
          <h2 class="form-title">{{ __('Login') }}</h2>
          <form method="POST" class="register-form" id="login-form" action="{{ route('login') }}">
            @csrf
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
              <input type="checkbox" name="remember" id="remember-me"
                     class="agree-term" {{ old('remember') ? 'checked' : '' }}/>
              <label for="remember-me" class="label-agree-term"><span><span></span></span>{{ __('Remember Me') }}
              </label>

            </div>
            <div class="form-group form-button">
              <input type="submit" name="signin" id="signin" class="form-submit" value="{{ __('Login') }}"/><br>
              <a class="btn btn-link" href="{{ route('password.request') }}">
                {{ __('Forgot Your Password?') }}
              </a>
            </div>
          </form>
          <div class="social-login">
            <span class="social-label">Or login with</span>
            <ul class="socials">
              <li><a href="#"><i class="display-flex-center zmdi zmdi-facebook"></i></a></li>
              <li><a href="#"><i class="display-flex-center zmdi zmdi-twitter"></i></a></li>
              <li><a href="#"><i class="display-flex-center zmdi zmdi-google"></i></a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
