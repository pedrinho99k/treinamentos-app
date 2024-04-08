@extends('layouts.app')

@section('content')
    <!-- Insights -->
    <ul class="insights">
        <li onclick="window.location.href ='{{ route('setores.index') }}'">
            <i class='bx bx-map'></i>
            <span class="info">
                <h3>{{ __('Sectors') }}</h3>
                <p>{{ __('To manage') }}</p>
            </span>
        </li>
        <li onclick="window.location.href ='{{ route('cargos.index') }}'">
            <i class='bx bxs-user-badge'></i>
            <span class="info">
                <h3>{{ __('Positions') }}</h3>
                <p>{{ __('To manage') }}</p>
            </span>
        </li>
        <li onclick="window.location.href ='{{ route('dashboard') }}'">
            <i class='bx bx-calendar-check'></i>
            <span class="info">
                <h3>1,074</h3>
                <p>{{ __('Paid Order') }}</p>
            </span>
        </li>
        <li onclick="window.location.href ='{{ route('dashboard') }}'">
            <i class='bx bx-calendar-check'></i>
            <span class="info">
                <h3>1,074</h3>
                <p>{{ __('Paid Order') }}</p>
            </span>
        </li>
    </ul>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const title = document.getElementById('title-page-nav');
            const icon = document.querySelector('.icon');
            icon.classList.add('bx-cog');
            title.textContent = "{{ __('Settings') }}";

            title.onclick = function() {
                window.location.href = "{{ route('settings') }}";
            };
        });
    </script>
@endsection
