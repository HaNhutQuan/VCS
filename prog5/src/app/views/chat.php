<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Poppins:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('css/chat.css'); ?>">
    <title><?= $title . " " . $user['full_name'] ?></title>
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
    <div class="chat-container">
        <div class="chat-header d-flex align-items-center justify-content-between shadow-sm p-3 bg-white">

            <div class="d-flex align-items-center">
                <img src="<?= $user['avatar_url']; ?>" class="rounded-circle me-2" alt="Avatar">
                <span class="chat-title fw-bold"><?= $user['full_name']; ?></span>
            </div>
            <a class="btn btn-danger" href="/<?= $_SESSION['user']['role']; ?>/home">
                <i class="bi bi-house-door"></i>
            </a>
        </div>

        <div class="chat-body" id="chatBody">
            <?php foreach ($messages as $message): ?>
                <div class="message <?php echo $message['sender_id'] === $user['id'] ? 'received' : 'sent'; ?>"
                    data-message-id="<?= $message['id']; ?>"
                    data-content="<?= $message['content']; ?>"
                    data-user-id="<?= $_SESSION['user']['id']; ?>"   
                    data-sender-id="<?= $message['sender_id']; ?>"
                    >
                    <?= nl2br((htmlspecialchars($message['content']))); ?>
                </div>

            <?php endforeach; ?>
        </div>
        <form method="POST" action="/chat/send">
            <div class="chat-footer">
                <input type="hidden" name="receiver_id" value="<?php echo htmlspecialchars($user['id']); ?>" />
                <input type="hidden" name="sender_id" value="<?php echo htmlspecialchars($_SESSION['user']['id']); ?>" />
                <input type="text" id="messageInput" placeholder="Aa" autocomplete="off" name="content" />
                <button type="submit"><i class="material-icons isend">send</i></button>
            </div>
        </form>
    </div>
    <div class="modal fade" id="messageOptions" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tùy chọn tin nhắn</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editMessageForm" action="/chat/editMessage" method="POST">
                        <input type="hidden" name="id" id="editMessageId">
                        <input type="hidden" name="receiver_id" value="<?= $user['id']; ?>">
                        <textarea class="form-control mb-2" name="content" id="editMessageContent"></textarea>
                    </form>
                </div>
                <div class="modal-footer d-flex justify-content-end gap-2">
                    <form action="/chat/deleteMessage" method="POST">
                        <input type="hidden" name="id" id="deleteMessageId">
                        <input type="hidden" name="receiver_id" value="<?= $user['id']; ?>">
                        <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                    </form>
                    <button type="submit" form="editMessageForm" class="btn btn-success btn-sm">Lưu</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url("js/chat.js") ?>"></script>
    <script src="<?= base_url("js/toast.js") ?>"></script>
</body>

</html>