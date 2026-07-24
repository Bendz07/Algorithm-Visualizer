# 🧩 Algorithm Visualizer

> **Interactive visualization of sorting and searching algorithms built with PHP, MySQL, and JavaScript**

[![PHP Version](https://img.shields.io/badge/PHP-7.4%2B-blue.svg)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-5.7%2B-orange.svg)](https://mysql.com)
[![JavaScript](https://img.shields.io/badge/JavaScript-ES6-yellow.svg)](https://javascript.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)
[![PRs Welcome](https://img.shields.io/badge/PRs-welcome-brightgreen.svg)](CONTRIBUTING.md)

---

## 📸 Preview

<!-- Replace with your actual screenshot -->
<p align="center">
  <img src=["https://github.com/Bendz07/Algorithm-Visualizer/blob/ffc69c8bc054c67488f8c964bd8d6153b4b2c0f2/algov.png"]>
</p>

---

## ✨ Features

| Feature | Description |
|---------|-------------|
| 🎯 **Multiple Algorithms** | Bubble Sort, Quick Sort, Merge Sort, and Binary Search |
| 🎨 **Interactive Visualization** | Real-time animated bar charts showing algorithm execution |
| ⏯️ **Playback Controls** | Play, Pause, Reset with adjustable speed (100ms - 1000ms) |
| 🎮 **Keyboard Shortcuts** | Press `Space` to toggle play/pause |
| 📊 **Step-by-Step Tracking** | Watch each comparison and swap in detail |
| 🔍 **Search Support** | Binary Search with target value input |
| 💾 **Database Persistence** | All steps stored in MySQL for review |
| 📱 **Responsive Design** | Works on desktop and mobile devices |
| 🎨 **Modern UI** | Clean, colorful, and user-friendly interface |

---

## 🚀 Quick Start

### Prerequisites

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx) or XAMPP/WAMP/MAMP
- Composer (optional, for autoloader)

### Installation

```bash
# 1. Clone the repository
git clone https://github.com/yourusername/algorithm-visualizer.git
cd algorithm-visualizer

# 2. Set up the database
mysql -u root -p < database/schema.sql

# 3. Configure environment
cp .env.example .env
# Edit .env with your database credentials

# 4. Install dependencies (optional)
composer install

# 5. Start your web server
# For PHP built-in server:
php -S localhost:8000 -t public/

# For XAMPP/WAMP:
# Place the project in htdocs/www folder
```

### Quick Access

Open your browser and navigate to:
```
http://localhost:8000/
```
or
```
http://localhost/algorithm-visualizer/public/
```

---

## 🎯 Usage Guide

### 1️⃣ **Choose an Algorithm**

Select from the dropdown menu:
- **Bubble Sort** - Simple adjacent comparison sort
- **Quick Sort** - Divide and conquer with pivot
- **Merge Sort** - Recursive merge-based sorting
- **Binary Search** - Find target in sorted array

### 2️⃣ **Enter Your Data**

**For Sorting:**
```json
[5, 3, 8, 1, 2, 7, 4, 6]
```

**For Binary Search:**
```json
[10, 20, 30, 40, 50, 60, 70, 80]
```
Then enter a **target value** (e.g., `50`)

### 3️⃣ **Visualize & Interact**

| Button | Action |
|--------|--------|
| 🟢 **Visualize** | Generate algorithm steps |
| ▶️ **Play** | Start animation |
| ⏸️ **Pause** | Pause animation |
| 🔄 **Reset** | Go back to first step |
| 🎚️ **Speed Slider** | Adjust animation speed |

---

## 🧮 Supported Algorithms

### Sorting Algorithms

<details>
<summary><b>Bubble Sort</b> - O(n²) Time Complexity</summary>

- Compares adjacent elements and swaps if they're in wrong order
- Largest elements "bubble" to the end
- Visual: Red bars indicate comparisons/swaps
</details>

<details>
<summary><b>Quick Sort</b> - O(n log n) Average</summary>

- Uses divide-and-conquer approach
- Selects a pivot and partitions around it
- Visual: Red bar shows pivot element
</details>

<details>
<summary><b>Merge Sort</b> - O(n log n) Time</summary>

- Divides array into halves recursively
- Merges sorted sub-arrays
- Visual: Shows merging process
</details>

### Search Algorithms

<details>
<summary><b>Binary Search</b> - O(log n) Time</summary>

- Requires sorted array
- Repeatedly divides search space in half
- Visual: Red bar shows current middle element
</details>

---

## 🏗️ Project Structure

```
algorithm-visualizer/
├── config/
│   └── database.php          # Database configuration
├── public/                    # Web root
│   ├── index.php              # Main entry point
│   ├── css/
│   │   └── style.css          # Stylesheets
│   └── js/
│       ├── visualizer.js      # Main visualization logic
│       └── api.js             # API calls
├── src/
│   ├── Controllers/
│   │   ├── AlgorithmController.php
│   │   └── HomeController.php
│   ├── Models/
│   │   ├── StepModel.php
│   │   └── SessionModel.php
│   └── Algorithms/
│       ├── AlgorithmInterface.php
│       ├── BubbleSort.php
│       ├── QuickSort.php
│       ├── MergeSort.php
│       ├── BinarySearch.php
│       └── SearchInterface.php
├── logs/                      # Application logs
├── .env                       # Environment variables
├── composer.json              # Composer dependencies
└── README.md                  # This file
```

---

## 🛠️ Technology Stack

<p align="center">
  <img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black" alt="JavaScript">
  <img src="https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white" alt="HTML5">
  <img src="https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white" alt="CSS3">
  <img src="https://img.shields.io/badge/Canvas_API-2C3E50?style=for-the-badge&logo=html5&logoColor=white" alt="Canvas API">
</p>

---

## 📊 Database Schema

```sql
CREATE TABLE algorithm_steps (
    id INT AUTO_INCREMENT PRIMARY KEY,
    session_id VARCHAR(36) NOT NULL,
    step_number INT NOT NULL,
    array_state TEXT NOT NULL,
    active_indices TEXT,
    message VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_session (session_id)
);
```

---

## 🎮 Keyboard Shortcuts

| Key | Action |
|-----|--------|
| `Space` | Toggle Play/Pause |
| `Enter` | Start Visualization |

---

## 🤝 Contributing

Contributions are welcome! Here's how you can help:

1. **Fork** the repository
2. **Create** a feature branch (`git checkout -b feature/amazing-feature`)
3. **Commit** your changes (`git commit -m 'Add amazing feature'`)
4. **Push** to the branch (`git push origin feature/amazing-feature`)
5. **Open** a Pull Request

### Development Setup

```bash
# Clone your fork
git clone https://github.com/yourusername/algorithm-visualizer.git

# Install dependencies
composer install

# Run tests (if any)
phpunit

# Start development server
php -S localhost:8000 -t public/
```

### Adding New Algorithms

1. Create a new class in `src/Algorithms/`
2. Implement the `AlgorithmInterface` (for sorting) or `SearchInterface` (for searching)
3. Add your algorithm to the dropdown in `public/index.php`
4. Update the controller's switch statement

---

## 🐛 Troubleshooting

<details>
<summary><b>Database Connection Error</b></summary>

- Ensure MySQL is running
- Check credentials in `.env` file
- Verify database exists: `CREATE DATABASE algorithm_visualizer;`
- Run the SQL schema to create tables
</details>

<details>
<summary><b>Composer Autoloader Missing</b></summary>

- Run `composer install` in the project root
- Or use the manual autoloader (see `public/index.php`)
</details>

<details>
<summary><b>Blank Page / No Visualization</b></summary>

- Check PHP error logs
- Enable error reporting: `error_reporting(E_ALL); ini_set('display_errors', 1);`
- Verify all files are in correct locations
- Check browser console for JavaScript errors
</details>

---

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

## 🙏 Acknowledgments

- Inspired by various algorithm visualization tools
- Built with ❤️ for the developer community
- Thanks to all contributors and open-source libraries

---

## 📬 Contact

**Your Name** - [@yourtwitter](https://twitter.com/yourtwitter) - email@example.com

Project Link: [https://github.com/yourusername/algorithm-visualizer](https://github.com/yourusername/algorithm-visualizer)

---

<p align="center">
  Made with ❤️ and PHP
</p>

<p align="center">
  <a href="#-features">Features</a> •
  <a href="#-quick-start">Quick Start</a> •
  <a href="#-usage-guide">Usage Guide</a> •
  <a href="#-supported-algorithms">Algorithms</a> •
  <a href="#-contributing">Contributing</a>
</p>

---

## 📸 Screenshots Gallery

<!-- Add actual screenshots here -->
<p align="center">
  <table>
    <tr>
      <td><img src="https://via.placeholder.com/400x200/3498db/ffffff?text=Bubble+Sort" alt="Bubble Sort"></td>
      <td><img src="https://via.placeholder.com/400x200/e74c3c/ffffff?text=Quick+Sort" alt="Quick Sort"></td>
    </tr>
    <tr>
      <td><img src="https://via.placeholder.com/400x200/2ecc71/ffffff?text=Merge+Sort" alt="Merge Sort"></td>
      <td><img src="https://via.placeholder.com/400x200/f39c12/ffffff?text=Binary+Search" alt="Binary Search"></td>
    </tr>
  </table>
</p>

---

## ⭐ Star History

[![Star History Chart](https://api.star-history.com/svg?repos=yourusername/algorithm-visualizer&type=Date)](https://star-history.com/#yourusername/algorithm-visualizer&Date)

---

**Don't forget to ⭐ star this repository if you found it helpful!**
