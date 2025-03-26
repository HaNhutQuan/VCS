document.addEventListener("DOMContentLoaded", function () {
    const messages = document.querySelectorAll(".message");
    messages.forEach((msg) => {
        msg.addEventListener("click", function (e) {
            e.preventDefault();

            const senderId = this.getAttribute("data-sender-id");
            const currentUserId = this.getAttribute("data-user-id");

            if (senderId !== currentUserId) return;

            const messageId = this.getAttribute("data-message-id");
            const messageContent = this.getAttribute("data-content");


            document.getElementById("editMessageId").value = messageId;
            document.getElementById("deleteMessageId").value = messageId;
            document.getElementById("editMessageContent").value = messageContent;

            new bootstrap.Modal(document.getElementById("messageOptions")).show();
        });

    });
});
