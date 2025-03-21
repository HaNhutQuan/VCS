<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('css/style.css'); ?>">
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
    <?php if (!empty($errMessage)) : ?>
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 1050;">
            <div id="toastAlert" class="alert alert-warning alert-dismissible fade show" role="alert">
                <span id="toastMessage"><?= htmlspecialchars($errMessage); ?></span>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    <?php endif; ?>
    <div class="login-container">
        <img src="<?php echo base_url("image/logo.svg"); ?>" alt="Logo" width="100">
        <form method="POST" class="needs-validation" novalidate action="login" autocomplete="off">
            <div class="mb-3 text-start">
                <label class="mb-2 text-muted" for="email">Tên tài khoản</label>
                <input id="email" type="email" class="form-control" name="username" required autofocus>
                <div class="invalid-feedback">
                    Vui lòng nhập tên tài khoản.
                </div>
            </div>

            <div class="mb-3 text-start">
                <label class="mb-2 text-muted" for="password">Mật khẩu</label>
                <input id="password" type="password" class="form-control" name="password" required>
                <div class="invalid-feedback">
                    Vui lòng nhập mật khẩu.
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="#" class="text-muted">Quên mật khẩu?</a>
            </div>

            <button type="submit" class="btn btn-primary">Đăng nhập</button>

            <div class="text-center mt-3 text-muted">
                Bạn chưa có tài khoản? <a href="<?php echo base_url('register'); ?>">Đăng ký ngay</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>