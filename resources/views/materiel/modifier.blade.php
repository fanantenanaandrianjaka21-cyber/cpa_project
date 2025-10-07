@extends('layouts.dynamique')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="text-align:center">{{ __('Modification d\'un Materiel') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('materiel.modifier') }}" id="register-form" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">

                                <div id="etape1">

                                    <input type="hidden" name='idmateriel' value="{{ $materiel['id'] }}">
                                    <!-- alaina avy any anaty base -->
                                    <div class="form-group row">
                                        <label for="id_emplacement" id="id_emplacement"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Emplacement') }}</label>
                                        <div class="col-md-6">
                                            <select class="form-select" aria-label="Default select example"
                                                name="id_emplacement" required>

                                                <option value="{{ $materiel['id_emplacement'] }}">
                                                    {{ $materiel['emplacement'] }}</option>
                                                @if (!empty($emplacement))
                                                    @foreach ($emplacement as $emplacement)
                                                        <option value="{{ $emplacement->id }}">
                                                            {{ $emplacement->emplacement }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('id_emplacement')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                            <div class="row mb-3">
                                <label for="date_aquisition"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Date d\'aquisition') }}</label>

                                <div class="col-md-6">
                                    <input id="date_aquisition" type="date"
                                        class="form-control @error('date_aquisition') is-invalid @enderror"
                                        name="date_aquisition" value="{{ $materiel['date_aquisition'] }}" required
                                        autocomplete="date_aquisition" autofocus>
                                    @error('date_aquisition')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                                    <div class="row mb-3">
                                        <label for="type"
                                            class="col-md-4 col-form-label text-md-end">{{ __('Type du Materiel') }}</label>

                                        <div class="col-md-6">
                                            <input id="type" type="text"
                                                class="form-control @error('type') is-invalid @enderror" name="type"
                                                value="{{ $materiel['type'] }}" required autocomplete="type" autofocus>

                                            @error('type')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="marque"
                                            class="col-md-4 col-form-label text-md-end">{{ __('Marque') }}</label>

                                        <div class="col-md-6">
                                            <input id="marque" type="text"
                                                class="form-control @error('marque') is-invalid @enderror" name="marque"
                                                value="{{ $materiel['marque'] }}" required autocomplete="marque" autofocus>

                                            @error('marque')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="model"
                                            class="col-md-4 col-form-label text-md-end">{{ __('model') }}</label>

                                        <div class="col-md-6">
                                            <input id="model" type="text"
                                                class="form-control @error('model') is-invalid @enderror" name="model"
                                                value="{{ $materiel['model'] }}" required autocomplete="model" autofocus>

                                            @error('model')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>



                                    <div class="row mb-3">
                                        <label for="serie"
                                            class="col-md-4 col-form-label text-md-end">{{ __('Numero de Serie') }}</label>

                                        <div class="col-md-6">
                                            <input id="num_serie" type="text"
                                                class="form-control @error('num_serie') is-invalid @enderror"
                                                name="num_serie" value="{{ $materiel['num_serie'] }}" required>

                                            @error('num_serie')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="status"
                                            class="col-md-4 col-form-label text-md-end">{{ __('Status') }}</label>

                                        <div class="col-md-6">
                                            <input id="status" type="text"
                                                class="form-control @error('status') is-invalid @enderror" name="status"
                                                value="{{ $materiel['status'] }}"required>

                                            @error('status')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <input class="form-control-file border" type="hidden" name="image"
                                        value="{{ $materiel['image'] }}" />
                                    {{-- <div class="row mb-3">
                            <label for="image" class="col-md-4 col-form-label text-md-end">Image :</label>
                            <div class="col-md-6">
                            <input class="form-control-file border" type="file" name="image" required/>
                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> --}}

                                    @foreach ($colonnes as $colonnes)
                                        @if ($materiel[$colonnes] != '-')
                                            <div class="row mb-3">
                                                <label
                                                    class="col-md-4 col-form-label text-md-end">{{ $colonnes }}</label>

                                                <div class="col-md-6">
                                                    <input type="text" class="form-control" name="{{ $colonnes }}"
                                                        value="{{ $materiel[$colonnes] ?? '-' }}"required>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach

                                    <div class="row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Modifier') }}
                                            </button>
                                        </div>
                                    </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
