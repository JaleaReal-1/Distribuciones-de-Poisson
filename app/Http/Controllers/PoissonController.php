<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PoissonController extends Controller
{
    public function poissonProbability($mu, $x)
    {
        return (exp(-$mu) * pow($mu, $x)) / $this->factorial($x);
    }

    public function cumulativePoisson($mu, $xMax)
    {
        $cumulativeProb = 0;
        for ($x = 0; $x <= $xMax; $x++) {
            $cumulativeProb += $this->poissonProbability($mu, $x);
        }
        return $cumulativeProb;
    }

    private function factorial($n)
    {
        return ($n == 0) ? 1 : $n * $this->factorial($n - 1);
    }

    // Método para la vista principal
    public function index()
    {
        return view('poisson');
    }

    // Calcula la probabilidad para un número específico de eventos (opción 1)
    public function calculateProbability(Request $request)
    {
        $mu = $request->input('mu');
        $x = $request->input('x');
        $probability = $this->poissonProbability($mu, $x) * 100; // Convertimos a porcentaje

        return response()->json(['probability' => $probability]);
    }

    // Calcula la probabilidad acumulada hasta un número máximo de eventos (opción 2)
    public function calculateCumulative(Request $request)
    {
        $mu = $request->input('mu');
        $xMax = $request->input('x_max');
        $cumulative = $this->cumulativePoisson($mu, $xMax) * 100; // Convertimos a porcentaje

        return response()->json(['cumulative' => $cumulative]);
    }

    // Genera los datos para graficar la distribución de Poisson (opción 3)
    public function calculateGraphData(Request $request)
    {
        $mu = $request->input('mu');
        $xRange = $request->input('x_range');

        $xValues = range(0, $xRange);
        $yValues = array_map(function ($x) use ($mu) {
            return $this->poissonProbability($mu, $x) * 100; // Convertimos cada probabilidad a porcentaje
        }, $xValues);

        return response()->json(['xValues' => $xValues, 'yValues' => $yValues]);
    }
}
