// Utility functions
function toUpperCase(input) {
    input.value = input.value.toUpperCase();
}

function formatDate(input) {
    let value = input.value.replace(/\D/g, '');
    if (value.length > 8) {
        value = value.substring(0, 8);
    }
    let formattedValue = '';
    if (value.length >= 2) {
        formattedValue += value.substring(0, 2) + '/';
        if (value.length >= 4) {
            formattedValue += value.substring(2, 4) + '/';
            if (value.length >= 8) {
                formattedValue += value.substring(4, 8);
            }
        }
    } else {
        formattedValue = value;
    }
    input.value = formattedValue;
}

// Validation functions
function showError(inputId, message) {
    let errorSpan = document.getElementById(`${inputId}-error`);
    if (!errorSpan) {
        const inputField = document.getElementById(inputId);
        errorSpan = document.createElement('span');
        errorSpan.id = `${inputId}-error`;
        errorSpan.classList.add('error-message');
        inputField.parentElement.appendChild(errorSpan);
    }
    errorSpan.textContent = message;
}

function clearError(inputId) {
    const errorSpan = document.getElementById(`${inputId}-error`);
    if (errorSpan) {
        errorSpan.remove();
    }
}

// Event handlers
document.addEventListener('DOMContentLoaded', function() {
    // Phone validation
    const phoneInput = document.getElementById('phone');
    if (phoneInput) {
        phoneInput.addEventListener('input', function() {
            let phoneNumber = this.value.replace(/\D/g, '');
            if (phoneNumber.startsWith('08')) {
                phoneNumber = '+62' + phoneNumber.substring(1);
                if (phoneNumber.length > 15) {
                    phoneNumber = phoneNumber.substring(0, 15);
                }
            } else {
                showError('phone', 'Nomor HP harus diawali dengan 08');
            }
            this.value = phoneNumber;
            if (phoneNumber.length < 11 || phoneNumber.length > 15) {
                showError('phone', 'Nomor HP harus 11-13 angka (08xxxxxxxxxx)');
            } else {
                clearError('phone');
            }
        });
    }

    // NIK validation
    const nikInput = document.getElementById('nik');
    if (nikInput) {
        nikInput.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '').substring(0, 16);
            if (this.value.length !== 16) {
                showError('nik', 'NIK harus 16 angka');
            } else {
                clearError('nik');
            }
        });
    }

    // Form multi-step handling
    const form = document.getElementById('pendaftaranForm');
    if (form) {
        const steps = form.querySelectorAll('.form-step');
        const progressSteps = form.querySelectorAll('.progress-step');

        // Next step handlers
        form.querySelectorAll('.next-step').forEach(button => {
            button.addEventListener('click', function() {
                const currentStep = this.closest('.form-step');
                const nextStep = currentStep.nextElementSibling;
                if (validateStep(currentStep)) {
                    currentStep.classList.remove('active');
                    nextStep.classList.add('active');
                    updateProgress('next', currentStep.dataset.step);
                }
            });
        });

        // Previous step handlers
        form.querySelectorAll('.prev-step').forEach(button => {
            button.addEventListener('click', function() {
                const currentStep = this.closest('.form-step');
                const prevStep = currentStep.previousElementSibling;
                currentStep.classList.remove('active');
                prevStep.classList.add('active');
                updateProgress('prev', currentStep.dataset.step);
            });
        });

        // Form submission handler
        form.addEventListener('submit', handleFormSubmit);
    }

    // Work status handler
    const bekerjaYa = document.getElementById('bekerja_ya');
    const bekerjaTidak = document.getElementById('bekerja_tidak');
    const tempatKerjaContainer = document.getElementById('tempat_kerja_container');

    if (bekerjaYa && bekerjaTidak && tempatKerjaContainer) {
        bekerjaYa.addEventListener('change', function() {
            if (this.checked) tempatKerjaContainer.style.display = 'block';
        });
        bekerjaTidak.addEventListener('change', function() {
            if (this.checked) tempatKerjaContainer.style.display = 'none';
        });
    }
    
    // Date input handling
    const dateInput = document.getElementById('tanggal_lahir');
    if (dateInput) {
        // Set max date to today
        const today = new Date();
        const maxDate = today.toISOString().split('T')[0];
        dateInput.setAttribute('max', maxDate);
        
        // Set min date to 1940-01-01
        dateInput.setAttribute('min', '1940-01-01');
        
        // Clear validation message when user starts typing
        dateInput.addEventListener('input', function() {
            this.setCustomValidity('');
        });
    }

    // Format date on form submission
    if (form) {
        form.addEventListener('submit', function(e) {
            const dateInput = document.getElementById('tanggal_lahir');
            if (dateInput && dateInput.value) {
                const date = new Date(dateInput.value);
                const formattedDate = [
                    String(date.getDate()).padStart(2, '0'),
                    String(date.getMonth() + 1).padStart(2, '0'),
                    date.getFullYear()
                ].join('/');
                
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'formatted_date';
                hiddenInput.value = formattedDate;
                this.appendChild(hiddenInput);
            }
        });
    }

    // Modal functionality
    const modal = document.getElementById('petunjukModal');
    const closeIcon = document.getElementById('closeModal');
    const closeBtn = document.getElementById('closeModalBtn');

    if (modal && closeIcon && closeBtn) {
        // Close modal when clicking X or close button
        closeIcon.onclick = function() {
            modal.style.display = "none";
        }
        
        closeBtn.onclick = function() {
            modal.style.display = "none";
        }
        
        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    }
});

// Form submission handler
async function handleFormSubmit(e) {
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);
    
    try {
        const response = await fetch('pendaftaran.php', {
            method: 'POST',
            body: formData
        });
        const data = await response.text();
        
        try {
            const jsonData = JSON.parse(data);
            if (jsonData.error) {
                showAlert('error', jsonData.error);
            }
        } catch(e) {
            if (data.trim() === 'success') {
                window.location.href = 'success.php';
            } else {
                showAlert('warning', `Terjadi kesalahan: ${data}`);
            }
        }
    } catch(error) {
        console.error('Error:', error);
        showAlert('error', 'Terjadi kesalahan pada server. Silakan coba lagi.');
    }
}

// Helper functions for form steps
function validateStep(step) {
    let isValid = true;
    const inputs = step.querySelectorAll('input[required], select[required]');
    inputs.forEach(input => {
        if (!input.value) {
            isValid = false;
            showError(input.id, 'Field ini wajib diisi');
        } else {
            clearError(input.id);
        }
    });
    return isValid;
}

function updateProgress(direction, stepNumber) {
    const step = parseInt(stepNumber);
    const progressSteps = document.querySelectorAll('.progress-step');
    
    progressSteps.forEach(progressStep => {
        const stepNum = parseInt(progressStep.dataset.step);
        if (direction === 'next' && stepNum <= step + 1) {
            progressStep.classList.add('active');
            if (stepNum < step + 1) progressStep.classList.add('completed');
        } else if (direction === 'prev' && stepNum > step - 1) {
            progressStep.classList.remove('active', 'completed');
        }
    });
}

// Date formatting and validation
function formatTanggalLahir(value, element) {
    // ...existing date formatting code...
}

// Enhanced date validation
function validateDate(dateString) {
    const parts = dateString.split('/');
    if (parts.length !== 3) return false;

    const day = parseInt(parts[0]);
    const month = parseInt(parts[1]);
    const year = parseInt(parts[2]);
    
    // Validate month
    if (month < 1 || month > 12) return false;
    
    // Validate day
    const daysInMonth = new Date(year, month, 0).getDate();
    if (day < 1 || day > daysInMonth) return false;
    
    // Validate year
    const currentYear = new Date().getFullYear();
    if (year < 1940 || year > currentYear) return false;
    
    return true;
}

// Alert helper function
function showAlert(type, message) {
    const alertContainer = document.getElementById('alert-container');
    if (alertContainer) {
        alertContainer.innerHTML = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        `;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
}
