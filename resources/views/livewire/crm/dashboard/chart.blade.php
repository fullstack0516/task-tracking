<x-card>
    <div id="chart"></div>
    <script>
        var options = {
            series: [{
                name: 'Prospects',
                data: [{!! implode(',', $prospectsByMonth) !!}],
            }, {
                name: 'Clients',
                data: [{!! implode(',', $clientsByMonth) !!}],
            }],
            chart: {
                height: 350,
                type: 'area',
                toolbar: {
                    show: false,
                },
                selection: {
                    enabled: false,
                },
            },
            dataLabels: {
                enabled: false,
            },
            stroke: {
                curve: 'smooth',
            },
            xaxis: {
                type: 'text',
                categories: ['{!! implode("','", $chartHeaders) !!}'],
            },
            tooltip: {
                x: {
                    format: 'dd/MM/yy HH:mm',
                },
            },
        };

        var chart = new ApexCharts(document.querySelector('#chart'), options);
        chart.render();
    </script>
</x-card>
