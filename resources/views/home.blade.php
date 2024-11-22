@extends('layout.template')


@section('content')
<h1>Welcome</h1>
<p>Welcome, User ID: {{ session('user_id') }}
@endsection
