@extends('admin.layouts.app',['title'=>__('Create Plan'),'current'=>'plans'])

@section('content')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Container-->
    <div class="container-xxl" id="kt_content_container">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            </div>
            <!--end::Toolbar container-->
        </div>
        <!--end::Toolbar-->
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-fluid">
                <!--begin::Row-->
                <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-xl-12">
                        <!--begin::Tables widget 14-->
                        <div class="card card-flush h-md-100">
                            <!--begin::Header-->
                            <div class="card-header pt-7">
                                <!--begin::Title-->
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold">Plans</span>

                                </h3>
                                <!--end::Title-->
                                <!--begin::Toolbar-->
                                <div class="card-toolbar">
                                </div>
                                <!--end::Toolbar-->
                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body pt-6">
                                <div class="card-body pt-6">
                                    <form action="{{ route('admin.plans.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @include('admin.plans.form')
                                    </form>
                                </div>

                            </div>
                            <!--end: Card Body-->
                        </div>
                        <!--end::Tables widget 14-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row-->
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Content wrapper-->
</div>@endsection
