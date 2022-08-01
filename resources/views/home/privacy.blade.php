@extends('layouts.main')
@section('main')
<x-breadcrumb :title="$title" />
<div class="container-fluid">
    <div class="privacy">
        {!! $privacy !!}
    </div>
</div>
@endsection