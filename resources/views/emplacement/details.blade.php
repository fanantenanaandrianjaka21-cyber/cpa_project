@extends('layouts.dynamique')

@section('content')
    <div class="header d-none d-lg-block">
        <i class="fa fa-home"></i>Locale / Details
    </div>
    <div class="w3-panel">
        <h4 class="w3-start w3-animate-right">
            Inforamtion Locale
        </h4>
    </div>
    <div class="card">

        <div class="card-body bg-primary text-white" style="background-color:rgba(11, 5, 22, 0.137);">
            <table class="table table-bordered table-striped table-responsive w3-card-4">
                <tbody>
                    <tr>
                        <th>
                            Id :

                        </th>
                        <td>
                            {{ $emplacement->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Locale :
                        </th>
                        <td>
                            {{ $emplacement->emplacement }}
                        </td>

                    </tr>


                    <tr>
                        <th>
                            Code Locale :
                        </th>

                        <td>
                            {{ $emplacement->code_emplacement }}

                        </td>

                    </tr>

                </tbody>
            </table>
        </div>
    @endsection
