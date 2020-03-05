@extends('layouts.admin')

@section('content')
    <div id="app"><timelog-summary></timelog-summary></div>
@endsection

@section('custom-js')
<script src="{{ asset('js/app.js') }}"></script>
@endsection