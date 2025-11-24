@extends('layouts.dynamique')

@section('content')
    <div class="container mt-4">

        <h3 class="mb-3" style="color: white"><i class="fa fa-bell"></i> Configuration des alertes</h3>

        @if (session('success'))
            <div class="alert alert-success"> <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <i class='fa fa-close'></i>
                </button>{{ session('success') }}</div>
        @endif
                                <a href="" class="btn btn-success btn-sm mb-2" data-toggle="modal" data-target="#modal-locale">
                                        Ajouter un autre mail
                                    </a>
        <table class="table table-bordered align-middle text-center">
            <thead class="table-primary">
                <tr>
                    <th>Email Destinataire</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($destinataires as $destinataires)
                    <tr>
                        <form action="{{ route('alertes.updateDestinataire', $destinataires->id) }}" method="POST">
                            @csrf
                            <td>
                                <input type="email" name="email_destinataire"
                                    value="{{ $destinataires->email_destinataire }}" class="form-control">
                            </td>
                            <td>
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fa fa-check"></i> Enregistrer
                                </button>
                                <button type="button" class="btn btn-danger btn-sm"
                                        data-toggle="modal" data-target="#modal-delete-{{ $destinataires->id }}">
                                    <i class="fa fa-trash"></i> Supprimer
                                </button>       
                            </td>
                        </form>
                    </tr>
                    <!-- Modal de suppression -->
                    <div class="modal fade" id="modal-delete-{{ $destinataires->id }}">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title">Confirmer la suppression</h5>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <div class="modal-body">
                                    <p>Voulez-vous vraiment supprimer : <strong>{{ $destinataires->email_destinataire }}</strong> ?</p>
                                    <p>Elle ne receverra plus d'email de notification si vous confirmer la suppression</p>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>

                                    <form action="{{ route('alertes.deleteDestinataire', $destinataires->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-success">
                                            Confirmer
                                        </button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>

                @endforeach
            </tbody>
        </table>
        <!--debut modal-->
        <div class="modal" id="modal-locale">
            <div class="modal-dialog modal-lg w3-animate-right">
                <div class="modal-content info ">
                    <div class="modal-header ">
                        <h4 class="modal-title text-primary">Ajouter une nouvelle destinataire</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action=" {{ route('ajoutmaildestinataire')}}" id="register-form"
                            onsubmit="return validateForm()" class="needs-validation" novalidate>
                            @csrf
                            <div class="row mb-3">
                                <label for="email_destinataire"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Email :') }}</label>
                                <div class="col-md-6">
                                    <input id="email_destinataire" type="email"
                                        class="form-control  @error('email_destinataire') is-invalid @enderror" name="email_destinataire"
                                        value="{{ old('email_destinataire') }}" required>
                                    <div class="invalid-feedback">Email déja dans la liste</div>
                                </div>
                            </div>
                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-success">
                                        {{ __('Enregistrer') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <table class="table table-bordered align-middle text-center">
            <thead class="table-primary">
                <tr>
                    <th>Envoi par jour</th>
                    <th>Envoi par semaine</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <form action="{{ route('alertes.update', $alerte->id) }}" method="POST">
                        @csrf

                        <td>
                            <input type="checkbox" name="par_jour" value="1" {{ $alerte->par_jour ? 'checked' : '' }}>
                            <input type="time" name="heure_envoie_par_jour" value="{{ $alerte->heure_envoie_par_jour }}"
                                class="form-control mt-1">
                        </td>

                        <td>
                            <input type="checkbox" name="hebdomadaire" value="1"
                                {{ $alerte->hebdomadaire ? 'checked' : '' }}>
                            <select name="jour_du_semaine" class="form-select mt-1">
                                @foreach (['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'] as $jour)
                                    <option value="{{ $jour }}"
                                        {{ $alerte->jour_du_semaine === $jour ? 'selected' : '' }}>{{ $jour }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="time" name="heure_envoie_par_semaine"
                                value="{{ $alerte->heure_envoie_par_semaine }}" class="form-control mt-1">
                        </td>

                        <td>
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fa fa-check"></i> Enregistrer
                            </button>
                        </td>
                    </form>
                </tr>
            </tbody>
        </table>
        <table class="table table-bordered align-middle text-center">
            <thead class="table-primary">
                <tr>
                    {{-- <th>Email</th> --}}
                    <th>Type matériel</th>
                    <th>Seuil</th>
                    <th>Critique</th>
                    {{-- <th>Envoi par jour</th>
                <th>Envoi par semaine</th> --}}
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($types as $type)
                    <tr>
                        <form action="{{ route('alertes.updateAlerteTypes', $type->id) }}" method="POST">
                            @csrf
                            {{-- <td><input type="email" name="email_destinataire" value="{{ $type->email_destinataire }}" class="form-control"></td> --}}
                            <td>{{ $type->type_materiel }}</td>
                            <td><input type="number" name="niveau_seuil" value="{{ $type->niveau_seuil }}"
                                    class="form-control"></td>
                            <td><input type="number" name="niveau_critique" value="{{ $type->niveau_critique }}"
                                    class="form-control"></td>

                            {{-- <td>
                            <input type="checkbox" name="par_jour" value="1" {{ $alerte->par_jour ? 'checked' : '' }}>
                            <input type="time" name="heure_envoie_par_jour" value="{{ $alerte->heure_envoie_par_jour }}" class="form-control mt-1">
                        </td>

                        <td>
                            <input type="checkbox" name="hebdomadaire" value="1" {{ $alerte->hebdomadaire ? 'checked' : '' }}>
                            <select name="jour_du_semaine" class="form-select mt-1">
                                @foreach (['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'] as $jour)
                                    <option value="{{ $jour }}" {{ $alerte->jour_du_semaine === $jour ? 'selected' : '' }}>{{ $jour }}</option>
                                @endforeach
                            </select>
                            <input type="time" name="heure_envoie_par_semaine" value="{{ $alerte->heure_envoie_par_semaine }}" class="form-control mt-1">
                        </td> --}}

                            <td>
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fa fa-check"></i> Enregistrer
                                </button>
                            </td>
                        </form>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
