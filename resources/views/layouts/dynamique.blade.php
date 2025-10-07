@php
    $role = Auth::user()->role;

    switch ($role) {
        case 'Super Admin':
            $layout = 'layouts.admin.app';
            break;
        case 'Utilisateur':
            $layout = 'layouts.informatique.app';
            break;
        case 'Informatique':
            $layout = 'layouts.informatique.app';
            break;
        default:
            $layout = 'layouts.app';
            break;
    }
@endphp

@extends($layout)

@section('content')
    @yield('page-content')
@endsection
