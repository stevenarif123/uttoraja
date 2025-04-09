// Core configuration
const DEBUG = true;
const apiHeaders = {
    'Accept': 'application/json',
    'Content-Type': 'application/json',
    'X-API-KEY': 'pantanmandiri25'
};

// Utility functions
function debug(message, data = null) {
    if (DEBUG) {
        console.log(`[Debug] ${message}`, data || '');
    }
}

function secureUrl(url) {
    if (window.location.protocol === 'https:' && url.startsWith('http:')) {
        return url.replace('http:', 'https:');
    }
    return url;
}

function getGreeting() {
    const hour = new Date().getHours();
    if (hour < 12) return "Selamat pagi";
    if (hour < 15) return "Selamat siang";
    if (hour < 18) return "Selamat sore";
    return "Selamat malam";
}

// Modal functions
window.openModal = function(modalId) {
    debug(`🔓 Opening modal: ${modalId}`);
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'block';
        modal.classList.remove('hidden');
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }
};

window.closeModal = function(modalId) {
    debug(`🔒 Closing modal: ${modalId}`);
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'none';
        modal.classList.add('hidden');
        modal.classList.remove('show');
        document.body.style.overflow = '';
    }
};

window.showAddModal = function() {
    debug('➕ Opening add modal');
    const addModal = document.getElementById('addModal');
    if (!addModal) {
        console.error('❌ Modal not found: addModal');
        return;
    }

    const form = document.getElementById('addForm');
    if (form) {
        // Clear form
        form.reset();
        // Update form content - reuse existing template
        openModal('addModal');
    } else {
        console.error('❌ Add form not found');
    }
};

// WhatsApp functions
function generateWhatsAppMessage(nama, jalurProgram) {
    const biaya = jalurProgram?.toLowerCase() === 'rpl' ? '600.000' : '200.000';
    return `${getGreeting()}, ${nama}
    
terima kasih sudah mendaftar di Sentra Layanan Universitas Terbuka (SALUT) Tana Toraja...`;
    // ... existing WhatsApp message content ...
}

// Export functions
window.debug = debug;
window.secureUrl = secureUrl;
window.getGreeting = getGreeting;
window.generateWhatsAppMessage = generateWhatsAppMessage;
window.apiHeaders = apiHeaders;
