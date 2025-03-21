<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('css/404.css'); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Poppins:wght@600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        h1,
        h2,
        h3 {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
        }

        button {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body>
    <div class="error-page d-flex align-items-center justify-content-center">
        <div class="container text-center">
            <h1 class="error-code glitch mb-4">404</h1>
            <h2 class="display-6 mb-3">32)(*@#</h2>
            <p class="lead mb-5">Oops! Looks like this page got scrambled</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="<?= isset($_SESSION['user']) ? base_url($_SESSION['user']['role'] . '/home') : base_url('login'); ?>" class="btn btn-primary">Go Home</a>
                <a href="#" class="btn btn-outline-secondary">Report Issue</a>
            </div>
        </div>
    </div>
</body>

</html>