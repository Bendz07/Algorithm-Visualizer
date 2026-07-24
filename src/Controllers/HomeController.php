<?php
namespace App\Controllers;

class HomeController
{
    public function show()
    {
        // Serve the main HTML page
        require_once __DIR__ . '/../../public/index.html';
    }
}