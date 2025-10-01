@extends('front.layouts.app', ['title' => __('Dashboard'), 'current' => 'home'])
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Container-->
        <div class="container-xxl" id="kt_content_container">

            <h1>{{$result}}</h1>

            <br>

            <h3>@dump($end_request)</h3>
            <select class="form-select form-control " name="actions" data-control="select2" data-placeholder="select onption">
                <option></option>
                @foreach($extracted_data as $key=>$val)
                    <option value="{{$val}}"> {{$key}} => {{$val}}</option>
                @endforeach
            </select>
        </div>
        <!--end::Container-->
    </div>
@endsection
