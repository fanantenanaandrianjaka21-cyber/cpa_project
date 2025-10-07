@extends('layouts.dynamique')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="text-align:center">{{ __('Modification d\'un emplacement') }}
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('emplacement.modifier') }}" id="register-form">
                            @csrf
                            <input type="hidden" name="idemplacement" value="{{ $emplacement->id }}">
                            <div class="row mb-3">
                                <label for="code_emplacement"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Code emplacement') }}</label>

                                <div class="col-md-6">
                                    <input id="code_emplacement" type="text"
                                        class="form-control @error('code_emplacement') is-invalid @enderror"
                                        name="code_emplacement" value="{{ $emplacement->code_emplacement }}" required
                                        autocomplete="code_emplacement" autofocus>

                                    @error('code_emplacement')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="emplacement"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Emplacement') }}</label>

                                <div class="col-md-6">
                                    <input id="emplacement" type="text"
                                        class="form-control @error('emplacement') is-invalid @enderror" name="emplacement"
                                        value="{{ $emplacement->emplacement }}" required autocomplete="emplacement"
                                        autofocus>

                                    @error('emplacement')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="code_final"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Code final') }}</label>

                                <div class="col-md-6">
                                    <input id="code_final" type="text"
                                        class="form-control @error('code_final') is-invalid @enderror" name="code_final"
                                        value="{{ $emplacement->code_final }}" required autocomplete="code_final"
                                        autofocus>

                                    @error('code_final')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

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
