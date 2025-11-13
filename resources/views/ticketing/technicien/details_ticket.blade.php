@extends('layouts.dynamique')

@section('content')
    <?php
    use Carbon\Carbon;
    $date = Carbon::parse($ticket->created_at)->translatedFormat('H:i:s d M Y');
    ?>
    <div class="card">
        <div class="card-header">
            Ticket numero : {{ $ticket->id }}
        </div>
        <div class="card-body bg-primary text-white" style="background-color:rgba(11, 5, 22, 0.137);">
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
                            @if ($ticket->statut == 'ATTRIBUE')
                                <span class="badge bg-warning">
                                    À traiter
                                </span>
                            @else
                                <span class="badge" style="background-color: {{ $ticket->statut->color() }}">
                                    {{ $ticket->statut->label() }}
                                </span>
                            @endif
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
                    <tr>
                        <th>
                            Assigné à:
                        </th>

                        <td>
                            Moi <br><br>
                            <a href="{{ route('listTicketAdmin') }}" class="btn btn-primary btn-xs">Contacter Demandeur</a>
                            <a href="{{ route('listTicketAdmin') }}" class="btn btn-primary btn-xs">Traiter le ticket</a>
                            <a href="{{ route('listTicketAdmin') }}" class="btn btn-primary btn-xs">Plannifier le ticket</a>
                            <a href="{{ route('listTicketAdmin') }}" class="btn btn-primary btn-xs">Revenir à la
                                liste</a>

                        </td>

                    </tr>
                </tbody>
            </table>
            <div class="row">
                <div class="col-lg-3 mb-5 mb-lg-0">
                </div>
                <div class="col-lg-4 ps-lg-3">


                    Information de ses materiels: select * from materiel where id egale {{ $ticket->id_utilisateur }} <br>
                    liste des tickets (objet an ilay ticket ) ratache a chaque materiel avec le statut resolu ou pas <br>
                    ssina bouton base de connaissance
                </div>
            </div>
        </div>
    </div>
@endsection
