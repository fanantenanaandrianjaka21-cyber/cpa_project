@extends('layouts.dynamique')

@section('content')
    <div class="container mt-4">

        <h3 class="mb-3"><i class="fa fa-bell"></i> Configuration des alertes</h3>

        @if (session('success'))
            <div class="alert alert-success"> <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <i class='fa fa-close'></i>
                </button>{{ session('success') }}</div>
        @endif
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
                            <td><input type="email" name="email_destinataire"
                                    value="{{ $destinataires->email_destinataire }}" class="form-control"></td>
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
