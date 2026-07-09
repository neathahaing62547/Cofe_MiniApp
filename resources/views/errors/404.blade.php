@extends('layout.app')

@section('title', 'Page Not Found')

@section('page-header', 'true')
@section('page-title', '404 - Page Not Found')
@section('page-subtitle', 'The page you are looking for does not exist.')

@section('content')
    <div class="card notfound-card">
        <div class="notfound-content">
            <h2>Oops! Nothing to see here.</h2>
            <p>The requested page could not be found. Please check the URL or return to the dashboard.</p>
            <a href="{{ route('dashboard') }}" class="btn btn-primary">Go to Dashboard</a>
            <a href="{{ route('login') }}" class="btn btn-outline">Go to Login</a>
        </div>
    </div>
@endsection
