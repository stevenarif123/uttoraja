/**
 * 📝 Pendaftaran (Registration) Form JavaScript
 * Clean version for SALUT Tana Toraja Registration
 */

document.addEventListener('DOMContentLoaded', function() {
  // ===== Global Variables =====
  let currentStep = 1;
  
  // ===== Initial Setup =====
  initializePreloader();
  initializeFormSteps();
  initializeFormValidation();
  initializeDropdowns();
  initializeDomicileHandlers();
  initializeWorkStatusHandler();
  initializeDatePicker();
  setupModalHandlers();
  
  // Show welcome message after a short delay
  setTimeout(() => {
    showAlert('Selamat datang di Formulir Pendaftaran Mahasiswa Baru! 🎓', 'success');
  }, 1000);
});

// ===== Preloader Handling =====
function initializePreloader() {
  const preloader = document.getElementById('preloader');
  if (preloader) {
    // Force remove after 2 seconds
    setTimeout(() => {
      preloader.classList.add('fade-out');
      setTimeout(() => preloader.remove(), 300);
    }, 2000);
  }
}

// ===== Form Navigation Functions =====
function initializeFormSteps() {
  const formSteps = document.querySelectorAll('.form-step');
  const progressSteps = document.querySelectorAll('.progress-step');
  let currentStep = 1;
  
  // Setup initial state
  updateFormProgress();
  
  // Next step button handlers
  document.querySelectorAll('.next-step').forEach(button => {
    button.addEventListener('click', function(e) {
      e.preventDefault();
      
      const currentStepElement = document.querySelector(`.form-step[data-step="${currentStep}"]`);
      
      if (validateStep(currentStep)) {
        currentStep++;
        updateFormProgress();
        showAlert(`Langkah ${currentStep-1} berhasil dilengkapi! ✅`, 'success');
      }
    });
  });
  
  // Previous step button handlers
  document.querySelectorAll('.prev-step').forEach(button => {
    button.addEventListener('click', function(e) {
      e.preventDefault();
      currentStep--;
      updateFormProgress();
    });
  });
  
  // Form submission handler
  const pendaftaranForm = document.getElementById('pendaftaranForm');
  if (pendaftaranForm) {
    pendaftaranForm.addEventListener('submit', handleFormSubmit);
  }
  
  // Helper function to update form progress UI
  function updateFormProgress() {
    // Hide all steps
    formSteps.forEach(step => {
      step.classList.remove('active');
    });
    
    // Show current step
    document.querySelector(`.form-step[data-step="${currentStep}"]`).classList.add('active');
    
    // Update progress indicators
    progressSteps.forEach(step => {
      const stepNum = parseInt(step.getAttribute('data-step'));
      
      // Reset all steps
      step.classList.remove('active', 'completed');
      
      // Mark current step as active
      if (stepNum === currentStep) {
        step.classList.add('active');
      } 
      // Mark previous steps as completed
      else if (stepNum < currentStep) {
        step.classList.add('completed');
      }
    });
    
    // Scroll to top of form
    document.querySelector('.contact-form').scrollIntoView({ 
      behavior: 'smooth', 
      block: 'start' 
    });
  }
}

// ===== Form Validation =====
function initializeFormValidation() {
  // Form field validation
  document.querySelectorAll('input, select, textarea').forEach(field => {
    if (field.hasAttribute('required')) {
      field.addEventListener('blur', function() {
        validateField(this);
      });
    }
  });
}

function validateStep(stepNumber) {
  const currentStepElement = document.querySelector(`.form-step[data-step="${stepNumber}"]`);
  const requiredFields = currentStepElement.querySelectorAll('[required]');
  let valid = true;
  
  // Reset validation messages
  currentStepElement.querySelectorAll('.validation-message').forEach(el => el.remove());
  
  // Check all required fields in current step
  requiredFields.forEach(field => {
    // Only validate visible fields (prevents validating hidden fields)
    if (isElementVisible(field) && !field.value.trim()) {
      valid = false;
      showFieldError(field, 'Field ini wajib diisi');
    }
  });
  
  // Step-specific validation
  switch(parseInt(stepNumber)) {
    case 1:
      valid = validateStepOne(currentStepElement) && valid;
      break;
    case 2:
      valid = validateStepTwo(currentStepElement) && valid;
      break;
    case 3:
      valid = validateStepThree(currentStepElement) && valid;
      break;
  }
  
  return valid;
}

function validateStepOne(stepElement) {
  let valid = true;
  
  // Validate program selection
  const jalurProgram = stepElement.querySelector('input[name="jalur_program"]:checked');
  if (!jalurProgram) {
    valid = false;
    showErrorMessage('Silakan pilih jalur program pendaftaran');
  }
  
  // Validate jurusan selection
  const jurusan = document.getElementById('jurusan');
  if (!jurusan || !jurusan.value) {
    valid = false;
    const dropdownSearch = stepElement.querySelector('.dropdown-search');
    if (dropdownSearch) {
      showFieldError(dropdownSearch, 'Silakan pilih jurusan');
    }
  }
  
  return valid;
}

function validateStepTwo(stepElement) {
  let valid = true;
  
  // Validate phone number format
  const phone = document.getElementById('phone');
  if (phone && phone.value) {
    if (!phone.value.startsWith('628') || phone.value.length < 11 || phone.value.length > 14) {
      valid = false;
      showFieldError(phone, 'Nomor HP tidak valid. Pastikan nomor dimulai dengan 628 dan terdiri dari 11-14 digit');
    }
  }
  
  // Validate NIK format
  const nik = document.getElementById('nik');
  if (nik && nik.value && nik.value.length !== 16) {
    valid = false;
    showFieldError(nik, 'NIK harus terdiri dari 16 digit');
  }
  
  // Validate birthdate
  const birthDate = document.getElementById('tanggal_lahir');
  if (birthDate && birthDate.value) {
    const birthDateObj = new Date(birthDate.value);
    const today = new Date();
    
    // Check if date is in the future
    if (birthDateObj > today) {
      valid = false;
      showFieldError(birthDate, 'Tanggal lahir tidak dapat berada di masa depan');
    }
    
    // Check if person is at least 15 years old
    const fifteenYearsAgo = new Date();
    fifteenYearsAgo.setFullYear(fifteenYearsAgo.getFullYear() - 15);
    
    if (birthDateObj > fifteenYearsAgo) {
      valid = false;
      showFieldError(birthDate, 'Anda harus berusia minimal 15 tahun untuk mendaftar');
    }
  }
  
  return valid;
}

function validateStepThree(stepElement) {
  let valid = true;
  
  // Validate domisili selection
  const domisili = document.querySelector('input[name="domisili"]:checked');
  if (domisili) {
    if (domisili.value === 'toraja') {
      const kelurahan = document.getElementById('kelurahan');
      if (!kelurahan || !kelurahan.value) {
        valid = false;
        const dropdownSearch = document.querySelector('#toraja_fields .dropdown-search');
        if (dropdownSearch) {
          showFieldError(dropdownSearch, 'Silakan pilih Kelurahan/Lembang');
        }
      }
    } else if (domisili.value === 'luar_toraja') {
      const domisiliManual = document.getElementById('domisili_manual');
      if (!domisiliManual || !domisiliManual.value.trim()) {
        valid = false;
        showFieldError(domisiliManual, 'Silakan isi domisili lengkap Anda');
      }
    }
  } else {
    valid = false;
    showErrorMessage('Silakan pilih domisili Anda');
  }
  
  return valid;
}

function validateField(field) {
  if (!field.value.trim() && field.hasAttribute('required')) {
    showFieldError(field, 'Field ini wajib diisi');
    return false;
  }
  return true;
}

// ===== Enhanced Dropdowns Initialization =====
function initializeDropdowns() {
  // Initialize jurusan dropdown
  initializeJurusanDropdown();
  
  // Initialize kelurahan dropdown
  initializeKelurahanDropdown();
  
  // Initialize all searchable dropdowns with common functionality
  initializeSearchableDropdowns();
}

function initializeJurusanDropdown() {
  const jurusanDropdown = document.querySelector('.field-container .dropdown-list');
  const jurusanSearchInput = document.querySelector('.field-container .dropdown-search');
  
  if (!jurusanDropdown || !jurusanSearchInput || typeof jurusanData === 'undefined') return;
  
  // Clear existing items
  jurusanDropdown.innerHTML = '';
  
  // Add data items
  Object.keys(jurusanData).forEach(jurusan => {
    const item = document.createElement('div');
    item.className = 'dropdown-item';
    item.setAttribute('data-value', jurusan);
    item.textContent = jurusan;
    
    item.addEventListener('click', function(e) {
      e.preventDefault();
      e.stopPropagation();
      selectJurusan(this.getAttribute('data-value'));
      
      // ✅ FIX 1: Close dropdown after selection
      const dropdown = this.closest('.searchable-dropdown');
      if (dropdown) {
        dropdown.classList.remove('active');
        const dropdownList = dropdown.querySelector('.dropdown-list');
        if (dropdownList) {
          dropdownList.style.display = 'none';
          dropdownList.style.visibility = 'hidden';
        }
      }
    });
    
    jurusanDropdown.appendChild(item);
  });
}

// Fixed Kelurahan Dropdown initialization with improved selection handling
function initializeKelurahanDropdown() {
  const kelurahanDropdown = document.querySelector('#toraja_fields .dropdown-list');
  const kelurahanSearchInput = document.querySelector('#toraja_fields .dropdown-search');
  
  if (!kelurahanDropdown || !kelurahanSearchInput) return;
  
  // Clear existing items
  kelurahanDropdown.innerHTML = '';
  
  // Add a placeholder item
  const placeholderItem = document.createElement('div');
  placeholderItem.className = 'dropdown-item dropdown-placeholder';
  placeholderItem.textContent = 'Pilih Kelurahan/Lembang';
  placeholderItem.style.fontStyle = 'italic';
  placeholderItem.style.color = '#999';
  kelurahanDropdown.appendChild(placeholderItem);
  
  // Check if kelurahanData exists and is properly formatted
  if (typeof kelurahanData !== 'undefined' && kelurahanData && kelurahanData.length > 0) {
    console.log('Populating kelurahan dropdown with data:', kelurahanData);
    
    // Add data items
    kelurahanData.forEach(data => {
      const item = document.createElement('div');
      item.className = 'dropdown-item';
      
      // Handle different data formats
      const areaName = data.area_name || data;
      const kemendagriCode = data.kemendagri_code || '';
      
      item.setAttribute('data-value', areaName);
      item.setAttribute('data-kemendagri-code', kemendagriCode);
      item.textContent = areaName;
      
      item.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        selectKelurahan(this.getAttribute('data-value'), this.getAttribute('data-kemendagri-code'));
        
        // ✅ FIX 1: Close dropdown after selection
        const dropdown = this.closest('.searchable-dropdown');
        if (dropdown) {
          dropdown.classList.remove('active');
          const dropdownList = dropdown.querySelector('.dropdown-list');
          if (dropdownList) {
            dropdownList.style.display = 'none';
            dropdownList.style.visibility = 'hidden';
          }
        }
      });
      
      kelurahanDropdown.appendChild(item);
    });
  } else {
    console.error('kelurahanData is not defined or empty');
    
    // Add some default items if data is missing
    const defaultAreas = ['Lembang A', 'Lembang B', 'Kelurahan C'];
    defaultAreas.forEach(area => {
      const item = document.createElement('div');
      item.className = 'dropdown-item';
      item.setAttribute('data-value', area);
      item.textContent = area;
      
      item.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        selectKelurahan(this.getAttribute('data-value'));
        
        // ✅ FIX 1: Close dropdown after selection
        const dropdown = this.closest('.searchable-dropdown');
        if (dropdown) {
          dropdown.classList.remove('active');
          const dropdownList = dropdown.querySelector('.dropdown-list');
          if (dropdownList) {
            dropdownList.style.display = 'none';
            dropdownList.style.visibility = 'hidden';
          }
        }
      });
      
      kelurahanDropdown.appendChild(item);
    });
  }
}

function initializeSearchableDropdowns() {
  const searchableDropdowns = document.querySelectorAll('.searchable-dropdown');
  
  searchableDropdowns.forEach(dropdown => {
    const searchInput = dropdown.querySelector('.dropdown-search');
    const dropdownList = dropdown.querySelector('.dropdown-list');
    
    if (!searchInput || !dropdownList) return;
    
    // Toggle dropdown on click
    searchInput.addEventListener('click', function(e) {
      e.preventDefault();
      e.stopPropagation();

      // ✅ FIX 2: Clear search input when dropdown is opened
      if (!dropdown.classList.contains('active')) {
        // Only clear if this is a new dropdown opening, not continuing an existing search
        // searchInput.value = '';
      }
      
      toggleDropdown(dropdown);
    });
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
      if (!dropdown.contains(e.target)) {
        dropdown.classList.remove('active');
        if (dropdownList) {
          dropdownList.style.display = 'none';
          dropdownList.style.visibility = 'hidden';
        }
      }
    });
    
    // Filter dropdown items on search input
    searchInput.addEventListener('input', function() {
      const searchValue = this.value.toLowerCase();
      filterDropdownItems(dropdown, searchValue);
      
      // When typing, always ensure dropdown is visible
      if (searchValue.length > 0 && !dropdown.classList.contains('active')) {
        toggleDropdown(dropdown);
      }
    });
    
    // Handle keyboard navigation
    searchInput.addEventListener('keydown', function(e) {
      handleDropdownKeyboard(e, dropdown);
    });
  });
}

// ===== Conditional Field Handlers =====
function initializeDomicileHandlers() {
  const domisiliRadios = document.querySelectorAll('input[name="domisili"]');
  const torajaFields = document.getElementById('toraja_fields');
  const luarTorajaFields = document.getElementById('luar_toraja_fields');
  
  if (!domisiliRadios.length || !torajaFields || !luarTorajaFields) return;
  
  domisiliRadios.forEach(radio => {
    radio.addEventListener('change', function() {
      if (this.value === 'toraja') {
        torajaFields.style.display = 'block';
        luarTorajaFields.style.display = 'none';
        
        // Update required attributes
        const kelurahanInput = document.getElementById('kelurahan');
        const domisiliManual = document.getElementById('domisili_manual');
        
        if (kelurahanInput) kelurahanInput.setAttribute('required', '');
        if (domisiliManual) domisiliManual.removeAttribute('required');
      } else {
        torajaFields.style.display = 'none';
        luarTorajaFields.style.display = 'block';
        
        // Update required attributes
        const kelurahanInput = document.getElementById('kelurahan');
        const domisiliManual = document.getElementById('domisili_manual');
        
        if (kelurahanInput) kelurahanInput.removeAttribute('required');
        if (domisiliManual) domisiliManual.setAttribute('required', '');
      }
    });
  });
}

function initializeWorkStatusHandler() {
  const bekerjaRadios = document.querySelectorAll('input[name="bekerja"]');
  const tempatKerjaContainer = document.getElementById('tempat_kerja_container');
  
  if (!bekerjaRadios.length || !tempatKerjaContainer) return;
  
  bekerjaRadios.forEach(radio => {
    radio.addEventListener('change', function() {
      const tempatKerjaInput = document.getElementById('tempat_kerja');
      
      if (this.value === 'Ya') {
        tempatKerjaContainer.style.display = 'block';
        if (tempatKerjaInput) tempatKerjaInput.setAttribute('required', '');
      } else {
        tempatKerjaContainer.style.display = 'none';
        if (tempatKerjaInput) tempatKerjaInput.removeAttribute('required');
      }
    });
  });
}

function initializeDatePicker() {
  const birthDateInput = document.getElementById('tanggal_lahir');
  
  if (!birthDateInput) return;
  
  // Set min/max dates
  const today = new Date();
  const fifteenYearsAgo = new Date();
  fifteenYearsAgo.setFullYear(today.getFullYear() - 15);
  
  birthDateInput.setAttribute('max', fifteenYearsAgo.toISOString().split('T')[0]);
  birthDateInput.setAttribute('min', '1940-01-01');
}

// ===== Dropdown Helper Functions =====
function toggleDropdown(dropdown) {
  if (!dropdown) return;
  
  const wasActive = dropdown.classList.contains('active');
  const searchInput = dropdown.querySelector('.dropdown-search');
  
  // Close all dropdowns first
  document.querySelectorAll('.searchable-dropdown').forEach(d => {
    // ✅ FIX 2: Clear other search inputs when closing their dropdowns
    if (d !== dropdown && d.classList.contains('active')) {
      const otherSearchInput = d.querySelector('.dropdown-search');
      // Don't clear the input value here, as it should display the selected value
    }
    
    d.classList.remove('active');
    const list = d.querySelector('.dropdown-list');
    if (list) {
      list.style.display = 'none';
      list.style.visibility = 'hidden';
    }
  });
  
  // Toggle this dropdown
  if (!wasActive) {
    dropdown.classList.add('active');
    const dropdownList = dropdown.querySelector('.dropdown-list');
    
    if (dropdownList) {
      // ✅ FIX 2: Select all text in search input for easy replacement
      if (searchInput) {
        searchInput.focus();
        searchInput.select();
      }
      
      dropdownList.style.display = 'block';
      dropdownList.style.visibility = 'visible';
      dropdownList.style.opacity = '1';
      dropdownList.style.backgroundColor = 'white';
      dropdownList.style.zIndex = '9999';
      
      // Force repaint to ensure proper display
      setTimeout(() => {
        dropdownList.style.display = 'block';
        dropdownList.style.visibility = 'visible';
      }, 10);
    }
  }
}

function filterDropdownItems(dropdown, searchValue) {
  const items = dropdown.querySelectorAll('.dropdown-item:not(.dropdown-placeholder)');
  let hasMatches = false;
  
  items.forEach(item => {
    const text = item.textContent.toLowerCase();
    const match = text.includes(searchValue);
    
    item.style.display = match ? '' : 'none';
    
    if (match) hasMatches = true;
  });
  
  // If no matches, show "No results" message
  let noResults = dropdown.querySelector('.no-results');
  
  if (!hasMatches) {
    if (!noResults) {
      noResults = document.createElement('div');
      noResults.className = 'dropdown-item no-results';
      noResults.textContent = 'Tidak ada hasil ditemukan';
      dropdown.querySelector('.dropdown-list').appendChild(noResults);
    }
    noResults.style.display = '';
  } else if (noResults) {
    noResults.style.display = 'none';
  }
}

function handleDropdownKeyboard(e, dropdown) {
  const items = Array.from(dropdown.querySelectorAll('.dropdown-item')).filter(item => 
    item.style.display !== 'none' && !item.classList.contains('no-results')
  );
  const currentIndex = items.findIndex(item => item.classList.contains('highlighted'));
  
  // If dropdown is not active, activate it on arrow down
  if (!dropdown.classList.contains('active') && e.key === 'ArrowDown') {
    e.preventDefault();
    toggleDropdown(dropdown);
    return;
  }
  
  if (['ArrowDown', 'ArrowUp', 'Enter', 'Escape'].includes(e.key)) {
    e.preventDefault();
    
    if (e.key === 'ArrowDown') {
      const nextIndex = currentIndex < 0 ? 0 : (currentIndex + 1) % items.length;
      highlightItem(items, nextIndex);
    } else if (e.key === 'ArrowUp') {
      const prevIndex = currentIndex < 0 ? items.length - 1 : (currentIndex - 1 + items.length) % items.length;
      highlightItem(items, prevIndex);
    } else if (e.key === 'Enter') {
      const highlighted = dropdown.querySelector('.dropdown-item.highlighted');
      if (highlighted) {
        highlighted.click();
      }
    } else if (e.key === 'Escape') {
      dropdown.classList.remove('active');
    }
  }
}

function highlightItem(items, index) {
  items.forEach(item => item.classList.remove('highlighted'));
  if (items[index]) {
    items[index].classList.add('highlighted');
    items[index].scrollIntoView({ block: 'nearest' });
  }
}

function selectJurusan(value) {
  const jurusanInput = document.getElementById('jurusan');
  const searchInput = document.querySelector('.dropdown-search');
  if (!jurusanInput || !searchInput) return;
  
  const dropdown = searchInput.closest('.searchable-dropdown');
  
  jurusanInput.value = value;
  searchInput.value = value;
  
  // ✅ FIX 1: Close dropdown after selection
  if (dropdown) {
    dropdown.classList.remove('active');
    const dropdownList = dropdown.querySelector('.dropdown-list');
    if (dropdownList) {
      dropdownList.style.display = 'none';
    }
  }
  
  // Update fakultas field
  updateFakultas(value);
  
  // Highlight the selected item
  const items = dropdown ? dropdown.querySelectorAll('.dropdown-item') : [];
  items.forEach(item => {
    item.classList.toggle('selected', item.getAttribute('data-value') === value);
  });
}

function updateFakultas(jurusan) {
  const fakultasInput = document.getElementById('fakultas');
  if (fakultasInput && jurusanData && jurusanData[jurusan]) {
    fakultasInput.value = jurusanData[jurusan];
    fakultasInput.classList.add('filled');
  } else if (fakultasInput) {
    fakultasInput.value = '';
    fakultasInput.classList.remove('filled');
  }
}

// ✅ FIX 3: Enhanced Kelurahan selection with auto-population
function selectKelurahan(value, kemendagriCode = '') {
  const kelurahanInput = document.getElementById('kelurahan');
  const searchInput = document.querySelector('#toraja_fields .dropdown-search');
  if (!kelurahanInput || !searchInput) return;
  
  const dropdown = searchInput.closest('.searchable-dropdown');
  
  kelurahanInput.value = value;
  searchInput.value = value;
  
  // Close dropdown
  if (dropdown) {
    dropdown.classList.remove('active');
    const dropdownList = dropdown.querySelector('.dropdown-list');
    if (dropdownList) {
      dropdownList.style.display = 'none';
    }
  }
  
  // Highlight the selected item
  const items = dropdown ? dropdown.querySelectorAll('.dropdown-item') : [];
  items.forEach(item => {
    item.classList.toggle('selected', item.getAttribute('data-value') === value);
  });
  
  // Auto-populate kecamatan and kabupaten fields
  fetchLocationDetails(value, kemendagriCode);
}

// ✅ FIX 3: New function to fetch district and regency data
function fetchLocationDetails(kelurahanName, kemendagriCode = '') {
  const kecamatanInput = document.getElementById('kecamatan');
  const kabupatenInput = document.getElementById('kabupaten');
  
  if (!kecamatanInput || !kabupatenInput) return;
  
  // If we have the kelurahan data already loaded, we can populate from it directly
  if (typeof kelurahanData !== 'undefined' && kelurahanData && kelurahanData.length > 0) {
    // Find the selected kelurahan in our data
    const selectedKelurahan = kelurahanData.find(item => 
      (item.area_name === kelurahanName) || 
      (kemendagriCode && item.kemendagri_code === kemendagriCode)
    );
    
    if (selectedKelurahan) {
      // Make an AJAX request to get kecamatan and kabupaten details
      fetch(`get_location_details.php?kelurahan_name=${encodeURIComponent(kelurahanName)}&kemendagri_code=${encodeURIComponent(kemendagriCode || '')}`)
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            kecamatanInput.value = data.kecamatan || 'Tidak ditemukan';
            kabupatenInput.value = data.kabupaten || 'Tidak ditemukan';
          } else {
            // Fallback to default values if server request fails
            setDefaultLocationValues(kelurahanName, kecamatanInput, kabupatenInput);
          }
        })
        .catch(error => {
          console.error('Error fetching location details:', error);
          // Fallback to default values
          setDefaultLocationValues(kelurahanName, kecamatanInput, kabupatenInput);
        });
    } else {
      // If kelurahan not found in our data, set default values
      setDefaultLocationValues(kelurahanName, kecamatanInput, kabupatenInput);
    }
  } else {
    // If no kelurahan data available, use default values
    setDefaultLocationValues(kelurahanName, kecamatanInput, kabupatenInput);
  }
}

// Helper function for default location values
function setDefaultLocationValues(kelurahanName, kecamatanInput, kabupatenInput) {
  // Set some intelligent defaults based on the name
  if (kelurahanName.includes('Rantepao') || kelurahanName.includes('Tallunglipu')) {
    kecamatanInput.value = 'Rantepao';
    kabupatenInput.value = 'Toraja Utara';
  } else if (kelurahanName.includes('Makale') || kelurahanName.includes('Sangalla')) {
    kecamatanInput.value = 'Makale';
    kabupatenInput.value = 'Tana Toraja';
  } else if (kelurahanName.includes('Lembang')) {
    kecamatanInput.value = 'Kecamatan (diisi otomatis)';
    kabupatenInput.value = 'Toraja Utara';
  } else {
    kecamatanInput.value = 'Kecamatan (diisi otomatis)';
    kabupatenInput.value = 'Kabupaten (diisi otomatis)';
  }
}

// ===== Modal Handlers =====
function setupModalHandlers() {
  const modal = document.getElementById("petunjukModal");
  const showModalBtn = document.getElementById("showPetunjukBtn");
  const closeModalBtn = document.getElementById("closeModalBtn");
  const startRegistrationBtn = document.getElementById("startRegistrationBtn");
  const closeModal = document.getElementById("closeModal");

  if (!modal) return;

  if (showModalBtn) {
    showModalBtn.addEventListener('click', function() {
      modal.classList.add('show');
      setTimeout(() => {
        const modalContent = modal.querySelector('.modal-content');
        if (modalContent) {
          modalContent.style.opacity = '1';
          modalContent.style.transform = 'translateY(0)';
        }
      }, 10);
    });
  }

  // Define close modal function
  const closeModalFunction = function() {
    const modalContent = modal.querySelector('.modal-content');
    if (modalContent) {
      modalContent.style.opacity = '0';
      modalContent.style.transform = 'translateY(-50px)';
    }
    setTimeout(() => {
      modal.classList.remove('show');
    }, 300);
  };

  if (closeModal) {
    closeModal.addEventListener('click', closeModalFunction);
  }

  if (closeModalBtn) {
    closeModalBtn.addEventListener('click', closeModalFunction);
  }

  if (startRegistrationBtn) {
    startRegistrationBtn.addEventListener('click', function() {
      closeModalFunction();
      // Focus on first form field
      const firstField = document.querySelector('.form-step.active input, .form-step.active select');
      if (firstField) firstField.focus();
    });
  }

  // Close modal when clicking outside
  window.addEventListener('click', function(e) {
    if (e.target === modal) {
      closeModalFunction();
    }
  });
}

// ===== Form Submission =====
function handleFormSubmit(e) {
  e.preventDefault();
  
  // Check if final step is valid
  const currentStepElement = document.querySelector(`.form-step.active`);
  const currentStep = parseInt(currentStepElement.dataset.step);
  
  if (validateStep(currentStep)) {
    // Show loading state
    const submitButton = e.target.querySelector('button[type="submit"]');
    const originalText = submitButton.innerHTML;
    submitButton.disabled = true;
    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
    
    // In a real application, you'd use AJAX to submit the form
    // For this demo, we'll simulate a successful submission after a delay
    setTimeout(() => {
      submitButton.innerHTML = '<i class="fas fa-check-circle"></i> Berhasil!';
      
      showAlert('Pendaftaran berhasil dikirim! Tim kami akan menghubungi Anda segera. 🎉', 'success');
      
      // Redirect to success page
      setTimeout(() => {
        window.location.href = 'pendaftaran_sukses.php';
      }, 2000);
    }, 1500);
  }
}

// ===== Helper Functions =====
// Check if element is visible
function isElementVisible(element) {
  let currentElement = element;
  while (currentElement) {
    if (currentElement.style && 
       (currentElement.style.display === 'none' || 
        currentElement.style.visibility === 'hidden' ||
        currentElement.offsetParent === null)) {
      return false;
    }
    currentElement = currentElement.parentElement;
  }
  return true;
}

// Show field error
function showFieldError(field, message) {
  // Create error message element
  const errorElement = document.createElement('div');
  errorElement.className = 'validation-message';
  errorElement.style.color = '#dc3545';
  errorElement.style.fontSize = '13px';
  errorElement.style.marginTop = '5px';
  errorElement.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${message}`;
  
  // Insert after the field
  if (field && field.parentNode) {
    field.parentNode.insertBefore(errorElement, field.nextSibling);
    
    // Highlight the field
    field.style.borderColor = '#dc3545';
    
    // Remove required attribute temporarily to allow focusing on other fields
    if (field.hasAttribute('required')) {
      field.dataset.wasRequired = "true";
      field.removeAttribute('required');
    }
    
    // Add event listener to remove error when field is focused
    field.addEventListener('focus', function() {
      field.style.borderColor = '';
      if (errorElement.parentNode) {
        errorElement.parentNode.removeChild(errorElement);
      }
      
      // Restore required attribute if it was removed
      if (field.dataset.wasRequired === "true") {
        field.setAttribute('required', '');
        delete field.dataset.wasRequired;
      }
    }, { once: true });
  }
}

// Show alert message
function showAlert(message, type) {
  const alertContainer = document.getElementById('alert-container');
  if (!alertContainer) return;
  
  const alertBox = document.createElement('div');
  alertBox.className = `alert alert-${type} fade show`;
  alertBox.innerHTML = `
    <div class="d-flex align-items-center">
      <i class="${type === 'danger' ? 'fas fa-exclamation-circle' : 'fas fa-check-circle'} me-2"></i>
      <span>${message}</span>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  `;
  
  alertContainer.appendChild(alertBox);
  
  // Auto dismiss after 5 seconds
  setTimeout(() => {
    alertBox.classList.remove('show');
    setTimeout(() => alertBox.remove(), 300);
  }, 5000);
}

// Show error message in alert
function showErrorMessage(message) {
  showAlert(message, 'danger');
}

// Global input value formatters
window.toUpperCase = function(input) {
  input.value = input.value.toUpperCase();
};

// Validate phone number - Updated for 628 format
window.validatePhone = function(input) {
  // Allow only digits
  input.value = input.value.replace(/\D/g, '');
  
  // Convert 08 to 628 if needed
  if (input.value.startsWith('08')) {
    input.value = '62' + input.value.substring(1);
  }
  
  // Check if valid Indonesian mobile number format (628xx)
  if (input.value.length > 0) {
    if (!input.value.startsWith('628')) {
      showAlert("Nomor HP harus diawali dengan 628 (format internasional)", "danger");
      input.setCustomValidity("Nomor HP harus diawali dengan 628");
    } else if (input.value.length < 11 || input.value.length > 14) {
      showAlert("Nomor HP harus terdiri dari 11-14 digit", "danger");
      input.setCustomValidity("Nomor HP harus terdiri dari 11-14 digit");
    } else {
      input.setCustomValidity("");
    }
  }
};

// Validate NIK
window.validateNIK = function(input) {
  // Allow only digits
  input.value = input.value.replace(/\D/g, '');
  
  if (input.value.length > 0 && input.value.length !== 16) {
    showAlert("NIK harus terdiri dari 16 digit", "danger");
    input.setCustomValidity("NIK harus terdiri dari 16 digit");
  } else {
    input.setCustomValidity("");
  }
};
