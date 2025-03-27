<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('css/404.css'); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Poppins:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('css/index.css'); ?>">
</head>

<body>
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
    <?php
    $fileUrl = $submission['file_url'];
    $fileExtension = strtolower(pathinfo($fileUrl, PATHINFO_EXTENSION));
    ?>
    <div class="container mt-4">
        <div class="card shadow-lg">
            <form method="post" enctype="multipart/form-data" action="/teacher/updateSubmission">
                <div class="card-body">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($submission['id']); ?>">
                    <div class="mb-3">
                        <label for="title" class="form-label fw-bold">Tên sinh viên</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($student['full_name'] ?? ''); ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="title" class="form-label fw-bold">Tên bài tập</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($assignment['title'] ?? ''); ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label fw-bold">Mô tả</label>
                        <textarea class="form-control" id="description" name="description" rows="4" readonly><?php echo htmlspecialchars($assignment['description'] ?? ''); ?></textarea>
                    </div>
                    <div class="mt-3 text-start">
                    <label for="description" class="form-label fw-bold">Bài nộp</label>
                        <div class="text-center">
                            <?php if (in_array($fileExtension, ['jpg', 'jpeg', 'png'])): ?>
                                <img src="<?= htmlspecialchars($fileUrl) ?>" class="img-fluid rounded shadow-sm" alt="Preview">

                            <?php elseif ($fileExtension === 'pdf'): ?>
                                <iframe src="<?= htmlspecialchars($fileUrl) ?>" width="100%" height="500px" class="border rounded"></iframe>

                            <?php elseif (in_array($fileExtension, ['doc', 'docx'])): ?>
                                <iframe src="https://docs.google.com/gview?url=<?= urlencode($fileUrl) ?>&embedded=true" width="100%" height="500px" class="border rounded"></iframe>

                            <?php else: ?>
                                <p class="text-danger">Không hỗ trợ hiển thị loại file này.</p>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" onclick="history.back()"><i class="fas fa-arrow-left"></i> Quay lại</button>
                    <a href="<?= htmlspecialchars($fileUrl); ?>" class="btn btn-success" download>
                        <i class="fa fa-download"></i> Tải xuống
                    </a>
                </div>
        </div>
        </form>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url('js/toast.js') ?>"></script>
</body>

</html>