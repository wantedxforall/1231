@extends('admin.layouts.app', ['title' => __('Plans'), 'current' => 'plans'])

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Container-->
        <div class="container-xxl" id="kt_content_container">
            <!--begin::Products-->
            <div class="card card-flush">
                <!--begin::Card header-->
                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                    <!--begin::Card title-->
                    <div class="card-title">
                    </div>
                    <!--end::Card title-->
                    <!--begin::Card toolbar-->

                    <div class="card-toolbar flex-row-fluid justify-content-end gap-5">

                    </div>
                    <!--end::Card toolbar-->
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-subscription-table-toolbar="base">
                        <!--begin::Add plan-->
                        {{-- <a type="button" class="btn btn-primary" href="{{ route('admin.plans.create') }}">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2"
                                        rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
                                    <rect x="4.36396" y="11.364" width="16" height="2" rx="1"
                                        fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->Add Plan
                        </a> --}}
                        <!--end::Add plan-->
                    </div>
                    <!--end::Toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                @include('admin.plans.table', [
                    'plans' => $plans,
                ])
                {{ $plans->links() }}

                <!--end::Card body-->
            </div>
            <!--end::Products-->

        </div>
        <!--end::Container-->
    </div>
@endsection

@push('js')
    <!--begin::Custom Javascript(used for this page only)-->
    <script src="{{ url('assets/js/custom/account/settings/signin-methods.js') }}"></script>
@endpush
