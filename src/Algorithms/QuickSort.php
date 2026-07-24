<?php
namespace App\Algorithms;

use App\Models\StepModel;

class QuickSort implements AlgorithmInterface
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

        // Start Quick Sort
        $this->quickSort($arr, 0, count($arr) - 1);

        // Save final state
        $this->model->saveStep($this->sessionId, $this->step++, $arr, [], 'Array sorted!');
        
        return $this->step;
    }

    private function quickSort(&$arr, $low, $high)
    {
        if ($low < $high) {
            $pi = $this->partition($arr, $low, $high);
            
            // Save state after partition
            $this->model->saveStep(
                $this->sessionId, 
                $this->step++, 
                $arr, 
                [$pi], 
                "Partitioned around index {$pi} (value: {$arr[$pi]})"
            );
            
            $this->quickSort($arr, $low, $pi - 1);
            $this->quickSort($arr, $pi + 1, $high);
        }
    }

    private function partition(&$arr, $low, $high)
    {
        $pivot = $arr[$high];
        $i = $low - 1;

        for ($j = $low; $j < $high; $j++) {
            // Save comparison step
            $this->model->saveStep(
                $this->sessionId, 
                $this->step++, 
                $arr, 
                [$j, $high], 
                "Comparing {$arr[$j]} with pivot {$pivot}"
            );

            if ($arr[$j] < $pivot) {
                $i++;
                // Swap
                $temp = $arr[$i];
                $arr[$i] = $arr[$j];
                $arr[$j] = $temp;
                
                if ($i != $j) {
                    $this->model->saveStep(
                        $this->sessionId, 
                        $this->step++, 
                        $arr, 
                        [$i, $j], 
                        "Swapped {$arr[$i]} and {$arr[$j]}"
                    );
                }
            }
        }

        // Place pivot in correct position
        $temp = $arr[$i + 1];
        $arr[$i + 1] = $arr[$high];
        $arr[$high] = $temp;

        if ($i + 1 != $high) {
            $this->model->saveStep(
                $this->sessionId, 
                $this->step++, 
                $arr, 
                [$i + 1, $high], 
                "Placed pivot {$arr[$i + 1]} in correct position"
            );
        }

        return $i + 1;
    }
}