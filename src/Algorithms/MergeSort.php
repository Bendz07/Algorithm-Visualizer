<?php
namespace App\Algorithms;

use App\Models\StepModel;

class MergeSort implements AlgorithmInterface
{
    private $model;
    private $sessionId;
    private $step = 0;

    public function runAndSave(array $arr, StepModel $model, string $sessionId): int
    {
        $this->model = $model;
        $this->sessionId = $sessionId;
        $this->step = 0;

        // Save initial state
        $this->model->saveStep($this->sessionId, $this->step++, $arr, [], 'Initial array');

        // Start Merge Sort
        $arr = $this->mergeSort($arr);

        // Save final state
        $this->model->saveStep($this->sessionId, $this->step++, $arr, [], 'Array sorted!');
        
        return $this->step;
    }

    private function mergeSort($arr)
    {
        $n = count($arr);
        if ($n <= 1) {
            return $arr;
        }

        $mid = floor($n / 2);
        $left = array_slice($arr, 0, $mid);
        $right = array_slice($arr, $mid);

        $left = $this->mergeSort($left);
        $right = $this->mergeSort($right);

        $merged = $this->merge($left, $right);
        
        // Save state after merge
        $this->model->saveStep(
            $this->sessionId, 
            $this->step++, 
            $merged, 
            [], 
            "Merged arrays: [" . implode(',', $left) . "] and [" . implode(',', $right) . "]"
        );

        return $merged;
    }

    private function merge($left, $right)
    {
        $result = [];
        $i = $j = 0;
        $leftCount = count($left);
        $rightCount = count($right);

        while ($i < $leftCount && $j < $rightCount) {
            if ($left[$i] <= $right[$j]) {
                $result[] = $left[$i];
                $i++;
            } else {
                $result[] = $right[$j];
                $j++;
            }
        }

        while ($i < $leftCount) {
            $result[] = $left[$i];
            $i++;
        }

        while ($j < $rightCount) {
            $result[] = $right[$j];
            $j++;
        }

        return $result;
    }
}