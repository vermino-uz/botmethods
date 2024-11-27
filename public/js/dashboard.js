// Handle modal form submissions
document.addEventListener('DOMContentLoaded', function() {
    // Get modal elements
    const responseModal = new bootstrap.Modal(document.getElementById('apiResponseModal'));
    const modalTitle = document.getElementById('apiResponseModalLabel');
    const modalBody = document.getElementById('apiResponseBody');
    const modalSpinner = document.getElementById('modalSpinner');

    // Handle all API method forms
    document.querySelectorAll('.api-method-form').forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            // Show loading state
            modalSpinner.classList.remove('d-none');
            modalBody.innerHTML = 'Sending request...';
            modalTitle.textContent = 'API Response';
            responseModal.show();

            try {
                // Send form data
                const formData = new FormData(this);
                const response = await fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();

                // Update modal with response
                modalSpinner.classList.add('d-none');
                
                if (response.ok) {
                    modalBody.innerHTML = `
                        <div class="alert alert-success">
                            Request successful!
                        </div>
                        <pre class="bg-light p-3 rounded"><code>${JSON.stringify(data, null, 2)}</code></pre>
                    `;
                } else {
                    throw new Error(data.message || 'Request failed');
                }

            } catch (error) {
                modalSpinner.classList.add('d-none');
                modalBody.innerHTML = `
                    <div class="alert alert-danger">
                        ${error.message || 'An error occurred while processing your request'}
                    </div>
                `;
            }
        });
    });

    // Reset modal content when hidden
    document.getElementById('apiResponseModal').addEventListener('hidden.bs.modal', function () {
        modalBody.innerHTML = '';
        modalSpinner.classList.add('d-none');
    });
});

// Helper function to format JSON responses
function formatJsonResponse(json) {
    if (typeof json === 'string') {
        try {
            json = JSON.parse(json);
        } catch (e) {
            return json;
        }
    }
    return JSON.stringify(json, null, 2);
}
