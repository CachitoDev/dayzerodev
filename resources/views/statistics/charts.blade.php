<x-app-layout title="{{ __('Estadisticas') }}">
    <div class="container grid px-6 mx-auto">
        <canvas id="myChart"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($citizensByLeaderChart['labels']),
                datasets: [{
                    label: 'Canjes por lider',
                    data: @json($citizensByLeaderChart['data']),
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</x-app-layout>
