// Core utility functions
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

// Error handling and validation
function showError(inputId, message) {
    const container = document.getElementById(inputId)?.closest('.field-container') || 
                     document.querySelector(`[name="${inputId}"]`)?.closest('.field-container') ||
                     document.querySelector(`[name="${inputId}"]`)?.closest('.radio-field');
    
    if (container) {
        const errorSpan = document.createElement('span');
        errorSpan.className = 'error-message';
        errorSpan.textContent = message;
        container.appendChild(errorSpan);
        container.classList.add('has-error');
    }
}

function clearError(inputId) {
    const element = document.getElementById(inputId);
    if (!element) return;
    
    const container = element.closest('.field-container');
    if (!container) return;
    
    const errorSpan = container.querySelector('.error-message');
    if (errorSpan) {
        errorSpan.remove();
        container.classList.remove('has-error');
    }
}

function clearErrors(step) {
    if (!step) return;
    step.querySelectorAll('.error-message').forEach(msg => msg.remove());
    step.querySelectorAll('.has-error').forEach(field => field.classList.remove('has-error'));
}

// Form validation functions
function validateStep(step) {
    let isValid = true;
    const errors = [];
    console.log('Validating step:', step.dataset.step);

    clearErrors(step);

    switch(step.dataset.step) {
        case '1':
            isValid = validateStepOne(step, errors);
            break;
        case '2':
            isValid = validateStepTwo(step, errors);
            break;
        case '3':
            isValid = validateStepThree(step, errors);
            break;
    }

    if (errors.length > 0) {
        errors.forEach(error => {
            showError(error.field, error.message);
        });
        isValid = false;
    }

    return isValid;
}

function validateStepOne(step) {
    const errors = [];

    const jalurProgram = step.querySelector('input[name="jalur_program"]:checked');
    if (!jalurProgram) {
        errors.push({ field: 'jalur_program', message: 'Pilih jalur program' });
    }

    const jurusan = document.getElementById('jurusan');
    if (!jurusan || !jurusan.value) {
        errors.push({ field: 'jurusan', message: 'Pilih jurusan' });
    }

    const nama = document.getElementById('firstn');
    if (!nama || !nama.value.trim()) {
        errors.push({ field: 'firstn', message: 'Nama lengkap wajib diisi' });
    }

    return errors.length === 0;
}

function validateStepTwo(step) {
    // Implement step two validation logic
    return true;
}

function validateStepThree(step) {
    // Implement step three validation logic
    return true;
}

// Form step navigation
function moveToNextStep(currentStep, nextStep) {
    if (!nextStep) return;
    
    currentStep.classList.remove('active');
    nextStep.classList.add('active');
    updateProgress('next', currentStep.dataset.step);
    nextStep.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function moveToPrevStep(currentStep, prevStep) {
    if (!prevStep) return;
    
    currentStep.classList.remove('active');
    prevStep.classList.add('active');
    updateProgress('prev', currentStep.dataset.step);
    prevStep.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

// Progress tracking
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

// Initialize all form components and event listeners
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('pendaftaranForm');
    
    if (form) {
        initializeFormSteps(form);
        initializeValidation(form);
        initializeDropdowns();
        form.addEventListener('submit', handleFormSubmit);
    }

    initializeDomicileHandlers();
    initializeSearchableDropdowns();
    initializeKelurahanDropdown();
    setupDateValidation();
    setupModalHandlers();
});

// Event handlers
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('pendaftaranForm');
    
    // Initialize all components
    initializeDomicileHandlers();
    initializeSearchableDropdowns();
    initializeKelurahanDropdown();
    
    // Initialize popovers if Bootstrap is loaded
    if (typeof $ !== 'undefined') {
        $('[data-toggle="popover"]').popover({
            placement: 'right',
            html: true,
            trigger: 'hover focus'
        });
    }

    // Keep popover open on hover
    $('.help-icon').on('mouseover', function () {
        $(this).popover('show');
    }).on('mouseout', function () {
        $(this).popover('hide');
    });
    
    // Close popover when clicking outside
    $(document).on('click', function (e) {
        if ($(e.target).data('toggle') !== 'popover' 
            && $(e.target).parents('.popover.show').length === 0) {
            $('[data-toggle="popover"]').popover('hide');
        }
    });

    // Jurusan and Fakultas handler
    const jurusanSelect = document.getElementById('jurusan');
    const fakultasInput = document.getElementById('fakultas');

    if (jurusanSelect && fakultasInput) {
        jurusanSelect.addEventListener('change', function() {
            const selectedJurusan = this.value;
            console.log('Selected Jurusan:', selectedJurusan); // Debug
            console.log('Available data:', jurusanData); // Desbug
            
            if (jurusanData[selectedJurusan]) {
                fakultasInput.value = jurusanData[selectedJurusan];
                fakultasInput.classList.add('filled');
            } else {
                fakultasInput.value = 'Fakultas tidak ditemukan';
                fakultasInput.classList.remove('filled');
            }
        });
    }
    
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
    if (form) {
        initializeFormSteps(form);
        initializeValidation(form);
        initializeDropdowns();
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
        const maxDate = new Date();
        maxDate.setFullYear(maxDate.getFullYear() - 15);
        const maxDateString = maxDate.toISOString().split('T')[0];
        
        dateInput.setAttribute('max', maxDateString);
        dateInput.setAttribute('min', '1940-01-01');
        
        // Prevent manual date entry and enforce picker
        dateInput.addEventListener('keydown', function(e) {
            e.preventDefault();
        });

        // Enhanced date validation
        dateInput.addEventListener('change', function() {
            const selectedDate = new Date(this.value);
            const wrapper = this.closest('.date-picker-wrapper');
            
            // Clear previous states
            wrapper.classList.remove('error');
            clearError('tanggal_lahir');

            // Validate year range
            if (selectedDate.getFullYear() >= 2011) {
                wrapper.classList.add('error');
                this.value = '';
                showError('tanggal_lahir', 'Pilih tahun sebelum 2011');
                return false;
            }

            // Validate age requirement
            if (selectedDate > maxDate) {
                wrapper.classList.add('error');
                this.value = '';
                showError('tanggal_lahir', 'Usia minimal untuk mendaftar adalah 15 tahun');
                return false;
            }

            // Validate minimum date
            if (selectedDate < new Date('1940-01-01')) {
                wrapper.classList.add('error');
                this.value = '';
                showError('tanggal_lahir', 'Tanggal lahir tidak valid (minimal tahun 1940)');
                return false;
            }
        });

        // Format display date on focus out
        dateInput.addEventListener('blur', function() {
            if (this.value) {
                const date = new Date(this.value);
                const formattedDate = date.toLocaleDateString('id-ID', {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric'
                });
                this.setAttribute('data-date', formattedDate);
            }
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

    // Searchable Select Implementation
    const searchInput = document.querySelector('.select-search');
    const selectItems = document.querySelector('.select-items');
    const hiddenInput = document.querySelector('#jurusan');
    const dropdownIcon = document.querySelector('.searchable-select-container .dropdown-icon');
    const options = selectItems.querySelectorAll('div');

    // Show/hide dropdown on search input focus
    searchInput.addEventListener('focus', function() {
        selectItems.classList.remove('select-hide');
    });

    // Handle click outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.searchable-select-container')) {
            selectItems.classList.add('select-hide');
        }
    });

    // Handle search
    searchInput.addEventListener('input', function() {
        const filter = this.value.toLowerCase();
        options.forEach(option => {
            const txtValue = option.textContent || option.innerText;
            if (txtValue.toLowerCase().indexOf(filter) > -1) {
                option.style.display = "";
            } else {
                option.style.display = "none";
            }
        });
    });

    // Handle option selection
    options.forEach(option => {
        option.addEventListener('click', function() {
            const value = this.getAttribute('data-value');
            searchInput.value = this.textContent;
            hiddenInput.value = value;
            selectItems.classList.add('select-hide');
            
            // Trigger fakultas update
            if (typeof updateFakultas === 'function') {
                updateFakultas(value);
            }
        });
    });

    // Toggle dropdown on icon click
    dropdownIcon.addEventListener('click', function() {
        selectItems.classList.toggle('select-hide');
        searchInput.focus();
    });

    // Initialize kelurahan dropdown immediately
    initializeKelurahanDropdown();

    // Fetch kelurahan data and populate dropdown
    fetch('get_kelurahan.php')
        .then(response => response.json())
        .then(data => {
            const dropdownList = document.querySelector('#toraja_fields .dropdown-list');
            const searchInput = document.querySelector('#toraja_fields .dropdown-search');
            const hiddenInput = document.getElementById('kelurahan');
            
            function populateDropdown(items) {
                dropdownList.innerHTML = '';
                items.forEach(item => {
                    const div = document.createElement('div');
                    div.className = 'dropdown-item';
                    div.textContent = item.area_name;
                    div.dataset.kecamatan = item.district_name;
                    div.dataset.kabupaten = item.kabupaten_name;
                    dropdownList.appendChild(div);
                });
            }

            // Initial population
            populateDropdown(data);

            // Search functionality
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const filtered = data.filter(item => 
                    item.area_name.toLowerCase().includes(searchTerm)
                );
                populateDropdown(filtered);
            });

            // Selection handling
            dropdownList.addEventListener('click', function(e) {
                if (e.target.classList.contains('dropdown-item')) {
                    const selectedArea = e.target;
                    hiddenInput.value = selectedArea.textContent;
                    searchInput.value = selectedArea.textContent;
                    document.getElementById('kecamatan').value = selectedArea.dataset.kecamatan;
                    document.getElementById('kabupaten').value = selectedArea.dataset.kabupaten;
                    dropdownList.style.display = 'none';
                }
            });

            // Show/hide dropdown list
            searchInput.addEventListener('focus', () => dropdownList.style.display = 'block');
            document.addEventListener('click', (e) => {
                if (!e.target.closest('.searchable-dropdown')) {
                    dropdownList.style.display = 'none';
                }
            });
        });
});

// Add this new function outside DOMContentLoaded
function initializeKelurahanDropdown() {
    const dropdownContainer = document.querySelector('#toraja_fields .searchable-dropdown');
    const dropdownList = document.querySelector('#toraja_fields .dropdown-list');
    const searchInput = document.querySelector('#toraja_fields .dropdown-search');
    const hiddenInput = document.getElementById('kelurahan');
    
    if (!dropdownContainer || !dropdownList || !searchInput || !hiddenInput) {
        console.error('Required kelurahan dropdown elements not found');
        return;
    }

    // Show loading state
    searchInput.placeholder = 'Loading data...';
    searchInput.disabled = true;

    fetch('get_kelurahan.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                throw new Error(data.error);
            }

            // Reset input state
            searchInput.placeholder = 'Cari Kelurahan/Lembang...';
            searchInput.disabled = false;

            // Clear and populate dropdown
            dropdownList.innerHTML = '';
            
            if (data.length === 0) {
                const emptyMessage = document.createElement('div');
                emptyMessage.className = 'dropdown-item';
                emptyMessage.textContent = 'Tidak ada data tersedia';
                dropdownList.appendChild(emptyMessage);
                return;
            }

            data.forEach(item => {
                const div = document.createElement('div');
                div.className = 'dropdown-item';
                div.textContent = item.display_name;
                div.dataset.kecamatan = item.district_name;
                div.dataset.kabupaten = item.kabupaten_name;
                dropdownList.appendChild(div);
            });

            // Update event listeners
            searchInput.addEventListener('focus', () => {
                dropdownList.style.display = 'block';
            });

            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const items = dropdownList.getElementsByClassName('dropdown-item');
                
                Array.from(items).forEach(item => {
                    const text = item.textContent.toLowerCase();
                    item.style.display = text.includes(searchTerm) ? '' : 'none';
                });
            });

            dropdownList.addEventListener('click', function(e) {
                const item = e.target.closest('.dropdown-item');
                if (!item) return;
                
                searchInput.value = item.textContent;
                hiddenInput.value = item.textContent;
                
                // Update related fields
                if (item.dataset.kecamatan) {
                    document.getElementById('kecamatan').value = item.dataset.kecamatan;
                }
                if (item.dataset.kabupaten) {
                    document.getElementById('kabupaten').value = item.dataset.kabupaten;
                }
                
                dropdownList.style.display = 'none';
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', (e) => {
                if (!dropdownContainer.contains(e.target)) {
                    dropdownList.style.display = 'none';
                }
            });

        })
        .catch(error => {
            console.error('Error:', error);
            searchInput.placeholder = 'Error loading data';
            searchInput.disabled = true;
            
            // Show error message in dropdown
            dropdownList.innerHTML = `
                <div class="dropdown-item error">
                    Error: ${error.message}. Please refresh the page or contact support.
                </div>
            `;
        });
}

// Move the Domicile radio button handlers outside of DOMContentLoaded
function initializeDomicileHandlers() {
    const torajaRadio = document.getElementById('toraja');
    const luarTorajaRadio = document.getElementById('luar_toraja');
    const torajaFields = document.getElementById('toraja_fields');
    const luarTorajaFields = document.getElementById('luar_toraja_fields');

    if (!torajaRadio || !luarTorajaRadio || !torajaFields || !luarTorajaFields) {
        console.error('Domicile elements not found:', {
            torajaRadio: !!torajaRadio,
            luarTorajaRadio: !!luarTorajaRadio,
            torajaFields: !!torajaFields,
            luarTorajaFields: !!luarTorajaFields
        });
        return;
    }

    function toggleDomicileFields() {
        console.log('Toggle called:', {
            torajaChecked: torajaRadio.checked,
            luarTorajaChecked: luarTorajaRadio.checked
        });

        if (torajaRadio.checked) {
            torajaFields.style.display = 'block';
            luarTorajaFields.style.display = 'none';
            document.getElementById('kelurahan').setAttribute('required', 'required');
            const domisiliManual = document.getElementById('domisili_manual');
            if (domisiliManual) {
                domisiliManual.removeAttribute('required');
            }
        } else if (luarTorajaRadio.checked) {
            torajaFields.style.display = 'none';
            luarTorajaFields.style.display = 'block';
            const domisiliManual = document.getElementById('domisili_manual');
            if (domisiliManual) {
                domisiliManual.setAttribute('required', 'required');
            }
            document.getElementById('kelurahan').removeAttribute('required');
        }
    }

    // Add change listeners
    torajaRadio.addEventListener('change', toggleDomicileFields);
    luarTorajaRadio.addEventListener('change', toggleDomicileFields);

    // Initialize on page load
    if (torajaRadio.checked || luarTorajaRadio.checked) {
        toggleDomicileFields();
    }
}

// Searchable Dropdown Implementation
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('.dropdown-search');
    const dropdownList = document.querySelector('.dropdown-list');
    const dropdownItems = document.querySelectorAll('.dropdown-item');
    const hiddenInput = document.getElementById('jurusan');
    const fakultasInput = document.getElementById('fakultas');

    // Clear search input when clicking after a selection
    searchInput.addEventListener('click', function() {
        if (hiddenInput.value) { // Only clear if a value has been selected
            this.value = '';
            // Show all options again
            dropdownItems.forEach(item => {
                item.classList.remove('hidden');
            });
            dropdownList.classList.add('active');
        }
    });

    // Show dropdown on input focus
    searchInput.addEventListener('focus', function() {
        dropdownList.classList.add('active');
        // Clear input if there's a selected value
        if (hiddenInput.value) {
            this.value = '';
            // Show all options again
            dropdownItems.forEach(item => {
                item.classList.remove('hidden');
            });
        }
    });

    // Hide dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.searchable-dropdown')) {
            dropdownList.classList.remove('active');
        }
    });

    // Filter dropdown items
    searchInput.addEventListener('input', function() {
        const searchText = this.value.toLowerCase();
        let hasMatch = false;

        dropdownItems.forEach(item => {
            const text = item.textContent.toLowerCase();
            if (text.includes(searchText)) {
                item.classList.remove('hidden');
                hasMatch = true;
            } else {
                item.classList.add('hidden');
            }
        });

        // Show/hide dropdown based on matches
        if (hasMatch) {
            dropdownList.classList.add('active');
        } else {
            dropdownList.classList.remove('active');
        }
    });

    // Handle item selection
    dropdownItems.forEach(item => {
        item.addEventListener('click', function() {
            const value = this.dataset.value;
            searchInput.value = this.textContent;
            hiddenInput.value = value;
            dropdownList.classList.remove('active');

            // Update fakultas if jurusanData is available
            if (typeof jurusanData !== 'undefined' && jurusanData[value]) {
                fakultasInput.value = jurusanData[value];
                fakultasInput.classList.add('filled');
            }

            // Remove selected class from all items
            dropdownItems.forEach(di => di.classList.remove('selected'));
            // Add selected class to clicked item
            this.classList.add('selected');
        });
    });

    // Initialize domicile handlers
    initializeDomicileHandlers();
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
    console.log('Validating step:', step.dataset.step); // Debug log

    // Clear previous errors
    step.querySelectorAll('.error-message').forEach(msg => msg.remove());
    step.querySelectorAll('.has-error').forEach(field => field.classList.remove('has-error'));

    if (step.dataset.step === '1') {
        // Validate jalur program
        const jalurProgram = step.querySelector('input[name="jalur_program"]:checked');
        if (!jalurProgram) {
            isValid = false;
            const container = step.querySelector('.radio-field');
            container.classList.add('has-error');
            showError('jalur_program', 'Pilih jalur program');
        }

        // Validate jurusan
        const jurusan = document.getElementById('jurusan');
        if (!jurusan.value) {
            isValid = false;
            const container = jurusan.closest('.field-container');
            container.classList.add('has-error');
            showError('jurusan', 'Pilih jurusan');
        }

        // Validate nama lengkap
        const nama = document.getElementById('firstn');
        if (!nama.value.trim()) {
            isValid = false;
            const container = nama.closest('.field-container');
            container.classList.add('has-error');
            showError('firstn', 'Nama lengkap wajib diisi');
        }

        console.log('Step 1 validation result:', isValid); // Debug log
    }

    // Add validation for other steps here...

    return isValid;
}

// Update event listener for next step buttons
document.addEventListener('DOMContentLoaded', function() {
    // ...existing code...

    // Next step handlers with debug logging
    form.querySelectorAll('.next-step').forEach(button => {
        button.addEventListener('click', function() {
            const currentStep = this.closest('.form-step');
            const nextStep = currentStep.nextElementSibling;
            console.log('Current step:', currentStep.dataset.step); // Debug log
            
            if (validateStep(currentStep)) {
                console.log('Validation passed, moving to next step'); // Debug log
                currentStep.classList.remove('active');
                nextStep.classList.add('active');
                updateProgress('next', currentStep.dataset.step);
            } else {
                console.log('Validation failed'); // Debug log
            }
        });
    });

    // ...existing code...
});

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

function validateDateOfBirth(dateString) {
    const today = new Date();
    const minDate = new Date('1940-01-01');
    const maxDate = new Date(today.getFullYear() - 15, today.getMonth(), today.getDate());
    const inputDate = new Date(dateString);

    if (inputDate < minDate) {
        return "Tanggal lahir tidak valid (minimal tahun 1940)";
    }
    
    if (inputDate > maxDate) {
        return "Usia minimal untuk mendaftar adalah 15 tahun";
    }

    return "";
}

// Enhanced form step handling
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('pendaftaranForm');
    
    if (form) {
        initializeFormSteps(form);
        initializeValidation(form);
        initializeDropdowns();
    }
});

function initializeFormSteps(form) {
    if (!form) return;

    form.querySelectorAll('.next-step').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const currentStep = this.closest('.form-step');
            const nextStep = currentStep.nextElementSibling;
            
            console.log('Attempting to move to next step');
            
            if (validateStep(currentStep)) {
                console.log('Step validation passed');
                currentStep.classList.remove('active');
                nextStep.classList.add('active');
                updateProgress('next', currentStep.dataset.step);
            } else {
                console.log('Step validation failed');
            }
        });
    });

    // Previous step handlers
    form.querySelectorAll('.prev-step').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const currentStep = this.closest('.form-step');
            const prevStep = currentStep.previousElementSibling;
            moveToPrevStep(currentStep, prevStep);
        });
    });
}

function moveToNextStep(currentStep, nextStep) {
    if (!nextStep) return;
    
    currentStep.classList.remove('active');
    nextStep.classList.add('active');
    updateProgress('next', currentStep.dataset.step);
    
    // Scroll to top of form
    nextStep.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function moveToPrevStep(currentStep, prevStep) {
    if (!prevStep) return;
    
    currentStep.classList.remove('active');
    prevStep.classList.add('active');
    updateProgress('prev', currentStep.dataset.step);
    
    // Scroll to top of form
    prevStep.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

// Enhanced dropdown initialization
function initializeDropdowns() {
    const searchableDropdowns = document.querySelectorAll('.searchable-dropdown');
    
    searchableDropdowns.forEach(dropdown => {
        const searchInput = dropdown.querySelector('.dropdown-search');
        const dropdownList = dropdown.querySelector('.dropdown-list');
        const hiddenInput = dropdown.querySelector('input[type="hidden"]');
        
        if (!searchInput || !dropdownList || !hiddenInput) return;
        
        setupDropdownHandlers(searchInput, dropdownList, hiddenInput);
    });
}

function setupDropdownHandlers(searchInput, dropdownList, hiddenInput) {
    // Show dropdown on focus
    searchInput.addEventListener('focus', () => {
        dropdownList.style.display = 'block';
    });

    // Filter items on input
    searchInput.addEventListener('input', () => {
        const searchTerm = searchInput.value.toLowerCase();
        filterDropdownItems(dropdownList, searchTerm);
    });

    // Handle selection
    dropdownList.addEventListener('click', (e) => {
        if (e.target.classList.contains('dropdown-item')) {
            handleDropdownSelection(e.target, searchInput, hiddenInput, dropdownList);
        }
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.searchable-dropdown')) {
            dropdownList.style.display = 'none';
        }
    });
}

// Add missing initialization functions
function initializeSearchableDropdowns() {
    const searchableDropdowns = document.querySelectorAll('.searchable-dropdown');
    searchableDropdowns.forEach(dropdown => {
        const searchInput = dropdown.querySelector('.dropdown-search');
        const dropdownList = dropdown.querySelector('.dropdown-list');
        const hiddenInput = dropdown.querySelector('input[type="hidden"]');
        
        if (searchInput && dropdownList && hiddenInput) {
            setupDropdownHandlers(searchInput, dropdownList, hiddenInput);
        }
    });
}

function initializeValidation(form) {
    // Add validation listeners to all required fields
    const requiredFields = form.querySelectorAll('[required]');
    requiredFields.forEach(field => {
        field.addEventListener('blur', () => {
            validateField(field);
        });
    });

    // Add form submit validation
    form.addEventListener('submit', handleFormSubmit);
}

function validateField(field) {
    const container = field.closest('.field-container');
    if (!container) return;

    clearError(field.id);
    if (!field.value.trim()) {
        showError(field.id, `${field.placeholder || 'Field ini'} wajib diisi`);
        return false;
    }
    return true;
}

// Add missing clearErrors function
function clearErrors(step) {
    if (!step) return;
    step.querySelectorAll('.error-message').forEach(msg => msg.remove());
    step.querySelectorAll('.has-error').forEach(field => field.classList.remove('has-error'));
}

// Add missing dropdown helper functions
function filterDropdownItems(dropdownList, searchTerm) {
    const items = dropdownList.getElementsByClassName('dropdown-item');
    Array.from(items).forEach(item => {
        const text = item.textContent.toLowerCase();
        item.style.display = text.includes(searchTerm) ? '' : 'none';
    });
}

function handleDropdownSelection(selectedItem, searchInput, hiddenInput, dropdownList) {
    searchInput.value = selectedItem.textContent;
    hiddenInput.value = selectedItem.dataset.value || selectedItem.textContent;
    dropdownList.style.display = 'none';
}

// Fix form reference in DOMContentLoaded event
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('pendaftaranForm');
    
    // Initialize form steps only if form exists
    if (form) {
        // Next step handlers
        form.querySelectorAll('.next-step').forEach(button => {
            button.addEventListener('click', function() {
                const currentStep = this.closest('.form-step');
                const nextStep = currentStep.nextElementSibling;
                
                if (validateStep(currentStep)) {
                    moveToNextStep(currentStep, nextStep);
                }
            });
        });

        // Previous step handlers
        form.querySelectorAll('.prev-step').forEach(button => {
            button.addEventListener('click', function() {
                const currentStep = this.closest('.form-step');
                const prevStep = currentStep.previousElementSibling;
                moveToPrevStep(currentStep, prevStep);
            });
        });

        // Initialize other form components
        initializeValidation(form);
        initializeDropdowns();
    }

    // Initialize other components that don't depend on form
    initializeDomicileHandlers();
    initializeSearchableDropdowns();
    initializeKelurahanDropdown();
    
    // ...rest of existing DOMContentLoaded code...
});

function initializeKelurahanDropdown() {
    const dropdownContainer = document.querySelector('#toraja_fields .searchable-dropdown');
    const dropdownList = document.querySelector('#toraja_fields .dropdown-list');
    const searchInput = document.querySelector('#toraja_fields .dropdown-search');
    const hiddenInput = document.getElementById('kelurahan');
    
    if (!dropdownContainer || !dropdownList || !searchInput || !hiddenInput) {
        console.error('Required kelurahan dropdown elements not found:', {
            container: !!dropdownContainer,
            list: !!dropdownList,
            input: !!searchInput,
            hidden: !!hiddenInput
        });
        return;
    }

    // Show loading state
    searchInput.placeholder = 'Loading data...';
    searchInput.disabled = true;
    dropdownList.style.display = 'none';

    fetch('get_kelurahan.php')
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(response => {
            if (response.error) {
                throw new Error(response.message || 'Error loading data');
            }

            const data = response.data || response;
            
            if (!Array.isArray(data)) {
                throw new Error('Invalid data format received');
            }

            // Reset input state
            searchInput.placeholder = 'Cari Kelurahan/Lembang...';
            searchInput.disabled = false;

            // Clear and populate dropdown
            dropdownList.innerHTML = '';
            
            data.forEach(item => {
                const div = document.createElement('div');
                div.className = 'dropdown-item';
                div.textContent = item.display_name;
                div.dataset.kecamatan = item.district_name;
                div.dataset.kabupaten = item.kabupaten_name;
                dropdownList.appendChild(div);
            });

            // Show dropdown on input focus
            searchInput.addEventListener('focus', () => {
                dropdownList.style.display = 'block';
            });

            // Filter items on input
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                dropdownList.style.display = 'block';
                
                Array.from(dropdownList.children).forEach(item => {
                    const text = item.textContent.toLowerCase();
                    item.style.display = text.includes(searchTerm) ? '' : 'none';
                });
            });

            // Handle item selection
            dropdownList.addEventListener('click', function(e) {
                const item = e.target.closest('.dropdown-item');
                if (!item) return;
                
                searchInput.value = item.textContent;
                hiddenInput.value = item.textContent;
                
                document.getElementById('kecamatan').value = item.dataset.kecamatan;
                document.getElementById('kabupaten').value = item.dataset.kabupaten;
                
                dropdownList.style.display = 'none';
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', (e) => {
                if (!dropdownContainer.contains(e.target)) {
                    dropdownList.style.display = 'none';
                }
            });

        })
        .catch(error => {
            console.error('Error:', error);
            searchInput.placeholder = 'Error loading data';
            searchInput.disabled = true;
            dropdownList.innerHTML = `
                <div class="dropdown-item error">
                    ${error.message}. Please refresh or contact support.
                </div>
            `;
            dropdownList.style.display = 'block';
        });
}

// ...existing code...

// Replace searchable dropdown handler with select handler
document.getElementById('jurusan').addEventListener('change', function() {
    const selectedJurusan = this.value;
    const fakultasInput = document.getElementById('fakultas');
    
    if (selectedJurusan && jurusanData[selectedJurusan]) {
        fakultasInput.value = jurusanData[selectedJurusan];
        fakultasInput.classList.add('filled');
    } else {
        fakultasInput.value = '';
        fakultasInput.classList.remove('filled');
    }
});

// Initialize jurusan searchable dropdown
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('.dropdown-search');
    const dropdownList = document.querySelector('.dropdown-list');
    const dropdownItems = document.querySelectorAll('.dropdown-item');
    const hiddenInput = document.getElementById('jurusan');
    const fakultasInput = document.getElementById('fakultas');

    if (!searchInput || !dropdownList || !hiddenInput) return;

    // Show dropdown on focus
    searchInput.addEventListener('focus', function() {
        dropdownList.style.display = 'block';
        if (hiddenInput.value) {
            this.value = '';
            dropdownItems.forEach(item => item.style.display = '');
        }
    });

    // Filter items while typing
    searchInput.addEventListener('input', function() {
        const searchText = this.value.toLowerCase();
        dropdownItems.forEach(item => {
            const matches = item.textContent.toLowerCase().includes(searchText);
            item.style.display = matches ? '' : 'none';
        });
    });

    // Handle item selection
    dropdownItems.forEach(item => {
        item.addEventListener('click', function() {
            const value = this.dataset.value || this.textContent;
            searchInput.value = this.textContent;
            hiddenInput.value = value;
            dropdownList.style.display = 'none';
            
            // Add class to container when value is selected
            searchInput.closest('.searchable-dropdown').classList.add('has-value');
            
            // Update fakultas
            if (jurusanData[value]) {
                fakultasInput.value = jurusanData[value];
                fakultasInput.classList.add('filled');
            }
        });
    });

    // Clear has-value class when clicking to search again
    searchInput.addEventListener('focus', function() {
        if (hiddenInput.value) {
            this.closest('.searchable-dropdown').classList.remove('has-value');
        }
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.searchable-dropdown')) {
            dropdownList.style.display = 'none';
        }
    });
});

// ...existing code...
