@extends('layouts.app')

@section('title', 'Edit Jenis')

@section('content')
<h4>Edit Jenis</h4>

<form action="{{ route('jenis.update', $jenis) }}" method="POST">
    @method('PUT')
    @include('jenis._form', ['jenis' => $jenis])
</form>
@endsection
