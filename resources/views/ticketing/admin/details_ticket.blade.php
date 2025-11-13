@extends('layouts.dynamique')

@section('content')
    <?php
    use Carbon\Carbon;
    $date = Carbon::parse($ticket->created_at)->translatedFormat('H:i:s d M Y');
    ?>
    <div class="header d-none d-lg-block">
        <i class="fa fa-home"></i>Ticket / Details
    </div>
    <div class="card">
        <div class="card-header">
            Ticket numero : {{ $ticket->id }}
        </div>
        <div class="card-body  bg-primary text-white" style="background-color:rgba(11, 5, 22, 0.137);">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            Id :

                        </th>
                        <td>
                            {{ $ticket->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Type du ticket :
                        </th>
                        <td>
                            {{ $ticket->type }}
                        </td>
                    </tr>

                    <tr>
                        <th>
                            Demandeur :

                        </th>
                        <td>
                            {{ $ticket->utilisateur->nom_utilisateur }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Objet :

                        </th>
                        <td>
                            {{ $ticket->objet }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Priorite:

                        </th>
                        <td style="color: {{ $ticket->priorite->color() }}">
                            <span class="badge" style="background-color: {{ $ticket->priorite->color() }}">

                            </span>
                            {{ $ticket->priorite->label() }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Status:

                        </th>
                        <td>
                            <span class="badge" style="background-color: {{ $ticket->statut->color() }}">
                                {{ $ticket->statut->label() }}
                            </span>

                        </td>
                    </tr>
                    @if ($ticket->fichier)
                        <tr>
                            <th>
                                Piece Jointe :
                            </th>
                            <td>
                                @foreach (json_decode($ticket->fichier, true) as $img)
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
                            {{-- {{ dd( $ticket) }} --}}
                            {!! $ticket->description !!}
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

                    {{-- <tr>
                        <th>
                            Assigné à:
                        </th>
                        @if ($ticket->assignement)
                            <td>
                                {{ $ticket->technicien->nom_utilisateur }} <br>
                                <a href="{{ route('listTicketAdmin') }}" class="btn btn-primary btn-xs">Revenir à la
                                    liste</a><br><br>

                            </td>
                        @else
                            <td>
                                <form action="{{ route('tickets.assigner', $ticket->id) }}" method="POST">
                                    @csrf
                                    <div>
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <select class="form-select" aria-label="Default select example"
                                                    name="assignement" required>
                                                    <option value="">Choisir Technicien</option>
                                                    @if (!empty($techniciens))
                                                        @foreach ($techniciens as $technicien)
                                                            <option value="{{ $technicien->id }}">
                                                                {{ $technicien->nom_utilisateur }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-xs">Assigner le ticket</button>
                                    <a href="{{ route('listTicketAdmin') }}" class="btn btn-primary btn-xs">Revenir à la
                                        liste</a><br><br>

                                </form>
                 

                            </td>
                        @endif

                    </tr> --}}
@if (Auth::user()->role=='Super Admin' OR Auth::user()->role=='Admin IT')
                     <tr>
                        @if ($ticket->statut->label() == 'Fermé')
                            <th>
                                Solution :
                            </th>
                        @else
                            <th>
                                Action :
                            </th>
                        @endif

                        @if ($ticket->statut->label() == 'Nouveau' or $ticket->statut->label() == 'Attribué')
                            <td>

                                <a href="{{ route('tickets.traiter', $ticket->id) }}"
                                    class="btn btn-primary btn-xs">Traiter
                                    le
                                    Ticket</a><br><br>

                            </td>
                        @elseif ($ticket->statut->label() == 'Fermé')
                            <td>
                                {{ $ticket->solution }}
                            </td>
                        @else
                            <td class="text-center">
                                <form action="{{ route('tickets.terminer', $ticket->id) }}" method="POST">
                                    @csrf
                                    <div>
                                        <div class="form-group row">
                                            Solution :
                                            <div class="col-md-6">
                                                <textarea name="solution" id="solution" cols="40" rows="5" required></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-success btn-xs">Terminer</button>
                                    <a href="" class="btn btn-info btn-xs">Mettre en attente</a>
                                    <a href="{{ route('listTicketAdmin') }}" class="btn btn-primary btn-xs">Revenir à la
                                        liste</a><br><br>

                                </form>


                            </td>
                        @endif

                    </tr>   
@endif

                </tbody>
            </table>
@if (Auth::user()->role=='Super Admin' OR Auth::user()->role=='Admin IT')
                <h4>Liste des Materiels du demandeur</h4>
            <table id="#" class="table table-hover table-responsive">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Materiel</th>
                        <th>Marque</th>
                        <th>Model</th>
                        <th>Etat</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($materielUtilisateur as $materiel)
                        <tr data-row-id="{{ $materiel['id'] }}">
                            <td>{{ $materiel['id'] }}</td>
                            {{-- <td class="text-center"><img class="card-img-top"
                                            style="background-size: cover;min-height: 100px; max-height: 100px;max-width:150px"src="{{ asset('storage/' . $materiel['image']) }}"><br>{{ $materiel['type'] }}
                                    </td> --}}
                            <td class="text-center">
                                {{ $materiel['type'] }}
                            </td>
                            <td class="text-center">{{ $materiel['marque'] ?? '--' }}</td>
                            <td>
                                {{ $materiel['model'] }}
                            </td>
                            <td class="text-center">

                                {{ $materiel['Etat'] }}
                            </td>
                            <td>
                                <div class="pull-right hidden-phone">
                                    <a href="{{ route('caracteristique.voir', $materiel['id']) }}"
                                        class="btn btn-outline-info btn-xs">Details</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
@endif
        </div>

    </div>

    {{-- <a href="#" class="btn btn-secondary" data-bs-toggle="collapse" data-bs-target="#modal-info-materiel">Materiels Du
        Demandeur</a> --}}

    <!-- modal infomateriel -->
    <div class="modal" id="modal-info-materiel">
        <div class="modal-dialog modal-lg w3-animate-right">
            <div class="modal-content info">
                <div class="modal-header ">
                    <h4 class="modal-title text-primary">Materiels du Demandeur</h4>
                    <a href="#" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                <div class="modal-body bg-primary">

                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

@endsection
