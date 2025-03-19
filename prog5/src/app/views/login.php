<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('css/style.css'); ?>">
</head>

<body>
    
 
    <div class="login-container">
    <img src="<?php echo base_url("image/logo.svg"); ?>" alt="Logo" width="100">
        <form method="POST" class="needs-validation" novalidate>
            <div class="mb-3 text-start">
                <label class="mb-2 text-muted" for="email">Tên tài khoản</label>
                <input id="email" type="email" class="form-control" name="email" required autofocus>
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

            <button type="submit" class="btn btn-custom">Đăng nhập</button>

            <div class="text-center mt-3 text-muted">
                Bạn chưa có tài khoản? <a href="<?php echo base_url('register'); ?>">Đăng ký ngay</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>