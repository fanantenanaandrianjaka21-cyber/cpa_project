@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card p-4">

                <h4 class="mb-3">Compléter votre profil</h4>
                <p>Vous devez ajouter un email, un mot de passe et un code PIN à 6 chiffres pour continuer.</p>

                {{-- 🔥 Affichage global des erreurs --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('complete.profile') }}">
                    @csrf

                    {{-- EMAIL --}}
                    <div class="mb-3">
                        <label>Email :</label>
                        <input 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}"
                            class="form-control @error('email') is-invalid @enderror" 
                            required
                        >
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- PASSWORD --}}
                    <div class="mb-3">
                        <label>Nouveau mot de passe :</label>
                        <input 
                            type="password" 
                            name="password" 
                            class="form-control @error('password') is-invalid @enderror" 
                            required
                        >
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- CONFIRMATION --}}
                    <div class="mb-3">
                        <label>Confirmation :</label>
                        <input 
                            type="password" 
                            name="password_confirmation" 
                            class="form-control" 
                            required
                        >
                    </div>

                    {{-- ⭐ PIN à 6 chiffres --}}
                    <div class="mb-3">
                        <label>Code PIN (6 chiffres) :</label>

                        {{-- Champ caché pour Laravel --}}
                        <input type="hidden" name="pin" id="pin-hidden" value="{{ old('pin') }}" required>

                        <div class="d-flex gap-2 justify-content-between mt-2">

                            @for ($i = 0; $i < 6; $i++)
                                <input 
                                    type="text" 
                                    maxlength="1"
                                    class="form-control text-center pin-input @error('pin') is-invalid @enderror"
                                    style="width: 45px; font-size: 22px; padding: 8px;"
                                    data-index="{{ $i }}"
                                >
                            @endfor
                        </div>

                        @error('pin')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <button class="btn btn-primary w-100 mt-2">Valider</button>
                </form>

            </div>
        </div>
    </div>
</div>

{{-- ⭐ Script pour faire fonctionner les inputs PIN --}}
<script>
    const inputs = document.querySelectorAll('.pin-input');
    const hiddenPin = document.getElementById('pin-hidden');

    inputs.forEach((input, index) => {
        input.addEventListener('input', () => {
            // Autoriser seulement les chiffres
            input.value = input.value.replace(/[^0-9]/g, '');

            // Passer automatiquement au suivant
            if (input.value && index < 5) {
                inputs[index + 1].focus();
            }

            // Mettre à jour le champ caché
            let pin = '';
            inputs.forEach(i => pin += (i.value ?? ''));
            hiddenPin.value = pin;
        });

        // Retour arrière → ramener au précédent
        input.addEventListener('keydown', (e) => {
            if (e.key === "Backspace" && !input.value && index > 0) {
                inputs[index - 1].focus();
            }
        });
    });
</script>
@endsection
