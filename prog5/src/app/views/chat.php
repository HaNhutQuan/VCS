<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Poppins:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('css/chat.css'); ?>">
    <title>Chat với</title>
</head>

<body>
    <div class="chat-container">
        <div class="chat-header d-flex align-items-center justify-content-between shadow-sm p-3 bg-white">

            <div class="d-flex align-items-center">
                <img src="https://via.placeholder.com/40" class="rounded-circle me-2" alt="Avatar">
                <span class="chat-title fw-bold">Nhật Quang</span>
            </div>
            <a class="btn btn-danger" href="/student/home">
                <i class="bi bi-house-door"></i>
            </a>
        </div>

        <div class="chat-body" id="chatBody">
            <div class="message received">Chào bạn!</div>
            <div class="message sent">Xin chào!</div>
            <div class="message received">Bạn khỏe không?</div>
        </div>
        <div class="chat-footer">
            <input type="text" id="messageInput" placeholder="Aa" autocomplete="off">
            <button onclick="sendMessage()">Gửi</button>
        </div>
    </div>

    <script>
        function sendMessage() {
            var input = document.getElementById("messageInput");
            var message = input.value.trim();
            if (message) {
                var chatBody = document.getElementById("chatBody");
                var messageElement = document.createElement("div");
                messageElement.classList.add("message", "sent");
                messageElement.textContent = message;
                chatBody.appendChild(messageElement);
                input.value = "";
                chatBody.scrollTop = chatBody.scrollHeight;
            }
        }
    </script>
</body>

</html>