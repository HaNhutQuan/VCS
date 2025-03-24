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
    <header class="p-3 mb-3 border-bottom bg-white shadow-sm">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <img src="<?php echo base_url('image/logo.svg'); ?>" width="40" height="40">

                <div class="dropdown text-end">
                    <a href="profileDropdown" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="<?= $_SESSION['user']['avatar_url']; ?>" alt="avatar" width="40" height="40" class="rounded-circle border border-2">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end text-small" aria-labelledby="profileDropdown">
                        <li><a class="dropdown-item" href="/profile?id=<?= $_SESSION['user']['id'] ?>">Hồ sơ cá nhân</a></li>
                        <li><a class="dropdown-item" href="#">Cài đặt</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item text-danger" href="<?php echo base_url('logout'); ?>">Đăng xuất</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>

    <div class="container py-4">
        <div class="row g-3 mb-4">
            <div class="col-12 col-md-4">
                <div class="card border-0 shadow-lg text-center">
                    <div class="card-body">
                        <i class="fas fa-user-graduate fa-3x mb-3"></i>
                        <h5 class="card-title">Tổng số sinh viên</h5>
                        <p class="card-text fs-4 fw-bold"><?php echo count($students); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card border-0 shadow-lg text-center">
                    <div class="card-body">
                        <i class="fas fa-book fa-3x mb-3"></i>
                        <h5 class="card-title">Tổng số bài tập đang giao</h5>
                        <p class="card-text fs-4 fw-bold"><?php echo count($assignments); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card border-0 shadow-lg text-center">
                    <div class="card-body">
                        <i class="fas fa-lightbulb fa-3x mb-3"></i>
                        <h5 class="card-title">Tổng số câu đố</h5>
                        <p class="card-text fs-4 fw-bold"><?php echo count($hintFiles); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-12 col-lg-8">

                <div class="card border-0 shadow-lg ">
                    <div class="card-header bg-white border-0">
                        <h4 class="mb-0">Danh sách bài tập</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th class="text-center" style="width: 10%;">ID</th>
                                    <th class="text-start" style="width: 60%;">Tên bài tập</th>
                                    <th class="text-center" style="width: 30%;">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $index = 1; ?>
                                <?php foreach ($assignments as $assignment) : ?>
                                    <tr>
                                        <td class="text-center"><?= $index++; ?></td>
                                        <td class="text-start"><?= htmlspecialchars($assignment['title']); ?></td>
                                        <td class="text-center">
                                            <a href='/teacher/deleteAssignment?id=<?= $assignment['id']; ?>' class='btn btn-danger btn-sm px-3'>Xóa</a>
                                            <a href='/teacher/assignment?id=<?= $assignment['id']; ?>' class='btn btn-success btn-sm px-3'>Mở</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card border-0 shadow-lg mt-4">
                    <div class="card-header bg-white border-0">
                        <h4 class="mb-0">Danh sách câu đố</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th>Gợi ý</th>
                                    <th>Đáp án</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $index = 1;
                                foreach ($hints as $h) : ?>
                                    <tr>
                                        <td class="text-center"><?= $index++; ?></td>
                                        <td><?= htmlspecialchars($h['hint']); ?></td>
                                        <td>
                                            <span class="badge bg-success text-dark p-2"><?= htmlspecialchars($h['answer']); ?></span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <div class="col-12 col-lg-4">
                <div class="card border-0 shadow">
                    <div class="card-body d-grid gap-2">
                        <button class="btn btn-down" data-bs-toggle="modal" data-bs-target="#assignTaskModal">
                            <i class="fas fa-plus me-2"></i>Giao bài tập
                        </button>
                        <button class="btn btn-down" data-bs-toggle="modal" data-bs-target="#createChallengeModal">
                            <i class="fas fa-question me-2"></i>Tạo câu đố
                        </button>
                        <button class="btn btn-down" data-bs-toggle="modal" data-bs-target="#manageSubmissionsModal">
                            <i class="fas fa-book-open me-2"></i>Danh sách nộp bài
                        </button>
                        <button class="btn btn-down" data-bs-toggle="modal" data-bs-target="#manageStudentsModal">
                            <i class="fas fa-users me-2"></i>Quản lý sinh viên
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="assignTaskModal" tabindex="-1" aria-labelledby="assignTaskModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="assignTaskModalLabel">Giao Bài Tập</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/teacher/createAssignment" method="POST" enctype="multipart/form-data">

                            <input type="hidden" name="teacher_id" value="<?= $_SESSION['user']['id']; ?>">


                            <div class="mb-3">
                                <label for="title" class="form-label">Tên bài tập</label>
                                <input type="text" class="form-control" id="title" name="title" required placeholder="Nhập tên bài tập">
                            </div>


                            <div class="mb-3">
                                <label for="description" class="form-label">Mô tả</label>
                                <textarea class="form-control" id="description" name="description" rows="3" placeholder="Nhập mô tả chi tiết"></textarea>
                            </div>


                            <div class="mb-3">
                                <label for="file" class="form-label">Tài liệu đính kèm</label>
                                <input type="file" class="form-control" id="file" name="file">
                            </div>

                            <!-- Nút Giao bài -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-success">Giao bài</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="createChallengeModal" tabindex="-1" aria-labelledby="createChallengeModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createChallengeModalLabel">Tạo câu đố mới</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/teacher/createChallenge" method="POST" enctype="multipart/form-data">

                            <input type="hidden" name="teacher_id" value="<?= $_SESSION['user']['id']; ?>">

                            <div class="mb-3">
                                <label for="hint" class="form-label"><strong>Gợi ý</strong></label>
                                <textarea class="form-control" id="hint" name="hint" rows="3" placeholder="Nhập mô gợi ý"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="file" class="form-label"><strong>Tệp bài thơ/văn</strong></label>
                                <input type="file" class="form-control" name="text_file" accept=".txt" required>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-success">Tạo câu đố</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="manageStudentsModal" tabindex="-1" aria-labelledby="manageStudentsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="manageStudentsModalLabel">Quản Lý Sinh Viên</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body overflow-auto">
                        <table class="table  table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Họ và Tên</th>
                                    <th>Email</th>
                                    <th>Số điện thoại</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $index = 1;
                                foreach ($students as $student) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($index) . "</td>";
                                    echo "<td>" . htmlspecialchars($student['full_name']) . "</td>";
                                    echo "<td>" . htmlspecialchars($student['email']) . "</td>";
                                    echo "<td>" . htmlspecialchars($student['phone']) . "</td>";
                                    echo "<td><a href='/profile?id=" . htmlspecialchars($student['id']) . "' class='btn btn-success btn-sm'>Chi tiết</a></td>";
                                    echo "</tr>";

                                    $index++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
        <div class="modal fade" id="manageSubmissionsModal" tabindex="-1" aria-labelledby="manageStudentsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="manageStudentsModalLabel">Danh sách nộp bài</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body overflow-auto">
                        <table class="table  table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Họ và Tên</th>
                                    <th>Tên bài tập</th>
                                    <th>Ngày nộp</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                $index = 1;
                                foreach ($submissions as $submission) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($index) . "</td>";
                                    echo "<td>" . htmlspecialchars($submission['full_name']) . "</td>";
                                    echo "<td>" . htmlspecialchars($submission['title']) . "</td>";
                                    $date = new DateTime($submission['submitted_at'], new DateTimeZone("UTC"));
                                    $date->setTimezone(new DateTimeZone("Asia/Ho_Chi_Minh"));
                                    echo "<td>" . htmlspecialchars($date->format("H:i:s d-m-Y")) . "</td>";
                                    echo "<td><a href='/teacher/getSubmission?id=" . htmlspecialchars($submission['submission_id']) . "' class='btn btn-success btn-sm'>Chi tiết</a></td>";
                                    echo "</tr>";

                                    $index++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="<?php echo base_url('js/toast.js') ?>"></script>
</body>

</html>