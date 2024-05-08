@extends('layouts.app')

@section('title', 'Treinamentos')

@section('content')

    <div class="bottom-data">
        <div class="orders">
            <div class="header form-content">
                <button class="button button-transparent" onclick="window.history.back()"><i
                        class='bx bx-chevron-left'></i><span class="text">{{ __('Back') }}</span></button>
                <div class="header form-content">
                    <i class='bx bx-receipt'></i>
                    <h5>{{ __('Update Training') }} : 
                        {{ $descricao }}
                    </h5>
                </div>

                <i class='icon-minimizar bx bx-chevron-down'></i>
            </div>
            <div class="formulario">
                <form method="POST" action="{{ route('treinamentos.update', $treinamento->id) }}" class="row form-content">
                    @csrf
                    @method('put')

                    <div class="col-sm-12 col-md-12 col-xxl-12">
                        <label for="treinamento_setor_responsavel_id"
                            class="label-input">{{ __('Responsible sector') }}</label>
                        <select id="treinamento_setor_responsavel_id" type="text" class="form-input"
                            name="treinamento_setor_responsavel_id" required>
                            @foreach ($setores as $setor)
                                <option value="{{ $setor->id }}">{{ $setor->id }} - {{ $setor->setor_descricao }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-sm-12 col-md-12 col-xxl-12">
                        <label for="treinamento_professor_id" class="label-input">{{ __('Teacher') }}</label>
                        <select id="treinamento_professor_id" type="text" class="form-input"
                            name="treinamento_professor_id" required>
                            @foreach ($professores as $professor)
                                <option value="{{ $professor->id }}">{{ $professor->id }} - {{ $professor->professor_nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- <div class="col-sm-12 col-md-12 col-xxl-12">
                        <label for="treinamento_m_treinamento_id" class="label-input">{{ __('Training/Course') }}</label>
                        <select id="treinamento_m_treinamento_id" type="text" class="form-input"
                            name="treinamento_m_treinamento_id" required>
                        </select>
                    </div> --}}

                    <div class="col-sm-12 col-md-12 col-xxl-12">
                        <label for="treinamento_data" class="label-input">{{ __('Training date') }}</label>
                        <input id="treinamento_data" type="date"
                            class="form-input @error('treinamento_data') is-invalid @enderror" name="treinamento_data"
                            placeholder="00/00/0000" value="{{ $treinamento->treinamento_data }}" autocomplete="off" required>
                    </div>

                    <div class="col-sm-12 col-md-12 col-xxl-12">
                        <label for="m_treinamento_tempo" class="label-input">{{ __('Training time') }}</label>
                        <input id="m_treinamento_tempo" type="text"
                            class="form-input @error('m_treinamento_tempo') is-invalid @enderror" name="m_treinamento_tempo"
                            placeholder="HH:MM:SS" value="{{ $treinamento->treinamento_carga_horaria }}" autocomplete="off">
                    </div>

                    {{-- <div class="col-sm-12 col-md-12 col-xxl-12 d-flex justify-between-content">
                        <div class="input col-6">
                            <input type="checkbox" name="m_treinamento_obrigatorio" id="m_treinamento_obrigatorio"
                                value="SIM">
                            <label for="m_treinamento_obrigatorio" class="label-input"
                                style="cursor: pointer">{{ __('Mandatory Training') }}</label>
                        </div>
                    </div> --}}

                    <div class="col-sm-12 col-md-12 col-xxl-12">
                        <label class="label-input" for="m_treinamento_cargos">
                            {{ __('Positions that will receive the Training') }}
                        </label>
                        <div class="d-flex justify-between-content flex-wrap select-none input col-12" id="cargos" >
                            <div class="input col-12">
                                <div class="marcarTodos">
                                    <input id="marcarTodos" type="checkbox">
                                    <label for="marcarTodos">MARCAR TODOS</label>
                                </div>
                                @foreach ($cargos as $cargo)
                                    <input type="checkbox" name="m_treinamento_cargos[]" id="cargo_{{ $cargo['id'] }}" value="{{ $cargo['id'] }}">
                                    <label class="checkbox" for="cargo_{{ $cargo['id'] }}">{{ $cargo['cargo_descricao'] }}</label>
                                    <br>
                                @endforeach  
                            </div>                        
                        </div>
                    </div>

                    {{-- <div>
                        <div class="input col-6">
                            <input type="checkbox" name="m_treinamento_obrigatorio_avaliacao_eficacia"
                                id="m_treinamento_obrigatorio_avaliacao_eficacia" value="SIM">
                            <label for="m_treinamento_obrigatorio_avaliacao_eficacia" class="label-input"
                                style="cursor: pointer">{{ __('Mandatory Effectiveness Assessment') }}</label>
                        </div>
                    </div> --}}
               

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
    </div>
    <script>
        $(document).ready(function() {
            selectOptionSetor("{{ $treinamento->m_treinamento_setor_responsavel_id }}");
            selectOptionAtivo("{{ $treinamento->m_treinamento_ativo }}");
            CheckBoxObrigatorio("{{ $treinamento->m_treinamento_obrigatorio }}");
            CheckBoxAvaliacao("{{ $treinamento->m_treinamento_obrigatorio_avaliacao_eficacia }}");
            CheckBoxCargos(@json($treinamento_registro));


        });

        document.addEventListener("DOMContentLoaded", function() {
            const title = document.getElementById('title-page-nav');
            const icon = document.querySelector('.icon');
            icon.classList.add('bx-library');
            title.textContent = `{{ __('Training') }}`;
            title.onclick = function() {
                window.location.href = "{{ route('treinamentos.index') }}";
            };
        });

        function selectOptionAtivo(value) {
            let select = $("#professor_ativo");
            let option = select.find("option[value='" + value + "']");
            option.prop("selected", true);
        }

        function selectOptionSetor(value) {
            let select = $("#m_treinamento_setor_responsavel_id");
            let option = select.find("option[value='" + value + "']");
            option.prop("selected", true);
        }

        function CheckBoxObrigatorio(value) {
            let input = $("#m_treinamento_obrigatorio");
            if (value === "SIM") {
                input.prop("checked", true);
            }
        }

        function CheckBoxAvaliacao(value) {
            let input = $("#m_treinamento_obrigatorio_avaliacao_eficacia");
            if (value === "SIM") {
                input.prop("checked", true);
            }
        }

        function CheckBoxCargos(treinamento_registro) {

            // Iterar sobre cada checkbox
            $("input[name='m_treinamento_cargos[]']").each(function() {
                const checkbox = $(this);
                const valorDoCheckbox = checkbox.val();

                // Verificar se o valor do checkbox está presente na lista de cargos selecionados
                if (treinamento_registro.includes(parseInt(valorDoCheckbox))) {
                    checkbox.prop("checked", true); // Marcar o checkbox se estiver na lista
                } else {
                    checkbox.prop("checked", false); // Desmarcar o checkbox se não estiver na lista
                }
            });
        }

        // Associa o evento 'change' ao checkbox 'Marcar Todos'
        $(document).on('change', '#marcarTodos', function() {
            $('#cargos input[type="checkbox"]').prop('checked', $(this).prop('checked'));
        });

    </script>
@endsection