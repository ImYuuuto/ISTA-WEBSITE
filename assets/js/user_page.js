/**
 * user_page.js
 * Logic for student dashboard: logout and profile photo upload.
 */
document.addEventListener('DOMContentLoaded', () => {
    const logoutBtn = document.getElementById("logoutBtn");
    if (logoutBtn) {
        logoutBtn.addEventListener("click", () => {
            fetch("../assets/php/auth.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    action: "logout",
                    csrf_token: CSRF_TOKEN
                })
            })
                .then(response => response.json())
                .then(result => {
                    if (result.status === "success") {
                        window.location.href = "inscrire.php";
                    }
                })
                .catch(error => console.error("Error:", error));
        });
    }

    const uploadPhotoBtn = document.getElementById("uploadPhotoBtn");
    const photoInput = document.getElementById("photoInput");
    const profileImg = document.getElementById("profileImg");

    if (uploadPhotoBtn && photoInput) {
        uploadPhotoBtn.addEventListener("click", () => photoInput.click());

        photoInput.addEventListener("change", () => {
            if (photoInput.files.length > 0) {
                const formData = new FormData();
                formData.append("profile_image", photoInput.files[0]);
                formData.append("csrf_token", CSRF_TOKEN);

                uploadPhotoBtn.disabled = true;
                uploadPhotoBtn.innerHTML = "<span class='spinner-border spinner-border-sm'></span>";

                fetch("../assets/php/upload_profile.php", {
                    method: "POST",
                    body: formData
                })
                    .then(response => response.json())
                    .then(result => {
                        if (result.status === "success") {
                            profileImg.src = "../assets/php/" + result.path + "?t=" + new Date().getTime();
                            alert("Photo de profil mise à jour !");
                        } else {
                            alert("Erreur: " + result.message);
                        }
                    })
                    .catch(error => console.error("Error:", error))
                    .finally(() => {
                        uploadPhotoBtn.disabled = false;
                        uploadPhotoBtn.innerHTML = "<i class='bi bi-camera-fill'></i>";
                    });
            }
        });
    }
});
