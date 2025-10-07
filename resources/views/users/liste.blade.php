@extends('layouts.dynamique')
@section('content')
    @if (!empty($user))
           <div class="header">
        <i class="fa fa-home"></i>/ Utilisateur / Liste

    </div>
        <div class="card">
            <div class="card-header">
                <h7>Liste des Utilisateurs</h7>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class="col-12">
                        <?php
                        if (isset($notification)) {
                            echo "<div class='alert alert-success'>
                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                              <i class='fa fa-close'></i>
                                            </button>
                                            <span>
                                              <i class='fa fa-bell'></i><b>  Success - </b>" .
                                $notification .
                                "</span>
                                          </div>";
                        }
                        ?>
                        <table id="bootstrap-data-table-export" class="table table-hover table-responsive table-bordered">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Prenom</th>
                                    <th>E-mail</th>
                                    <th>Equipe</th>
                                    <th>Societe</th>
                                    <th>Emplacement</th>
                                    <th>Contact</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user as $user)
                                    <tr>
                                        <td>{{ $user->nom_utilisateur }}</td>
                                        <td>{{ $user->prenom_utilisateur }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->equipe }}</td>
                                        <td>{{ $user->societe }}</td>
                                        <td>{{ $user->id_emplacement }}</td>
                                        {{-- emplacement --}}
                                        <td>{{ $user->contact_utilisateur }}</td>
                                        <td>
                                            <div class="pull-right hidden-phone">
                                                <a href="{{ route('utilisateur.details', $user->id) }}"
                                                    class="btn btn-info btn-xs">Details</a>
                                                <a href="{{ route('utilisateur.edit', $user->id) }}"
                                                    class="btn btn-secondary btn-xs"><i class="fa fa-pencil"></i></a>
                                                <a href="{{ route('utilisateur.delete', $user->id) }}"
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
    @else
        <h1>hafa</h1>
    @endif
@endsection
