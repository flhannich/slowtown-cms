
              <div id="settings__register" class="block">

                <h4>Register new User</h4>

                    <form method="POST" action="/dashboard/register">
                        @csrf

                        <div>
                          <label for="name"><small>Name</small></label>
                          <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
                            @if ($errors->has('name'))
                              <span>{{ $errors->first('name') }}</span>
                            @endif
                        </div>

                        <div>
                          <label><small>E-mail</small></label>
                          <input id="email" type="email" class="{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                          @if ($errors->has('email'))
                            <span>{{ $errors->first('email') }}</span>
                          @endif
                        </div>

                        <div>
                          <label><small>Password</small></label>
                          <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" value="123456" required>
                          @if ($errors->has('password'))
                            <span>{{ $errors->first('password') }}</span>
                          @endif
                        </div>

                        <div>
                          <label for="password-confirm"><small>Confirm Password</small></label>
                          <input id="password-confirm" type="password" class="form-control" name="password_confirmation" value="123456" required>
                        </div>

                        <div class="register__controls">
                          <button class="button--cta button--small" type="submit">{{ __('Register') }}</button>
                        </div>

                    </form>
            </div>
