@extends('layouts.dynamique')
@section('content')
    @if (!empty($affectation))
        <div class="header">
            <i class="fa fa-home"></i>/ Affectation / Historique
        </div>
        <div class="w3-panel w3-pale-blue w3-bottombar w3-border-blue w3-border">
            <h4 class="w3-start w3-animate-right">
                Historique des affectations
            </h4>
        </div>
        <div class="card">

            <div class="card-body bg-info text-white">
                <div class="row">
                    <div class="col-12">
                        <?php
                        if (isset($notification)) {
                            echo "<div class='alert alert-success'>
                                                                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                                                      <i class='fa fa-close'></i>
                                                                    </button>
                                                                    <span>
                                                                      <b><i class='fa fa-bell'></i>  Success - </b>" .
                                $notification .
                                "</span>
                                                                  </div>";
                        }
                        ?>
                        <table id="bootstrap-data-table-export" class="table table-hover table-responsive ">
                            <thead>
                                <tr>
                                    <th rowspan="2"style="text-align: center">ID</th>
                                    <th rowspan="2"style="text-align: center">Materiel</th>
                                    <th rowspan="2"style="text-align: center">Model</th>
                                    <th colspan="3"style="text-align: center">Historique</th>
                                    {{-- <th rowspan="2"style="text-align: center">Action</th> --}}
                                </tr>
                                <tr>
                                    <th style="text-align: center">Utilisateur</th>
                                    <th style="text-align: center">Localisation</th>
                                    <th style="text-align: center">Date d'affectation</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($affectation as $affectation)
                                    <tr>
                                        <td>
                                            {{ $affectation['id_materiel'] }}
                                        </td>
                                        <td>
                                            {{-- <img class="card-img-top"
                                                style="background-size: cover;min-height: 100px; max-height: 100px"src="{{ asset('storage/' . $affectation['image']) }}"> --}}
                                            {{ $affectation['type'] }}
                                        </td>
                                        <td>
                                            {{ $affectation['model'] }}
                                        </td>
                                        <td>
                                            @foreach ($affectation['utilisateur'] as $utilisateur)
                                                @if ($utilisateur['email'] == '-')
                                                    <div style="border-bottom: 1px solid rgb(0, 0, 0); padding: 5px;">
                                                        {{ $utilisateur['emplacement'] }}</div>
                                                @else
                                                    <div style="border-bottom: 1px solid rgb(0, 0, 0); padding: 5px;">
                                                        {{ $utilisateur['email'] }}</div>
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($affectation['utilisateur'] as $utilisateur)
                                                <div style="border-bottom: 1px solid rgb(0, 0, 0); padding: 5px;">
                                                    {{ $utilisateur['emplacement'] }}</div>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($affectation['utilisateur'] as $utilisateur)
                                                <div style="border-bottom: 1px solid rgb(0, 0, 0); padding: 5px;">
                                                    {{ $utilisateur['date_affectation'] }}</div>
                                            @endforeach
                                        </td>
                                        {{-- <td>{{$affectation['email']}}</td>
                      <td>{{$affectation['emplacement']}}</td>
                      <td>{{$affectation['date_affectation']}}</td> --}}

                                        {{-- <td>
                                            <div class="pull-right hidden-phone">
                                                <a href="#" class="btn btn-outline-info btn-xs">Details</a>
                                                <a href="#" class="btn btn-outline-danger btn-xs"><i
                                                        class="fa fa-trash-o "></i></a>
                                            </div>
                                        </td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
