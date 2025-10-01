@extends('front.layouts.app', ['title' => __('QR Code'), 'current' => 'qrcode'])
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Container-->
        <div class="container-xxl" id="kt_content_container">
            <form method="post" action="" id="change_api"
                class="form d-flex flex-column flex-lg-row" data-kt-redirect="#" enctype="multipart/form-data">
                @csrf
                <!--begin::Main column-->
                <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                    <!--begin::General options-->
                    <div class="card card-flush py-4">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <div class="card-title">
                                <h2>QR Code</h2>
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <!--begin::Input group-->
                            <div class="mb-0 fv-row">
                                <!--begin::Input-->
                                <div style="display:flex;">
                                    <img src="{{ $qrcode }}" class="b--2 border--primary" alt="">
                                </div>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <!--end::Input group-->
                        </div>
                        <!--end::Card header-->




                    </div>
                </div>
                <!--end::Main column-->
            </form>
        </div>
        <!--end::Container-->
    </div>
@endsection

@push('js')
    <script src="{{ url('assets/js/custom/apps/customers/list/export.js') }}"></script>
    <script src="{{ url('assets/js/custom/apps/customers/list/list.js') }}"></script>
    <script src="{{ url('assets/js/custom/apps/customers/add.js') }}"></script>
@endpush
