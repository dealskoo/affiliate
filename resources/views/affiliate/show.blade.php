@extends('admin::layouts.panel')

@section('title',__('affiliate::affiliate.affiliate_information'))
@section('body')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{ route('admin.dashboard') }}">{{ __('admin::admin.dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('affiliate::affiliate.affiliate_information') }}</li>
                    </ol>
                </div>
                <h4 class="page-title">{{ __('affiliate::affiliate.affiliate_information') }}</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="name" class="form-label">{{ __('affiliate::affiliate.name') }}</label>
                                <input type="text" class="form-control" id="name" name="name" required
                                       value="{{ $affiliate->name }}" readonly autofocus tabindex="1">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('affiliate::affiliate.email') }}</label>
                                <input type="text" class="form-control" id="email" name="email" required
                                       value="{{ $affiliate->email }}" readonly autofocus tabindex="4">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="company_name"
                                       class="form-label">{{ __('affiliate::affiliate.company_name') }}</label>
                                <input type="text" class="form-control" id="company_name" name="company_name" required
                                       value="{{ $affiliate->company_name }}" readonly autofocus tabindex="5">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="website" class="form-label">{{ __('affiliate::affiliate.website') }}</label>
                                <input type="text" class="form-control" id="website" name="website" required
                                       value="{{ $affiliate->website }}" readonly autofocus tabindex="6">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="bio" class="form-label">{{ __('affiliate::affiliate.bio') }}</label>
                                <textarea class="form-control" id="bio" rows="4" name="bio" tabindex="8"
                                          readonly>{{ old('bio',Auth::user()->bio) }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="status_box" name="status"
                                           tabindex="9"
                                           value="1" {{ $affiliate->status?'checked':'' }}>
                                    <label for="status_box"
                                           class="form-check-label">{{ __('affiliate::affiliate.active') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
