@extends('layouts.app')

@section('content')
    <div class="bottom-data">
        <div class="reminders" style="display: none">
            <div class="header">
                <i class='bx bx-receipt'></i>
                <h3>{{ __('Add New Sector') }}</h3>
                <i class='icon-minimizar bx bx-chevron-down'></i>
                <i class='bx bx-x'></i>
            </div>
            <div class="formulario">
                <form method="POST" action="{{ route('setores.store') }}" class="row form-content">
                    @csrf

                    <div class="col-sm-12 col-md-12 col-xxl-9">
                        <label for="setor_descricao" class="label-input">{{ __('Name') }}</label>
                        <input id="setor_descricao" type="text"
                            class="form-input @error('setor_descricao') is-invalid @enderror" name="setor_descricao"
                            placeholder="{{ __('Sector describe') }}" autocomplete="setor_descricao" autofocus
                            value="{{ old('setor_descricao') }}">
                    </div>

                    <div class="col-sm-12 col-md-12 col-xxl-3">
                        <label for="setor_ativo" class="label-input">{{ __('Sector Activo') }}</label>
                        <select id="setor_ativo" type="text" class="form-input" name="setor_ativo" required
                            autocomplete="setor_ativo" autofocus>
                            <option value="SIM">Sim</option>
                            <option value="NÂO">Não</option>
                        </select>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="col-12">
                        <button type="submit" class="button button-primary">
                            {{ __('Save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @include('settings.setores._components.table_setores')
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const title = document.getElementById('title-page-nav');
            const icon = document.querySelector('.icon');
            icon.classList.add('bx-map');
            title.textContent = "{{ __('Sectors') }}";

            title.onclick = function() {
                window.location.href = "{{ route('setores.index') }}";
            };
        });
    </script>
@endsection
