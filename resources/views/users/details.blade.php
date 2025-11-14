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


                                <div class="row mt">
                                    <div class="col-md-12">
                                        <section class="task-panel tasks-widget">
                                            <h1>{{ $utilisateur->nom_utilisateur }}</h1>
                                            <div class="panel-body">
                                                <div class="task-content">




                                                    {{-- <div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull">
            
            
            <img class="sary1" src="{{asset('storage/'.$emplacement->id)}}" title="Profil" alt="" />
        </div>
        <div class="pull-right">
            <a href="" class="label label-primary pull-right"> Retourner</a>
        </div>
    </div>
</div> --}}
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
                                                                    {{ $utilisateur->equipe }}
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
            </section>
            <!-- /wrapper -->
        </section>
    </header>
@endsection
