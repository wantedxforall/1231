<div class="card-body pt-0">
    <!--begin::Table-->
    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_sales_table">
        <!--begin::Table head-->
        <thead>

            <tr class="fs-7 fw-bold text-gray-400 border-bottom-0">
                <th class="w-10px pe-2">
                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                        <input class="form-check-input" type="checkbox" data-kt-check="true"
                            data-kt-check-target="#kt_ecommerce_sales_table .form-check-input" value="1" />
                    </div>
                </th>
                <th class="p-0 pb-3 min-w-50px text-start">#</th>
                {{-- <th class="p-0 pb-3 min-w-100px text-start">Avatar</th> --}}
                <th class="p-0 pb-3 min-w-100px text-start">Name</th>
                <th class="p-0 pb-3 min-w-100px text-start">Email</th>
                <th class="p-0 pb-3 min-w-150px text-end pe-12">Created</th>
                <th class="p-0 pb-3 w-50px text-end">Actions</th>
            </tr>
        </thead>
        <!--end::Table head-->
        <!--begin::Table body-->
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <!--begin::Checkbox-->
                    <td>
                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" value="1" />
                        </div>
                    </td>
                    <!--end::Checkbox-->
                    <td>
                        <a href="{{ route('admin.users.edit', $user->id) }}"
                            class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">{{ $user->id }}</a>
                    </td>
                    {{-- <td>
                    <div class="symbol symbol-50px me-3">
                        <img src="{{ $user->avatar ? url('storage/' . $user->avatar) : '' }}" class="" alt="" />
</div>
</td> --}}
                    <td>
                        <a href="{{ route('admin.users.edit', $user->id) }}"
                            class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">{{ $user->name }}
                            {{ $user->last_name }}</a>
                    </td>
                    <td>
                        <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                        <span
                            class="badge p-1 {{ !is_null($user->email_verified_at) ? 'badge-success' : 'badge-danger' }}">{{ !is_null($user->email_verified_at) ? 'Verified' : 'UnVerified' }}</span>
                    </td>
                    <td class="text-center pe-0">
                        <span class="text-gray-600 fw-bold fs-6">{{ $user->created_at }}</span>
                    </td>
                    {{-- <td class="text-end pe-12">
                    <span class="badge py-3 px-4 fs-7 badge-light-{{ App\Models\Campaign::STATUSES_CLASSES[$campaign->status] }}">{{ App\Models\Campaign::STATUSES[$campaign->status] }}</span>
</td> --}}

                    <td class="text-center d-flex">
                        @include('admin.layouts.actions', [
                            'id' => $user->id,
                            'edit' => route('admin.users.edit', $user->id),
                            'show' => route('admin.users.show', $user->id),
                            'destroy' => route('admin.users.destroy', $user->id),
                            'login' => route('admin.users.login', $user->id),
                        ])
                        {{-- <a title="Publisher Status" onclick="document.getElementById('publisher-status-{{ $user->id }}').submit()" class="btn btn-{{ $user->is_active_publisher ? 'danger' : 'success' }} actions"><i class="bi bi-{{ $user->is_active_publisher ? 'person-x' : 'person-check' }}"></i></a>
    <form id="publisher-status-{{ $user->id }}" action="{{ route('admin.users.pstatus',$user) }}" method="POST">
        @csrf
    </form>
    <a title="Advertiser Status" onclick="document.getElementById('advertiser-status-{{ $user->id }}').submit()" class="btn btn-{{ $user->is_active_adv ? 'danger' : 'success' }} actions"><i class="bi bi-{{ $user->is_active_adv ? 'person-video3' : 'person-workspace' }}"></i></a>
    <form id="advertiser-status-{{ $user->id }}" action="{{ route('admin.users.astatus',$user) }}" method="POST">
        @csrf
    </form> --}}
                        {{-- <a class="btn btn-{{ $user->email_verified_at ? 'transparent disabled' : 'success' }} actions" title="Verfiy" href="#" @if (is_null($user->email_verified_at)) onclick="document.getElementById('verfiy-{{ $user->id }}').submit()" @endif>
    <i class="bi bi-envelope-check"></i>
    </a> --}}
                        <form id="verfiy-{{ $user->id }}" action="{{ route('admin.users.verfiy',$user) }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-{{ $user->email_verified_at ? 'transparent disabled' : 'success' }} actions" title="Verfiy"><i class="bi bi-envelope-check"></i></button>
    </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <!--end::Table body-->
    </table>
</div>
<!--end::Table-->
