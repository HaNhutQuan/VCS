const toggleUserList = document.getElementById("toggleUserList");
const userSidebar = document.getElementById("userSidebar");
const closeSidebar = document.getElementById("closeSidebar");

toggleUserList.addEventListener("click", function () {
    userSidebar.classList.add("active");
    toggleUserList.style.display = "none"; 
});


closeSidebar.addEventListener("click", function () {
    userSidebar.classList.remove("active");
    toggleUserList.style.display = "block";
});