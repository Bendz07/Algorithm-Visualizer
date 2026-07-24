<?php
namespace App\Controllers;

use App\Models\StepModel;
use App\Algorithms\BubbleSort;
use App\Algorithms\QuickSort;
use App\Algorithms\MergeSort;
use App\Algorithms\BinarySearch;

class AlgorithmController
{
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function run()
    {
        // Get input parameters
        $input = isset($_POST['array']) ? json_decode($_POST['array'], true) : [];
        $type = $_POST['type'] ?? 'bubble';
        $target = isset($_POST['target']) ? $_POST['target'] : null;

        if (empty($input)) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid array']);
            return;
        }

        $sessionId = uniqid('vis_', true);
        $model = new StepModel($this->pdo);

        // Factory: instantiate algorithm class
        $totalSteps = 0;
        
        switch ($type) {
            case 'bubble':
                $algorithm = new BubbleSort();
                $totalSteps = $algorithm->runAndSave($input, $model, $sessionId);
                break;
                
            case 'quick':
                $algorithm = new QuickSort();
                $totalSteps = $algorithm->runAndSave($input, $model, $sessionId);
                break;
                
            case 'merge':
                $algorithm = new MergeSort();
                $totalSteps = $algorithm->runAndSave($input, $model, $sessionId);
                break;
                
            case 'binary':
                if ($target === null || $target === '') {
                    http_response_code(400);
                    echo json_encode(['error' => 'Target value required for binary search']);
                    return;
                }
                $algorithm = new BinarySearch();
                $totalSteps = $algorithm->runAndSave($input, (int)$target, $model, $sessionId);
                break;
                
            default:
                http_response_code(400);
                echo json_encode(['error' => 'Algorithm not supported']);
                return;
        }

        header('Content-Type: application/json');
        echo json_encode([
            'session_id' => $sessionId, 
            'total_steps' => $totalSteps,
            'algorithm' => $type
        ]);
    }

    public function getSteps()
    {
        $sessionId = $_GET['session_id'] ?? '';
        if (!$sessionId) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing session_id']);
            return;
        }

        $model = new StepModel($this->pdo);
        $steps = $model->getStepsBySession($sessionId);

        // Decode JSON fields for frontend
        foreach ($steps as &$s) {
            $s['array_state'] = json_decode($s['array_state']);
            $s['active_indices'] = json_decode($s['active_indices']);
        }

        header('Content-Type: application/json');
        echo json_encode($steps);
    }
}