@extends('wrapper')

@section('content')

  <div id="login">
                    <form method="POST" action="{{ route('login') }}">

                        @csrf

                        <div>

                          {{-- <label for="password">{{ __('Login') }}</label> --}}
                          <label for="password">E-mail</label>

                          <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                          @if ($errors->has('email'))
                            <span>{{ $errors->first('email') }}</span>
                          @endif

                        </div>

                        <div>

                          <label for="password">{{ __('Password') }}</label>

                          <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" value="123456" required>

                          @if ($errors->has('password'))
                            <span>{{ $errors->first('password') }}</span>
                          @endif

                        </div>

                        {{-- <div>

                          <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                          <label for="remember">
                              {{ __('Remember Me') }}
                          </label>

                        </div> --}}

                        <div id="login__submit">

                          <button class="button--small button--cta" type="submit">{{ __('Login') }}</button>

                          @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
                          @endif

                        </div>

                    </form>
</div>
@endsection
