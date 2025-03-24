<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title><?= $title; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Poppins:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('css/index.css'); ?>">
</head>

<body>
    <?php
    $uploadDir = __DIR__ . "/../../storage/uploads/";
    $hintFiles = glob($uploadDir . '*.hint');
    $hints = [];
    foreach ($hintFiles as $hintFile) {
        $hintContent = file_get_contents($hintFile);
        $answerBase = pathinfo($hintFile, PATHINFO_FILENAME);
        $hints[] = [
            'hint' => $hintContent,
            'answer' => $answerBase,
        ];
    }
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
                <a href="#" class="d-block text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
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
                                <form action="/student/submit" method="POST" enctype="multipart/form-data">
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
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Gợi ý</th>
                    <th>Nhập đáp án</th>
                    <?php if (!empty($isCheckChallengeDisabled)): ?>
                    <th>Nội dung</th>
                    <th>Kết quả</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($hints as $h): ?>
                    <tr>
                        <td class="text-wrap"><?= htmlspecialchars($h['hint']); ?></td>
                        <td>
                            <input type="text" class="form-control answer-input" data-challenge-id="<?= $challenge['id']; ?>">
                        </td>
                        <td>
                            <button class="btn btn-primary btn-check-answer" data-challenge-id="<?= $challenge['id']; ?>">Kiểm tra</button>
                            <div class="result mt-2 text-success fw-bold" id="result_<?= $challenge['id']; ?>"></div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url('js/toast.js') ?>"></script>
</body>

</html>