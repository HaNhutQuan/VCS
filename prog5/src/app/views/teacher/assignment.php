<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Poppins:wght@600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('css/404.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('css/index.css'); ?>">
    <title><?= $title; ?></title>
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
    <div class="container mt-4">
        <div class="card shadow-lg">

            <form method="post" enctype="multipart/form-data" action="/teacher/updateAssignment">
                <div class="card-body">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($assignment['id']); ?>">
                    <div class="mb-3">
                        <label for="title" class="form-label fw-bold">Tên bài tập</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($assignment['title'] ?? ''); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label fw-bold">Mô tả</label>
                        <textarea class="form-control" id="description" name="description" rows="4"><?php echo htmlspecialchars($assignment['description'] ?? ''); ?></textarea>
                    </div>
                    <div class="mt-3 text-start">
                        <?php if (!empty($assignment['file_url'])): ?>
                            <?php
                            $file_url = htmlspecialchars($assignment['file_url']);
                            $file_extension = strtolower(pathinfo($file_url, PATHINFO_EXTENSION));
                            ?>

                            <p class="fw-bold">Tệp hiện tại:</p>
                            <!-- Preview Image -->
                            <?php if (in_array($file_extension, ['jpg', 'jpeg', 'png', 'svg'])): ?>
                                <img src="<?= $file_url; ?>" alt="Preview" style="max-width: 100%; height: auto; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                            <?php elseif ($file_extension === 'pdf'): ?>
                                <!-- Preview PDF -->
                                <iframe src="<?= $file_url; ?>" width="100%" height="500px" style="border: none;"></iframe>
                            <?php elseif (in_array($file_extension, ['doc', 'docx'])): ?>
                                <!-- Preview doc, docx-->
                                <iframe src="https://docs.google.com/gview?url=<?= urlencode($file_url); ?>&embedded=true" width="100%" height="500px"></iframe>
                            <?php else: ?>
                                <p>Không thể preview loại tệp này. <a href="<?= $file_url; ?>" class="btn btn-primary" download>Tải xuống</a></p>
                            <?php endif; ?>

                            <input type="hidden" name="file_url" value="<?= $file_url; ?>">
                        <?php endif; ?>
                    </div>

                    <div class="mt-3">
                        <label for="file" class="form-label fw-bold">Tải lên tệp mới</label>
                        <input type="file" class="form-control" id="file" name="new_file">
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" onclick="history.back()">Quay lại</button>
                    <button type="submit" class="btn btn-success">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url('js/toast.js') ?>"></script>
</body>

</html>