@extends('admin.layouts.app',['title'=>__('Create User'),'current'=>'users'])

@section('content')
@include('admin.users.form')
@endsection
