@extends('layouts.admin')
@section('title', 'User Management')
@section('custom-css')
<style>
    .horizontal-line-wrapper{
        background-color: #355dce;
        padding: .5rem;
        color: #fff;
    }
    .horizontal-line-wrapper h6{
        margin-bottom: 0;
    }
    .row {
        padding: 1px;
    }
</style>
@endsection

@section('content')
    <div id="app">
        <user-detail></user-detail>
    </div>
          

@endsection

@section('custom-js')
    <script>
        
    </script>

    <script src="{{ asset('js/app.js') }}"></script>
    {{-- <script src="{{ asset('/sb-admin/js/demo/chart-area-demo.js') }}"></script> --}}
    {{-- <script src="{{ asset('/sb-admin/js/demo/chart-pie-demo.js') }}"></script> --}}
@endsection