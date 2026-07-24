<?php
// Manual autoloader (no Composer required)
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../src/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

// Get PDO connection
$pdo = require_once __DIR__ . '/../config/database.php';

$action = $_GET['action'] ?? 'home';

if ($action === 'run') {
    $controller = new App\Controllers\AlgorithmController($pdo);
    $controller->run();
} elseif ($action === 'getSteps') {
    $controller = new App\Controllers\AlgorithmController($pdo);
    $controller->getSteps();
} else {
    // Serve the main HTML page
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Algorithm Visualizer</title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <div class="container">
    <h1>🧩 Algorithm Visualizer</h1>
    <div class="controls">
        <div class="input-group">
            <label>Array (JSON):</label>
            <input type="text" id="arrayInput" value="[5,3,8,1,2,7,4,6]" placeholder="e.g., [5,3,8,1,2]">
        </div>
        <div class="input-group">
            <label>Algorithm:</label>
            <select id="algoSelect">
                <optgroup label="Sorting">
                    <option value="bubble">Bubble Sort</option>
                    <option value="quick">Quick Sort</option>
                    <option value="merge">Merge Sort</option>
                </optgroup>
                <optgroup label="Searching">
                    <option value="binary">Binary Search</option>
                </optgroup>
            </select>
        </div>
        <div class="input-group" id="targetGroup" style="display:none;">
            <label>Target:</label>
            <input type="number" id="targetInput" value="5" placeholder="Enter target">
        </div>
        <button id="visualizeBtn">▶ Visualize</button>
        <button id="playBtn" disabled>⏩ Play</button>
        <button id="pauseBtn" disabled>⏸ Pause</button>
        <button id="resetBtn" disabled>⟲ Reset</button>
        <div class="speed-control">
            <label>Speed: <span id="speedLabel">500</span>ms</label>
            <input type="range" id="speedSlider" min="100" max="1000" value="500" step="50">
        </div>
        <span id="stepInfo">Step 0 / 0</span>
    </div>
    <div id="messageBox"></div>
    <canvas id="canvas" width="800" height="400"></canvas>
</div>
        <script src="js/api.js"></script>
        <script src="js/visualizer.js"></script>
    </body>
    </html>
    <?php
}
?>