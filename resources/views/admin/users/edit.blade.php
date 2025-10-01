@extends('admin.layouts.app',['title'=>__('Edit : ') . 'Mohamed Eid','current'=>'users'])

@section('content')
@include('admin.users.form')
@endsection
