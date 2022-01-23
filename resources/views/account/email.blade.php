@extends('affiliate::layouts.panel')

@section('title',__('affiliate::affiliate.update_email'))
@section('body')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{ route('affiliate.dashboard') }}">{{ __('affiliate::affiliate.dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('affiliate::affiliate.update_email') }}</li>
                    </ol>
                </div>
                <h4 class="page-title">{{ __('affiliate::affiliate.update_email') }}</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-4 col-lg-5">
            @include('affiliate::includes.profile')
        </div> <!-- end col-->

        <div class="col-xl-8 col-lg-7">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('affiliate.account.email') }}" method="post">
                        @csrf
                        <h5 class="mb-4 text-uppercase"><i
                                class="mdi mdi-account-edit me-1"></i>{{ __('affiliate::affiliate.update_email') }}</h5>
                        @if(!empty(session('success')))
                            <div class="alert alert-success">
                                <p class="mb-0">{{ session('success') }}</p>
                            </div>
                        @endif
                        @if(!empty($errors->all()))
                            <div class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                    <p class="mb-0">{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="email" class="form-label">{{ __('affiliate::affiliate.email') }}</label>
                                    <input type="email" class="form-control" id="email" name="email" required
                                           value="{{ old('email',Auth::user()->email) }}" autofocus tabindex="1"
                                           placeholder="{{ __('affiliate::affiliate.email_placeholder') }}">
                                </div>
                            </div>
                        </div> <!-- end row -->

                        <div class="text-end">
                            <button type="submit" class="btn btn-success mt-2" tabindex="2"><i
                                    class="mdi mdi-content-save"></i> {{ __('affiliate::affiliate.save') }}
                            </button>
                        </div>
                    </form>
                </div> <!-- end card body -->
            </div> <!-- end card -->
        </div> <!-- end col -->
    </div>
@endsection
