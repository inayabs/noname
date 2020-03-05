@extends('layouts.admin')

@section('content')
    <div id="app"><documents></documents></div>
@endsection

@section('custom-js')
<script src="{{ asset('js/app.js') }}"></script>
@endsection