@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')


@include('layouts.navbar')

<h4>Tambah Pengguna</h4>

<form action="{{ route('admin.users.store') }}" method="POST">
    @csrf
    @include('users._form')
</form>
@endsection