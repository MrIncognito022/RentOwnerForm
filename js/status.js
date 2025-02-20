document.addEventListener('DOMContentLoaded', () => {
    // Fetch status from the PHP endpoint
    async function fetchStatus() {
        try {
            const response = await fetch('Status/get-status.php'); // Path to the PHP API
            if (!response.ok) {
                throw new Error('Failed to fetch status');
            }
            const statuses = await response.json();

            // Populate the select dropdown
            const statusSelect = document.getElementById('statusSelect');
            if (!statusSelect) {
                console.error("Element with ID 'statusSelect' not found.");
                return;
            }

            // Clear any existing options (optional)
            statusSelect.innerHTML = '<option value="">Select Status</option>';

            statuses.forEach(status => {
                const option = document.createElement('option');
                option.value = status.id; // Assuming 'id' is the unique identifier in the response
                option.textContent = status.name; // Assuming 'name' is the field for status name in the response
                statusSelect.appendChild(option);
            });
        } catch (error) {
            console.error('Error fetching status:', error);
        }
    }

    // Call fetchStatus when the page loads
    fetchStatus();

    // Add event listener to the "+" icon to create a new status
    const createStatusIcon = document.getElementById('createStatusIcon');
    if (createStatusIcon) {
        createStatusIcon.addEventListener('click', () => {
            const modalElement = document.getElementById('addStatusModal');
            if (!modalElement) {
                console.error("Modal with ID 'addStatusModal' not found.");
                return;
            }
            const modal = new bootstrap.Modal(modalElement);
            modal.show();
        });
    } else {
        console.error("Element with ID 'createStatusIcon' not found.");
    }

    // Handle the saving of the status
    const saveStatusBtn = document.getElementById('saveStatusBtn');
    saveStatusBtn.addEventListener('click', async () => {
        const statusNameInput = document.getElementById('statusName');
        
        // Check if the input element exists
        if (!statusNameInput) {
            console.error("Element with ID 'statusName' not found.");
            alert('Error: Status input field not found.');
            return;
        }
    
        const statusName = statusNameInput.value.trim();
    
        if (statusName) {
            try {
                const response = await fetch('Status/create-status.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ name: statusName })
                });
    
                const result = await response.json();
                if (response.ok && result.success) {
                    alert('Status saved successfully!');
                    fetchStatus(); // Refresh the dropdown list
                    // Close the modal after success
                    const modalInstance = bootstrap.Modal.getInstance(document.getElementById('addStatusModal'));
                    if (modalInstance) {
                        modalInstance.hide();
                    }
                } else {
                    alert('Failed to save status: ' + (result.error || 'Unknown error'));
                }
            } catch (error) {
                console.error('Error saving status:', error);
                alert('An error occurred while saving the status.');
            }
        } else {
            alert('Please enter a status name');
        }
    });

    // Add event listener to the trash icon for deleting a status
    document.getElementById('deleteStatusIcon').addEventListener('click', () => {
        const modal = new bootstrap.Modal(document.getElementById('deleteStatusModal'));
        modal.show();
    });

    // When the Status delete modal is about to be shown, populate the dropdown
    const deleteStatusModalEl = document.getElementById('deleteStatusModal');
    deleteStatusModalEl.addEventListener('show.bs.modal', populateStatusDropdown);

    async function populateStatusDropdown() {
        try {
            const response = await fetch('Status/get-status.php'); // Adjust path if necessary
            if (!response.ok) {
                throw new Error('Failed to fetch statuses');
            }
            const statuses = await response.json();
            const statusSelect = document.getElementById('statusModalDropdown');

            // Clear any existing options and add the default option
            statusSelect.innerHTML = '<option value="">Select Status</option>';

            // Populate dropdown with fetched statuses
            statuses.forEach(status => {
                const option = document.createElement('option');
                option.value = status.id;        // Adjust property name if needed
                option.textContent = status.name;  // Adjust property name if needed
                statusSelect.appendChild(option);
            });
        } catch (error) {
            console.error('Error fetching statuses:', error);
        }
    }

    // Attach the Delete button event handler for Status deletion
    const confirmDeleteStatusBtn = document.getElementById('confirmDeleteStatusBtn');
    confirmDeleteStatusBtn.addEventListener('click', async function () {
        const statusSelect = document.getElementById('statusModalDropdown');
        const selectedStatusId = statusSelect.value;

        if (!selectedStatusId) {
            alert('Please select a Status to delete.');
            return;
        }

        try {
            // Send the selected Status's ID to the backend for deletion
            const response = await fetch('Status/delete-status.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: selectedStatusId }) // Sending the ID as JSON
            });

            const result = await response.json();
            if (response.ok && result.success) {
                alert('Status deleted successfully.');
                populateStatusDropdown(); // Refresh the dropdown to remove the deleted Status
                const modalInstance = bootstrap.Modal.getInstance(deleteStatusModalEl);
                modalInstance.hide();
            } else {
                alert('Failed to delete Status: ' + result.message);
            }
        } catch (error) {
            console.error('Error deleting Status:', error);
            alert('An error occurred while deleting the Status.');
        }
    });
});
