@extends('layouts.app')

@section('title', 'Treinamentos')

@section('content')

    <div class="bottom-data ">
        <div class="reminders" style="display: none">
            <div class="header">
                <div class="sub-header">
                    <i class='bx bx-receipt'></i>
                </div>
                <div class="sub-header">
                    <h4>{{ __('Conduct New Training') }}</h4>
                </div>
                <div class="sub-header">
                    <i class='icon-minimizar bx bx-chevron-down'></i>
                    <i class='bx bx-x'></i>
                </div>
            </div>
            <div class="formulario">
                <form method="POST" action="{{ route('treinamentos.store') }}" class="row form-content">
                    @csrf

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

                    <div class="col-sm-12 col-md-12 col-xxl-12">
                        <label for="treinamento_m_treinamento_id" class="label-input">{{ __('Training/Course') }}</label>
                        <select id="treinamento_m_treinamento_id" type="text" class="form-input"
                            name="treinamento_m_treinamento_id" required>
                        </select>
                    </div>

                    <div class="col-sm-12 col-md-12 col-xxl-12">
                        <label for="treinamento_data" class="label-input">{{ __('Training date') }}</label>
                        <input id="treinamento_data" type="date"
                            class="form-input @error('treinamento_data') is-invalid @enderror" name="treinamento_data"
                            placeholder="00/00/0000" value="{{ old('treinamento_data') }}" autocomplete="off" required>
                    </div>

                    <div class="col-sm-12 col-md-12 col-xxl-12">
                        <label for="treinamento_carga_horaria" class="label-input">{{ __('Training time') }}</label>
                        <input id="treinamento_carga_horaria" type="text"
                            class="form-input @error('treinamento_carga_horaria') is-invalid @enderror"
                            name="treinamento_carga_horaria" placeholder="HH:MM:SS"
                            value="{{ old('treinamento_carga_horaria') }}">
                    </div>

                    <div id="mensagemErro" style="display: none;color: red;">Nenhum cargo selecionado</div>

                    <div class="col-sm-12 col-md-12 col-xxl-12">
                        <label class="label-input" for="m_treinamento_cargos">{{ __('Positions that will receive the Training') }}</label>
                        <div class="d-flex justify-between-content flex-wrap">
                            <div class="input col-12" id="treinamento_cargos"></div>
                            <input type="hidden" id="cargo_id" name="cargo_id">
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-12 col-xxl-12">
                        <label for="treinamento_observacoes" class="label-input">{{ __('Comments') }}</label>
                        <textarea rows="3" id="treinamento_observacoes"
                            class="form-input @error('treinamento_observacoes') is-invalid @enderror" name="treinamento_observacoes"
                            value="{{ old('treinamento_observacoes') }}" autocomplete="off"></textarea>
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
                        <button id="submit" type="submit" class="button button-primary w-100">
                            {{ __('Save') }}
                        </button>
                    </div>

                </form>
            </div>
        </div>
        @include('treinamentos._components.table_treinamentos')
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
        $(document).ready(function() {
            $('#treinamento_setor_responsavel_id').select2({
                placeholder: 'Digite um valor...',
                language: {
                    noResults: function() {
                        return 'Nenhum resultado encontrado';
                    }
                }
            });

            $('#treinamento_professor_id').select2({
                placeholder: 'Digite um valor...',
                language: {
                    noResults: function() {
                        return 'Nenhum resultado encontrado';
                    }
                }
            });

            $('#treinamento_m_treinamento_id').select2({
                placeholder: 'Digite um valor...',
                language: {
                    noResults: function() {
                        return 'Nenhum resultado encontrado';
                    }
                }
            });
        });


        // Função para buscar e preencher a matriz de treinamentos
        function buscarMatrizTreinamentos() {
            var setorId = $('#treinamento_setor_responsavel_id').val();

            $.ajax({
                url: "{{ route('buscar_matriz') }}",
                method: 'GET',
                data: {
                    setor_id: setorId
                },
                success: function(response) {
                    var matrizSelect = $('#treinamento_m_treinamento_id');
                    matrizSelect.empty();

                    $.each(response, function(index, matriz) {
                        matrizSelect.append($('<option>', {
                            value: matriz.id,
                            text: matriz.id + " - " + matriz.m_treinamento_descricao
                        }));
                    });
                    preencherTempoTreinamento();

                    preencherCargoTreinamento();
                }
            });
        }

        function preencherTempoTreinamento() {
            var m_treinamento_id = $('#treinamento_m_treinamento_id').val();

            $.ajax({
                url: "{{ route('buscar_matriz_id') }}",
                method: 'GET',
                data: {
                    matriz_id: m_treinamento_id
                },
                success: function(response) {
                    if (response.length > 0) {
                        $('#treinamento_carga_horaria').val(response[0]['m_treinamento_tempo']);
                    }
                }
            });
        }

        function checkboxIdFunction() {
            var cargos_selecionados = document.getElementById(checkboxId);

            if (cargos_selecionados.checked) {
                console.log(cargos_selecionados.value);
            } else {
                console.log("ERROR CHECKBOX");
            }
        };

        function preencherCargoTreinamento() {
            var m_treinamento_id = $('#treinamento_m_treinamento_id').val();

            $('#treinamento_cargos').empty();

            $.ajax({
                url: "{{ route('buscar_matriz_cargo') }}",
                method: 'GET',
                data: {
                    matriz_id: m_treinamento_id
                },
                success: function(response) {


                    var cargo = response.cargo;

                    var colaboradores_cargos = response.colaboradores_cargos;

                    var cargosSelecionados = [];

                    cargo.forEach(function(obj) {
                        // console.log(obj['id'] + obj['cargo_descricao']);

                        let checkboxId = 'checkboxCargos_' + obj['id']; // Cria um ID único

                        $('#treinamento_cargos').append(
                            '<input id="' + checkboxId + '" type="checkbox" value="' + obj['id'] + '" v><label>' + obj['cargo_descricao'] + '</label><br>'
                        );

                        cargosSelecionados.push(obj['id']);

                    });
                }
            })
        }

        // Chame a função quando a página é carregada
        $(document).ready(function() {
            buscarMatrizTreinamentos();
            $('#treinamento_carga_horaria').mask('00:00:00');
        });

        // Chame a função quando o campo treinamento_setor_responsavel_id é alterado
        $('#treinamento_setor_responsavel_id').on('change', function() {
            buscarMatrizTreinamentos();
        });

        $('#treinamento_m_treinamento_id').on('change', function() {
            preencherTempoTreinamento();
        });

        $('#treinamento_m_treinamento_id').on('change', function() {
            preencherCargoTreinamento();
        });

        $('#submit').click(function() {
            var cargosSelecionados =[];

            $('#treinamento_cargos input[type="checkbox"]:checked').each(function() {
                // console.log($(this).val());

                cargosSelecionados.push($(this).val());
            });

            $('#cargo_id').val(cargosSelecionados.join(','));

            if (cargosSelecionados == 0) {
                event.preventDefault();
                document.getElementById('mensagemErro').style.display = 'block';
                // alert("Nenhum cargo selecionado");
                // setTimeout(() => {
                //     document.getElementById('mensagemErro').style.display = 'none';
                // }, 5000);
            }
        });


        document.addEventListener("DOMContentLoaded", function() {
            const title = document.getElementById('title-page-nav');
            const icon = document.querySelector('.icon');
            icon.classList.add('bx-book-bookmark');
            title.textContent = `{{ __('Trainings') }}`;
            title.onclick = function() {
                window.location.href = "{{ route('treinamentos.index') }}";
            };
        });
    </script>

@endsection
