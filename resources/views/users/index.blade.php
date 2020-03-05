@extends('layouts.admin')
@section('title', 'User Management')
@section('content')
    <!-- Page Heading -->
    {{-- <div class="d-sm-flex align-items-center justify-content-between mb-4">
    	<h1 class="h3 mb-0 text-gray-800">Users</h1>
    </div> --}}
    <div id="app">
        <user-list></user-list>
    </div>
@endsection

@section('custom-js')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection