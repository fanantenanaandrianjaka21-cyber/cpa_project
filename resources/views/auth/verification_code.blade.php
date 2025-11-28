@extends('layouts.informatique.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-4">
                <h3 class="mb-3 text-center">Vérification du code</h3>

                @if(session('erreur'))
                    <div class="alert alert-danger">{{ session('erreur') }}</div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('verifier.code.submit') }}" autocomplete="off">
                    @csrf

                    <div class="mb-3">
                        <label for="code" class="form-label">Code de vérification</label>
                        <input type="text" class="form-control" id="code" name="code" required autocomplete="off">
                        @error('code')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="pin" class="form-label">PIN à 6 chiffres</label>
                        <input type="password" class="form-control" id="pin" name="pin" required autocomplete="new-password">
                        @error('pin')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Valider</button>
                </form>

                <form method="POST" action="{{ route('renvoyer.code') }}" class="mt-3 text-center">
                    @csrf
                    <button type="submit" class="btn btn-link">Renvoyer le code</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
