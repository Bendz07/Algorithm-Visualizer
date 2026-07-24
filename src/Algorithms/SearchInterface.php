<?php
namespace App\Algorithms;

use App\Models\StepModel;

interface SearchInterface
{
    public function runAndSave(array $inputArray, $target, StepModel $model, string $sessionId): int;
}