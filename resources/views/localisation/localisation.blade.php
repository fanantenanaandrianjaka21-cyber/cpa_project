@extends('layouts.dynamique')
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                @if (count($materiel) == 0)
                    Aucun materiel trouvé dans cet emplacement
                @else
                    <h4>Liste des materiels utilisés dans l'emplacement : <strong>{{ $materiel[0]['emplacement'] }}</strong>
                    </h4>
                @endif
            </div>
            <div class="card-body">

                <div class="row">
                    <div class="col-12">

                        <table id="bootstrap-data-table-export" class="table table-hover table-responsive table-bordered">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Materiel</th>
                                    <th>Type</th>
                                    <th>Marque</th>
                                    <th>Localisation</th>
                                    <th>status</th>

                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($materiel as $materiel)
                                    <tr>
                                        <td>{{ $materiel['id'] }}</td>
                                        <td><img class="card-img-top"
                                                style="background-size: cover;min-height: 100px; max-height: 100px"src="{{ asset('storage/' . $materiel['image']) }}">
                                        </td>
                                        <td>{{ $materiel['type'] }}</td>
                                        <td>{{ $materiel['marque'] }}</td>
                                        <td>{{ $materiel['emplacement'] }}</td>
                                        <td class="text-center">
                                            @if ($materiel['status'] == 'disponible')
                                                <span
                                                    style="background-color:rgba(0, 128, 0, 0.603);color:white;border-radius:10px;padding:5px;">{{ $materiel['status'] }}</span>
                                            @elseif ($materiel['status'] == 'utiliser')
                                                <span
                                                    style="background-color:rgba(35, 240, 213, 0.74);color:white;border-radius:10px;padding:5px">{{ $materiel['status'] }}</span><br><br>
                                                par {{ $materiel['email'] }}
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
    </div>
@endsection
