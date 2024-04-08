@extends('layouts.app')

@section('content')
    <div class="bottom-data">

        <div class="reminders" style="display: none">
            <div class="header">
                <i class='bx bx-receipt'></i>
                <h3>{{ __('Add New Office') }}</h3>
                <i class='icon-minimizar bx bx-chevron-down'></i>
                <i class='bx bx-x'></i>
            </div>
            <div class="formulario">
                <form method="POST" action="{{ route('cargos.store') }}" class="row form-content">
                    @csrf

                    <div class="col-sm-12 col-md-12 col-xxl-9">
                        <label for="cargo_descricao" class="label-input">{{ __('Name') }}</label>
                        <input id="cargo_descricao" type="text"
                            class="form-input @error('cargo_descricao') is-invalid @enderror" name="cargo_descricao"
                            required autocomplete="cargo_descricao" autofocus>
                    </div>

                    <div class="col-sm-12 col-md-12 col-xxl-3">
                        <label for="cargo_ativo" class="label-input">{{ __('Office Activo') }}</label>
                        <select id="cargo_ativo" type="text" class="form-input" name="cargo_ativo" required
                            autocomplete="cargo_ativo" autofocus>
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
        @include('settings.cargos._components.table_cargos')
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const title = document.getElementById('title-page-nav');
            const icon = document.querySelector('.icon');
            icon.classList.add('bxs-user-badge');
            title.textContent = "{{ __('Positions') }}";

            title.onclick = function() {
                window.location.href = "{{ route('cargos.index') }}";
            };
        });
    </script>
@endsection
