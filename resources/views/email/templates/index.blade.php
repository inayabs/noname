@extends('layouts.admin')

@section('content')
    <div id="app">
        <email-templates></email-templates>
    </div>
@endsection

@section('custom-js')
<script src="{{ asset('js/app.js') }}"></script>
@endsection