@extends('layouts.app')

@section('title', 'Matriz de Treinamentos')

@section('content')

    <div class="bottom-data ">
        <div class="reminders" style="display: none">
            <div class="header">
                <div class="sub-header">
                    <i class='bx bx-receipt'></i>
                </div>
                <div class="sub-header">
                    <h4>{{ __('Add New Training Matrix') }}</h4>
                </div>
                <div class="sub-header">
                    <i class='icon-minimizar bx bx-chevron-down'></i>
                    <i class='bx bx-x'></i>
                </div>
            </div>
            <div class="formulario">
                <form method="POST" action="{{ route('matriz_treinamentos.store') }}" class="row form-content">
                    @csrf

                    <div class="col-sm-12 col-md-12 col-xxl-12">
                        <label for="m_treinamento_descricao"
                            class="label-input">{{ __('Description Training Matrix') }}</label>
                        <input id="m_treinamento_descricao" type="text"
                            class="form-input @error('m_treinamento_descricao') is-invalid @enderror"
                            name="m_treinamento_descricao" placeholder="{{ __('Description Training Matrix') }}"
                            value="{{ old('m_treinamento_descricao') }}" autocomplete="off" autofocus>
                    </div>

                    <div class="col-sm-12 col-md-12 col-xxl-12">
                        <label for="m_treinamento_tempo" class="label-input">{{ __('Training time') }}</label>
                        <input id="m_treinamento_tempo" type="text"
                            class="form-input @error('m_treinamento_tempo') is-invalid @enderror" name="m_treinamento_tempo"
                            placeholder="HH:MM:SS" value="{{ old('m_treinamento_tempo') }}" autocomplete="off">
                    </div>

                    <div class="col-sm-12 col-md-12 col-xxl-12">
                        <label for="m_treinamento_setor_responsavel_id"
                            class="label-input">{{ __('Responsible sector') }}</label>
                        <select id="m_treinamento_setor_responsavel_id" type="text" class="form-input"
                            name="m_treinamento_setor_responsavel_id" required
                            autocomplete="m_treinamento_setor_responsavel_id">
                            @foreach ($setores as $setor)
                                <option value="{{ $setor->id }}">{{ $setor->id }} - {{ $setor->setor_descricao }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-sm-12 col-md-12 col-xxl-12 d-flex justify-between-content">
                        <div class="input col-6">
                            <input type="checkbox" name="m_treinamento_obrigatorio" id="m_treinamento_obrigatorio"
                                value="SIM">
                            <label for="m_treinamento_obrigatorio" class="label-input"
                                style="cursor: pointer">{{ __('Mandatory Training') }}</label>
                        </div>
                        <div class="input col-6">
                            <input type="checkbox" name="m_treinamento_obrigatorio_avaliacao_eficacia"
                                id="m_treinamento_obrigatorio_avaliacao_eficacia" value="SIM">
                            <label for="m_treinamento_obrigatorio_avaliacao_eficacia" class="label-input"
                                style="cursor: pointer">{{ __('Mandatory Effectiveness Assessment') }}</label>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-12 col-xxl-12">
                        <label for="m_treinamento_ativo" class="label-input">{{ __('Active Training Matrix') }}</label>
                        <select id="m_treinamento_ativo" type="text" class="form-input" name="m_treinamento_ativo"
                            required autocomplete="m_treinamento_ativo">
                            <option value="SIM">Sim</option>
                            <option value="NÃO">Não</option>
                        </select>
                    </div>

                    <div class="col-sm-12 col-md-12 col-xxl-12 user-select-none">
                        <label for="m_treinamento_cargos"
                            class="label-input">{{ __('Positions that will receive the Training') }}</label>
                        <div class="marcarTodos"><input id="marcarTodos" type="checkbox">
                            <label  style="cursor: pointer" for="marcarTodos">MARCAR TODOS</label>
                        </div>
                        <div class=" d-flex justify-between-content flex-wrap">
                            @foreach ($cargos as $cargo)
                                <div class="input col-6">
                                    <input type="checkbox" name="m_treinamento_cargos[]" id="cargo_{{ $cargo->id }}" class="cargo_checkbox"
                                        value="{{ $cargo->id }}">
                                    <label for="cargo_{{ $cargo->id }}"
                                        style="cursor: pointer">{{ $cargo->cargo_descricao }}</label>
                                </div>
                            @endforeach
                        </div>
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
        @include('matriz_treinamentos._components.table_matriz_treinamentos')
    </div>
    <div class="janela-modal" id="janela-modal">
        <div class="modal">
            <button class="fechar" id="fechar">X</button>
            <h3>Selecione o Colaborador</h3>
            <div class="modal-body">

            </div>
        </div>
    </div>

    <script>
        // Inicializar o Select2 no campo de entrada
        $(document).ready(function() {
            $('#m_treinamento_setor_responsavel_id').select2({
                placeholder: 'Digite um valor...',
            });
        });

        $(".id-colaborador").hide();
        document.addEventListener("DOMContentLoaded", function() {
            const title = document.getElementById('title-page-nav');
            const icon = document.querySelector('.icon');
            icon.classList.add('bx-library');
            title.textContent = `{{ __('Training Matrix') }}`;
            title.onclick = function() {
                window.location.href = "{{ route('matriz_treinamentos.index') }}";
            };
        });

        $(document).ready(function() {
            $("#professor_interno").change(function(e) {
                e.preventDefault();
                console.log($(this).val());
                $(".id-colaborador").slideDown();
                abrirModal();
            });


            $('#m_treinamento_tempo').mask('00:00:00');
        });

        // Associa o evento 'change' ao checkbox 'Marcar Todos'
        $(document).on('change', '#marcarTodos', function() {
            $('.cargo_checkbox').prop('checked', $(this).prop('checked'));
        });
    </script>

@endsection
