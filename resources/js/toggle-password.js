// resources/js/toggle-password.js

// PERBAIKAN: Gunakan 'window.togglePassword =' agar fungsi menjadi global
window.togglePassword = function (inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);

    if (input && icon) {
        // Tambahkan pengecekan null safety
        if (input.type === "password") {
            input.type = "text";
            icon.innerText = "visibility_off";
        } else {
            input.type = "password";
            icon.innerText = "visibility";
        }
    } else {
        console.error("Input or Icon element not found!");
    }
};
