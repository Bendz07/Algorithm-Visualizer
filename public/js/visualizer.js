let steps = [];
let currentStep = 0;
let timer = null;
let isPlaying = false;

const canvas = document.getElementById('canvas');
const ctx = canvas.getContext('2d');

const arrayInput = document.getElementById('arrayInput');
const algoSelect = document.getElementById('algoSelect');
const targetInput = document.getElementById('targetInput');
const targetGroup = document.getElementById('targetGroup');
const visualizeBtn = document.getElementById('visualizeBtn');
const playBtn = document.getElementById('playBtn');
const pauseBtn = document.getElementById('pauseBtn');
const resetBtn = document.getElementById('resetBtn');
const speedSlider = document.getElementById('speedSlider');
const speedLabel = document.getElementById('speedLabel');
const stepInfo = document.getElementById('stepInfo');
const messageBox = document.getElementById('messageBox');

// Show/hide target input based on algorithm selection
algoSelect.addEventListener('change', function() {
    if (this.value === 'binary') {
        targetGroup.style.display = 'flex';
    } else {
        targetGroup.style.display = 'none';
    }
});

// Helper to parse array input
function parseArray(input) {
    try {
        const arr = JSON.parse(input);
        if (Array.isArray(arr) && arr.every(n => typeof n === 'number' && !isNaN(n))) {
            return arr;
        }
    } catch (e) {}
    return null;
}

// Render a specific step with proper spacing
function renderStep(index) {
    if (!steps.length || index >= steps.length) return;

    const step = steps[index];
    const arr = step.array_state;
    const active = step.active_indices || [];
    const maxVal = Math.max(...arr, 1);
    
    // Get canvas dimensions
    const canvasWidth = canvas.width;
    const canvasHeight = canvas.height;
    
    // Define margins
    const margin = { top: 20, bottom: 40, left: 20, right: 20 };
    const chartWidth = canvasWidth - margin.left - margin.right;
    const chartHeight = canvasHeight - margin.top - margin.bottom;
    
    // Calculate bar width to fill the space
    const barCount = arr.length;
    const maxBarWidth = 60; // Maximum width per bar
    const minBarWidth = 20; // Minimum width per bar
    const gap = 4; // Gap between bars
    
    // Calculate optimal bar width to fill the space
    let barWidth = Math.min(
        maxBarWidth,
        (chartWidth - (barCount - 1) * gap) / barCount
    );
    
    // If there are very few items, make bars wider but keep them centered
    if (barCount <= 5) {
        barWidth = Math.min(maxBarWidth, (chartWidth - (barCount - 1) * gap) / barCount);
    }
    
    // Ensure minimum width
    barWidth = Math.max(minBarWidth, barWidth);
    
    // Recalculate total width used
    const totalBarWidth = barCount * barWidth + (barCount - 1) * gap;
    const startX = margin.left + (chartWidth - totalBarWidth) / 2;

    ctx.clearRect(0, 0, canvasWidth, canvasHeight);

    // Draw grid lines (optional)
    ctx.strokeStyle = '#ecf0f1';
    ctx.lineWidth = 1;
    ctx.setLineDash([5, 5]);
    for (let i = 1; i <= 4; i++) {
        const y = canvasHeight - margin.bottom - (i / 4) * chartHeight;
        ctx.beginPath();
        ctx.moveTo(margin.left, y);
        ctx.lineTo(canvasWidth - margin.right, y);
        ctx.stroke();
    }
    ctx.setLineDash([]);

    // Draw bars
    for (let i = 0; i < arr.length; i++) {
        const x = startX + i * (barWidth + gap);
        const barHeight = (arr[i] / maxVal) * chartHeight;
        const y = canvasHeight - margin.bottom - barHeight;

        // Color based on active indices
        let barColor;
        if (active.includes(i)) {
            barColor = '#e74c3c'; // red for comparison/swap
        } else {
            // Gradient based on value
            const hue = 210 - (arr[i] / maxVal) * 40;
            const lightness = 50 + (arr[i] / maxVal) * 20;
            barColor = `hsl(${hue}, 70%, ${lightness}%)`;
        }
        
        // Draw bar with rounded corners
        ctx.fillStyle = barColor;
        ctx.shadowColor = 'rgba(0,0,0,0.1)';
        ctx.shadowBlur = 4;
        ctx.shadowOffsetX = 2;
        ctx.shadowOffsetY = 2;
        
        // Rounded rectangle
        const radius = 4;
        ctx.beginPath();
        ctx.moveTo(x + radius, y);
        ctx.lineTo(x + barWidth - radius, y);
        ctx.quadraticCurveTo(x + barWidth, y, x + barWidth, y + radius);
        ctx.lineTo(x + barWidth, y + barHeight - radius);
        ctx.quadraticCurveTo(x + barWidth, y + barHeight, x + barWidth - radius, y + barHeight);
        ctx.lineTo(x + radius, y + barHeight);
        ctx.quadraticCurveTo(x, y + barHeight, x, y + barHeight - radius);
        ctx.lineTo(x, y + radius);
        ctx.quadraticCurveTo(x, y, x + radius, y);
        ctx.closePath();
        ctx.fill();
        
        // Reset shadow for text
        ctx.shadowColor = 'transparent';
        ctx.shadowBlur = 0;
        ctx.shadowOffsetX = 0;
        ctx.shadowOffsetY = 0;

        // Value label on top of bar
        ctx.fillStyle = '#2c3e50';
        ctx.font = `bold ${Math.min(14, barWidth * 0.8)}px sans-serif`;
        ctx.textAlign = 'center';
        ctx.textBaseline = 'bottom';
        ctx.fillText(arr[i], x + barWidth / 2, y - 4);

        // Index label below bar (only if enough space)
        if (barWidth > 25) {
            ctx.fillStyle = '#7f8c8d';
            ctx.font = '10px sans-serif';
            ctx.textBaseline = 'top';
            ctx.fillText(i, x + barWidth / 2, canvasHeight - margin.bottom + 6);
        }
    }

    // Update UI
    stepInfo.textContent = `Step ${index + 1} / ${steps.length}`;
    messageBox.textContent = step.message || '';
}

// Start visualization (fetch steps)
function startVisualization() {
    const array = parseArray(arrayInput.value);
    if (!array) {
        alert('Please enter a valid array in JSON format (e.g., [5,3,8,1,2])');
        return;
    }

    const algo = algoSelect.value;
    const target = targetInput.value;

    visualizeBtn.disabled = true;
    playBtn.disabled = true;
    pauseBtn.disabled = true;
    resetBtn.disabled = true;

    // Build form data
    const formData = new FormData();
    formData.append('array', JSON.stringify(array));
    formData.append('type', algo);
    if (algo === 'binary') {
        if (!target || isNaN(target)) {
            alert('Please enter a valid target number for binary search');
            visualizeBtn.disabled = false;
            return;
        }
        formData.append('target', target);
    }

    fetch('index.php?action=run', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            alert(data.error);
            visualizeBtn.disabled = false;
            return;
        }
        return fetch(`index.php?action=getSteps&session_id=${data.session_id}`);
    })
    .then(response => response.json())
    .then(stepsData => {
        if (!stepsData) return;
        steps = stepsData;
        currentStep = 0;
        renderStep(0);
        visualizeBtn.disabled = false;
        playBtn.disabled = false;
        resetBtn.disabled = false;
        pauseBtn.disabled = true;
        isPlaying = false;
        clearInterval(timer);
        timer = null;
    })
    .catch(err => {
        alert('Error: ' + err.message);
        visualizeBtn.disabled = false;
    });
}

// Play animation
function play() {
    if (isPlaying) return;
    if (currentStep >= steps.length - 1) {
        // If already at end, reset to start
        currentStep = 0;
        renderStep(0);
    }
    isPlaying = true;
    playBtn.disabled = true;
    pauseBtn.disabled = false;

    const speed = parseInt(speedSlider.value);
    timer = setInterval(() => {
        if (currentStep < steps.length - 1) {
            currentStep++;
            renderStep(currentStep);
        } else {
            clearInterval(timer);
            timer = null;
            isPlaying = false;
            playBtn.disabled = false;
            pauseBtn.disabled = true;
        }
    }, speed);
}

// Pause animation
function pause() {
    if (timer) {
        clearInterval(timer);
        timer = null;
    }
    isPlaying = false;
    playBtn.disabled = false;
    pauseBtn.disabled = true;
}

// Reset to first step
function reset() {
    pause();
    currentStep = 0;
    renderStep(0);
    playBtn.disabled = false;
    pauseBtn.disabled = true;
}

// Speed slider update
speedSlider.addEventListener('input', function() {
    speedLabel.textContent = this.value;
});

// Event listeners
visualizeBtn.addEventListener('click', startVisualization);
playBtn.addEventListener('click', play);
pauseBtn.addEventListener('click', pause);
resetBtn.addEventListener('click', reset);

// Enable pause via keyboard (spacebar)
document.addEventListener('keydown', (e) => {
    if (e.key === ' ' && !e.repeat) {
        e.preventDefault();
        if (isPlaying) pause();
        else if (steps.length) play();
    }
});

// Initial state
playBtn.disabled = true;
pauseBtn.disabled = true;
resetBtn.disabled = true;

// Handle window resize - make canvas responsive
function resizeCanvas() {
    const container = canvas.parentElement;
    const containerWidth = container.clientWidth - 40;
    if (containerWidth < 800) {
        canvas.width = containerWidth;
        canvas.height = Math.min(400, containerWidth * 0.5);
    } else {
        canvas.width = 800;
        canvas.height = 400;
    }
    // Re-render if we have steps
    if (steps.length > 0) {
        renderStep(currentStep);
    }
}

window.addEventListener('resize', resizeCanvas);
// Initial resize
setTimeout(resizeCanvas, 100);