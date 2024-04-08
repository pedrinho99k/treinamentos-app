@extends('layouts.app')

@section('content')
    <div class="bottom-data">
        <div class="orders">
            <div class="header form-content">
                <button class="button button-transparent" onclick="window.history.back()"><i
                        class='bx bx-chevron-left'></i><span class="text">{{ __('Back') }}</span></button>
                <i class='bx bx-receipt'></i>
                <h3>{{ __('Update Sector') }}: {{ $setor->setor_descricao }}</h3>
                <i class='icon-minimizar bx bx-chevron-down'></i>
            </div>
            <div class="formulario">
                <form method="POST" action="{{ route('setores.update', $setor->id) }}" class="row form-content w-50">
                    @csrf
                    @method('put')
                    <div class="col-8">
                        <label for="setor_descricao" class="label-input">{{ __('Name') }}</label>
                        <input id="setor_descricao" type="text"
                            class="form-input @error('setor_descricao') is-invalid @enderror" name="setor_descricao"
                            value="{{ $setor->setor_descricao }}" required autocomplete="setor_descricao" autofocus>
                    </div>

                    <div class="col-4">
                        <label for="setor_ativo" class="label-input">{{ __('Sector Activo') }}</label>
                        <select id="setor_ativo" type="text" class="form-input" name="setor_ativo" required autofocus>
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

                    <div class="col-12 ">
                        <button type="submit" class="button button-primary w-50">
                            {{ __('Save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            selectOption("{{ $setor->setor_ativo }}");
        });

        document.addEventListener("DOMContentLoaded", function() {
            const title = document.getElementById('title-page-nav');
            const icon = document.querySelector('.icon');
            icon.classList.add('bx-map');
            title.textContent = "{{ __('Sectors') }}";

            title.onclick = function() {
                window.location.href = "{{ route('setores.index') }}";
            };
        });

        function selectOption(value) {
            let select = $("#setor_ativo");
            let option = select.find("option[value='" + value + "']");
            option.prop("selected", true);
        }
    </script>
@endsection
