// Debug configuration
const DEBUG = true;

function debug(message, data = null) {
    if (DEBUG) {
        console.log(`[Debug] ${message}`, data || '');
    }
}

// Form handling functions - Define this before using it
async function handleFormSubmit(e) {
    e.preventDefault();
    debug('Form submission started');
    
    const form = e.target;
    const formId = form.id;
    const isEdit = formId === 'editForm';
    const id = isEdit ? document.getElementById('editId')?.value : null;
    
    const formData = {};
    const formElements = form.elements;
    for (let i = 0; i < formElements.length; i++) {
        const element = formElements[i];
        if (element.name && element.type !== 'submit' && element.type !== 'button') {
            formData[element.name] = element.value;
        }
    }

    try {
        const url = isEdit ? `${window.config.apiUrl}/${id}` : window.config.apiUrl;
        const method = isEdit ? 'PUT' : 'POST';
        
        const response = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-API-KEY': 'pantanmandiri25'
            },
            body: JSON.stringify(formData)
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const result = await response.json();
        alert(result.message || 'Operation successful');
        location.reload();
    } catch (error) {
        console.error('Form submission error:', error);
        alert('An error occurred. Please try again.');
    }
}

// Utility Functions
function getGreeting() {
    const hour = new Date().getHours();
    if (hour < 12) return "Selamat pagi";
    if (hour < 15) return "Selamat siang";
    if (hour < 18) return "Selamat sore";
    return "Selamat malam";
}

function generateWhatsAppMessage(nama, jalurProgram) {
    const biaya = jalurProgram?.toLowerCase() === 'rpl' ? '600.000' : '200.000';
    
    return `${getGreeting()}, ${nama}
    
terima kasih sudah mendaftar di Sentra Layanan Universitas Terbuka (SALUT) Tana Toraja, untuk melanjutkan pendaftaran silahkan melakukan langkah berikut:

1. Membayar uang pendaftaran sebesar Rp${biaya} ke nomor rekening berikut:
Nama : Ribka Padang (Kepala SALUT Tana Toraja)
Bank : Mandiri
Nomor Rekening : 1700000588917

2. Melengkapi berkas data diri berupa:
- Foto diri Formal (dapat menggunakan foto HP)
- Foto KTP asli (KTP asli difoto secara keseluruhan/tidak terpotong)
- Foto Ijazah dilegalisir cap basah atau Foto ijazah asli
- Mengisi formulir Keabsahan Data (dikirimkan)`;
}

// WhatsApp Handler
function handleWhatsAppClick(e) {
    e.preventDefault();
    const row = this.closest('tr');
    const phone = row.querySelector('td:nth-child(3)').textContent.trim();
    const nama = row.querySelector('td:nth-child(2)').textContent.trim();
    
    // Get the ID from the row or button
    const id = this.dataset.id || row.dataset.id;
    const pendaftar = findPendaftarById(id);
    
    if (pendaftar) {
        sendWhatsApp(phone, nama, pendaftar.jalur_program);
    } else {
        debug('Pendaftar not found:', id);
        sendWhatsApp(phone, nama); // Fallback to default amount
    }
}

function sendWhatsApp(phone, nama, jalurProgram) {
    const message = encodeURIComponent(generateWhatsAppMessage(nama, jalurProgram));
    window.open(`https://wa.me/${phone}?text=${message}`, '_blank');
}

// Modal Functions
function openModal(modalId) {
    debug(`Opening modal: ${modalId}`);
    try {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'flex';
            modal.classList.remove('hidden');
            modal.classList.add('show');
            // Prevent body scrolling
            document.body.style.overflow = 'hidden';
            debug('Modal opened successfully');
        }
    } catch (error) {
        console.error('Error opening modal:', error);
    }
}

function closeModal(modalId) {
    debug(`Closing modal: ${modalId}`);
    try {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'none';
            modal.classList.add('hidden');
            modal.classList.remove('show');
            // Restore body scrolling
            document.body.style.overflow = '';
            debug('Modal closed successfully');
        }
    } catch (error) {
        console.error('Error closing modal:', error);
    }
}

// Add click outside modal to close
document.addEventListener('click', function(event) {
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        if (event.target === modal) {
            const modalId = modal.getAttribute('id');
            closeModal(modalId);
        }
    });
});

// Add escape key to close modal
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const openModal = document.querySelector('.modal.show');
        if (openModal) {
            const modalId = openModal.getAttribute('id');
            closeModal(modalId);
        }
    }
});

// Event Handlers Initialization
function initializeEventHandlers() {
    debug('Initializing event handlers');

    // Form handlers
    const editForm = document.getElementById('editForm');
    const addForm = document.getElementById('addForm');

    if (editForm) {
        editForm.addEventListener('submit', handleFormSubmit);
        debug('Edit form handler attached');
    }

    if (addForm) {
        addForm.addEventListener('submit', handleFormSubmit);
        debug('Add form handler attached');
    }

    // WhatsApp handlers
    document.querySelectorAll('a[href^="https://wa.me/"]').forEach(link => {
        link.addEventListener('click', handleWhatsAppClick);
    });

    // Search functionality
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', debounce(handleSearch, 300));
    }
}

// Data Functions
function findPendaftarById(id) {
    debug('Finding pendaftar with id:', id);
    const pendaftar = allPendaftarData.find(p => p.id == id);
    debug('Found pendaftar:', pendaftar);
    return pendaftar;
}

// Search handling
function handleSearch(event) {
    const searchTerm = event.target.value.toLowerCase();
    const rows = document.querySelectorAll('#pendaftarTableBody tr:not(#noDataRow)');
    let visibleCount = 0;

    rows.forEach((row, index) => {
        const text = row.textContent.toLowerCase();
        const shouldShow = text.includes(searchTerm);
        row.style.display = shouldShow ? '' : 'none';
        
        if (shouldShow) {
            visibleCount++;
            const numberCell = row.querySelector('.row-number');
            if (numberCell) numberCell.textContent = visibleCount;
        }
    });

    const noDataRow = document.getElementById('noDataRow');
    if (noDataRow) {
        noDataRow.style.display = visibleCount === 0 ? '' : 'none';
    }
}

// Utility functions
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    debug('DOM Content Loaded');
    initializeEventHandlers();
});

// Export functions for use in other scripts
window.openModal = openModal;
window.closeModal = closeModal;
window.findPendaftarById = findPendaftarById;
window.showDetail = showDetail;
window.editData = editData;
window.handleWhatsAppClick = handleWhatsAppClick;
window.handleFormSubmit = handleFormSubmit;