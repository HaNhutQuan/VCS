<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Poppins:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('css/style.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url("css/index.css"); ?>">
    <title><?= $title; ?></title>
</head>

<body>
    <div class="login-container">
        <img src="<?php echo base_url("image/logo.svg"); ?>" alt="Logo" width="80">
        <form method="POST" class="needs-validation" novalidate id="registerForm">
            <div class="mb-3 text-start">
                <label class="mb-2 text-muted" for="email">Tên tài khoản</label>
                <input id="email" type="email" class="form-control" name="email" required autofocus>
                <div class="invalid-feedback">
                    Vui lòng nhập tên tài khoản.
                </div>
            </div>

            <div class="mb-3 text-start">
                <label class="mb-2 text-muted" for="password">Mật khẩu</label>
                <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password">
                <div class="invalid-feedback">
                    Vui lòng nhập mật khẩu.
                </div>
            </div>
            <div class="mb-3 text-start">
                <label class="mb-2 text-muted" for="confirmPassword">Xác nhận mật khẩu</label>
                <input id="confirmPassword" type="password" class="form-control" name="confirmPassword" required autocomplete="new-password">
                <div class="invalid-feedback">
                    Vui lòng nhập mật khẩu.
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Đăng ký</button>

            <div class="text-center mt-3 text-muted">
                Bạn đã có tài khoản? <a href="<?php echo base_url('login'); ?>">Đăng nhập ngay</a>
            </div>
        </form>
        <div class="modal fade" id="warningModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-warning text-white">
                        <h5 class="modal-title">Thông báo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-start">Chức năng đăng ký bị giới hạn. Nếu bạn cần tài khoản, hãy liên hệ quản trị viên để được hỗ trợ.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url('js/register.js'); ?>"></script>
    <script src="<?php echo base_url('js/toast.js') ?>"></script>
</body>

</html>