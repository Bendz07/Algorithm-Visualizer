<?php
namespace App\Algorithms;

use App\Models\StepModel;

interface AlgorithmInterface
{
    public function runAndSave(array $inputArray, StepModel $model, string $sessionId): int;
}