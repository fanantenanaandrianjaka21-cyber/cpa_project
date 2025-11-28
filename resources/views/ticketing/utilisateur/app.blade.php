@extends('layouts.dynamique')

@section('content')
    <?php
    use Carbon\Carbon;
    if (isset($dernierTickets)) {
        $date = Carbon::parse($dernierTickets->created_at)->translatedFormat('H:i:s d M Y');
    }
    ?>
    <!-- Bootstrap 5 -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Quill Editor -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link href="{{ asset('css/quill.snow.css') }}" rel="stylesheet">
    <!-- Bootstrap CSS -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> --}}

    {{-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> --}}
    <script src="{{ asset('assets/dist/jquery.min.js') }}"></script>
    <style>
        /* Conteneur principal */
        .input-file-area {
            position: relative;
        }

        /* Barre d’outils au-dessus du textarea */
        .toolbar {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
            position: absolute;
            right: 10px;
            top: 5px;
            z-index: 2;
        }

        .toolbar i {
            font-size: 16px;
            color: #6c757d;
            cursor: pointer;
            transition: color 0.2s ease;
        }

        .toolbar i:hover {
            color: #198754;
            /* vert bootstrap */
        }

        /* Zone de texte */
        .input-file-area textarea {
            padding-top: 35px;
            /* laisse de la place pour la barre d’outils */
            resize: vertical;
            height: 100px;
        }

        /* Cache l’input file */
        .input-file-area input[type="file"] {
            display: none;
        }

        /* Zone de prévisualisation des fichiers choisis */
        .file-preview {
            font-size: 13px;
            color: #6c757d;
            margin-top: 5px;
        }
    </style>
    <style>
        .message-box {
            max-width: 800px;
            margin: auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(25, 25, 26, 0.75);
        }

        #editor {
            height: 120px;
            border: none;
            font-size: 15px;
        }

        .ql-toolbar.ql-snow {
            border: none;
            border-radius: 10px 10px 0 0;
        }
    </style>
    <div class="col-lg-12">
        <section class="w3-animate-zoom">
            <div class="header">
                <i class="fa fa-home"></i>/ Accueil

            </div>
            <a href="#" class="btn btn-success btn-round mt-2" data-bs-toggle="modal"
                data-bs-target="#modal-ticket"><i class="bi bi-plus-circle"></i> Demander un nouveau ticket</a>
            <div class="row mt-2">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>Votre dernier ticket</h4>
                        </div>
                        <div class="card-body">
                            @if (isset($dernierTickets))
                                <table class="table table-bordered table-striped">
                                    <tbody>
                                        <tr>
                                            <th>
                                                Id :

                                            </th>
                                            <td>
                                                {{ $dernierTickets->id }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Type du ticket :
                                            </th>
                                            <td>
                                                {{ $dernierTickets->type }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>
                                                Demandeur :

                                            </th>
                                            <td>
                                                {{ $dernierTickets->utilisateur->nom_utilisateur }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Objet :

                                            </th>
                                            <td>
                                                {{ $dernierTickets->objet }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Priorite:

                                            </th>
                                            <td style="color: {{ $dernierTickets->priorite->color() }}">
                                                <span class="badge"
                                                    style="background-color: {{ $dernierTickets->priorite->color() }}">

                                                </span>
                                                {{ $dernierTickets->priorite->label() }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Status:

                                            </th>
                                            <td>
                                                <span class="badge"
                                                    style="background-color: {{ $dernierTickets->statut->color() }}">
                                                    {{ $dernierTickets->statut->label() }}
                                                </span>

                                            </td>
                                        </tr>
                                        @if ($dernierTickets->fichier)
                                            <tr>
                                                <th>
                                                    Piece Jointe :
                                                </th>
                                                <td>
                                                    @foreach (json_decode($dernierTickets->fichier, true) as $img)
                                                        <img src="{{ asset('storage/' . $img) }}" width="100">
                                                    @endforeach
                                                </td>
                                            </tr>
                                        @endif

                                        <tr>
                                            <th>
                                                Description :
                                            </th>
                                            <td>
                                                {!! $dernierTickets->description !!}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Date du demande :
                                            </th>
                                            <td>

                                                {{ $date }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            @endif
                        </div>

                        <!-- modal Ticket -->
                        <div class="modal fade" id="modal-ticket">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content info">
                                    <div class="modal-header card-body">
                                        <h4 class="modal-title">Demander un nouveau ticket</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <div class="m-4">
                                        <form method="POST" action="{{ route('ajoutTicketUtilisateur') }}"
                                            {{-- id="register-form" --}} enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group row">
                                                <label
                                                    class="col-md-3 col-form-label text-md-start">{{ __('Type :') }}</label>
                                                <div class="col-md-9">
                                                    <select class="form-select" name="type" required>
                                                        <option value="" disabled selected>Choisir type du
                                                            demande
                                                        </option>

                                                        <option value="Incident">Panne Materiel ou Logiciel</option>
                                                        <option value="Demande">Demande Materiel</option>
                                                    </select>
                                                </div>

                                            </div>
                                            <div class="row mb-3">
                                                <label for="marque"
                                                    class="col-md-3 col-form-label text-md-start">{{ __('Objet :') }}</label>
                                                <div class="col-md-9">
                                                    <input id="objet" type="text"
                                                        class="form-control @error('objet') is-invalid @enderror"
                                                        name="objet" value="{{ old('objet') }}"
                                                        placeholder="ex : Mon PC ne demmare pas, Site innaccessible,..."
                                                        autocomplete="objet" autofocus>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label
                                                    class="col-md-3 col-form-label text-md-start">{{ __('Priorite :') }}</label>
                                                <div class="col-md-9">
                                                    <select class="form-select" name="priorite" required>
                                                        <option value="" disabled selected>Choisir priorité
                                                        </option>
                                                        @foreach ($priorite as $priorite)
                                                            <option value="{{ $priorite->code }}">
                                                                {{ $priorite->label }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                            </div>


                                            <textarea id="description" name="description" value='test' hidden></textarea>



                                            <div class="row mb-3">
                                                <label for="description"
                                                    class="col-md-3 col-form-label text-md-start">{{ __('Description :') }}</label>
                                                <div class="col-md-9">
                                                    <div class="message-box">
                                                        <div id="toolbar">
                                                            <span class="ql-formats">
                                                                <button class="ql-bold"></button>
                                                                <button class="ql-italic"></button>
                                                                <button class="ql-link"></button>
                                                                <button class="ql-list" value="ordered"></button>
                                                                <button class="ql-list" value="bullet"></button>
                                                                <button class="ql-code-block"></button>
                                                            </span>
                                                        </div>

                                                        <div id="editor"></div>

                                                        <div
                                                            class="d-flex justify-content-between align-items-center p-2 border-top">
                                                            <div class="d-flex align-items-center gap-2">
                                                                <label class="btn btn-light btn-sm mb-0">
                                                                    <i class="bi bi-paperclip"></i>
                                                                    <input type="file" id="fileInput"
                                                                        name='nom_fichier[]' multiple hidden>
                                                                </label>
                                                                <span id="fileName" class="text-muted small"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                            <input id="objet" type="hidden" name="statut" value="nouveau">
                                            <div class="text-center">
                                                <button type="reset" class="btn btn-danger">Annuler</button>
                                                <button id="sendBtn" type="submit" class="btn btn-success">Envoyer
                                                    Demande</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card rounded-3 color-semi-secondary mb-2">
                        <div class="body m-3">
                            <div class="text-center">
                                <a href="#">
                                    @php
                                        $userImage = Auth::user()->image;
                                    @endphp

                                    <img src="{{ $userImage && file_exists(public_path('storage/' . $userImage))
                                        ? asset('storage/' . $userImage)
                                        : asset('asset/imageNotfound.jpg') }}"
                                        style="max-width: 200px;max-height: 200px;min-width: 200px;min-height: 200px;" class="rounded-circle">
                                </a>
                            </div>


                            <div class="card-body pt-3">
                                <div class="text-center">
                                    <h7>
                                        {{ Auth::user()->nom_utilisateur }} <br>({{ Auth::user()->prenom_utilisateur }})

                                    </h7>
                                    <div>
                                        Matricule : <i class="fa fa-localisation mr-2"></i>{{ Auth::user()->id }}
                                    </div>
                                    <div>
                                        Locale : <i
                                            class="fa fa-localisation mr-2"></i>{{ Auth::user()->emplacement->emplacement }}
                                    </div>
                                    <div class="h5 mt-1">
                                        <i class="ni mr-2"></i>{{ Auth::user()->societe }} {{ Auth::user()->equipe }}
                                    </div>
                                    @if (Auth::user()->contact_utilisateur != '')
                                        <div>
                                            <i class="fa fa-phone mr-2"></i>{{ Auth::user()->contact_utilisateur }}
                                        </div>
                                    @endif
                                    @if (Auth::user()->email != '')
                                        <div class="small">
                                            <i class="fa fa-envelope mr-2"></i>{{ Auth::user()->email }}
                                        </div>
                                    @endif

                                    <div>
                                        <a href="#" class="btn btn-success mt-3" data-bs-toggle="modal"
                                            data-bs-target="#editProfileModal">
                                            <i class="fa fa-edit"></i> Edit Profil
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Edit Profil -->
            <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title" id="editProfileLabel">Modifier le profil</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Fermer"></button>
                        </div>

                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="modal-body">

                                {{-- Nom --}}
                                <div class="mb-3">
                                    <label for="nom_utilisateur" class="form-label">Nom</label>
                                    <input type="text" class="form-control" id="nom_utilisateur"
                                        name="nom_utilisateur"
                                        value="{{ old('nom_utilisateur', Auth::user()->nom_utilisateur) }}" required>
                                </div>

                                {{-- Prénom --}}
                                <div class="mb-3">
                                    <label for="prenom_utilisateur" class="form-label">Prénom</label>
                                    <input type="text" class="form-control" id="prenom_utilisateur"
                                        name="prenom_utilisateur"
                                        value="{{ old('prenom_utilisateur', Auth::user()->prenom_utilisateur) }}"
                                        required>
                                </div>

                                {{-- Email --}}
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ old('email', Auth::user()->email) }}" required>
                                </div>

                                {{-- Contact --}}
                                <div class="mb-3">
                                    <label for="contact_utilisateur" class="form-label">Contact</label>
                                    <input type="text" class="form-control" id="contact_utilisateur"
                                        name="contact_utilisateur"
                                        value="{{ old('contact_utilisateur', Auth::user()->contact_utilisateur) }}">
                                </div>

                                {{-- Image --}}
                                <div class="mb-3">
                                    <label for="image" class="form-label">Photo de profil</label>
                                    <input type="file" class="form-control" id="image" name="image">
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>


        </section>
    </div>
    <!-- Bootstrap JS -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Quill + Bootstrap JS -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script src="{{ asset('js/quill.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Initialiser Quill
        const quill = new Quill('#editor', {
            modules: {
                toolbar: '#toolbar'
            },
            theme: 'snow',
            placeholder: 'Envoyer un message...',
        });

        // Gestion du bouton Envoyer
        document.getElementById('sendBtn').addEventListener('click', () => {

            const message = quill.root.innerHTML.trim();
            const description = document.getElementById('description');
            const fileInput = document.getElementById('fileInput');
            const file = fileInput.files[0];


            if (!message && !file) {
                alert('Veuillez écrire un message ou joindre un fichier.');
                return;
            }
            if (message) {
                // alert( message);
                console.log('Message:', message);
                description.value = message;
            }

            if (file) {
                fileInput.value = file.name;
                console.log('Fichier joint :', file.name);
            }
            quill.root.innerHTML = ''; // vider le champ
            fileInput.value = ''; // réinitialiser le fichier
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#fileInput').on('change', function() {
                let file = this.files[0];
                $('#fileName').text(file ? file.name : '');
            });
        });
    </script>
    {{-- @endsection --}}
@endsection
