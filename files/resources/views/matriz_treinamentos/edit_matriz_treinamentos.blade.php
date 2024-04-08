@extends('layouts.app')

@section('content')
    <div class="bottom-data">
        <div class="orders">
            <div class="header form-content">
                <button class="button button-transparent" onclick="window.history.back()"><i
                        class='bx bx-chevron-left'></i><span class="text">{{ __('Back') }}</span></button>
                <i class='bx bx-receipt'></i>
                <h5>{{ __('Update Training Matrix') }}:</h5>
                <h3> {{ $matriz_treinamento->m_treinamento_descricao }} </h3>
                <i class='icon-minimizar bx bx-chevron-down'></i>
            </div>
            <div class="formulario">
                <form method="POST" action="{{ route('matriz_treinamentos.update', $matriz_treinamento->id) }}" class="row form-content">
                    @csrf
                    @method('put')

                    <div class="col-sm-12 col-md-12 col-xxl-12">
                        <label for="m_treinamento_descricao"
                            class="label-input">{{ __('Description Training Matrix') }}</label>
                        <input id="m_treinamento_descricao" type="text"
                            class="form-input @error('m_treinamento_descricao') is-invalid @enderror"
                            name="m_treinamento_descricao" placeholder="{{ __('Description Training Matrix') }}"
                            value="{{ $matriz_treinamento->m_treinamento_descricao }}" autocomplete="off" autofocus>
                    </div>

                    <div class="col-sm-12 col-md-12 col-xxl-12">
                        <label for="m_treinamento_tempo" class="label-input">{{ __('Training time') }}</label>
                        <input id="m_treinamento_tempo" type="text"
                            class="form-input @error('m_treinamento_tempo') is-invalid @enderror" name="m_treinamento_tempo"
                            placeholder="HH:MM" value="{{ $matriz_treinamento->m_treinamento_tempo }}" autocomplete="off">
                    </div>

                    <div class="col-sm-12 col-md-12 col-xxl-12">
                        <label for="m_treinamento_setor_responsavel_id"
                            class="label-input">{{ __('Responsible sector') }}</label>
                        <select id="m_treinamento_setor_responsavel_id" type="text" class="form-input"
                            name="m_treinamento_setor_responsavel_id">
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

                    <div class="col-sm-12 col-md-12 col-xxl-12">
                        <label for="m_treinamento_cargos"
                            class="label-input">{{ __('Positions that will receive the Training') }}</label>
                        <div class=" d-flex justify-between-content flex-wrap">
                            @foreach ($cargos as $cargo)
                                <div class="input col-6">
                                    <input type="checkbox" name="m_treinamento_cargos[]" id="cargo_{{ $cargo->id }}"
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
            selectOptionSetor("{{ $matriz_treinamento->m_treinamento_setor_responsavel_id }}");
            selectOptionAtivo("{{ $matriz_treinamento->m_treinamento_ativo }}");
            CheckBoxObrigatorio("{{ $matriz_treinamento->m_treinamento_obrigatorio }}");
            CheckBoxAvaliacao("{{ $matriz_treinamento->m_treinamento_obrigatorio_avaliacao_eficacia }}");
            CheckBoxCargos(@json($matriz_treinamento->cargos));
            $('#m_treinamento_tempo').mask('00:00:00');


        });

        document.addEventListener("DOMContentLoaded", function() {
            const title = document.getElementById('title-page-nav');
            const icon = document.querySelector('.icon');
            icon.classList.add('bx-library');
            title.textContent = `{{ __('Training Matrix') }}`;
            title.onclick = function() {
                window.location.href = "{{ route('matriz_treinamentos.index') }}";
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

        function CheckBoxCargos(cargos) {

            // Iterar sobre cada checkbox
            $("input[name='m_treinamento_cargos[]']").each(function() {
                const checkbox = $(this);
                const valorDoCheckbox = checkbox.val();

                // Verificar se o valor do checkbox está presente na lista de cargos selecionados
                if (cargos.some(cargo => cargo.m_cargo_id == valorDoCheckbox)) {
                    checkbox.prop("checked", true); // Marcar o checkbox se estiver na lista
                } else {
                    checkbox.prop("checked", false); // Desmarcar o checkbox se não estiver na lista
                }
            });
        }
    </script>
@endsection
