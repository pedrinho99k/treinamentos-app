@extends('layouts.app')

@section('title', 'Presenças')

@section('content')

    <div class="bottom-data ">
        <div class="reminders reminders-presenca">
            <div class="header">
                <div class="sub-header">
                    <i class='bx bx-receipt'></i>
                </div>
                <div class="sub-header">
                    <h4>{{ __('Register Attendance') }}</h4>
                </div>
                <div class="sub-header">
                    <i class='icon-minimizar bx bx-chevron-down'></i>
                    <i class='bx bx-x'></i>
                </div>
            </div>
            <div class="formulario">
                <form method="POST" action="{{ route('lista_presenca.store') }}" class="row form-content">
                    @csrf
                    <input type="hidden" class="form-input" name="lp_treinamento_id" id="lp_treinamento_id" value="{{ $treinamento->id }}">

                    <input type="hidden" class="form-input" name="lp_colaborador_id" id="lp_colaborador_id">

                    <div class="col-sm-12 col-md-12 col-xxl-3">
                        <label for="colaborador_codigo_esocial" class="label-input">{{ __('Code eSocial') }}</label>
                        <input type="text" class="form-input" name="colaborador_codigo_esocial" id="colaborador_codigo_esocial">
                    </div>

                    <div class="col-sm-12 col-md-12 col-xxl-9">
                        <label for="colaborador_nome" class="label-input">{{ __('Collaborator Name') }}</label>
                        <input type="text" class="form-input" name="colaborador_nome" id="colaborador_nome">
                    </div>

                    <div class="col-sm-12 col-md-12 col-xxl-12">
                        <button class="button button-primary botao-filtrar-treinamentos w-100">
                            <i class='bx bx-search'></i>
                            <span class="text">{{ __('Search') }}</span>
                        </button>
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
                        <button type="submit" class="button button-primary w-100 button-salvar">
                            {{ __('Save') }}
                        </button>
                    </div>

                </form>
            </div>
        </div>
        @include('lista_presenca.components.table_lista_presenca')
    </div>
    <div class="janela-modal" id="janela-modal">
        <div class="modal">
            <button class="fechar" id="fechar">X</button>
            <h3>Selecione o Colaborador</h3>
            <div class="modal-body">
                @include('colaboradores._components.table_selecionar_colaboradores')
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const title = document.getElementById('title-page-nav');
            const icon = document.querySelector('.icon');
            icon.classList.add('bx-book-bookmark');
            title.textContent = `{{ __('Trainings') }}`;
            title.onclick = function() {
                window.location.href = "{{ route('treinamentos.index') }}";
            };
        });

        $(document).ready(function () {
            $('.button-salvar').hide();
        });

    </script>

@endsection
