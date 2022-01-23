@extends('affiliate::layouts.auth')

@section('title',__('affiliate::auth.sign_up'))

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

            <!-- title-->
            <h4 class="mt-0">{{ __('affiliate::auth.sign_up') }}</h4>
            <div class="mb-4">
                @if(empty($errors->all()))
                    <p class="text-muted mb-0">{{ __('affiliate::auth.sign_up_tip') }}</p>
                @else
                    @foreach($errors->all() as $error)
                        <p class="text-danger mb-0">{{ $error }}</p>
                    @endforeach
                @endif
            </div>


            <!-- form -->
            <form action="{{ route('affiliate.register') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="full_name" class="form-label">{{ __('affiliate::auth.full_name') }}</label>
                    <input class="form-control" type="text" id="full_name" name="name" value="{{ old('name') }}"
                           placeholder="{{ __('affiliate::auth.full_name_placeholder') }}" required autofocus
                           tabindex="1">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('affiliate::auth.email_address') }}</label>
                    <input class="form-control" type="email" id="email" name="email" value="{{ old('email') }}" required
                           placeholder="{{ __('affiliate::auth.email_address_placeholder') }}" tabindex="2">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">{{ __('affiliate::auth.password') }}</label>
                    <div class="input-group">
                        <input class="form-control" type="password" required id="password" name="password" tabindex="3"
                               min="{{ config('affiliate.password_length') }}"
                               placeholder="{{ __('affiliate::auth.password_placeholder') }}">
                        <div class="input-group-text" data-password="false">
                            <span class="password-eye"></span>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="password_confirmation"
                           class="form-label">{{ __('affiliate::auth.confirm_password') }}</label>
                    <div class="input-group">
                        <input class="form-control" type="password" required id="password_confirmation" tabindex="4"
                               name="password_confirmation" min="{{ config('affiliate.password_length') }}"
                               placeholder="{{ __('affiliate::auth.confirm_password_placeholder') }}">
                        <div class="input-group-text" data-password="false">
                            <span class="password-eye"></span>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" checked id="checkbox-signup" tabindex="5">
                        <label class="form-check-label" for="checkbox-signup">{{ __('affiliate::auth.i_accept') }} <a
                                href="{{ route(config('affiliate.terms_and_conditions_url')) }}" target="_blank"
                                class="text-muted">{{ __('affiliate::auth.terms_and_conditions') }}</a></label>
                    </div>
                </div>
                <div class="mb-0 d-grid text-center">
                    <button class="btn btn-primary" type="submit" tabindex="6"><i
                            class="mdi mdi-account-circle"></i> {{ __('affiliate::auth.sign_up') }}
                    </button>
                </div>
            </form>
            <!-- end form-->

            <!-- Footer-->
            <footer class="footer footer-alt">
                <p class="text-muted">{{ __('affiliate::auth.already_have_account') }} <a
                        href="{{ route('affiliate.login') }}"
                        class="text-muted ms-1"><b>{{ __('affiliate::auth.log_in') }}</b></a>
                </p>
            </footer>

        </div> <!-- end .card-body -->
    </div> <!-- end .align-items-center.d-flex.h-100-->
@endsection
