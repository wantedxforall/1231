<div class="card-body pt-0">
    <!--begin::Table-->
    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_sales_table">
        <!--begin::Table head-->
        <thead>

            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                <th class="text-center min-w-50px">ID</th>
                <th class="text-center min-w-100px">Name</th>
                <th class="text-center min-w-100px">Email</th>
                <th class="text-center min-w-100px">Invoice Date</th>
                <th class="text-center min-w-100px">Domain</th>
                <th class="text-center min-w-100px">Total</th>
                <th class="text-center min-w-100px">Status</th>
                <th class="text-center min-w-100px">Actions</th>
            </tr>
            </tr>
        </thead>
        <!--end::Table head-->
        <!--begin::Table body-->
        <tbody class="fw-semibold text-gray-600">
            @foreach ($invoices as $invoice)
                <!--begin::Table row-->
                <tr>
                    <!--begin::Order ID=-->
                    <td class="text-center pe-0">
                        <span class="fw-bold">{{ $invoice->id }}</span>
                    </td>
                    <!--end::Order ID=-->
                    <!--begin::Name-->
                    <td class="text-center pe-0">
                        <span class="fw-bold">
                            <a target="_blank"
                                href="{{ route('admin.users.show', $invoice->user->id) }}">{{ $invoice->user->name }}
                                {{ $invoice->user->last_name }}</a>
                        </span>
                    </td>
                    <!--end::Name-->
                    <!--begin::Email-->
                    <td class="text-center pe-0">
                        <span class="fw-bold">{{ $invoice->user->email }}</span>
                    </td>
                    <!--end::Email-->
                    <!--begin::Date Modified=-->
                    <td class="text-center">
                        <span class="fw-bold">{{ $invoice->created_at }}</span>
                    </td>
                    <!--end::Date Modified=-->
                    <!--begin::Phone=-->
                    <td class="text-center">
                        <a target='_blank'
                            href="https://{{ $invoice->store->domain }}">{{ $invoice->store->domain }}</a>
                    </td>
                    <!--end::Phone=-->
                    <!--begin::Amount=-->
                    <td class="text-center pe-0">
                        <span class="fw-bold">{{ $invoice->amount }}</span>
                    </td>
                    <!--end::Amount=-->
                    <!--begin::Status=-->
                    <td class="text-center pe-0">
                        <span
                            class="badge py-3 px-4 fs-7 badge-light-{{ App\Models\front\invoices::STATUSES_CLASSES[$invoice->status] }}">{{ App\Models\front\invoices::STATUSES[$invoice->status] }}</span>
                    </td>
                    <!--end::Status=-->
                    <!--begin::Action=-->
                    <td class="text-center">
                        <div class="d-flex justify-content-center">
                            @if ($invoice->status == 0)
                                @include('front.layouts.actions', [
                                    'id' => $invoice->hash,
                                    'show' => route('front.invoices.show', $invoice->hash),
                                    'approve' => route('front.invoices.approve', $invoice->id),
                                    'reject' => route('front.invoices.cancel', $invoice->id),
                                ])
                            @elseif($invoice->status == 1)
                                @include('front.layouts.actions', [
                                    'id' => $invoice->hash,
                                    'show' => route('front.invoices.show', $invoice->hash),
                                    'reject' => route('front.invoices.cancel', $invoice->id),
                                ])
                            @elseif($invoice->status == 2)
                                @include('front.layouts.actions', [
                                    'id' => $invoice->hash,
                                    'show' => route('front.invoices.show', $invoice->hash),
                                ])
                            @endif
                        </div>

                    </td>
                    <!--end::Action=-->
                </tr>
                <!--end::Table row-->
            @endforeach
        </tbody>
        <!--end::Table body-->
    </table>
</div>
<!--end::Table-->
