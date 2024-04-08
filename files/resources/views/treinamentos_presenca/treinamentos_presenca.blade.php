@extends('layouts.app')

@section('title', 'Presenças')

@section('content')


<div class="bottom-data ">
    <div class="reminders reminders-presenca">
        <div class="header">
            <div class="sub-header">
                <button class="button button-transparent" onclick="window.history.back()">
                <i class='bx bx-chevron-left'></i><span class="text">{{ __('Back') }}</span></button>
            </div>
            <div class="sub-header">
                <h4>{{ __('Register Attendance') }}</h4>
            </div>
        </div>
    <div class="formulario">

    <form method="POST" action="{{ route('treinamento_presenca.update') }}">
        @csrf
            @include('treinamentos_presenca.components.table_treinamentos_presenca')
            <button type="submit" class="button button-primary w-100 h-25">Salvar</button>
    </form>

    </div>
    <div class="janela-modal" id="janela-modal">
        <div class="modal">
            <button class="fechar" id="fechar">X</button>
            <h3>Selecione o Colaborador</h3>
            <div class="modal-body">
                {{-- @include('colaboradores._components.table_selecionar_colaboradores') --}}
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
