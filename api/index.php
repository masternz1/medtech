<?php

// Vercel only runs functions that live in /api, so forward every request to Laravel's normal entry point.
require __DIR__ . '/../public/index.php';
