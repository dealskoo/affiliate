@extends('affiliate::layouts.auth')

@section('title',__('affiliate::auth.confirm_password'))

@section('body')
    <div class="align-items-center d-flex h-100">
        <div class="card-body">

            <!-- Logo -->
            <div class="auth-brand text-center text-lg-start">
                <a href="{{ route('affiliate.dashboard') }}" class="logo-dark">
                    <span><img src="{{ asset(config('affiliate.logo')) }}" alt="" height="40"></span>
                </a>
                <a href="{{ route('affiliate.dashboard') }}" class="logo-light">
                    <span><img src="{{ asset(config('affiliate.logo_dark')) }}" alt="" height="40"></span>
                </a>
            </div>

            <!-- User pic with title-->
            <div class="text-center w-75 m-auto">
                <img src="{{ Auth::user()->avatar_url }}" height="64" alt="user-image" class="rounded-circle shadow">
                <h4 class="text-dark-50 text-center mt-3 fw-bold">Hi ! {{ Auth::user()->name }} </h4>
                <div class="mb-4">
                    @if(empty($errors->all()))
                        <p class="text-muted mb-0">{{ __('This is a secure area of the application. Please confirm your password before continuing.') }}</p>
                    @else
                        @foreach($errors->all() as $error)
                            <p class="text-danger mb-0">{{ $error }}</p>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- form -->
            <form method="POST" action="{{ route('affiliate.password.confirm') }}">
                @csrf
                <div class="mb-3">
                    <label for="password" class="form-label">{{ __('affiliate::auth.password') }}</label>
                    <div class="input-group">
                        <input class="form-control" type="password" required="" id="password" name="password"
                               minlength="{{ config('auth.password_length') }}" autofocus tabindex="1"
                               placeholder="{{ __('affiliate::auth.password_placeholder') }}">
                        <div class="input-group-text" data-password="false">
                            <span class="password-eye"></span>
                        </div>
                    </div>
                </div>
                <div class="mb-0 text-center d-grid">
                    <button class="btn btn-primary" type="submit">{{ __('Confirm') }}</button>
                </div>
            </form>
            <!-- end form-->

            <!-- Footer-->
            <footer class="footer footer-alt">
                <p class="text-muted">{{ config('affiliate.copyright') }}</p>
            </footer>

        </div> <!-- end .card-body -->
    </div>
@endsection
