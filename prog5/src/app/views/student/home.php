<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Poppins:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('css/index.css'); ?>">
    <title><?= $title; ?></title>
</head>

<body>
    <?php

    ?>
    <?php if (!empty($_SESSION['errMessage'])) : ?>
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 1050;">
            <div id="toastAlert" class="alert alert-warning alert-dismissible fade show" role="alert">
                <span id="toastMessage"><?= htmlspecialchars($_SESSION['errMessage']); ?></span>
            </div>
        </div>
        <?php unset($_SESSION['errMessage']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['successMessage'])) : ?>
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 1050;">
            <div id="toastAlert" class="alert alert-success alert-dismissible fade show shadow-lg" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <span id="toastMessage"><?= htmlspecialchars($_SESSION['successMessage']); ?></span>
            </div>
        </div>
        <?php unset($_SESSION['successMessage']); ?>
    <?php endif; ?>

    <header class="p-3 mb-3 border-bottom bg-white shadow-sm">
        <div class="container d-flex justify-content-between align-items-center">
            <img src="/image/logo.svg" width="40" height="40">
            <div class="dropdown">
                <a href="profileDropdown" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                    <img src="<?= $_SESSION['user']['avatar_url']; ?>" alt="avatar" width="40" height="40" class="rounded-circle border border-2">
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="/profile?id=<?= $_SESSION['user']['id'] ?>">Hồ sơ cá nhân</a></li>
                    <li><a class="dropdown-item" href="#">Cài đặt</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item text-danger" href="/logout">Đăng xuất</a></li>
                </ul>
            </div>
        </div>
    </header>

    <div class="container mt-4">
        <h2 class="mb-3">Danh sách bài tập</h2>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Tiêu đề</th>
                    <th>Mô tả</th>
                    <th>Trạng thái</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($assignments as $assignment): ?>
                    <tr>
                        <td><?= htmlspecialchars($assignment['title']); ?></td>
                        <td><?= htmlspecialchars($assignment['description']); ?></td>
                        <td>
                            <?php if ($assignment['status'] === "pending"): ?>
                                <span class="badge bg-danger">Chưa nộp</span>
                            <?php elseif ($assignment['status'] === "teacher_updated"): ?>
                                <span class="badge bg-warning">Vừa cập nhật bài tập</span>
                            <?php else: ?>
                                <span class="badge bg-success">Đã nộp</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?= htmlspecialchars($assignment['file_url']); ?>" class="btn btn-secondary btn-sm" download>Tải xuống</a>
                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#submitAssignmentModal_<?= $assignment['assignment_id']; ?>">
                                Nộp bài
                            </button>
                        </td>
                    </tr>

                    <!-- Modal cho từng bài tập -->
                    <div class="modal fade" id="submitAssignmentModal_<?= $assignment['assignment_id']; ?>" tabindex="-1" aria-labelledby="submitAssignmentModalLabel_<?= $assignment['assignment_id']; ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="submitAssignmentModalLabel_<?= $assignment['assignment_id']; ?>">Nộp bài tập</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                                </div>
                                <form action="/student/submitSubmission" method="POST" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <input type="hidden" name="assignment_id" value="<?= htmlspecialchars($assignment['assignment_id']); ?>">
                                        <div class="mb-3">
                                            <label for="fileUpload_<?= $assignment['assignment_id']; ?>" class="form-label fw-bold">Chọn tệp bài làm</label>
                                            <input type="file" class="form-control" id="fileUpload_<?= $assignment['assignment_id']; ?>" name="file" required>
                                            <small class="text-muted">Chỉ hỗ trợ: PDF, DOC, DOCX, JPG, PNG</small>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                        <button type="submit" class="btn btn-success">Gửi bài</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="container mt-5">
        <h2 class="mb-3">Danh sách câu đố</h2>
        <div class="row">
            <?php foreach ($challenges as $challenge): ?>
                <div class="col-md-12">
                    <div class="card mb-3 shadow-sm">
                        <div class="card-body">
                            <p class="card-text"><?= htmlspecialchars($challenge['hint']); ?></p>
                            <form method="POST" action="/student/submitAnswer">
                                <div class="d-flex">
                                    <input type="hidden" name="hint" value="<?= htmlspecialchars($challenge['hint']); ?>">
                                    <input type="text" class="form-control answer-input me-2" name="answer" autocomplete="off" placeholder="Nhập đáp án" required>
                                    <button type="submit" class="btn btn-primary">Kiểm tra</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if (empty($challenges)): ?>
                <div class="col-md-12">
                    <div class="alert alert-warning text-center">
                        <strong>Hiện tại chưa có câu đố mới!</strong>
                    </div>
                </div>
            <? endif; ?>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row">
            <?php if (!empty($correctAnswers) && is_array($correctAnswers)): ?>
                <?php foreach ($correctAnswers as $correctAnswer): ?>
                    <div class="col-md-12">
                        <div class="card mb-3 shadow-sm border border-success"">
                            <div class=" card-body">
                            <p class="card-text">
                                <strong>Đáp án:</strong>
                                <span class="badge bg-success p-2"><?= htmlspecialchars($correctAnswer['answer']); ?></span>
                            </p>
                            <p class="card-text">
                                <strong>Gợi ý:</strong>
                                <span class="bg-light p-2 rounded d-block"><?= nl2br(htmlspecialchars($correctAnswer['hint'])); ?></span>
                            </p>
                            <p class="card-text">
                                <strong>Nội dung:</strong>
                                <span class="bg-light p-2 rounded d-block"><?= nl2br(htmlspecialchars($correctAnswer['content'])); ?></span>
                            </p>
                        </div>
                    </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="col-md-12">
        <div class="alert alert-warning text-center">
            <strong>Chưa có câu trả lời đúng nào!</strong>
        </div>
    </div>
<?php endif; ?>
    </div>
    </div>

    <button id="toggleUserList" class="btn position-fixed end-0 bottom-50 me-3">
        <i class="fas fa-angle-double-left"></i>
    </button>

    <div id="userSidebar" class="user-sidebar">
        <div class="d-flex justify-content-between align-items-center p-2 border-bottom">
            <h6 class="fw-bold mb-0">Người dùng</h6>
            <button id="closeSidebar" class="btn btn-light btn-sm">&times;</button>
        </div>

        <ul class="list-unstyled  flex-grow-1 px-2">
            <?php foreach ($users as $user): ?>
                <a href="/profile?id=<?= htmlspecialchars($user['id']); ?>" class="text-decoration-none text-muted">
                    <li class="d-flex align-items-center p-2 rounded user-item">
                        <img src="<?= htmlspecialchars($user['avatar_url']); ?>" alt="Avatar" class="rounded-circle me-2 user-avatar" />
                        <div class="d-flex flex-column">
                            <span class="fw-bold user-name <?= $user['role'] === 'teacher' ? 'text-danger' : '' ?>"><?= htmlspecialchars($user['full_name']); ?></span>
                        </div>
                        <input type="hidden" value="<?= htmlspecialchars($user['id']); ?>">
                    </li>
                </a>
            <?php endforeach; ?>
        </ul>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('js/sidebar.js') ?>"></script>
    <script src="<?= base_url('js/toast.js') ?>"></script>
</body>

</html>