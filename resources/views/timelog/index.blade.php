@extends('layouts.admin')

@section('content')
    <div id="app"><timelog></timelog></div>
@endsection

@section('custom-js')
<script src="{{ asset('js/app.js') }}"></script>
@endsection