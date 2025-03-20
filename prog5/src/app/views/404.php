<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('css/404.css'); ?>">
</head>

<body>
    <div class="error-page d-flex align-items-center justify-content-center">
        <div class="container text-center">
            <h1 class="error-code glitch mb-4">404</h1>
            <h2 class="display-6 mb-3">32)(*@#</h2>
            <p class="lead mb-5">Oops! Looks like this page got scrambled</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="<?php echo base_url('login'); ?>" class="btn btn-primary">Go Home</a>
                <a href="#" class="btn btn-outline-secondary">Report Issue</a>
            </div>
        </div>
    </div>
</body>

</html>