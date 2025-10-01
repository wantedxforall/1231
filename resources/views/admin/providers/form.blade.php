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
<!--end::Input group-->

<!--begin::Input group-->
<div class="row mb-6">
    <!--begin::Label-->
    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Icon</label>
    <!--end::Label-->
    <!--begin::Col-->
    <div class="col-lg-8">
        <!--begin::Row-->
        <div class="row">
            <!--begin::Col-->
            <div class="col-lg-8">
                <style>
                    .image-input-placeholder {
                        background-image: url('{{ url('assets/media/svg/files/blank-image.svg') }}');
                    }

                    [data-theme="dark"] .image-input-placeholder {
                        background-image: url('{{ url('assets/media/svg/files/blank-image-dark.svg') }}');
                    }
                </style>
                <style>
                    .image-input-placeholder {
                        background-image: url('{{ optional($provider)->full_icon_url ? optional($provider)->full_icon_url : url('assets/media/svg/files/blank-image.svg') }}');
                    }

                    [data-theme="dark"] .image-input-placeholder {
                        background-image: url('{{ optional($provider)->full_icon_url ? optional($provider)->full_icon_url : url('assets/media/svg/files/blank-image-dark.svg') }}');
                    }
                </style>
                <div class="image-input image-input-empty image-input-outline image-input-placeholder"
                    data-kt-image-input="true">
                    <!--begin::Preview existing avatar-->
                    <div class="image-input-wrapper w-125px h-125px" style="background-image: url('')"></div>
                    <!--end::Preview existing avatar-->
                    <!--begin::Label-->
                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                        data-kt-image-input-action="change" data-bs-toggle="tooltip" data-kt-initialized="1">
                        <i class="bi bi-pencil-fill fs-7"></i>
                        <!--begin::Inputs-->
                        <input type="file" name="icon" accept=".png, .jpg, .jpeg">
                        <!--end::Inputs-->
                    </label>
                    <!--end::Label-->
                    <!--begin::Cancel-->
                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                        data-kt-image-input-action="cancel" data-bs-toggle="tooltip" data-kt-initialized="1">
                        <i class="bi bi-x fs-2"></i>
                    </span>
                    <!--end::Cancel-->
                    <!--begin::Remove-->
                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                        data-kt-image-input-action="remove" data-bs-toggle="tooltip" data-kt-initialized="1">
                        <i class="bi bi-x fs-2"></i>
                    </span>
                    <!--end::Remove-->

                </div>
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
    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Name</label>
    <!--end::Label-->
    <!--begin::Col-->
    <div class="col-lg-8">
        <!--begin::Row-->
        <div class="row">
            <!--begin::Col-->
            <div class="col-lg-8">
                <input type="text" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                    placeholder="Name" name="name" value="{{ optional($provider)->name }}" />
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
    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Message</label>
    <!--end::Label-->
    <!--begin::Col-->
    <div class="col-lg-8">
        <!--begin::Row-->
        <div class="row">
            <!--begin::Col-->
            <div class="col-lg-8">
                <textarea style="height: 117px;" type="text" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 msg_body"
                    placeholder="example message body" id="msg_body" name="msg_body">{{ optional($provider)->msg_body }}</textarea>
            </div>
            <!--end::Col-->
        </div>
        <!--end::Row-->
    </div>
    <!--end::Col-->
</div>
<!--end::Input group-->
{{-- <h3>@dump($result_1)</h3> --}}
<!--begin::Input group-->
<div class="row mb-6">
    <!--begin::Label-->
    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Start Message</label>
    <!--end::Label-->
    <!--begin::Col-->
    <div class="col-lg-8">
        <!--begin::Row-->
        <div class="row">
            <!--begin::Col-->
            <div class="col-lg-8">
                <input type="text" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                    placeholder="start message" id="start_body" name="start_body" value="{{ optional($provider)->start_body }}"/>
            </div>
            <!--end::Col-->
        </div>
        <!--end::Row-->
    </div>
    <!--end::Col-->
</div>
<!--end::Input group-->

<!--begin::Input group-->
<div class="row mb-6 amount_div" >
    <!--begin::Label-->
    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Amount</label>
    <!--end::Label-->
    <!--begin::Col-->
    <div class="col-lg-8">
        <!--begin::Row-->
        <div class="row">
            <!--begin::Col-->
            <div class="col-lg-8">
                <input type="text" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                    placeholder="" id="amount" name="amount" value="{{ optional($provider)->amount }}"/>

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
    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Phone</label>
    <!--end::Label-->
    <!--begin::Col-->
    <div class="col-lg-8">
        <!--begin::Row-->
        <div class="row">
            <!--begin::Col-->
            <div class="col-lg-8">
                <input type="text" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                    placeholder="" id="phone" name="phone" value="{{ optional($provider)->phone }}"/>

            </div>
            <!--end::Col-->
            <div class="col-lg-2" style="padding: 9px;">
                <div class="form-check form-check-custom form-check-solid">
                    <input class="form-check-input" type="checkbox" value="1" id="flexCheckDefault" name="nophone" {{ $provider ? (is_null($provider->phone) ? 'checked' : '') : '' }}>
                    <label class="form-check-label" for="flexCheckDefault">
                        Null
                    </label>
                </div>
            </div>
        </div>
        <!--end::Row-->
    </div>
    <!--end::Col-->
</div>
<!--end::Input group-->

<!--begin::Input group-->
<div class="row mb-6">
    <!--begin::Label-->
    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Transaction No.</label>
    <!--end::Label-->
    <!--begin::Col-->
    <div class="col-lg-8">
        <!--begin::Row-->
        <div class="row">
            <!--begin::Col-->
            <div class="col-lg-8">
                <input type="text" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                    placeholder="" id="transaction_no" name="transaction_no" value="{{ optional($provider)->transaction_no }}"/>

            </div>
            <!--end::Col-->
            <div class="col-lg-2" style="padding: 9px;">
                <div class="form-check form-check-custom form-check-solid">
                    <input class="form-check-input" type="checkbox" value="1" id="flexCheckDefault" name="notransaction" {{ $provider ? (is_null($provider->transaction_no) ? 'checked' : '') : '' }}>
                    <label class="form-check-label" for="flexCheckDefault">
                        Null
                    </label>
                </div>
            </div>
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
                        {{ optional($provider)->status ? 'checked="checked"' : '' }} />
                    <span class="form-check-label fw-bold text-gray-400">
                        {{ old('status', optional($provider)->status) ? 'ON' : 'OFF' }}
                    </span>
                </div>
            </div>
            <!--end::Col-->
        </div>
        <!--end::Row-->
    </div>
    <!--end::Col-->
</div>
<div class="card-footer d-flex justify-content-end py-6 px-9">
    <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Save</button>
</div>


@push('js')

{{-- <script src="{{ asset('assets/js/jquery.slim.min.js') }}"></script> --}}

        {{-- <script type="text/javascript">
        $(document).ready(function(){

            $('#msg_body').on('change',function(e){
               let message = $(this).val();
               let amount = $('#amount');
               let phone = $('#phone');
               let transaction_no = $('#transaction_no');
                $.ajax({
                type:'get',
                url:'{{ route('front.store.message') }}',
                data:{
                    message:message
                },
                // dataType:'json',
                success: function (response) {
                         amount.html('');
                         phone.html('');
                         transaction_no.html('');
                        // $('.amount_div').removeAttr('hidden');
                        amount.append('<option></option>');
                        phone.append('<option></option>');
                        transaction_no.append('<option></option>');

                        $.each(response , function (key ,value){
                            amount.append('<option value="'+key+'">'+value +'</option>');
                            phone.append('<option value="'+key+'">'+value +'</option>');
                            transaction_no.append('<option value="'+key+'">'+value +'</option>');
                        })
                }
                });//ajax



             });//msg_body

        });//end function

         </script> --}}
@endpush
