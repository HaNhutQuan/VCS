<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title><?= $title; ?></title>
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
    <header class="p-3 mb-3 border-bottom">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <img src="<?php echo base_url('image/logo.svg'); ?>" width="40" height="40">
                <div class="dropdown text-end">
                    <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="<?= $_SESSION['user']['avatar_url']; ?>" alt="avatar" width="32" height="32" class="rounded-circle">
                    </a>
                    <ul class="dropdown-menu text-small">
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
            <div class="col-12 col-md-6">
                <div class="card border-0 shadow-lg text-center">
                    <div class="card-body">
                        <i class="fas fa-user-graduate fa-3x text-primary mb-3"></i>
                        <h5 class="card-title">Tổng số sinh viên</h5>
                        <p class="card-text fs-4 fw-bold"><?php echo count($students); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="card border-0 shadow-lg text-center">
                    <div class="card-body">
                        <i class="fas fa-book fa-3x text-warning mb-3"></i>
                        <h5 class="card-title">Bài tập đang giao</h5>
                        <p class="card-text fs-4 fw-bold">20</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-12 col-lg-8">
                <div class="card border-0 shadow-lg">
                    <div class="card-header bg-white border-0">
                        <h4 class="mb-0">Danh sách bài tập</h4>
                    </div>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên bài tập</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Toán - Hình học</td>
                                <td>
                                    <button class="btn btn-danger btn-sm">Xóa</button>
                                    <button class="btn btn-success btn-sm">Mở</button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Văn - Phân tích thơ</td>
                                <td>
                                    <button class="btn btn-danger btn-sm">Xóa</button>
                                    <button class="btn btn-success btn-sm">Mở</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="card border-0 shadow">

                    <div class="card-body d-grid gap-2">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#assignTaskModal">
                            <i class="fas fa-plus me-2"></i>Giao bài tập
                        </button>
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#manageStudentsModal">
                            <i class="fas fa-users me-2"></i>Quản lý sinh viên
                        </button>
                    </div>
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
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Tên bài tập</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mô tả</label>
                            <textarea class="form-control"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Giao bài</button>
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
                                <th>Thao tác</th>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>