@extends('front.layouts.app_blank', ['title' => 'Payment Link'])
@section('content')
    <style>
        body,
        html {
            height: 100%;
        }
    </style>
    <div class="d-flex flex-column flex-center p-3 d-mobile" id="kt_content"
        style="background-image: url({{ asset('assets/media/auth/bg4.jpg') }}) ; background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    height: 100%;">
        <div class="container-xxl">
            <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                <!--begin::Post-->
                <div class="post d-flex flex-column-fluid" id="kt_post">

                    <!--begin::Container-->
                    <div id="kt_content_container" class="container-xxl">
                        <!--begin::Form-->
                        <form class="form d-flex flex-column flex-lg-row" action="" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <!--begin::Main column-->

                            <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10 m-12 p-12">
                                <!--begin::General options-->
                                <div class="card card-flush py-4 ">
                                    <!--begin::Card header-->
                                    <div style="position: relative; top:10px;">
                                        <img style="width:100px; height: auto; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); border-radius: 15%; border: 2px solid #fff;"
                                            src="{{ $store->full_logo_url }}" alt="Avatar">
                                    </div>
                                    @php
                                        $mobileNumbers = explode(',', $store->mobile_wallet);
                                        $number = array_rand($mobileNumbers);
                                        $number = $mobileNumbers[$number];
                                    @endphp

                                    <h1 class="fw-bolder fs-2qx text-gray-900  pt-20 p-3  text-center">{{ $store->name }}
                                    </h1>
                                    <h1 class="fw-bolder fs-2qx text-gray-900  text-center">
                                        <div class="badge badge-white"
                                            style="font-size: 20px;font-weight: bold;color: #000;">
                                            @if ($number)
                                                {{ $number }}
                                            @else
                                                N/A
                                            @endif
                                        </div>
                                    </h1>

                                    <h1 class="fw-bolder fs-2qx text-gray-900  text-center">
                                        <div class="badge badge-white"
                                            style="font-size: 20px;font-weight: bold;color: #000;">
                                            @if ($store->whatsapp)
                                                {{ $store->whatsapp }}
                                            @else
                                                N/A
                                            @endif
                                        </div>
                                    </h1>




                                    <div class="card-title p-5">
                                        <div class="message-link"></div>
                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                    <!--end::Card header-->
                                    <!--begin::Card body-->
                                    <div class="card-body pt-0">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Phone Number</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" name="phone" class="form-control mb-2 phone"
                                                placeholder="Phone Number" required="" />
                                            <!--end::Input-->
                                            <!--begin::Description-->
                                            <div class="text-muted fs-7">Enter Mobile Number you sent from</div>
                                            <!--end::Description-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Amount</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="number" name="amount" class="form-control mb-2 amount"
                                                placeholder="Amount" required=""/>
                                            <!--end::Input-->
                                            <!--begin::Description-->
                                            <div class="text-muted fs-7">Enter the amount you sent</div>
                                            <!--end::Description-->
                                        </div>
                                        <!--end::Input group-->

                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">User Name </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" name="user_name" class="form-control mb- user_name"
                                                placeholder="User Name in {{ $store->name }} " required=""/>
                                            <!--end::Input-->
                                            <!--begin::Description-->
                                            <div class="text-muted fs-7">Enter your username</div>
                                            <!--end::Description-->
                                        </div>
                                        <!--end::Input group-->


                                    </div>
                                    <!--end::Card header-->
                                </div>
                                <!--end::General options-->

                                <div class="d-flex justify-content-end">
                                    <!--begin::Button-->
                                    <a href="https://{{ $store->domain }}" class="btn btn-light me-5">Back</a>
                                    <!--end::Button-->
                                    <!--begin::Button-->
                                    <button type="button" class="btn btn-primary payment_link_check_btn">
                                        <span class="indicator-label">Confirm</span>
                                        <span class="indicator-progress">Please wait...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                    <!--end::Button-->
                                </div>
                            </div>
                            <!--end::Main column-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Post-->
            </div>
        </div>
    </div>

@endsection



@push('js')
    <!--begin::Javascript-->
    <script>
        var hostUrl = "assets/";
    </script>

    {{-- <script src="{{ asset('assets/js/jquery.slim.min.js') }}"></script> --}}
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.payment_link_check_btn').on('click', function(e) {
                e.preventDefault();
                $data = {
                    phone: $('.phone').val(),
                    amount: $('.amount').val(),
                    user_name: $('.user_name').val(),
                    store_id: {{ $store->id }}
                };
                $.ajax({
                    type: 'get',
                    url: '/api/stores/payment_link_check',
                    data: $data,
                    // dataType:'json',
                    beforeSend: function() {
                        $('.message-link').html('');
                        $('.message-link').html(
                            '<div class="spinner-border" role="status"></div>');
                    },
                    success: function(response) {
                        $('.message-link').html('');
                        $('.message-link').html(response['message']);
                    }
                });
            })

        })
    </script>
    <!--begin::Global Javascript Bundle(used by all pages)-->
    {{-- <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script> --}}
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Vendors Javascript(used by this page)-->
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
    <!--end::Vendors Javascript-->
    <!--begin::Custom Javascript(used by this page)-->
    <script src="{{ asset('assets/js/custom/apps/ecommerce/catalog/save-product.js') }}"></script>
    <script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/users-search.js') }}"></script>
    <!--end::Custom Javascript-->

    <!--end::Javascript-->
@endpush
