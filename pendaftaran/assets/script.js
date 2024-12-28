document.addEventListener("DOMContentLoaded", function() {
    var currentStep = 0;
    showStep(currentStep);

        // Mengonversi input ke huruf kapital
    document.querySelectorAll('input[type="text"], input[type="date"], select').forEach(input => {
        input.addEventListener('input', function() {
            this.value = this.value.toUpperCase();
        });
    });

    // Hanya izinkan angka untuk NIK
    document.getElementById("nik").addEventListener("input", function() {
        this.value = this.value.replace(/[^0-9]/g, ''); // Hanya izinkan angka
    });

    document.getElementById("nomor_hp").addEventListener("input", function() {
        // Hanya izinkan angka
        this.value = this.value.replace(/[^0-9]/g, '');
    
        // Mengubah format dari 08xxx menjadi 8xxx
        if (this.value.startsWith("08")) {
            this.value = this.value.substring(1); // Menghapus angka 0 di depan
        }
    });

    // Memperbarui konfirmasi saat agama dipilih
    document.getElementById("agama").addEventListener("change", function() {
        console.log("Agama dipilih:", this.value); // Log nilai agama yang dipilih
        updateConfirmation(); // Memperbarui konfirmasi saat agama dipilih
    });

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
        var jurusan = document.getElementById("jurusan").value;
        var tanggal = document.getElementById("tanggal").value;
        var nik = document.getElementById("nik").value;
        var agama = document.getElementById("agama").value;
        document.getElementById("confirmation").innerHTML = `
            <p><strong>Name:</strong> ${name}</p>
            <p><strong>Email:</strong> ${email}</p>
            <p><strong>Jurusan:</strong> ${jurusan}</p>
            <p><strong>Tanggal:</strong> ${tanggal}</p>
            <p><strong>NIK:</strong> ${nik}</p>
            <p><strong>Agama:</strong> ${agama}</p>
        `;
    }

    document.querySelectorAll(".next").forEach(button => {
        button.addEventListener("click", function() {
            if (currentStep < document.querySelectorAll(".step").length - 1) {
                if (validateStep(currentStep)) {
                    currentStep++;
                    showStep(currentStep);
                }
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
        if (validateStep(currentStep)) {
            alert("Form submitted!");
        }
    });

    function validateStep(step) {
        var isValid = true;

        if (step === 0) {
            var name = document.getElementById("name").value;
            var tempat_lahir = document.getElementById("tempat_lahir").value;
            var tanggal = document.getElementById("tanggal").value;
            var nik = document.getElementById("nik").value;
            var nomor_hp = document.getElementById("nomor_hp").value;
            var agama = document.getElementById("agama").value;

            
            console.log("Validating Step 1");
            console.log("Name:", name);
            console.log("Tempat Lahir:", tempat_lahir);
            console.log("Tanggal Lahir:", tanggal);
            console.log("NIK:", nik);
            console.log("Nomor HP:", nomor_hp);
            console.log("Agama:", agama);

            if (name.trim() === "") {
                document.getElementById("name").classList.add("invalid");
                document.getElementById("name-error").innerHTML = "Nama tidak boleh kosong";
                isValid = false;
            } else if (!name.match(/^[a-zA-Z ]+$/)) {
                document.getElementById("name").classList.add("invalid");
                document.getElementById("name-error").innerHTML = "Nama tidak boleh mengandung angka atau karakter khusus";
                isValid = false;
            } else {
                document.getElementById("name").classList.remove("invalid");
                document.getElementById("name").classList.add("valid");
                document.getElementById("name-error").innerHTML = "";
            }

            if (!tempat_lahir) {
                document.getElementById("tempat_lahir").classList.add("invalid");
                document.getElementById("tempat_lahir-error").innerHTML = "Tempat lahir harus diisi";
                isValid = false;
            } else {
                document.getElementById("tempat_lahir").classList.remove("invalid");
                document.getElementById("tempat_lahir").classList.add("valid");
                document.getElementById("tempat_lahir-error").innerHTML = "";
            }

            if (!tanggal) {
                document.getElementById("tanggal").classList.add("invalid");
                document.getElementById("tanggal-error").innerHTML = "Tanggal lahir harus diisi";
                isValid = false;
            } else {
                document.getElementById("tanggal").classList.remove("invalid");
                document.getElementById("tanggal").classList.add("valid");
                document.getElementById("tanggal-error").innerHTML = "";
            }

            if (!nik.match(/^[0-9]+$/)) {
                document.getElementById("nik").classList.add("invalid");
                document.getElementById("nik-error").innerHTML = "NIK tidak boleh mengandung huruf";
                isValid = false;
            } else if (nik.length !== 16) {
                document.getElementById("nik").classList.add("invalid");
                document.getElementById("nik-error").innerHTML = "NIK harus terdiri dari 16 digit";
                isValid = false;
            } else {
                document.getElementById("nik").classList.remove("invalid");
                document.getElementById("nik").classList.add("valid");
                document.getElementById("nik-error").innerHTML = "";
            }

            if (!nomor_hp.match(/^[0-9]+$/)) {
                document.getElementById("nomor_hp").classList.add("invalid");
                document.getElementById("nomor_hp-error").innerHTML = "Nomor HP tidak boleh mengandung huruf";
                isValid = false;
            } else {
                document.getElementById("nomor_hp").classList.remove("invalid");
                document.getElementById("nomor_hp").classList.add("valid");
                document.getElementById("nomor_hp-error").innerHTML = "";
            }

            if (nomor_hp.length < 10 || nomor_hp.length > 13) {
                document.getElementById("nomor_hp").classList.add("invalid");
                document.getElementById("nomor_hp-error").innerHTML = "Nomor HP harus berisi 10-13 digit";
                isValid = false;
            } else {
                document.getElementById("nomor_hp").classList.remove("invalid");
                document.getElementById("nomor_hp").classList.add("valid");
                document.getElementById("nomor_hp-error").innerHTML = "";
            }

            // Validasi Nomor HP
            if (!nomor_hp.match(/^[0-9]+$/)) {
                document.getElementById("nomor_hp").classList.add("invalid");
                document.getElementById("nomor_hp-error").innerHTML = "Nomor HP hanya boleh terdiri dari angka";
                isValid = false;
            } else if (nomor_hp.length < 10 || nomor_hp.length > 13) {
                document.getElementById("nomor_hp").classList.add("invalid");
                document.getElementById("nomor_hp-error").innerHTML = "Nomor HP harus berisi 10-13 digit";
                isValid = false;
            } else if (!nomor_hp.startsWith("8")) { // Memastikan nomor HP diawali dengan 8 setelah menghapus 0
                document.getElementById("nomor_hp").classList.add("invalid");
                document.getElementById("nomor_hp-error").innerHTML = "Nomor HP harus diawali dengan 8";
                isValid = false;
            } else {
                document.getElementById("nomor_hp").classList.remove("invalid");
                document.getElementById("nomor_hp").classList.add("valid");
                document.getElementById("nomor_hp-error").innerHTML = "";
            }

            if (agama === "") {
                document.getElementById("agama").classList.add("invalid");
                document.getElementById("agama-error").innerHTML = "Agama harus dipilih";
                isValid = false;
            } else {
                document.getElementById("agama").classList.remove("invalid");
                document.getElementById("agama-error").innerHTML = "";
            }

            // Simpan data ke cookie
            document.cookie = `name=${name}; expires=Fri, 31 Dec 9999 23:59:59 GMT`;
            document.cookie = `email=${email}; expires=Fri, 31 Dec 9999 23:59:59 GMT`;
            document.cookie = `tempat_lahir=${tempat_lahir}; expires=Fri, 31 Dec 9999 23:59:59 GMT`;
            document.cookie = `tanggal=${tanggal}; expires=Fri, 31 Dec 9999 23:59:59 GMT`;
            document.cookie = `nik=${nik}; expires=Fri, 31 Dec 9999 23:59:59 GMT`;
            document.cookie = `nomor_hp=${nomor_hp}; expires=Fri, 31 Dec 9999 23:59:59 GMT`;
        }

        return isValid;
    }

    // Load data dari cookie
    var cookies = document.cookie.split("; ");
    cookies.forEach(cookie => {
        var [key, value] = cookie.split("=");
        if (key === "name") {
            document.getElementById("name").value = value;
        } else if (key === "email") {
            document.getElementById("email").value = value;
        } else if (key === "tempat_lahir") {
            document.getElementById("tempat_lahir").value = value;
        } else if (key === "tanggal") {
            document.getElementById("tanggal").value = value;
        } else if (key === "nik") {
            document.getElementById("nik").value = value;
        } else if (key === "nomor_hp") {
            document.getElementById("nomor_hp").value = value;
        }
    });
});
