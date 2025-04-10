// Import shared functionality
import './shared.js';

// Debug configuration
const DEBUG = true;

function debug(message, data = null) {
    if (DEBUG) {
        console.log(`[Debug] ${message}`, data || '');
    }
}

// Store all data in a global variable
let allPendaftarData = [];

// Form handling functions
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

// Message status update function ✉️
async function updateMessageSent(id, messageType) {
    try {
        await fetch('pendaftar.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ 
                action: 'update_message',
                id: id,
                messageType: messageType 
            })
        });
    } catch (error) {
        console.error('Error updating message status:', error);
    }
}

// Status update function 🔄
async function updateStatus(id, status) {
    try {
        const select = document.querySelector(`select[data-id="${id}"]`);
        select.disabled = true; // Disable during update
        
        const response = await fetch('pendaftar.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ 
                action: 'update_status',
                id: id,
                status: status 
            })
        });

        if (!response.ok) throw new Error('Failed to update status');
        
        // Update UI
        if (select) {
            select.className = `status-select px-2 py-1 rounded border ${getStatusClass(status)}`;
            select.style.transition = 'all 0.3s ease';
            select.style.transform = 'scale(1.05)';
            setTimeout(() => {
                select.style.transform = 'scale(1)';
                select.disabled = false;
            }, 200);
        }

        showNotification('✅ Status updated successfully');
    } catch (error) {
        console.error('Error updating status:', error);
        showNotification('❌ Failed to update status', 'error');
        if (select) select.disabled = false;
    }
}

// WhatsApp messaging functions 💬
function sendInitialMessage(phone, name, id) {
    const message = `Halo ${name}, terima kasih telah mendaftar di UT Toraja. Kami ingin memastikan ketertarikan Anda untuk bergabung dengan kami. Apakah Anda berminat untuk melanjutkan pendaftaran?`;
    openWhatsApp(phone, message);
    updateMessageSent(id, 'initial');
    updateStatus(id, 'sudah_dihubungi');
}

function sendWhatsApp(phone, name, id) {
    const message = `Halo ${name}, untuk melanjutkan pendaftaran di UT Toraja, silakan melakukan pembayaran sesuai dengan ketentuan yang berlaku. Terima kasih.`;
    openWhatsApp(phone, message);
    updateMessageSent(id, 'payment');
}

function openWhatsApp(phone, message) {
    const formattedPhone = phone.replace(/\D/g, '');
    const encodedMessage = encodeURIComponent(message);
    window.open(`https://wa.me/${formattedPhone}?text=${encodedMessage}`, '_blank');
}

// Utility functions 🛠️
function getStatusClass(status) {
    return {
        'belum_diproses': 'bg-gray-100',
        'sudah_dihubungi': 'bg-yellow-100',
        'berminat': 'bg-green-100',
        'tidak_berminat': 'bg-red-100',
        'pendaftaran_selesai': 'bg-blue-100'
    }[status] || 'bg-gray-100';
}

function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `fixed bottom-4 right-4 px-4 py-2 rounded-lg shadow-lg transform transition-all duration-300 ${
        type === 'success' ? 'bg-green-500' : 'bg-red-500'
    } text-white z-50`;
    notification.textContent = message;
    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.opacity = '0';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
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

// Initialize table search functionality 🔍
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('searchInput');
    if (!searchInput) return;

    let lastTimeout = null;
    const tableBody = document.getElementById('pendaftarTableBody');
    const rows = Array.from(tableBody.getElementsByTagName('tr'));
    const noDataRow = document.getElementById('noDataRow');

    function updateRowNumbers(visibleRows) {
        visibleRows.forEach((row, index) => {
            const numberCell = row.querySelector('.row-number');
            if (numberCell) numberCell.textContent = index + 1;
        });
    }

    function performSearch(term) {
        term = term.toLowerCase().trim();
        const visibleRows = rows.filter(row => {
            if (row.id === 'noDataRow') return false;
            const show = row.textContent.toLowerCase().includes(term);
            row.style.display = show ? '' : 'none';
            return show;
        });

        updateRowNumbers(visibleRows);
        if (noDataRow) {
            noDataRow.style.display = visibleRows.length ? 'none' : '';
        }
    }

    searchInput.addEventListener('input', (e) => {
        clearTimeout(lastTimeout);
        lastTimeout = setTimeout(() => performSearch(e.target.value), 300);
    });

    searchInput.addEventListener('keyup', (e) => {
        if (e.key === 'Escape') {
            searchInput.value = '';
            performSearch('');
        }
    });
});

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    debug('DOM Content Loaded');
    initializeEventHandlers();
});

// Export needed functions
window.handleFormSubmit = handleFormSubmit;