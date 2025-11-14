@extends('layouts.dynamique')

@section('content')
    <header id="head">

        <!--main content start-->
        <section id="main-content">
            <section class="wrapper">



                <!--  row -->
                <!-- COMPLEX TO DO LIST -->




                <div class="row mt">
                    <div class="col-lg-12">
                        <div class="form-panel">
                            <div class=" form">


                                <div class="row mt"  style="margin-right: 10%; margin-left: 10%">
                                    <div class="col-md-12">
                                        <section class="task-panel tasks-widget">
                                            <h1>{{ $utilisateur->nom_utilisateur }}</h1>
                                            <div class="panel-body">
                                                <div class="task-content">
                                                   <table class="table table-bordered table-striped">
                                                        <tbody>
                                                            <tr>
                                                                <th>
                                                                    Matricule :

                                                                </th>
                                                                <td>
                                                                    {{ $utilisateur->id }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>
                                                                    Nom :

                                                                </th>
                                                                <td>
                                                                    {{ $utilisateur->nom_utilisateur }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>
                                                                    prenom :

                                                                </th>
                                                                <td>
                                                                    {{ $utilisateur->prenom_utilisateur }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>
                                                                    Email :

                                                                </th>
                                                                <td>
                                                                    {{ $utilisateur->email }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>
                                                                    Contact :

                                                                </th>
                                                                <td>
                                                                    {{ $utilisateur->contact_utilisateur }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>
                                                                    Societe :

                                                                </th>
                                                                <td>
                                                                    {{ $utilisateur->societe }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>
                                                                    Equipe :

                                                                </th>
                                                                <td>
                                                                    {{ $utilisateur->equipe}}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>
                                                                    Local :

                                                                </th>
                                                                <td>
                                                                    {{ $utilisateur->emplacement}}
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                    <!-- /col-md-12-->
                                </div>

                                <!-- /row -->
                                <!-- Liste des clients -->


                            </div>
                        </div>
                    </div>
                    <!-- /col-lg-12 -->
                </div>
                <!-- /row -->
                <div style="display: flex; justify-content: center;">
                    <form action="{{ route('utilisateur.details', $utilisateur->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir réinitialiser le mot de passe de cet utilisateur ?')">
                                        Réinitialiser le Mot de Passe
                                    </button>
                                </form>
                </div>
            </section>
            <!-- /wrapper -->
        </section>
    </header>
@endsection
