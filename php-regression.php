<?php
require_once 'vendor/autoload.php';

use Phpml\Regression\LeastSquares;

// Definer datasettet
$dataset = [
    [1, 2],
    [2, 3],
    [4, 5],
    [3, 4],
    [5, 6]
];

// Oppdel datasettet i treningsdata og testdata
$split = 0.8;
$splitIndex = round(count($dataset) * $split);
shuffle($dataset);
$trainData = array_slice($dataset, 0, $splitIndex);
$testData = array_slice($dataset, $splitIndex);

// Trening av modellen
$regression = new LeastSquares();
$regression->train($trainData);

// Test av modellen
$predictions = [];
$actuals = [];
foreach ($testData as $data) {
    $predictions[] = $regression->predict($data[0]);
    $actuals[] = $data[1];
}

// Beregn og skriv ut R²-verdien
$coefficients = $regression->getCoefficients();
$meanActuals = array_sum($actuals) / count($actuals);
$totalSumSquares = 0;
$residualSumSquares = 0;
foreach ($testData as $data) {
    $totalSumSquares += pow($data[1] - $meanActuals, 2);
    $residualSumSquares += pow($data[1] - $regression->predict($data[0]), 2);
}
$rSquared = 1 - ($residualSumSquares / $totalSumSquares);
echo "R² = $rSquared\n";
?>
