@extends('layouts.app')

@section('content')

    <!-- Insights -->
    <ul class="insights">
        <li>
            <i class='bx bx-calendar-check'></i>
            <span class="info">
                <h3>1,074</h3>
                <p>{{ __('Paid Order') }}</p>
            </span>
        </li>
        <li>
            <i class='bx bx-show-alt'></i>
            <span class="info">
                <h3>1,074</h3>
                <p>{{ __('Paid Order') }}</p>
            </span>
        </li>
        <li>
            <i class='bx bx-line-chart'></i>
            <span class="info">
                <h3>1,074</h3>
                <p>{{ __('Paid Order') }}</p>
            </span>
        </li>
        <li>
            <i class='bx bx-dollar'></i>
            <span class="info">
                <h3>1,074</h3>
                <p>{{ __('Paid Order') }}</p>
            </span>
        </li>
    </ul>
    <!-- End Insights -->
    <div class="bottom-data">
        <div class="orders">
            <div class="header">
                <i class='bx bx-receipt'></i>
                <h3>{{ __('Add New Training Matrix') }}</h3>
                <i class='bx bx-filter'></i>
                <i class='bx bx-search'></i>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>{{ __('User') }}</th>
                        <th>{{ __('Order Date') }}</th>
                        <th>{{ __('Status') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <img src="{{ asset('img/profile-1.jpg') }}" alt="">
                            <p>John Doe</p>
                        </td>
                        <td>14/08/2023</td>
                        <td><span class="status completed">{{ __('Completed') }}</span></td>
                    </tr>
                    <tr>
                        <td>
                            <img src="{{ asset('img/profile-1.jpg') }}" alt="">
                            <p>John Doe</p>
                        </td>
                        <td>14/08/2023</td>
                        <td><span class="status pending">{{ __('Pending') }}</span></td>
                    </tr>
                    <tr>
                        <td>
                            <img src="{{ asset('img/profile-1.jpg') }}" alt="">
                            <p>John Doe</p>
                        </td>
                        <td>14/08/2023</td>
                        <td><span class="status process">{{ __('Process') }}</span></td>
                    </tr>
                    <tr>
                        <td>
                            <img src="{{ asset('img/profile-1.jpg') }}" alt="">
                            <p>John Doe</p>
                        </td>
                        <td>14/08/2023</td>
                        <td><span class="status process">{{ __('Process') }}</span></td>
                    </tr>
                    <tr>
                        <td>
                            <img src="{{ asset('img/profile-1.jpg') }}" alt="">
                            <p>John Doe</p>
                        </td>
                        <td>14/08/2023</td>
                        <td><span class="status process">{{ __('Process') }}</span></td>
                    </tr>
                    <tr>
                        <td>
                            <img src="{{ asset('img/profile-1.jpg') }}" alt="">
                            <p>John Doe</p>
                        </td>
                        <td>14/08/2023</td>
                        <td><span class="status process">{{ __('Process') }}</span></td>
                    </tr>
                    <tr>
                        <td>
                            <img src="{{ asset('img/profile-1.jpg') }}" alt="">
                            <p>John Doe</p>
                        </td>
                        <td>14/08/2023</td>
                        <td><span class="status process">{{ __('Process') }}</span></td>
                    </tr>
                    <tr>
                        <td>
                            <img src="{{ asset('img/profile-1.jpg') }}" alt="">
                            <p>John Doe</p>
                        </td>
                        <td>14/08/2023</td>
                        <td><span class="status process">{{ __('Process') }}</span></td>
                    </tr>
                    <tr>
                        <td>
                            <img src="{{ asset('img/profile-1.jpg') }}" alt="">
                            <p>John Doe</p>
                        </td>
                        <td>14/08/2023</td>
                        <td><span class="status process">{{ __('Process') }}</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- Reminders -->
        <div class="reminders">
            <div class="header">
                <i class='bx bx-note'></i>
                <h3>{{ __('Reminders') }}</h3>
                <i class='bx bx-filter'></i>
                <i class='bx bx-plus'></i>
            </div>
            <ul class="task-list">
                <li class="completed">
                    <div class="task-title">
                        <i class='bx bx-check-circle'></i>
                        <p>{{ __('Start Our Meeting') }}</p>
                    </div>
                    <i class='bx bx-dots-vertical-rounded'></i>
                </li>
                <li class="completed">
                    <div class="task-title">
                        <i class='bx bx-check-circle'></i>
                        <p>{{ __('Analyse Our Site') }}</p>
                    </div>
                    <i class='bx bx-dots-vertical-rounded'></i>
                </li>
                <li class="not-completed">
                    <div class="task-title">
                        <i class='bx bx-x-circle'></i>
                        <p>{{ __('Play Footbal') }}</p>
                    </div>
                    <i class='bx bx-dots-vertical-rounded'></i>
                </li>
            </ul>
        </div>
        <!-- End of Reminders -->

    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
        const title = document.getElementById('title-page-nav');
        const icon = document.querySelector('.icon');
        icon.classList.add('bxs-dashboard');
        title.textContent = "{{ __('Dashboard') }}";
    });
    </script>
@endsection
