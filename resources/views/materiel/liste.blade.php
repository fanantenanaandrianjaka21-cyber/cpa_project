@extends('layouts.dynamique')

@section('content')
    <div class="header">
        <i class="fa fa-home"></i>/ Materiels / Tous les Materiels

    </div>
    <div class="card">
        <div class="card-header">
            <h7>Liste de tous les Matériels</h7>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                   @if (session('notification'))
                        <div class='alert alert-success'>
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                <i class='fa fa-close'></i>
                            </button>
                            <span>
                                <b><i class='fa fa-bell'></i> Success - </b>{{ session('notification') }}
                            </span>
                        </div>
                    @endif

                   
                    <table id="bootstrap-data-table-export" class="table table-hover table-responsive table-bordered">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Materiel</th>
                                <th>Model</th>
                                {{-- <th>Marque</th> --}}
                                <th>Localisation</th>
                                <th>status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($detail_materiel as $materiel)
                                <tr>
                                    <td>{{ $materiel['id'] }}</td>
                                    <td class="text-center"><img class="card-img-top"
                                            style="background-size: cover;min-height: 100px; max-height: 100px;max-width:150px"src="{{ asset('storage/' . $materiel['image']) }}"><br>{{ $materiel['type'] }}
                                    </td>
                                    <td>{{ $materiel['model'] }}</td>
                                    {{-- <td>{{$materiel['marque']}}</td> --}}
                                    <td><a
                                            href="/localisation/{{ $materiel['id_emplacement'] }}">{{ $materiel['emplacement'] }}</a>
                                    </td>
                                    <td class="text-center">
                                        @if ($materiel['status'] == 'disponible')
                                            <span
                                                style="background-color:rgba(0, 128, 0, 0.603);color:white;border-radius:10px;padding:5px;">{{ $materiel['status'] }}</span>
                                        @elseif ($materiel['status'] == 'utiliser')
                                            <span
                                                style="background-color:rgba(35, 240, 213, 0.74);color:white;border-radius:10px;padding:5px">{{ $materiel['status'] }}</span><br><br>
                                            par {{ $materiel['nom_utilisateur'] }}<br>{{ $materiel['societe'] }}, equipe
                                            {{ $materiel['equipe'] }}
                                        @else
                                            <span
                                                style="background-color:rgba(240, 192, 35, 0.74);color:white;border-radius:10px;padding:5px">{{ $materiel['status'] }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="pull-right hidden-phone">
                                            <a href="{{ route('caracteristique.voir', $materiel['id']) }}"
                                                class="btn btn-info btn-xs">Details</a>
                                            <a href="{{ route('materiel.edit', $materiel['id']) }}"
                                                class="btn btn-secondary btn-xs"><i class="fa fa-pencil"></i></a>
                                            <a href="{{ route('materiel.delete', $materiel['id']) }}"
                                                class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
