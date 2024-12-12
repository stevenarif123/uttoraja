// script.js
document.addEventListener("DOMContentLoaded", function() {
    var currentStep = 0;
    showStep(currentStep);

    function showStep(n) {
        var steps = document.querySelectorAll(".step");
        steps.forEach((step, index) => {
            step.classList.remove("active");
            if (index === n) {
                step.classList.add("active");
            }
        });
        updateConfirmation();
    }

    function updateConfirmation() {
        var name = document.getElementById("name").value;
        var email = document.getElementById("email").value;
        var jurusan = document.getElementById("jurusan").value;
        var tanggal = document.getElementById("tanggal").value;
        var nik = document.getElementById("nik").value;
        var nomor_hp = document.getElementById("nomor_hp").value;
        document.getElementById("confirmation").innerHTML = `
            <p><strong>Name:</strong> ${name}</p>
            <p><strong>Email:</strong> ${email}</p>
            <p><strong>Jurusan:</strong> ${jurusan}</p>
            <p><strong>Tanggal:</strong> ${tanggal}</p>
            <p><strong>NIK:</strong> ${nik}</p>
            <p><strong>Nomor HP:</strong> ${nomor_hp}</p>
        `;
    }

    document.querySelectorAll(".next").forEach(button => {
        button.addEventListener("click", function() {
            if (currentStep < document.querySelectorAll(".step").length - 1) {
                var name = document.getElementById("name").value;
                var email = document.getElementById("email").value;
                var jurusan = document.getElementById("jurusan").value;
                var tanggal = document.getElementById("tanggal").value;
                var nik = document.getElementById("nik").value;
                var nomor_hp = document.getElementById("nomor_hp").value;

                if (!name.match(/^[a-zA-Z ]+$/)) {
                    document.getElementById("name").classList.add("invalid");
                    document.getElementById("name-error").innerHTML = "Nama tidak boleh mengandung angka";
                    return;
                } else {
                    document.getElementById("name").classList.remove("invalid");
                    document.getElementById("name").classList.add("valid");
                    document.getElementById("name-error").innerHTML = "";
                }

                if (!email.match(/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/)) {
                    document.getElementById("email").classList.add("invalid");
                    document.getElementById("email-error").innerHTML = "Email tidak valid";
                    return;
                } else {
                    document.getElementById("email").classList.remove("invalid");
                    document.getElementById("email").classList.add("valid");
                    document.getElementById("email-error").innerHTML = "";
                }

                if (!nik.match(/^[0-9]+$/)) {
                    document.getElementById("nik").classList.add("invalid");
                    document.getElementById("nik-error").innerHTML = "NIK tidak boleh mengandung huruf";
                    return;
                } else {
                    document.getElementById("nik").classList.remove("invalid");
                    document.getElementById("nik").classList.add("valid");
                    document.getElementById("nik-error").innerHTML = "";
                }

                if (!nomor_hp.match(/^[0-9]+$/)) {
                    document.getElementById("nomor_hp").classList.add("invalid");
                    document.getElementById("nomor_hp-error").innerHTML = "Nomor HP tidak boleh mengandung huruf";
                    return;
                } else {
                    document.getElementById("nomor_hp").classList.remove("invalid");
                    document.getElementById("nomor_hp").classList.add("valid");
                    document.getElementById("nomor_hp-error").innerHTML = "";
                }

                if (nomor_hp.length < 10 || nomor_hp.length > 13) {
                    document.getElementById("nomor_hp").classList.add("invalid");
                    document.getElementById("nomor_hp-error").innerHTML = "Nomor HP harus berisi 10-13 digit";
                    return;
                } else {
                    document.getElementById("nomor_hp").classList.remove("invalid");
                    document.getElementById("nomor_hp").classList.add("valid");
                    document.getElementById("nomor_hp-error").innerHTML = "";
                }

                if (!nomor_hp.startsWith("08")) {
                    document.getElementById("nomor_hp").classList.add("invalid");
                    document.getElementById("nomor_hp-error").innerHTML = "Nomor HP harus diawali dengan 08";
                    return;
                } else {
                    document.getElementById("nomor_hp").classList.remove("invalid");
                    document.getElementById("nomor_hp").classList.add("valid");
                    document.getElementById("nomor_hp-error").innerHTML = "";
                }

                // Simpan data ke cookie
                document.cookie = `name=${name}; expires=Fri, 31 Dec 9999 23:59:59 GMT`;
                document.cookie = `email=${email}; expires=Fri, 31 Dec 9999 23:59:59 GMT`;
                document.cookie = `jurusan=${jurusan}; expires=Fri, 31 Dec 9999 23:59:59 GMT`;
                document.cookie = `tanggal=${tanggal}; expires=Fri, 31 Dec 9999 23:59:59 GMT`;
                document.cookie = `nik=${nik}; expires=Fri, 31 Dec 9999 23:59:59 GMT`;
                document.cookie = `nomor_hp=${nomor_hp}; expires=Fri, 31 Dec 9999 23:59:59 GMT`;
                currentStep++;
                showStep(currentStep);
            }
        });
    });

    document.querySelectorAll(".prev").forEach(button => {
        button.addEventListener("click", function() {
            if (currentStep > 0) {
                currentStep--;
                showStep(currentStep);
            }
        });
    });

    document.getElementById("regForm").addEventListener("submit", function(event) {
        event.preventDefault();
        alert("Form submitted!");
    });

    // Load data dari cookie
    var cookies = document.cookie.split("; ");
    cookies.forEach(cookie => {
        var [key, value] = cookie.split("=");
        if (key === "name") {
            document.getElementById("name").value = value;
        } else if (key === "email") {
            document.getElementById("email").value = value;
        } else if (key === "jurusan") {
            document.getElementById("jurusan").value = value;
        } else if (key === "tanggal") {
            document.getElementById("tanggal").value = value;
        } else if (key === "nik") {
            document.getElementById("nik").value = value;
        } else if (key === "nomor_hp") {
            document.getElementById("nomor_hp").value = value;
        }
    });
});
