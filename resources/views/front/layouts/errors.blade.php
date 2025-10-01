@if ($errors->any())

    <!--begin::Notice-->
    <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-6" style="margin: 30px;">
        <!--begin::Icon-->
        <!--begin::Svg Icon | path: icons/duotune/general/gen044.svg-->
        <span class="svg-icon svg-icon-2tx svg-icon-warning me-4">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10"
                    fill="currentColor" />
                <rect x="11" y="14" width="7" height="2" rx="1"
                    transform="rotate(-90 11 14)" fill="currentColor" />
                <rect x="11" y="17" width="2" height="2" rx="1"
                    transform="rotate(-90 11 17)" fill="currentColor" />
            </svg>
        </span>
        <!--end::Svg Icon-->
        <!--end::Icon-->
        <!--begin::Wrapper-->
        <div class="d-flex flex-stack flex-grow-1">
            <!--begin::Content-->
            <div class="fw-semibold">
                <h4 class="text-gray-900 fw-bold">خطأ في المدخلات</h4>
                @foreach ($errors->all() as $error)
                    <div class="fs-6 text-gray-700">{{ $error }}</div>
                @endforeach

            </div>
            <!--end::Content-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Notice-->
@endif

@if (session()->has('error'))
    <!--begin::Notice-->
    <div class="notice d-flex bg-light-danger rounded border-danger border border-dashed p-6" style="margin: 30px;">
        <!--begin::Icon-->
        <!--begin::Svg Icon | path: icons/duotune/general/gen044.svg-->
        <span class="svg-icon svg-icon-2tx svg-icon-danger me-4">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10"
                    fill="currentColor" />
                <rect x="11" y="14" width="7" height="2" rx="1"
                    transform="rotate(-90 11 14)" fill="currentColor" />
                <rect x="11" y="17" width="2" height="2" rx="1"
                    transform="rotate(-90 11 17)" fill="currentColor" />
            </svg>
        </span>
        <!--end::Svg Icon-->
        <!--end::Icon-->
        <!--begin::Wrapper-->
        <div class="d-flex flex-stack flex-grow-1">
            <!--begin::Content-->
            <div class="fw-semibold">
                <h4 class="text-gray-900 fw-bold">خطأ في المدخلات</h4>
                <div class="fs-6 text-gray-700"> {{ session()->get('error') }}
                </div>

            </div>
            <!--end::Content-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Notice-->
@endif
