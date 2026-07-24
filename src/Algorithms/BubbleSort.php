<?php
namespace App\Algorithms;

use App\Models\StepModel;

class BubbleSort implements AlgorithmInterface
{
    public function runAndSave(array $arr, StepModel $model, string $sessionId): int
    {
        $step = 0;
        $n = count($arr);
        $model->saveStep($sessionId, $step++, $arr, [], 'Initial array');

        for ($i = 0; $i < $n - 1; $i++) {
            for ($j = 0; $j < $n - $i - 1; $j++) {
                $model->saveStep($sessionId, $step++, $arr, [$j, $j + 1],
                    "Comparing {$arr[$j]} and {$arr[$j+1]}");

                if ($arr[$j] > $arr[$j + 1]) {
                    $temp = $arr[$j];
                    $arr[$j] = $arr[$j + 1];
                    $arr[$j + 1] = $temp;
                    $model->saveStep($sessionId, $step++, $arr, [$j, $j + 1],
                        "Swapped {$temp} and {$arr[$j]}");
                }
            }
        }
        $model->saveStep($sessionId, $step++, $arr, [], 'Array sorted!');
        return $step;
    }
}