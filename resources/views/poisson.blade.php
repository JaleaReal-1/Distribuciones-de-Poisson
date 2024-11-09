<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Distribución de Poisson</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4 text-primary">Distribución de Poisson</h1>

    <div class="card bg-light p-4 shadow-sm border-0">
        <div class="card-body">
            <form id="poissonForm" class="needs-validation" novalidate>
                <div class="mb-3">
                    <label for="mu" class="form-label">Promedio de eventos esperados (μ):</label>
                    <input type="number" step="0.1" class="form-control" id="mu" placeholder="Ingresa el valor de μ" required>
                </div>

                <div class="mb-3">
                    <label for="option" class="form-label">Selecciona una opción:</label>
                    <select class="form-select" id="option" required>
                        <option value="1">Calcular probabilidad de un número específico de eventos</option>
                        <option value="2">Calcular probabilidad acumulada de hasta cierto número de eventos</option>
                        <option value="3">Graficar la distribución de Poisson para un rango de eventos</option>
                    </select>
                </div>

                <!-- Entrada para número específico de eventos -->
                <div id="specificEventInput" class="mb-3">
                    <label for="x" class="form-label">Número de eventos (x):</label>
                    <input type="number" class="form-control" id="x" placeholder="Ingresa el número de eventos" required>
                </div>

                <!-- Entrada para probabilidad acumulada -->
                <div id="cumulativeEventInput" class="mb-3 d-none">
                    <label for="x_max" class="form-label">Número máximo de eventos (x_max):</label>
                    <input type="number" class="form-control" id="x_max" placeholder="Ingresa el número máximo de eventos" required>
                </div>

                <!-- Entrada para rango de eventos en la gráfica -->
                <div id="rangeEventInput" class="mb-3 d-none">
                    <label for="x_range" class="form-label">Rango máximo de eventos para la gráfica:</label>
                    <input type="number" class="form-control" id="x_range" placeholder="Ingresa el rango máximo de eventos" required>
                </div>

                <button type="button" class="btn btn-primary w-100 mt-3" onclick="calculate()">Calcular</button>
            </form>

            <p class="mt-4 text-center text-success fw-bold" id="resultText"></p>
            <canvas id="poissonChart" class="mt-4" style="display:none;" width="400" height="200"></canvas>
        </div>
    </div>
</div>

<script>
    // Mostrar/ocultar inputs según la opción seleccionada
    document.getElementById('option').addEventListener('change', function () {
        const option = this.value;
        document.getElementById('specificEventInput').classList.toggle('d-none', option !== '1');
        document.getElementById('cumulativeEventInput').classList.toggle('d-none', option !== '2');
        document.getElementById('rangeEventInput').classList.toggle('d-none', option !== '3');
        document.getElementById('poissonChart').style.display = option === '3' ? 'block' : 'none';
    });

    function calculate() {
        const mu = document.getElementById('mu').value;
        const option = document.getElementById('option').value;

        if (!mu) {
            alert("Por favor ingresa el promedio de eventos esperados (μ).");
            return;
        }

        if (option === '1') {
            const x = document.getElementById('x').value;
            if (!x) {
                alert("Por favor ingresa el número de eventos (x) para calcular la probabilidad.");
                return;
            }

            fetch('/calculate-probability', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ mu: mu, x: x })
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('resultText').innerText = `La probabilidad de que ocurran exactamente ${x} eventos es: ${(data.probability ).toFixed(4)}%`;
            });

        } else if (option === '2') {
            const xMax = document.getElementById('x_max').value;
            if (!xMax) {
                alert("Por favor ingresa el número máximo de eventos (x_max) para calcular la probabilidad acumulada.");
                return;
            }

            fetch('/calculate-cumulative', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ mu: mu, x_max: xMax })
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('resultText').innerText = `La probabilidad acumulada de que ocurran hasta ${xMax} eventos es: ${(data.cumulative ).toFixed(4)}%`;
            });

        } else if (option === '3') {
            const xRange = document.getElementById('x_range').value;
            if (!xRange) {
                alert("Por favor ingresa el rango máximo de eventos para la gráfica.");
                return;
            }
            plotPoissonChart(mu, xRange);
            document.getElementById('resultText').innerText = '';
        }
    }

    function plotPoissonChart(mu, xRange) {
    const xValues = Array.from({ length: parseInt(xRange) + 1 }, (_, i) => i);
    const yValues = xValues.map(x => poissonProbability(mu, x) * 100); // Multiplicamos cada valor por 100

    const ctx = document.getElementById('poissonChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: xValues,
            datasets: [{
                label: `Distribución de Poisson (μ = ${mu})`,
                data: yValues,
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                hoverBackgroundColor: 'rgba(54, 162, 235, 0.9)'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value + '%'; // Muestra porcentajes en el eje Y
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return `${tooltipItem.raw.toFixed(2)}%`; // Muestra porcentaje en el tooltip
                        }
                    }
                }
            }
        }
    });
}


    function poissonProbability(mu, x) {
        return (Math.exp(-mu) * Math.pow(mu, x)) / factorial(x);
    }

    function factorial(n) {
        return n === 0 ? 1 : n * factorial(n - 1);
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
