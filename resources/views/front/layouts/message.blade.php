@if (session()->has('success'))
<!--begin::Alert-->
<div class="alert alert-primary d-flex align-items-center p-5">
    <!--begin::Icon-->
    <span class="svg-icon svg-icon-2hx svg-icon-primary me-3">

    </span>
    <!--end::Icon-->

    <!--begin::Wrapper-->
    <div class="d-flex flex-column">
        <!--begin::Title-->
        <h4 class="mb-1 text-dark">SMS</h4>
        <!--end::Title-->
        <!--begin::Content-->
        <span>{{ session()->get('success')}}</span>
        <!--end::Content-->
    </div>
    <!--end::Wrapper-->
</div>
<!--end::Alert-->
@endif



