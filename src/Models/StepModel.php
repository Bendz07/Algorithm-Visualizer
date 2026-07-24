<?php
namespace App\Models;

class StepModel
{
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function saveStep($sessionId, $stepNum, $arr, $active = [], $msg = '')
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO algorithm_steps (session_id, step_number, array_state, active_indices, message)
             VALUES (?, ?, ?, ?, ?)"
        );
        return $stmt->execute([
            $sessionId,
            $stepNum,
            json_encode($arr),
            json_encode($active),
            $msg
        ]);
    }

    public function getStepsBySession($sessionId)
    {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM algorithm_steps WHERE session_id = ? ORDER BY step_number"
        );
        $stmt->execute([$sessionId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function deleteSession($sessionId)
    {
        $stmt = $this->pdo->prepare("DELETE FROM algorithm_steps WHERE session_id = ?");
        return $stmt->execute([$sessionId]);
    }
}