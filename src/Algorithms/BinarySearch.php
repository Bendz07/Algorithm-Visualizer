<?php
namespace App\Algorithms;

use App\Models\StepModel;

class BinarySearch implements SearchInterface
{
    public function runAndSave(array $arr, $target, StepModel $model, string $sessionId): int
    {
        $step = 0;
        
        // Sort the array first for binary search
        sort($arr);
        $model->saveStep($sessionId, $step++, $arr, [], "Sorted array for binary search");

        $low = 0;
        $high = count($arr) - 1;
        $found = false;
        $foundIndex = -1;

        while ($low <= $high) {
            $mid = floor(($low + $high) / 2);
            
            $model->saveStep(
                $sessionId, 
                $step++, 
                $arr, 
                [$mid], 
                "Checking middle element: {$arr[$mid]} (index {$mid})"
            );

            if ($arr[$mid] == $target) {
                $found = true;
                $foundIndex = $mid;
                $model->saveStep(
                    $sessionId, 
                    $step++, 
                    $arr, 
                    [$mid], 
                    "🎯 Found {$target} at index {$mid}!"
                );
                break;
            } elseif ($arr[$mid] < $target) {
                $low = $mid + 1;
                $model->saveStep(
                    $sessionId, 
                    $step++, 
                    $arr, 
                    [$mid], 
                    "{$target} > {$arr[$mid]}, searching right half"
                );
            } else {
                $high = $mid - 1;
                $model->saveStep(
                    $sessionId, 
                    $step++, 
                    $arr, 
                    [$mid], 
                    "{$target} < {$arr[$mid]}, searching left half"
                );
            }
        }

        if (!$found) {
            $model->saveStep(
                $sessionId, 
                $step++,
                $arr, 
                [], 
                "❌ {$target} not found in the array"
            );
        }

        return $step;
    }
}