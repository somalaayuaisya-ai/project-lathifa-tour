import ApexCharts from 'apexcharts';

document.addEventListener('alpine:init', () => {
    Alpine.data('chartComponent', ({ initialData }) => ({
        chart: null,
        chartData: initialData,

        initChart() {
            const options = {
                series: this.chartData.series,
                chart: {
                    height: 350,
                    type: 'bar',
                    toolbar: { show: false },
                    zoom: { enabled: false },
                },
                plotOptions: {
                    bar: {
                        borderRadius: 10,
                        horizontal: false,
                        columnWidth: '50%',
                    },
                },
                dataLabels: {
                    enabled: false,
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent'],
                },
                xaxis: {
                    categories: this.chartData.categories,
                    labels: {
                        style: {
                            colors: '#6b7280', // text-gray-500
                            fontSize: '12px',
                            fontFamily: 'Plus Jakarta Sans, sans-serif',
                        },
                    },
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: '#6b7280',
                            fontFamily: 'Plus Jakarta Sans, sans-serif',
                        },
                    },
                },
                fill: {
                    opacity: 1,
                    colors: ['#14b8a6'], // primary-500
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return val + " inquiries";
                        }
                    },
                    theme: 'dark'
                },
                grid: {
                    borderColor: '#f3f4f6', // gray-100
                    strokeDashArray: 4,
                }
            };

            this.chart = new ApexCharts(this.$refs.chart, options);
            this.chart.render();
        },

        updateChart(newData) {
            this.chart.updateOptions({
                series: newData.series,
                xaxis: {
                    categories: newData.categories
                }
            });
        }
    }));
});
