@if ($errors->any())
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger">{{ $error }}</div>
    @endforeach
@endif

@if (session()->has('fail'))
    <div class="alert alert-danger">
        {{ session()->get('fail') }}
    </div>
@endif

<br>
<!--begin::Input group-->
<div class="row mb-6">
    <!--begin::Label-->
    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Name</label>
    <!--end::Label-->
    <!--begin::Col-->
    <div class="col-lg-8">
        <!--begin::Row-->
        <div class="row">
            <!--begin::Col-->
            <div class="col-lg-8">
                <input type="text" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                    placeholder="Name" name="name" value="{{ optional($plan)->name }}" />
            </div>
            <!--end::Col-->
        </div>
        <!--end::Row-->
    </div>
    <!--end::Col-->
</div>
<!--end::Input group-->

<!--begin::Input group-->
<div class="row mb-6">
    <!--begin::Label-->
    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Quantity</label>
    <!--end::Label-->
    <!--begin::Col-->
    <div class="col-lg-8">
        <!--begin::Row-->
        <div class="row">
            <!--begin::Col-->
            <div class="col-lg-8">
                <!--begin::Input-->
                <div class="d-flex gap-3">
                    <input type="number" name="min" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="Min"
                        value="{{ optional($plan)->min }}" />
                    <input type="number" name="max" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="Max"  value="{{ optional($plan)->max }}"/>
                </div>
                <!--end::Input-->
            </div>
            <!--end::Col-->
        </div>
        <!--end::Row-->
    </div>
    <!--end::Col-->
</div>
<!--end::Input group-->

<!--begin::Input group-->
<div class="row mb-6">
    <!--begin::Label-->
    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Price</label>
    <!--end::Label-->
    <!--begin::Col-->
    <div class="col-lg-8">
        <!--begin::Row-->
        <div class="row">
            <!--begin::Col-->
            <div class="col-lg-8">
                <input type="text" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                    placeholder="Price" name="cost" value="{{ optional($plan)->cost }}" />
            </div>
            <!--end::Col-->
        </div>
        <!--end::Row-->
    </div>
    <!--end::Col-->
</div>
<!--end::Input group-->


<br>
<!--begin::Input group-->
<div class="row mb-6">
    <!--begin::Label-->
    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Status</label>
    <!--end::Label-->
    <!--begin::Col-->
    <div class="col-lg-8">
        <!--begin::Row-->
        <div class="row">
            <!--begin::Col-->
            <div class="col-lg-8">
                <div class="form-check form-check-solid form-switch fv-row">

                    <input type="hidden" name="status" value="0">
                    <input class="form-check-input" name="status" type="checkbox" value="1"
                        {{ optional($plan)->status ? 'checked="checked"' : '' }} />
                    <span class="form-check-label fw-bold text-gray-400">
                        {{ old('status', optional($plan)->status) ? 'ON' : 'OFF' }}
                    </span>
                </div>
            </div>
            <!--end::Col-->
        </div>
        <!--end::Row-->
    </div>
    <!--end::Col-->
</div>
<!--end::Input group-->

<div class="card-footer d-flex justify-content-end py-6 px-9">
    <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Save</button>
</div>
