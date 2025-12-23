function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);

    if (input.type === "password") {
        input.type = "text";
        icon.innerText = "visibility_off"; // Ganti ikon menjadi mata dicoret/tertutup
    } else {
        input.type = "password";
        icon.innerText = "visibility"; // Ganti ikon menjadi mata terbuka
    }
}
