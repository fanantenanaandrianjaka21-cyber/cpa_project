@php
    $role = Auth::user()->role;

    switch ($role) {
        case 'Super Admin':
        case 'Admin IT':
        case 'Responsable Site':
            $layout = 'layouts.admin.app';
            break;
        case 'Informatique':
            $layout = 'layouts.admin.app';
            break;
        default:
            $layout = 'layouts.utilisateur';
            break;
    }
@endphp

@extends($layout)

@section('content')
    @yield('page-content')
@endsection
