 @extends('layouts.dynamique')

 @section('content')

     <div class="page-heading email-application overflow-hidden">
         <div class="page-title">
             <div class="row">
                 <div class="col-12 col-md-6 order-md-1 order-last">
                     <h3>Mes Tickets</h3>
                 </div>
                 <div class="col-12 col-md-6 order-md-2 order-first">
                     <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                         <ol class="breadcrumb">
                             <li class="breadcrumb-item">
                                 <a href="/">Accueil</a>
                             </li>
                             <li class="breadcrumb-item active" aria-current="page">
                                 Tickets
                             </li>
                     </nav>
                 </div>
             </div>
         </div>
         <section class="section">
             <div class="row" id="basic-table">
                 <div class="col-12 col-md-12">
                     <div class="card">
                         <div class="card-header d-flex justify-content-between">
                             <h4 class="card-title">Mes Tickets</h4>
                             <form class="d-flex" action="./achat.php" method="get">
                                 <input style="background-color:#35356f;" class="form-control me-2" type="search"
                                     placeholder="Rechercher" aria-label="Search" name="rechercher" />
                                 <button class="btn btn-outline-primary" type="submit">
                                     Rechercher
                                 </button>
                             </form>
                         </div>
                         <div>

                             @if (isset($tickets) && $tickets->count() > 0)
                                 <table class="table table-bordered">
                                     <thead>
                                         <tr>
                                             <th>Numéro</th>
                                             <th>Matériel</th>
                                             <th>Objet</th>
                                             <th>Description</th>
                                             <th>Fichiers</th>
                                             <th>Statut</th>
                                             <th>Technicien</th>
                                             <th>Date</th>
                                         </tr>
                                     </thead>
                                     <tbody>
                                         @foreach ($tickets as $ticket)
                                             <tr>
                                                 <td>{{ $ticket->id }}</td>
                                                 <td>{{ $ticket->type }}</td>
                                                 <td>{{ $ticket->objet }}</td>
                                                 <td>{!! $ticket->description !!}</td>
                                                 <td>
                                                     @if ($ticket->fichier)
                                                         @foreach (json_decode($ticket->fichier, true) as $img)
                                                             <img src="{{ asset('storage/' . $img) }}" width="60"
                                                                 style="margin: 2px;">
                                                         @endforeach
                                                     @else
                                                         Aucun fichier
                                                     @endif
                                                 </td>

                                                 <td>
                                                     <span class="badge"
                                                         style="background-color: {{ $ticket->statut->color() }}">
                                                         {{ $ticket->statut->label() }}
                                                     </span>
                                                     </span>
                                                 </td>
                                                 <td>
                                                    @if ($ticket->assignement)
                                                    {{ $ticket->technicien->nom_utilisateur }}</td>
                                                    @endif
                                                 <td>{{ $ticket->created_at }}</td>
                                             </tr>
                                         @endforeach
                                     </tbody>
                                 </table>
                             @else
                                 <p>Aucun ticket trouvé</p>
                             @endif
                         </div>
                     @endsection
