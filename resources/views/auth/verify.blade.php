@extends('layouts.app')

@section('content')
  <div>

      <div>{{ __('Verify Your Email Address') }}</div>

      <div>

        @if (session('resent'))

          <div>

            {{ __('A fresh verification link has been sent to your email address.') }}

          </div>

        @endif

          {{ __('Before proceeding, please check your email for a verification link.') }}

          {{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>.

      </div>

    </div>

@endsection
