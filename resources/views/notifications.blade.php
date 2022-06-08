@extends('affiliate::layouts.panel')
@section('title',__('affiliate::affiliate.notifications'))
@section('body')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{ route('affiliate.dashboard') }}">{{ __('affiliate::affiliate.dashboard') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('affiliate::affiliate.notifications') }}</li>
                    </ol>
                </div>
                <h4 class="page-title">{{ __('affiliate::affiliate.notifications') }}</h4>
            </div>
        </div>
    </div>
    <div class="row">

        <!-- Right Sidebar -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @include('affiliate::includes.notification-sidebar')

                    <div class="page-aside-right">
                        @if(count($notifications)>0)
                            <div class="mt-3">
                                <ul class="email-list">
                                    @foreach($notifications as $notification)
                                        <li @if(!$notification->read_at)class="unread"@endif>
                                            <div class="row">
                                                <div class="col-lg-10 ps-4">
                                                    <a href="{{ route('affiliate.notification.show',$notification) }}">{{ __($notification->data['title']) }}</a>
                                                </div>
                                                <div class="col-lg-2">
                                                    <span>{{ $notification->created_at->diffForHumans() }}</span>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <!-- end .mt-4 -->
                        @else
                            @include('affiliate::nodata')
                        @endif
                        <div class="row">
                            {{ $notifications->withQueryString()->links('affiliate::pagination.simple') }}
                        </div>
                        <!-- end row-->
                    </div>
                    <!-- end inbox-rightbar-->
                </div>
                <!-- end card-body -->
                <div class="clearfix"></div>
            </div> <!-- end card-box -->

        </div> <!-- end Col -->
    </div>
@endsection
