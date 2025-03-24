document.addEventListener("DOMContentLoaded", function () {
    let toastElement = document.getElementById("toastAlert");
    if (toastElement) {
        setTimeout(() => {
            toastElement.classList.remove("show");
            toastElement.classList.add("fade");
            setTimeout(() => {
                toastElement.remove();
            }, 500);
        }, 3000);
    }
});