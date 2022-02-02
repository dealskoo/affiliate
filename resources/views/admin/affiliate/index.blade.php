@extends('admin::layouts.panel')

@section('title',__('affiliate::affiliate.affiliates_list'))
@section('body')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{ route('admin.dashboard') }}">{{ __('admin::admin.dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('affiliate::affiliate.affiliates_list') }}</li>
                    </ol>
                </div>
                <h4 class="page-title">{{ __('affiliate::affiliate.affiliates_list') }}</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="affiliates_table" class="table table-centered w-100 dt-responsive nowrap">
                            <thead class="table-light">
                            <tr>
                                <th>{{ __('affiliate::affiliate.id') }}</th>
                                <th>{{ __('affiliate::affiliate.name') }}</th>
                                <th>{{ __('affiliate::affiliate.email') }}</th>
                                <th>{{ __('affiliate::affiliate.status') }}</th>
                                <th>{{ __('affiliate::affiliate.created_at') }}</th>
                                <th>{{ __('affiliate::affiliate.updated_at') }}</th>
                                <th>{{ __('affiliate::affiliate.action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $(function () {
            $('#affiliates_table').dataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('admin.affiliates.index') }}",
                "language": language,
                "pageLength": pageLength,
                "columns": [
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': false},
                ],
                "order": [[0, "desc"]],
                "drawCallback": function () {
                    $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
                    $('#affiliates_table tr td:nth-child(2)').addClass('table-user');
                    $('#affiliates_table tr td:nth-child(7)').addClass('table-action');
                }
            })
        });
    </script>
@endsection
