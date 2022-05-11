<div x-data="{
    labels: ['Time used this month', 'Time remaining this month'],
    timeUsedThisMonth: @entangle('timeUsedForMonth'),
    timeRemaining: @entangle('timeRemaining'),
    init() {
        let chart = new Chart(this.$refs.canvas.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: this.labels,
                datasets: [{
                    data: [this.timeUsedThisMonth, this.timeRemaining],
                    backgroundColor: ['#db2777', '#f3f4f6'],
                }],
            },
            options: {},
        });

        this.$watch('timeUsedThisMonth', () => {
            chart.data.labels = this.labels;
            chart.data.datasets[0].data = [this.timeUsedThisMonth, this.timeRemaining];
            chart.update();
        });
    }
}">
    <canvas x-ref="canvas"></canvas>
</div>
