@extends('front.layouts.app_blank', ['title' => __('Invoices'), 'current' => 'invoices'])


@section('content')
    <style>
        body,
        html {
            height: 100%;
        }
    </style>
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content"
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

                        <!--begin::Main column-->
                        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10 m-12 p-12">
                            <!-- begin::Invoice 3-->
                            <div class="card">
                                <!-- begin::Body-->
                                <div class="card-body py-20">
                                    <!-- begin::Wrapper-->
                                    <div class="mw-lg-950px mx-auto w-100">
                                        <!-- begin::Header-->
                                        <div class="d-flex justify-content-between flex-column flex-sm-row mb-19">
                                            <h4 class="fw-bolder text-gray-800 fs-2qx pe-5 pb-7">Invoice
                                                #{{ $invoice->id }}
                                            </h4>

                                            <!--end::Logo-->
                                            <div class="text-sm-end">
                                                <!--begin::Logo-->
                                                <a href="#" class="d-block mw-150px ms-sm-auto">
                                                    <img alt="Logo" src="{{ $options['site_logo'] }}"
                                                        class="w-100" />
                                                </a>
                                                <!--end::Logo-->
                                            </div>
                                        </div>
                                        <!--end::Header-->
                                        <!--begin::Alert-->
                                        <div
                                            class="alert alert-dismissible bg-light-{{ App\Models\front\invoices::STATUSES_CLASSES[$invoice->status] }} d-flex flex-center flex-column py-5 px-10 px-lg-20 mb-10">

                                            <!--begin::Title-->
                                            <h1
                                                class="fw-bold badge-light-{{ App\Models\front\invoices::STATUSES_CLASSES[$invoice->status] }}">
                                                {{ App\Models\front\invoices::STATUSES[$invoice->status] }}</h1>
                                            <!--end::Title-->

                                        </div>

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

                                        <!--end::Alert-->



                                        <!--begin::Body-->
                                        <div class="pb-12">
                                            <!--begin::Wrapper-->
                                            <div class="d-flex flex-column gap-7 gap-md-10">
                                                <!--begin:Order summary-->
                                                @if ($invoice->status == 0)
                                                    {{-- <!--begin::Input group-->
                                                    <div class="row mb-6">
                                                        <!--begin::Col-->
                                                        <div class="col-lg-12 fv-row">
                                                            <select name="method" id="method" data-control="select2"
                                                                data-hide-search="true"
                                                                class="form-select form-select-solid">
                                                                <option value="stripe_checkout" checked="">Credit and
                                                                    debit cards
                                                                    (Stripe)
                                                                </option>
                                                                <option value="stripe_checkout" checked="">Credit and
                                                                    debit cards
                                                                    (Stripe)
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <!--end::Col-->
                                                    </div>
                                                    <!--end::Input group--> --}}

                                                    <div class="mb-5 fv-row">
                                                        <h2>Send Amount: <div class="badge badge-white"
                                                                style="font-size: 20px;font-weight: bold;color: #000;">
                                                                {{ $invoice->amount }}</div>
                                                        </h2>
                                                        @php
                                                            $store = \App\Models\front\stores::where(
                                                                'id',
                                                                $options['default_store'],
                                                            )->first();
                                                        @endphp
                                                        <h2>To Our Wallet Number
                                                            @php
                                                                $mobileNumbers = explode(',', $store->mobile_wallet ?? null);
                                                                $number = array_rand($mobileNumbers);
                                                                $number = $mobileNumbers[$number];
                                                            @endphp
                                                            <div class="badge badge-white"
                                                                style="font-size: 20px;font-weight: bold;color: #000;">
                                                                @if ($number)
                                                                    {{ $number }}
                                                                @else
                                                                    N/A
                                                                @endif
                                                            </div>
                                                        </h2>
                                                        <strong> Then confirm transction by input number which use for
                                                            transfer money then click confirm</strong>
                                                        <!--end::Label-->
                                                        <!--begin::Input-->
                                                    </div>
                                                    <!--begin::Input group-->
                                                    <div class="mb-5 fv-row">
                                                        <!--begin::Label-->
                                                        <label class="required form-label">Phone Number</label>
                                                        <!--end::Label-->
                                                        <!--begin::Input-->
                                                        <input type="text" name="phone" class="form-control mb-2 phone"
                                                            placeholder="Phone Number" />
                                                        <!--end::Input-->
                                                        <!--begin::Description-->
                                                        <!-- <div class="text-muted fs-7">A store name is required and recommended to be unique.</div> -->
                                                        <!--end::Description-->
                                                    </div>
                                                    <!--end::Input group-->
                                                @endif

                                                <div class="d-flex justify-content-between flex-column">
                                                    <!--begin::Table-->
                                                    <div class="table-responsive border-bottom mb-9">
                                                        <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                                                            <thead>
                                                                <tr class="border-bottom fs-6 fw-bold text-muted">
                                                                    <th class="min-w-175px pb-2">DESCRIPTION</th>
                                                                    <th class="min-w-175px pb-2"></th>
                                                                    <th class="min-w-175px pb-2"></th>
                                                                    <th class="min-w-100px text-end pb-2">AMOUNT</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="fw-semibold text-gray-600">

                                                                <!--begin::Products-->
                                                                <tr>
                                                                    <!--begin::Product-->
                                                                    <td>
                                                                        <div class="fw-bold">One month maintenance for
                                                                            {{ $invoice->store->domain }}</div>
                                                                    </td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <!--end::Product-->
                                                                    <!--begin::Total-->
                                                                    <td class="text-end">{{ $invoice->amount }}</td>
                                                                    <!--end::Total-->
                                                                </tr>
                                                                <!--end::Products-->
                                                                <!--begin::Grand total-->
                                                                <tr>
                                                                    <td colspan="3"
                                                                        class="fs-3 text-dark fw-bold text-end">Total
                                                                    </td>
                                                                    <td class="text-dark fs-3 fw-bolder text-end">
                                                                        {{ $invoice->amount }}
                                                                    </td>
                                                                </tr>
                                                                <!--end::Grand total-->
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <!--end::Table-->
                                                </div>
                                                <!--end:Order summary-->
                                            </div>
                                            <!--end::Wrapper-->
                                        </div>
                                        <!--end::Body-->
                                        <!-- begin::Footer-->
                                        <div class="d-flex flex-stack flex-wrap mt-lg-20 pt-13">
                                            <!-- begin::Action-->
                                            <a href="{{ route('front.invoices.index') }}"
                                                class="btn btn-light me-5">Back</a>
                                            @if ($invoice->is_cancel == 1 && $invoice->status == 0)
                                                <form id="cancel-{{ $invoice->id }}"
                                                    action="{{ route('front.invoices.cancel', $invoice) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger" title="Cancel">Cancel
                                                        invoice</button>
                                                </form>
                                                <!-- end::Action-->
                                            @endif
                                            @if ($invoice->status == 0)
                                                {{-- <form id="payment-{{ $invoice->id }}"
                                                    action="{{ route('front.invoices.payment', $invoice) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary"
                                                        title="Payment">Pay</button>
                                                </form> --}}

                                                <!--begin::Button-->
                                                <button type="button" class="btn btn-primary invoices_check_btn">
                                                    <span class="indicator-label">Pay</span>
                                                    <span class="indicator-progress">Please wait...
                                                        <span
                                                            class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                </button>
                                                <!--end::Button-->
                                            @endif
                                            <!-- end::Action-->
                                        </div>
                                        <!-- end::Footer-->

                                    </div>
                                    <!-- end::Wrapper-->
                                </div>
                                <!-- end::Body-->
                            </div>
                            <!-- end::Invoice 1-->

                        </div>
                        <!--end::Main column-->
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Post-->
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            $('.invoices_check_btn').on('click', function(e) {
                e.preventDefault();
                $data = {
                    phone: $('.phone').val(),
                    hash: '{{ $invoice->hash }}',
                };
                $.ajax({
                    type: 'get',
                    url: '/api/invoices/invoices_check',
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

    <!--begin::Javascript-->
    <script>
        var hostUrl = "assets/";
    </script>

    {{-- <script src="{{ asset('assets/js/jquery.slim.min.js') }}"></script> --}}
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

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
