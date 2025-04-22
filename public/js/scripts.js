// Initialize DataTables
$(document).ready(function() {
    $('.datatable').DataTable({
        responsive: true,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search...",
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ entries"
        },
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rtip'
    });
});

// Form Validation
function validateForm(formId) {
    const form = document.getElementById(formId);
    const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
    let isValid = true;

    inputs.forEach(input => {
        if (!input.value.trim()) {
            input.classList.add('is-invalid');
            isValid = false;
        } else {
            input.classList.remove('is-invalid');
        }
    });

    return isValid;
}

// Toast Notifications
function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `toast toast-${type} fade-in`;
    toast.innerHTML = `
        <div class="toast-header">
            <strong class="me-auto">${type.charAt(0).toUpperCase() + type.slice(1)}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body">${message}</div>
    `;
    document.body.appendChild(toast);
    
    const bsToast = new bootstrap.Toast(toast);
    bsToast.show();
    
    toast.addEventListener('hidden.bs.toast', () => {
        toast.remove();
    });
}

// Loading Spinner
function showSpinner() {
    const spinner = document.createElement('div');
    spinner.className = 'spinner';
    spinner.id = 'loading-spinner';
    document.body.appendChild(spinner);
}

function hideSpinner() {
    const spinner = document.getElementById('loading-spinner');
    if (spinner) {
        spinner.remove();
    }
}

// AJAX Form Submission
function submitForm(formId, url, method = 'POST') {
    const form = document.getElementById(formId);
    const formData = new FormData(form);
    
    showSpinner();
    
    fetch(url, {
        method: method,
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        hideSpinner();
        if (data.success) {
            showToast(data.message, 'success');
            if (data.redirect) {
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 1000);
            }
        } else {
            showToast(data.message, 'error');
        }
    })
    .catch(error => {
        hideSpinner();
        showToast('An error occurred. Please try again.', 'error');
    });
}

// Image Preview
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('image-preview');
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Match Calendar
function initializeCalendar() {
    const calendarEl = document.getElementById('match-calendar');
    if (calendarEl) {
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: '/api/matches/calendar',
            eventClick: function(info) {
                window.location.href = `/match/${info.event.id}`;
            }
        });
        calendar.render();
    }
}

// Stats Charts
function initializeCharts() {
    const goalsChart = document.getElementById('goals-chart');
    if (goalsChart) {
        new Chart(goalsChart, {
            type: 'bar',
            data: {
                labels: ['Goals', 'Assists'],
                datasets: [{
                    label: 'Player Statistics',
                    data: [goalsChart.dataset.goals, goalsChart.dataset.assists],
                    backgroundColor: [
                        'rgba(78, 115, 223, 0.8)',
                        'rgba(34, 74, 190, 0.8)'
                    ]
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
}

// Initialize all features
document.addEventListener('DOMContentLoaded', function() {
    // Initialize DataTables
    $('.datatable').DataTable();
    
    // Initialize Calendar if present
    if (document.getElementById('match-calendar')) {
        initializeCalendar();
    }
    
    // Initialize Charts if present
    if (document.getElementById('goals-chart')) {
        initializeCharts();
    }
    
    // Form validation
    const forms = document.querySelectorAll('form[data-validate]');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!validateForm(this.id)) {
                e.preventDefault();
            }
        });
    });
    
    // Image preview
    const imageInputs = document.querySelectorAll('input[type="file"][accept="image/*"]');
    imageInputs.forEach(input => {
        input.addEventListener('change', function() {
            previewImage(this);
        });
    });
}); 