@extends('layouts.dynamique')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="header">
                    <i class="fa fa-home"></i>/ Modification Materiel

                </div>
                <div class="w3-panel w3-pale-blue w3-bottombar w3-border-blue w3-border">
                    <h4 class="w3-start w3-animate-right">
                        Modification d'un Materiel
                    </h4>
                </div>
                <div class="card">
                    <div class="card-body bg-primary text-white">
                        <form method="POST" action="{{ route('materiel.modifier') }}" id="register-form"
                            enctype="multipart/form-data" onsubmit="return validateForm()" class="needs-validation"
                            novalidate>
                            @csrf
                            <input type="hidden" name='idmateriel' value="{{ $materiel['id'] }}">
                            <div class="form-group row">
                                <label for="id_emplacement" id="id_emplacement"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Emplacement :') }}<strong
                                        class="text-danger m-2 mt-2">*</strong></label>
                                <div class="col-md-6">
                                    <select class="form-select" aria-label="Default select example" name="id_emplacement"
                                        required>

                                        <option value="{{ $materiel['id_emplacement'] }}">
                                            {{ $materiel['emplacement'] }}</option>
                                        @if (!empty($emplacement))
                                            @if (Auth::User()->role == 'Super Admin' or Auth::User()->role == 'Admin IT')
                                                @foreach ($emplacement as $emplacement)
                                                    <option value="{{ $emplacement->id }}">
                                                        {{ $emplacement->emplacement }}
                                                    </option>
                                                @endforeach
                                            @else
                                                @foreach ($emplacement as $emplacement)
                                                    @if (Auth::User()->id_emplacement == $emplacement->id)
                                                        <option value="{{ $emplacement->id }}">
                                                            {{ $emplacement->emplacement }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            @endif

                                        @endif
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="date_aquisition"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Date d\'aquisition :') }}<strong
                                        class="text-danger m-2 mt-2">*</strong></label>

                                <div class="col-md-6">
                                    <input id="date_aquisition" type="date"
                                        class="form-control @error('date_aquisition') is-invalid @enderror"
                                        name="date_aquisition" value="{{ $materiel['date_aquisition'] }}" required
                                        autocomplete="date_aquisition">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="type"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Type du Materiel :') }}<strong
                                        class="text-danger m-2 mt-2">*</strong></label>

                                <div class="col-md-6">
                                    <input id="type" type="text"
                                        class="form-control @error('type') is-invalid @enderror" name="type"
                                        value="{{ $materiel['type'] }}" required autocomplete="type">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            {{-- <div class="row mb-3">
                                <label for="quantite"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Quantite :') }}</label>
                                <div class="col-md-6">
                                    <input id="quantite" type="number"
                                        class="form-control @error('quantite') is-invalid @enderror" name="quantite"
                                        value="{{ $materiel['quantite'] }}" autocomplete="quantite">
                                    <div class="invalid-feedback">Caractere interdit.</div>
                                </div>
                            </div> --}}
                            <input type="hidden" name="quantite" value="1">
                            <div class="row mb-3">
                                <label for="marque"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Marque :') }}</label>

                                <div class="col-md-6">
                                    <input id="marque" type="text"
                                        class="form-control @error('marque') is-invalid @enderror" name="marque"
                                        value="{{ $materiel['marque'] }}" autocomplete="marque">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="model"
                                    class="col-md-4 col-form-label text-md-end">{{ __('model :') }}</label>

                                <div class="col-md-6">
                                    <input id="model" type="text"
                                        class="form-control @error('model') is-invalid @enderror" name="model"
                                        value="{{ $materiel['model'] }}" autocomplete="model">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>



                            <div class="row mb-3">
                                <label for="serie"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Numero de Serie :') }}</label>

                                <div class="col-md-6">
                                    <input id="num_serie" type="text"
                                        class="form-control @error('num_serie') is-invalid @enderror" name="num_serie"
                                        value="{{ $materiel['num_serie'] }}">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="status"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Status :') }}</label>

                                <div class="col-md-6">
                                    <input id="status" type="text"
                                        class="form-control @error('status') is-invalid @enderror" name="status"
                                        value="{{ $materiel['status'] }}"required>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="image" class="col-md-4 col-form-label text-md-end">Image :</label>
                                <div class="col-md-6">
                                    <input class="form-control-file border" type="file" name="image" />
                                    <div class="invalid-feedback">Veuillez choisir un image.</div>
                                </div>
                            </div>

                            {{-- @foreach ($colonnes as $colonnes)
                                @if ($materiel[$colonnes] != '-')
                                    <div class="row mb-3">
                                        <label class="col-md-4 col-form-label text-md-end">{{ $colonnes }}</label>

                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="{{ $colonnes }}"
                                                value="{{ $materiel[$colonnes] ?? '-' }}"required>
                                        </div>
                                    </div>
                                @endif
                            @endforeach --}}

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-success">
                                        {{ __('Modifier') }}
                                    </button>
                                                                        <button type="reset" class="btn btn-danger">
                                        {{ __('Annulerr') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('register-form');
            const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
            const fileInput = form.querySelector('input[type="file"][name="image"]');

            // Convertir NodeList en tableau pour ajout du champ image
            let formInputs = [...inputs];
            if (fileInput && !formInputs.includes(fileInput)) {
                formInputs.push(fileInput);
            }

            // Fonction helpers pour validation
            function valide(input, feedback) {
                input.classList.remove('is-invalid');
                input.classList.add('is-valid');
                feedback.style.display = 'none';
            }

            function invalide(input, feedback, message) {
                input.classList.remove('is-valid');
                input.classList.add('is-invalid');
                feedback.textContent = message;
                feedback.style.display = 'block';
            }

            // Regex pour éviter les caractères spéciaux (lettres, chiffres, espaces et tirets seulement)
            const noSpecialChars = /^[A-Za-z0-9\s\-]+$/;

            formInputs.forEach(input => {
                const feedback = input.parentElement.querySelector('.invalid-feedback');

                // --- Validation texte (ex: type, code interne, etc.)
                if (input.type === 'text') {
                    input.addEventListener('input', () => {
                        if (input.value.trim() === '') {
                            invalide(input, feedback, "Ce champ est obligatoire.");
                        } else if (!noSpecialChars.test(input.value)) {
                            invalide(input, feedback, "Caractères spéciaux non autorisés.");
                        } else {
                            valide(input, feedback);
                        }
                    });
                }

                // --- Validation select
                if (input.tagName.toLowerCase() === 'select') {
                    input.addEventListener('change', () => {
                        if (input.value === '') {
                            invalide(input, feedback, "Veuillez faire un choix.");
                        } else {
                            valide(input, feedback);
                        }
                    });
                }

                // --- Validation date
                if (input.type === 'date') {
                    input.addEventListener('change', () => {
                        if (input.value === '') {
                            invalide(input, feedback, "Date requise.");
                        } else {
                            valide(input, feedback);
                        }
                    });
                }

                // --- Validation fichier image (.jpg uniquement, max 2 Mo)
                if (input.type === 'file') {
                    input.addEventListener('change', () => {
                        const file = input.files[0];
                        if (!file) {
                            invalide(input, feedback, "Veuillez choisir une image.");
                        } else if (!/\.(jpg|jpeg|png)$/i.test(file.name)) {
                            invalide(input, feedback,
                                "Le fichier doit être au format jpg,jpeg ou png.");
                            input.value = ''; // réinitialise
                        } else if (file.size > 2 * 1024 * 1024) {
                            invalide(input, feedback, "L'image ne doit pas dépasser 2 Mo.");
                            input.value = ''; // réinitialise
                        } else {
                            valide(input, feedback);
                        }
                    });
                }
            });

            // Validation finale avant envoi
            form.addEventListener('submit', function(e) {
                let isValid = true;
                formInputs.forEach(input => {
                    const feedback = input.parentElement.querySelector('.invalid-feedback');
                    if (input.required && input.value.trim() === '') {
                        invalide(input, feedback, "Champ obligatoire.");
                        isValid = false;
                    }
                });
                if (!isValid) {
                    e.preventDefault();
                }
            });
        });
    </script> --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('register-form');
            const inputs = form.querySelectorAll('input, select, textarea'); // tous les champs

            const regexNoSpecial = /^[A-Za-z0-9\s\-]+$/; // lettres, chiffres, espaces et tirets

            // Helpers pour Bootstrap
            function valide(input, feedback) {
                input.classList.remove('is-invalid');
                input.classList.add('is-valid');
                if (feedback) feedback.style.display = 'none';
            }

            function invalide(input, feedback, message) {
                input.classList.remove('is-valid');
                input.classList.add('is-invalid');
                if (feedback) {
                    feedback.textContent = message;
                    feedback.style.display = 'block';
                }
            }

            function neutral(input, feedback) {
                input.classList.remove('is-valid', 'is-invalid');
                if (feedback) feedback.style.display = 'none';
            }

            // Validation en direct pour tous les champs
            inputs.forEach(input => {
                const feedback = input.parentElement.querySelector('.invalid-feedback');

                // --- Champs texte / textarea ---
                if (input.type === 'text' || input.tagName === 'TEXTAREA') {
                    input.addEventListener('input', () => {
                        if (input.value.trim() === '') {
                            neutral(input, feedback); // vide = neutre
                        } else if (!regexNoSpecial.test(input.value)) {
                            invalide(input, feedback, "Caractères spéciaux non autorisés.");
                        } else {
                            valide(input, feedback);
                        }
                    });
                }

                // --- Champs select ---
                if (input.tagName.toLowerCase() === 'select') {
                    input.addEventListener('change', () => {
                        if (input.required && input.value === '') {
                            invalide(input, feedback, "Veuillez faire un choix.");
                        } else {
                            valide(input, feedback);
                        }
                    });
                }

                // --- Champs date ---
                if (input.type === 'date') {
                    input.addEventListener('change', () => {
                        const today = new Date();
                        const valueDate = new Date(input.value);
                        if (input.required && input.value === '') {
                            invalide(input, feedback, "Date requise.");
                        } else if (valueDate > today) {
                            invalide(input, feedback, "La date ne peut pas être dans le futur.");
                        } else {
                            valide(input, feedback);
                        }
                    });
                }

                // --- Champ fichier image (.jpg uniquement, max 2 Mo) ---
                if (input.type === 'file') {
                    input.addEventListener('change', () => {
                        const file = input.files[0];
                        if (!file) {
                            if (input.required) invalide(input, feedback,
                                "Veuillez choisir une image.");
                        } else if (!/\.(jpg|jpeg)$/i.test(file.name)) {
                            invalide(input, feedback, "Le fichier doit être au format JPG.");
                            input.value = '';
                        } else if (file.size > 2 * 1024 * 1024) {
                            invalide(input, feedback, "L'image ne doit pas dépasser 2 Mo.");
                            input.value = '';
                        } else {
                            valide(input, feedback);
                        }
                    });
                }
            });

            // Validation finale avant soumission
            form.addEventListener('submit', function(e) {
                let isValid = true;

                inputs.forEach(input => {
                    const feedback = input.parentElement.querySelector('.invalid-feedback');

                    // Champs requis
                    if (input.required && input.value.trim() === '') {
                        invalide(input, feedback, "Ce champ est obligatoire.");
                        isValid = false;
                    }

                    // Champs texte / textarea -> caractères spéciaux
                    if ((input.type === 'text' || input.tagName === 'TEXTAREA') && input.value
                        .trim() !== '' && !regexNoSpecial.test(input.value)) {
                        invalide(input, feedback, "Caractères spéciaux non autorisés.");
                        isValid = false;
                    }

                    // Select requis
                    if (input.tagName.toLowerCase() === 'select' && input.required && input
                        .value === '') {
                        invalide(input, feedback, "Veuillez faire un choix.");
                        isValid = false;
                    }

                    // Date
                    if (input.type === 'date' && input.value !== '') {
                        const today = new Date();
                        const valueDate = new Date(input.value);
                        if (valueDate > today) {
                            invalide(input, feedback, "La date ne peut pas être dans le futur.");
                            isValid = false;
                        }
                    }

                    // Fichier image
                    if (input.type === 'file' && input.files[0]) {
                        const file = input.files[0];
                        if (!/\.(jpg|jpeg)$/i.test(file.name) || file.size > 2 * 1024 * 1024) {
                            invalide(input, feedback, "Fichier invalide.");
                            isValid = false;
                        }
                    }
                });

                if (!isValid) {
                    afficherEtape(1);
                    e.preventDefault();
                }
            });
        });
    </script>

@endsection
