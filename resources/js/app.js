import './bootstrap';

import Alpine from 'alpinejs';
import Swal from 'sweetalert2';

window.Alpine = Alpine;
window.Swal = Swal;

Alpine.start();

// SweetAlert2 Helper Functions
window.showAlert = function (title, text, icon = 'success') {
    return Swal.fire({
        title: title,
        text: text,
        icon: icon,
        confirmButtonText: 'OK',
        confirmButtonColor: '#3b82f6',
    });
};

window.showConfirm = function (title, text, confirmText = 'Ya', cancelText = 'Batal') {
    return Swal.fire({
        title: title,
        text: text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3b82f6',
        cancelButtonColor: '#ef4444',
        confirmButtonText: confirmText,
        cancelButtonText: cancelText,
    });
};

window.showSuccess = function (title, text = '') {
    return Swal.fire({
        title: title,
        text: text,
        icon: 'success',
        confirmButtonText: 'OK',
        confirmButtonColor: '#10b981',
        timer: 3000,
        timerProgressBar: true,
    });
};

window.showError = function (title, text = '') {
    return Swal.fire({
        title: title,
        text: text,
        icon: 'error',
        confirmButtonText: 'OK',
        confirmButtonColor: '#ef4444',
    });
};

window.showLoading = function (title = 'Memproses...', text = 'Mohon tunggu') {
    Swal.fire({
        title: title,
        text: text,
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
};

window.closeLoading = function () {
    Swal.close();
};

// Initialize SweetAlert for forms with confirm attribute
document.addEventListener('DOMContentLoaded', function () {
    // Handle all forms with data-confirm attribute
    document.querySelectorAll('form[data-confirm]').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const message = this.dataset.confirm || 'Apakah Anda yakin?';

            showConfirm('Konfirmasi', message, 'Ya', 'Batal').then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    });

    // Replace all onclick with confirm() calls - More secure approach
    document.querySelectorAll('[onclick*="confirm("]').forEach(element => {
        const originalOnclick = element.getAttribute('onclick');
        element.removeAttribute('onclick');

        element.addEventListener('click', function (e) {
            e.preventDefault();

            // Extract confirm message
            const match = originalOnclick.match(/confirm\(['"](.+?)['"]\)/);
            const message = match ? match[1] : 'Apakah Anda yakin?';

            showConfirm('Konfirmasi', message, 'Ya', 'Batal').then((result) => {
                if (result.isConfirmed) {
                    // Check if this is a form submit button or inside a form
                    const form = element.closest('form');
                    if (form) {
                        form.submit();
                    } else {
                        // For links, try to extract href and navigate
                        const href = element.getAttribute('href');
                        if (href && href !== '#') {
                            window.location.href = href;
                        } else {
                            // Try to extract function call from onclick
                            const functionMatch = originalOnclick.match(/(\w+)\s*\(/);
                            if (functionMatch && window[functionMatch[1]]) {
                                // Call the function if it exists globally
                                const args = originalOnclick.match(/\((.*?)\)/);
                                if (args && args[1]) {
                                    const argValues = args[1].split(',').map(arg => {
                                        arg = arg.trim();
                                        // Remove quotes if present
                                        if ((arg.startsWith("'") && arg.endsWith("'")) ||
                                            (arg.startsWith('"') && arg.endsWith('"'))) {
                                            return arg.slice(1, -1);
                                        }
                                        // Try to parse as number
                                        const num = Number(arg);
                                        return isNaN(num) ? arg : num;
                                    });
                                    window[functionMatch[1]](...argValues);
                                } else {
                                    window[functionMatch[1]]();
                                }
                            }
                        }
                    }
                }
            });
        });
    });
});
