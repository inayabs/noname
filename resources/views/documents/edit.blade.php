@extends('layouts.admin')

@section('content')
    <div id="app"><documents-update></documents-update></div>
@endsection

@section('custom-js')
<script src="{{ asset('js/app.js') }}"></script>
@endsection