<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= $title; ?></title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet" />
    <script
        src="https://kit.fontawesome.com/a076d05399.js"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?php echo base_url("css/profile.css"); ?>">
</head>

<body>
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
            <a href="javascript:history.go(-1)" class="btn btn-secondary btn-custom">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
            <?php if ($isTeacher && $isStudent): ?>
                <a
                    href="/student/delete?id=<?php echo $user['id']; ?>"
                    class="btn btn-danger btn-custom"
                    onclick="return confirm('Bạn có chắc muốn xóa sinh viên này không?');">
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
                action="/student/update"
                method="POST"
                class="modal-content"
                enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">
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
                        value="<?php echo $user['id']; ?>" />
                    <div class="mb-3">
                        <label for="username" class="form-label">Tài khoản</label>
                        <input
                            type="text"
                            class="form-control"
                            id="username"
                            name="username"
                            value="<?php echo $user['username']; ?>"
                            readonly />
                    </div>
                    <div class="mb-3">
                        <label for="full_name" class="form-label">Họ tên</label>
                        <input
                            type="text"
                            class="form-control"
                            id="full_name"
                            name="full_name"
                            value="<?php echo $user['full_name']; ?>" />
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input
                            type="email"
                            class="form-control"
                            id="email"
                            name="email"
                            value="<?php echo $user['email']; ?>" />
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input
                            type="text"
                            class="form-control"
                            id="phone"
                            name="phone"
                            value="<?php echo $user['phone']; ?>" />
                    </div>
                    <div class="mb-3">
                        <label for="avatar" class="form-label">Upload Avatar</label>
                        <input
                            type="file"
                            class="form-control"
                            id="avatar"
                            name="avatar" />
                    </div>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>