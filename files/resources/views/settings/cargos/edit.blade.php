@extends('layouts.app')

@section('content')
    <div class="bottom-data">
        <div class="orders">
            <div class="header form-content">
                <button class="button button-transparent" onclick="window.history.back()"><i
                        class='bx bx-chevron-left'></i><span class="text">{{ __('Back') }}</span></button>
                <i class='bx bx-receipt'></i>
                <h3>{{ __('Update Office') }}: {{ $cargo->cargo_descricao }}</h3>
                <i class='icon-minimizar bx bx-chevron-down'></i>
            </div>
            <div class="formulario">
                <form method="POST" action="{{ route('cargos.update', $cargo->id) }}" class="row w-50 form-content">
                    @csrf
                    @method('put')
                    <div class="col-8">
                        <label for="cargo_descricao" class="label-input">{{ __('Name') }}</label>
                        <input id="cargo_descricao" type="text"
                            class="form-input @error('cargo_descricao') is-invalid @enderror" name="cargo_descricao"
                            value="{{ $cargo->cargo_descricao }}" required autocomplete="cargo_descricao" autofocus>
                    </div>

                    <div class="col-4">
                        <label for="cargo_ativo" class="label-input">{{ __('Sector Activo') }}</label>
                        <select id="cargo_ativo" type="text" class="form-input" name="cargo_ativo" required autofocus>
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
            selectOption("{{ $cargo->cargo_ativo }}");
        });

        document.addEventListener("DOMContentLoaded", function() {
            const title = document.getElementById('title-page-nav');
            const icon = document.querySelector('.icon');
            icon.classList.add('bxs-user-badge');
            title.textContent = "{{ __('Positions') }}";

            title.onclick = function() {
                window.location.href = "{{ route('cargos.index') }}";
            };
        });

        function selectOption(value) {
            let select = $("#cargo_ativo");
            let option = select.find("option[value='" + value + "']");
            option.prop("selected", true);
        }
    </script>
@endsection
