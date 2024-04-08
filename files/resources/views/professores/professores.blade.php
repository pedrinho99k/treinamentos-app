@extends('layouts.app')

@section('content')

    <div class="bottom-data">
        <div class="reminders w-100" style="display: none">
            <div class="header">
                <i class='bx bx-receipt'></i>
                <h3>{{ __('Add New Teacher') }}</h3>
                <i class='icon-minimizar bx bx-chevron-down'></i>
                <i class='bx bx-x'></i>
            </div>
            <div class="formulario">
                <form method="POST" action="{{ route('professores.store') }}" class="row form-content">
                    @csrf

                    <div class="col-sm-12 col-md-12 col-xxl-12">
                        <input type="checkbox" name="professor_interno" id="professor_interno">
                        <label for="professor_interno" style="cursor: pointer">Colaborador Interno</label>
                    </div>

                    <div class="col-sm-12 col-md-12 col-xxl-12 id-colaborador">
                        <input id="professor_colaborador_id" type="hidden"
                            class="form-input @error('professor_colaborador_id') is-invalid @enderror"
                            name="professor_colaborador_id" autocomplete="professor_colaborador_id"
                            value="{{ old('professor_colaborador_id') }}">
                    </div>

                    <div class="col-sm-12 col-md-12 col-xxl-12">
                        <label for="professor_nome" class="label-input">{{ __('Teacher Name') }}</label>
                        <input id=" professor_nome" type="text"
                            class="form-input colaborador-nome @error('professor_nome') is-invalid @enderror"
                            name="professor_nome" placeholder="{{ __('Teacher Name') }}" autocomplete="professor_nome"
                            autofocus value="{{ old('professor_nome') }}">
                    </div>


                    <div class="col-sm-12 col-md-12 col-xxl-4">
                        <label for="professor_ativo" class="label-input">{{ __('Active teacher') }}</label>
                        <select id="professor_ativo" type="text" class="form-input" name="professor_ativo" required
                            autocomplete="professor_ativo" autofocus>
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
                        <button type="submit" class="button button-primary">
                            {{ __('Save') }}
                        </button>
                    </div>


                </form>
            </div>
        </div>
        @include('professores._components.table_professores')
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
        $(".id-colaborador").hide();
        document.addEventListener("DOMContentLoaded", function() {
            const title = document.getElementById('title-page-nav');
            const icon = document.querySelector('.icon');
            icon.classList.add('bx-group');
            title.textContent = `{{ __("Teacher' s") }}`;
            title.onclick = function() {
                window.location.href = "{{ route('professores.index') }}";
            };
        });

        $(document).ready(function() {
            $("#professor_interno").change(function(e) {
                e.preventDefault();
                console.log($(this).val());
                $(".id-colaborador").slideDown();
                abrirModal();
            });
        });
    </script>

@endsection
