@extends('layouts.app')

@section('content')
    <div class="bottom-data">
        <div class="orders">
            <div class="header form-content">
                <button class="button button-transparent" onclick="window.history.back()"><i
                        class='bx bx-chevron-left'></i><span class="text">{{ __('Back') }}</span></button>
                <i class='bx bx-receipt'></i>
                <h3>{{ __('Update Sector') }}: {{ $colaborador->colaborador_nome }}</h3>
                <i class='icon-minimizar bx bx-chevron-down'></i>
            </div>
            <div class="formulario">
                <form method="POST" action="{{ route('colaboradores.update', $colaborador->id) }}" class="row form-content w-50">
                    @csrf
                    @method('put')
                    <div class="col-sm-12 col-md-12 col-xxl-12">
                        <label for="colaborador_nome" class="label-input">{{ __('Collaborator Name') }}</label>
                        <input id="colaborador_nome" type="text"
                            class="form-input @error('colaborador_nome') is-invalid @enderror" name="colaborador_nome"
                            placeholder="{{ __('Collaborator Name') }}" autocomplete="colaborador_nome" autofocus
                            value="{{ $colaborador->colaborador_nome }}">
                    </div>

                    <div class="col-sm-12 col-md-12 col-xxl-12">
                        <label for="colaborador_codigo_esocial" class="label-input">{{ __('Code eSocial') }}</label>
                        <input id="colaborador_codigo_esocial" type="text"
                            class="form-input @error('colaborador_codigo_esocial') is-invalid @enderror" name="colaborador_codigo_esocial"
                            placeholder="{{ __('Code eSocial')}}" autocomplete="off" autofocus value="{{ $colaborador->colaborador_codigo_esocial }}">
                    </div>

                    <div class="col-md-12">
                        <label for="colaborador_cargo_id" class="label-input">{{ __('Office') }}</label>
                        <select id="colaborador_cargo_id" type="text" class="form-input" name="colaborador_cargo_id"
                            required autocomplete="colaborador_cargo_id" autofocus>
                            @foreach ($cargos as $cargo)
                                <option value="{{ $cargo->id }}">{{ $cargo->id }} - {{ $cargo->cargo_descricao }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label for="colaborador_setor_id" class="label-input">{{ __('Sector') }}</label>
                        <select id="colaborador_setor_id" type="text" class="form-input" name="colaborador_setor_id"
                            required autocomplete="colaborador_setor_id" autofocus>
                            @foreach ($setores as $setor)
                                <option value="{{$setor->id}}">{{$setor->id}} - {{$setor->setor_descricao}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-sm-12 col-md-12 col-xxl-4">
                        <label for="colaborador_ativo" class="label-input">{{ __('Active contributor') }}</label>
                        <select id="colaborador_ativo" type="text" class="form-input" name="colaborador_ativo" required
                            autocomplete="colaborador_ativo" autofocus>
                            <option value="SIM">Sim</option>
                            <option value="NÃO">Não</option>
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
                        <button type="submit" class="button button-primary w-100">
                            {{ __('Save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            selectOptionSetor("{{ $colaborador->colaborador_setor_id }}");
            selectOptionCargo("{{ $colaborador->colaborador_cargo_id }}");
            selectOptionAtivo("{{ $colaborador->colaborador_ativo }}");
        });

        document.addEventListener("DOMContentLoaded", function() {
            const title = document.getElementById('title-page-nav');
            const icon = document.querySelector('.icon');
            icon.classList.add('bx-group');
            title.textContent = "{{ __('Collaborators') }}";

            title.onclick = function() {
                window.location.href = "{{ route('colaboradores.index') }}";
            };
        });

        function selectOptionSetor(value) {
            let select = $("#colaborador_setor_id");
            let option = select.find("option[value='" + value + "']");
            option.prop("selected", true);
        }
        function selectOptionCargo(value) {
            let select = $("#colaborador_cargo_id");
            let option = select.find("option[value='" + value + "']");
            option.prop("selected", true);
        }
        function selectOptionAtivo(value) {
            let select = $("#colaborador_ativo");
            let option = select.find("option[value='" + value + "']");
            option.prop("selected", true);
        }
    </script>
@endsection
