<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= $title; ?></title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha384-3TTOkDqU0UygpTuAjrsxU3dSYbAGIoXt2L7/g7K+d8ag04z4kEl+4Ub5q69T9aD2" crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Poppins:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url("css/profile.css"); ?>">
    <link rel="stylesheet" href="<?php echo base_url('css/index.css'); ?>">
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

    <?php if (!empty($successMessage)) : ?>
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 1050;">
            <div id="toastAlert" class="alert alert-success alert-dismissible fade show shadow-lg" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <span id="toastMessage"><?= htmlspecialchars($successMessage); ?></span>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    <?php endif; ?>

    <div class="profile-card">
        <div class="profile-header">
            <?php $role = $user['role'] === 'teacher' ? 'giáo viên' : 'sinh viên'; ?>
            <h2 class="fw-bold">Thông tin <?= $role; ?></h2>
        </div>
        <div class="profile-body">
            <div class="row align-items-center">

                <div class="col-md-4 text-center mb-3 mb-md-0">
                    <img
                        src="<?php echo $user['avatar_url']; ?>"
                        alt="Avatar"
                        class="profile-img" />
                </div>

                <div class="col-md-8">
                    <div class="card shadow-sm p-4">

                        <h4 class="mb-3 text-primary"><i class="fas fa-id-badge"></i> Thông Tin Cá Nhân</h4>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <i class="fas fa-user-graduate text-secondary"></i> <strong>Vai trò:</strong>
                                <span class="badge <?= $user['role'] === 'teacher' ? 'bg-danger' : 'bg-success'; ?> text-white"><?= ucfirst(htmlspecialchars($role)) ?></span>
                            </li>
                            <li class="list-group-item">
                                <i class="fas fa-user-edit text-secondary"></i> <strong>Họ tên:</strong>
                                <span class="text-dark"><?= htmlspecialchars($user['full_name']) ?></span>
                            </li>
                            <li class="list-group-item">
                                <i class="fas fa-user text-secondary"></i> <strong>Tài khoản:</strong>
                                <span class="text-dark"><?= htmlspecialchars($user['username']) ?></span>
                            </li>
                            <li class="list-group-item">
                                <i class="fas fa-envelope text-secondary"></i> <strong>Email:</strong>
                                <span class="text-dark"><?= htmlspecialchars($user['email']) ?></span>
                            </li>
                            <li class="list-group-item">
                                <i class="fas fa-phone text-secondary"></i> <strong>SĐT:</strong>
                                <span class="text-dark"><?= $user['phone'] ? htmlspecialchars($user['phone']) : '<span class="text-muted">Chưa cập nhật</span>'; ?></span>
                            </li>

                        </ul>
                    </div>
                </div>

            </div>
        </div>

        <?php
        $loggedInUser = $_SESSION['user'];
        $isTeacher = ($loggedInUser['role'] === 'teacher');
        $isSelf = ($loggedInUser['id'] === $user['id']);
        $isStudent = ($user['role'] === 'student');
        ?>

        <div class="profile-footer">
            <a href="<?= $_SESSION['user']['role']; ?>/home" class="btn btn-secondary btn-custom">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
            <?php if ($isTeacher && $isStudent): ?>
                <a href="#" class="btn btn-danger btn-custom" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
                    <i class="fas fa-trash"></i> Xóa
                </a>
            <?php endif; ?>
            <?php if ($isSelf || ($isTeacher && $isStudent)): ?>
                <button
                    class="btn btn-success btn-custom"
                    data-bs-toggle="modal"
                    data-bs-target="#editModal">
                    <i class="fas fa-edit"></i> Chỉnh sửa
                </button>
            <?php endif; ?>
        </div>
    </div>


    <div
        class="modal fade"
        id="editModal"
        tabindex="-1"
        aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form
                action="/profile"
                method="POST"
                class="modal-content"
                enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="editModalLabel">
                        Chỉnh sửa thông tin sinh viên
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Đóng"></button>
                </div>
                <div class="modal-body">

                    <input
                        type="hidden"
                        name="id"
                        value="<?php echo htmlspecialchars($user['id']); ?>" />
                    <div class="mb-3">
                        <label for="username" class="form-label">Tài khoản</label>
                        <input
                            type="text"
                            class="form-control"
                            id="username"
                            value="<?php echo $user['username']; ?>"
                            <?php if ($isStudent): ?>
                            readonly disabled
                            <?php else: ?>
                            name="username"
                            <?php endif; ?> />
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mật khẩu</label>
                        <input
                            type="password"
                            class="form-control"
                            id="password"
                            name="password"
                            value="" />
                    </div>
                    <div class="mb-3">
                        <label for="full_name" class="form-label">Họ tên</label>
                        <input
                            type="text"
                            class="form-control"
                            id="full_name"
                            value="<?php echo htmlspecialchars($user['full_name']); ?>"
                            <?php if ($isStudent): ?>
                            readonly disabled
                            <?php else: ?>
                            name="full_name"
                            <?php endif; ?> />
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input
                            type="email"
                            class="form-control"
                            id="email"
                            name="email"
                            value="<?php echo htmlspecialchars($user['email']); ?>" />
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input
                            type="text"
                            class="form-control"
                            id="phone"
                            name="phone"
                            value="<?php echo htmlspecialchars($user['phone']); ?>" />
                    </div>
                    <?php if ($isStudent && $isSelf) : ?>
                        <div class="mb-3">
                            <label for="avatar" class="form-label">Upload Avatar</label>
                            <input
                                type="file"
                                class="form-control"
                                id="avatar"
                                name="avatar" />
                        </div>
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                        Đóng
                    </button>
                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteLabel">Xác nhận xóa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Bạn có chắc chắn muốn xóa sinh viên này không?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <!-- Form Xóa Dùng POST -->
                    <form method="POST" action="/deleteUser">
                        <input type="hidden" name="id" value="<?= $user['id']; ?>">
                        <button type="submit" class="btn btn-danger">Xóa</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const urlParams = new URLSearchParams(window.location.search);

            if (!urlParams.has("id")) {
                const userId = "<?php echo isset($user['id']) ? htmlspecialchars($user['id']) : ''; ?>";

                if (userId) {
                    urlParams.set("id", userId);
                    const newUrl = window.location.pathname + "?" + urlParams.toString();
                    history.replaceState(null, "", newUrl);
                }
            }
        });
    </script>
</body>

</html>