/**
 * Module Check Form Handler 🚀
 * This script handles the module checking form submission and displays results
 * Enhanced with better error handling and user feedback
 */

$(document).ready(function() {
  // Form validation and submission
  const cekModulForm = document.getElementById('cekModulForm');
  const statusContainer = document.getElementById('status-container');
  const kembaliButton = document.getElementById('kembaliButton');
  
  if (cekModulForm) {
    cekModulForm.addEventListener('submit', function(event) {
      event.preventDefault();
      
      const nim = document.getElementById('nim').value;
      const tanggalLahir = document.getElementById('tanggal_lahir').value;
      
      // Validate NIM
      if (nim.length !== 9 || !/^\d+$/.test(nim)) {
        showToast('NIM harus terdiri dari 9 digit angka', 'error');
        return;
      }
      
      // Validate date format
      if (!isValidDateFormat(tanggalLahir)) {
        showToast('Format tanggal lahir tidak valid. Gunakan format DD/MM/YYYY', 'error');
        return;
      }
      
      // Show loading indicator ⏳
      const submitButton = document.querySelector('.btn-check-module');
      submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...';
      submitButton.disabled = true;
      
      // Send AJAX request to check module status
      $.ajax({
        url: 'check_module.php',
        type: 'POST',
        data: {
          nim: nim,
          tanggal_lahir: tanggalLahir
        },
        dataType: 'json',
        success: function(response) {
          console.log("API Response:", response); // For debugging
          
          // Reset button state
          submitButton.innerHTML = '<i class="bi bi-search"></i><span>Cek Status Modul</span>';
          submitButton.disabled = false;
          
          if (response.status === 'success') {
            // Show success message 🎉
            showToast('Data modul ditemukan', 'success');
            
            // Show result
            showModuleStatus(response.data);
            
            // Hide form, show results
            cekModulForm.closest('.module-card').style.display = 'none';
            statusContainer.style.display = 'block';
            
            // Scroll to results
            statusContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
          } else {
            // Show error message ❌
            showToast(response.message || 'Terjadi kesalahan saat memeriksa data modul', 'error');
          }
        },
        error: function(xhr, status, error) {
          // Reset button state
          submitButton.innerHTML = '<i class="bi bi-search"></i><span>Cek Status Modul</span>';
          submitButton.disabled = false;
          
          // Show error message
          console.error("AJAX Error:", xhr.responseText);
          showToast('Terjadi kesalahan saat menghubungi server. Silakan coba lagi nanti.', 'error');
        }
      });
    });
  }
  
  // Back button functionality
  if (kembaliButton) {
    kembaliButton.addEventListener('click', function() {
      // Hide results, show form
      cekModulForm.closest('.module-card').style.display = 'block';
      statusContainer.style.display = 'none';
      
      // Reset form
      cekModulForm.reset();
    });
  }
});

/**
 * Check if a date string is in valid DD/MM/YYYY format
 * @param {string} dateString - The date string to validate
 * @return {boolean} True if valid, false otherwise
 */
function isValidDateFormat(dateString) {
  const pattern = /^(\d{1,2})\/(\d{1,2})\/(\d{4})$/;
  if (!pattern.test(dateString)) return false;
  
  const parts = dateString.split('/');
  const day = parseInt(parts[0], 10);
  const month = parseInt(parts[1], 10);
  const year = parseInt(parts[2], 10);
  
  // Check month range
  if (month < 1 || month > 12) return false;
  
  // Check day range based on month
  const daysInMonth = new Date(year, month, 0).getDate();
  if (day < 1 || day > daysInMonth) return false;
  
  // Validate year is not in the future
  const currentYear = new Date().getFullYear();
  if (year > currentYear) return false;
  
  return true;
}

/**
 * Display a toast notification with customized styling 🔔
 * @param {string} message - The message to display
 * @param {string} type - The notification type ('success', 'error', 'info')
 */
function showToast(message, type = 'info') {
  // Create toast element if it doesn't exist
  if (!document.getElementById('toast-container')) {
    const toastContainer = document.createElement('div');
    toastContainer.id = 'toast-container';
    toastContainer.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 1050;';
    document.body.appendChild(toastContainer);
  }
  
  // Create a unique ID for this toast
  const toastId = 'toast-' + Date.now();
  
  // Set icon based on toast type
  let icon = 'info-circle-fill';
  if (type === 'error') icon = 'exclamation-circle-fill';
  if (type === 'success') icon = 'check-circle-fill';
  
  const toast = document.createElement('div');
  toast.id = toastId;
  toast.className = `toast bg-${type === 'error' ? 'danger' : type === 'success' ? 'success' : 'info'} text-white`;
  toast.style.cssText = 'min-width: 300px; margin-bottom: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.15); opacity: 0; transform: translateX(20px);';
  
  toast.innerHTML = `
    <div class="toast-header bg-${type === 'error' ? 'danger' : type === 'success' ? 'success' : 'info'} text-white">
      <i class="bi bi-${icon} me-2"></i>
      <strong class="me-auto">${type === 'error' ? 'Error' : type === 'success' ? 'Sukses' : 'Informasi'}</strong>
      <button type="button" class="btn-close btn-close-white" onclick="document.getElementById('${toastId}').remove()"></button>
    </div>
    <div class="toast-body">
      ${message}
    </div>
  `;
  
  document.getElementById('toast-container').appendChild(toast);
  
  // Animate the toast in
  setTimeout(() => {
    toast.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
    toast.style.opacity = '1';
    toast.style.transform = 'translateX(0)';
  }, 10);
  
  // Auto remove toast after 5 seconds
  setTimeout(() => {
    if (document.getElementById(toastId)) {
      toast.style.opacity = '0';
      toast.style.transform = 'translateX(20px)';
      
      setTimeout(() => {
        if (document.getElementById(toastId)) {
          document.getElementById(toastId).remove();
        }
      }, 500);
    }
  }, 5000);
}

/**
 * Update the status container with module data 📦
 * @param {object} data - The module status data
 */
function showModuleStatus(data) {
  // Update status icon based on status
  const statusIcon = document.querySelector('.status-icon');
  
  if (data.status === "Sudah Tersedia") {
    statusIcon.innerHTML = '<i class="bi bi-check-circle-fill text-success"></i>';
  } else if (data.status === "Dalam Perjalanan") {
    statusIcon.innerHTML = '<i class="bi bi-truck text-warning"></i>';
  } else {
    statusIcon.innerHTML = '<i class="bi bi-exclamation-circle-fill text-danger"></i>';
  }
  
  // Update status details
  document.getElementById('student-name').textContent = data.name;
  document.getElementById('student-program').textContent = data.program;
  document.getElementById('module-status').textContent = data.status;
  document.getElementById('shipping-date').textContent = data.shipDate || '-';
  document.getElementById('arrival-date').textContent = data.arrivalDate || '-';
  
  // Update status message with appropriate styling
  let statusMessage = '';
  let statusClass = '';
  
  if (data.status === "Sudah Tersedia") {
    statusMessage = "Modul Anda telah tersedia dan siap untuk diambil! 🎉";
    statusClass = "text-success";
  } else if (data.status === "Dalam Perjalanan") {
    statusMessage = "Modul Anda sedang dalam proses pengiriman. 🚚";
    statusClass = "text-warning";
  } else {
    statusMessage = "Modul Anda belum tersedia. ⏳";
    statusClass = "text-danger";
  }
  
  const statusMessageElement = document.querySelector('.status-message');
  statusMessageElement.textContent = statusMessage;
  statusMessageElement.className = 'status-message ' + statusClass;
  
  // Add animation to the status container
  const statusContainer = document.getElementById('status-container');
  statusContainer.classList.add('animate__animated', 'animate__fadeIn');
}
