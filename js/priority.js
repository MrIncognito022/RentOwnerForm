document.addEventListener('DOMContentLoaded', () => {
    // Fetch priorities from the PHP endpoint
    async function fetchPriorities() {
        try {
            const response = await fetch('Priorities/get-priority.php'); // Path to the PHP API
            if (!response.ok) {
                throw new Error('Failed to fetch priorities');
            }
            const priorities = await response.json();

            // Populate the select dropdown
            const prioritySelect = document.getElementById('prioritySelect');
            if (!prioritySelect) {
                console.error("Element with ID 'prioritySelect' not found.");
                return;
            }

            // Clear any existing options (optional)
            prioritySelect.innerHTML = '<option value="">Select Priority</option>';

            priorities.forEach(priority => {
                const option = document.createElement('option');
                option.value = priority.id; // Assuming 'id' is the unique identifier in the response
                option.textContent = priority.name; // Assuming 'name' is the field for priority name in the response
                prioritySelect.appendChild(option);
            });
        } catch (error) {
            console.error('Error fetching priorities:', error);
        }
    }

    // Call fetchPriorities when the page loads
    fetchPriorities();

    // Add event listener to the "+" icon to create a new priority
    const createPriorityIcon = document.getElementById('createPriorityIcon');
    if (createPriorityIcon) {
        createPriorityIcon.addEventListener('click', () => {
            const modalElement = document.getElementById('addPriorityModal');
            if (!modalElement) {
                console.error("Modal with ID 'addPriorityModal' not found.");
                return;
            }
            const modal = new bootstrap.Modal(modalElement);
            modal.show();
        });
    } else {
        console.error("Element with ID 'createPriorityIcon' not found.");
    }

    // Save the priority when the "Save Priority" button is clicked
    const savePriorityBtn = document.getElementById('savePriorityBtn');
    if (savePriorityBtn) {
        savePriorityBtn.addEventListener('click', async () => {
            const priorityName = document.getElementById('priorityName').value.trim();

            if (priorityName) {
                try {
                    const response = await fetch('Priorities/create-priority.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ name: priorityName })
                    });

                    const result = await response.json();
                    if (response.ok && result.success) {
                        alert('Priority saved successfully!');
                        fetchPriorities(); // Refresh the dropdown list
                        // Close the modal after success
                        const modalInstance = bootstrap.Modal.getInstance(document.getElementById('addPriorityModal'));
                        if (modalInstance) {
                            modalInstance.hide();
                        }
                    } else {
                        alert('Failed to save priority: ' + (result.error || 'Unknown error'));
                    }
                } catch (error) {
                    console.error('Error saving priority:', error);
                    alert('An error occurred while saving the priority.');
                }
            } else {
                alert('Please enter a priority name');
            }
        });
    } else {
        console.error("Element with ID 'savePriorityBtn' not found.");
    }

    // Add event listener to the trash icon for deleting a priority
    const deletePriorityModalEl = document.getElementById('deletePriorityModal');
    const deletePriorityIcon = document.getElementById('deletePriorityIcon');

    if (deletePriorityIcon) {
        deletePriorityIcon.addEventListener('click', () => {
            const modal = new bootstrap.Modal(deletePriorityModalEl);
            modal.show();
        });
    } else {
        console.error("Element with ID 'deletePriorityIcon' not found.");
    }

    // When the priority delete modal is about to be shown, populate the dropdown
    deletePriorityModalEl.addEventListener('show.bs.modal', populatePriorityDropdownForDelete);

    async function populatePriorityDropdownForDelete() {
        try {
            const response = await fetch('Priorities/get-priority.php'); // Adjust path if necessary
            if (!response.ok) {
                throw new Error('Failed to fetch priorities');
            }
            const priorities = await response.json();
            const prioritySelect = document.getElementById('priorityModalDropdown');

            // Clear any existing options and add the default option
            prioritySelect.innerHTML = '<option value="">Select Priority</option>';

            // Populate dropdown with fetched priorities
            priorities.forEach(priority => {
                const option = document.createElement('option');
                option.value = priority.id;        // Adjust property name if needed
                option.textContent = priority.name;  // Adjust property name if needed
                prioritySelect.appendChild(option);
            });
        } catch (error) {
            console.error('Error fetching priorities:', error);
        }
    }

    // Delete priority when "Delete Priority" button is clicked
    const confirmDeletePriorityBtn = document.getElementById('confirmDeletePriorityBtn');
    confirmDeletePriorityBtn.addEventListener('click', async function () {
        const prioritySelect = document.getElementById('priorityModalDropdown');
        const selectedPriorityId = prioritySelect.value;

        if (!selectedPriorityId) {
            alert('Please select a priority to delete.');
            return;
        }

        try {
            // Send the selected priority's ID to the backend for deletion
            const response = await fetch('Priorities/delete-priority.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: selectedPriorityId }) // Sending the ID to be deleted
            });

            const result = await response.json();
            if (response.ok && result.success) {
                alert('Priority deleted successfully.');
                populatePriorityDropdownForDelete(); // Refresh the dropdown to remove the deleted priority
                // Close the modal after deletion
                const modalInstance = bootstrap.Modal.getInstance(deletePriorityModalEl);
                if (modalInstance) {
                    modalInstance.hide();
                }
            } else {
                alert('Failed to delete priority: ' + result.message);
            }
        } catch (error) {
            console.error('Error deleting priority:', error);
            alert('An error occurred while deleting the priority.');
        }
    });
});
