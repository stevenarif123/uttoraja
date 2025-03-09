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
    if (!element) return; // Exit if element not found
    
    const container = element.closest('.field-container');
    if (!container) return; // Exit if container not found
    
    const errorSpan = container.querySelector('.error-message');
    if (errorSpan) {
        errorSpan.remove();
        container.classList.remove('has-error');
    }
}

// Event handlers
document.addEventListener('DOMContentLoaded', function() {
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
            console.log('Available data:', jurusanData); // Debug
            
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
    const dropdownList = document.querySelector('#toraja_fields .dropdown-list');
    if (!dropdownList) {
        console.error('Kelurahan dropdown list not found');
        return;
    }

    fetch('get_kelurahan.php')
        .then(response => response.json())
        .then(data => {
            const searchInput = document.querySelector('#toraja_fields .dropdown-search');
            const hiddenInput = document.getElementById('kelurahan');
            
            if (!searchInput || !hiddenInput) {
                console.error('Required kelurahan elements not found');
                return;
            }

            // Clear and populate dropdown
            dropdownList.innerHTML = '';
            data.forEach(item => {
                const div = document.createElement('div');
                div.className = 'dropdown-item';
                div.textContent = `${item.area_name} (${item.area_type})`;
                div.dataset.kecamatan = item.district_name;
                div.dataset.kabupaten = item.kabupaten_name;
                dropdownList.appendChild(div);
            });

            // Add event listeners
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const items = dropdownList.getElementsByClassName('dropdown-item');
                
                Array.from(items).forEach(item => {
                    const text = item.textContent.toLowerCase();
                    item.style.display = text.includes(searchTerm) ? '' : 'none';
                });
                
                dropdownList.style.display = searchTerm ? 'block' : 'none';
            });

            // Selection handling
            dropdownList.addEventListener('click', function(e) {
                if (e.target.classList.contains('dropdown-item')) {
                    const selectedItem = e.target;
                    searchInput.value = selectedItem.textContent;
                    hiddenInput.value = selectedItem.textContent;
                    
                    // Update kecamatan and kabupaten
                    const kecamatanInput = document.getElementById('kecamatan');
                    const kabupatenInput = document.getElementById('kabupaten');
                    if (kecamatanInput) kecamatanInput.value = selectedItem.dataset.kecamatan;
                    if (kabupatenInput) kabupatenInput.value = selectedItem.dataset.kabupaten;
                    
                    dropdownList.style.display = 'none';
                }
            });

            // Show/hide dropdown
            searchInput.addEventListener('focus', () => {
                dropdownList.style.display = 'block';
            });

            document.addEventListener('click', (e) => {
                if (!e.target.closest('.searchable-dropdown')) {
                    dropdownList.style.display = 'none';
                }
            });
        })
        .catch(error => {
            console.error('Error fetching kelurahan data:', error);
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
    const inputs = step.querySelectorAll('input[required], select[required], input[type="radio"][required]');
    
    // Reset previous errors
    step.querySelectorAll('.error-message').forEach(msg => msg.remove());
    step.querySelectorAll('.has-error').forEach(field => field.classList.remove('has-error'));

    // Special validation for step 1
    if (step.dataset.step === '1') {
        // Check jalur program radio
        const jalurProgram = step.querySelector('input[name="jalur_program"]:checked');
        if (!jalurProgram) {
            isValid = false;
            const container = step.querySelector('.radio-field');
            container.classList.add('has-error');
            showError('jalur_program', 'Pilih jalur program');
        }

        // Check jurusan
        const jurusan = document.getElementById('jurusan');
        if (!jurusan.value) {
            isValid = false;
            const container = jurusan.closest('.field-container');
            container.classList.add('has-error');
            showError('jurusan', 'Pilih jurusan');
        }

        // Check nama lengkap
        const nama = document.getElementById('firstn');
        if (!nama.value.trim()) {
            isValid = false;
            const container = nama.closest('.field-container');
            container.classList.add('has-error');
            showError('firstn', 'Nama lengkap wajib diisi');
        }
    }

    // Validate required fields
    inputs.forEach(input => {
        if (input.type === 'radio') {
            const radioGroup = step.querySelector(`input[name="${input.name}"]:checked`);
            if (!radioGroup) {
                isValid = false;
                const container = input.closest('.radio-field');
                container.classList.add('has-error');
                showError(input.name, 'Pilihan ini wajib diisi');
            }
        } else if (!input.value.trim()) {
            isValid = false;
            const container = input.closest('.field-container');
            container.classList.add('has-error');
            showError(input.id, 'Field ini wajib diisi');
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
