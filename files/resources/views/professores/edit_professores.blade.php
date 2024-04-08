@extends('layouts.app')

@section('content')
    <div class="bottom-data">
        <div class="orders">
            <div class="header form-content">
                <button class="button button-transparent" onclick="window.history.back()"><i
                        class='bx bx-chevron-left'></i><span class="text">{{ __('Back') }}</span></button>
                <i class='bx bx-receipt'></i>
                <h3>{{ __('Update Teacher') }}: {{ $professor->professor_nome }}</h3>
                <i class='icon-minimizar bx bx-chevron-down'></i>
            </div>
            <div class="formulario">
                <form method="POST" action="{{ route('professores.update', $professor->id) }}"
                    class="row form-content">
                    @csrf
                    @method('put')

                    <div class="col-sm-12 col-md-12 col-xxl-12">
                        <label for="professor_nome" class="label-input">{{ __('Teacher Name') }}</label>
                        <input id=" professor_nome" type="text"
                            class="form-input colaborador-nome @error('professor_nome') is-invalid @enderror"
                            name="professor_nome" placeholder="{{ __('Teacher Name') }}" autocomplete="professor_nome"
                            autofocus value="{{ $professor->professor_nome }}">
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
    </div>
    <script>
        $(document).ready(function() {
            selectOptionAtivo("{{ $professor->professor_ativo }}");
        });

        document.addEventListener("DOMContentLoaded", function() {
            const title = document.getElementById('title-page-nav');
            const icon = document.querySelector('.icon');
            icon.classList.add('bx-group');
            title.textContent = `{{ __("Teacher' s") }}`;

            title.onclick = function() {
                window.location.href = "{{ route('professores.index') }}";
            };
        });

        function selectOptionAtivo(value) {
            let select = $("#professor_ativo");
            let option = select.find("option[value='" + value + "']");
            option.prop("selected", true);
        }
    </script>
@endsection
