@extends('layouts.base')

@section('title', 'Doctor Dashboard')

@section('header')
    <div class="d-flex justify-content-between align-items-center mb-4 ">

        <div class="d-flex">
            <div class="me-3">
                <div class="text-end">
                    <small class="text-muted d-block">Last login</small>
                    <span class="fw-semibold">{{ now()->format('M j, Y h:i A') }}</span>
                </div>
            </div>
            <div class="avatar avatar-md">
                <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center"
                    style="width: 40px; height: 40px;">
                    <i class="bi bi-person-fill text-primary"></i>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container-fluid px-0">
        @yield('dashboard-content')
    </div>
@endsection
