document.addEventListener('DOMContentLoaded', () => {
    // Fetch PropTypes from the PHP endpoint
    async function fetchPropTypes() {
        try {
            const response = await fetch('PropTypes/get-propType.php'); // Verify this path!
            if (!response.ok) {
                throw new Error('Failed to fetch PropTypes');
            }
            const propTypes = await response.json();

            // Populate the select dropdown
            const proptypeSelect = document.getElementById('propTypeSelect');
            if (!proptypeSelect) {
                console.error("Element with ID 'propTypeSelect' not found.");
                return;
            }

            // Clear any existing options (optional)
            proptypeSelect.innerHTML = '<option value="">Select PropType</option>';

            propTypes.forEach(propType => {
                const option = document.createElement('option');
                option.value = propType.id; // Ensure this matches your database field
                option.textContent = propType.name;
                proptypeSelect.appendChild(option);
            });
        } catch (error) {
            console.error('Error fetching PropTypes:', error);
        }
    }

    // Call fetchPropTypes when the page loads
    fetchPropTypes();

    // Add event listener to the "+" icon for creating a PropType
    const createPropTypeIcon = document.getElementById('createPropTypeIcon');
    if (createPropTypeIcon) {
        createPropTypeIcon.addEventListener('click', () => {
            const modalElement = document.getElementById('addPropTypeModal');
            if (!modalElement) {
                console.error("Modal with ID 'addPropTypeModal' not found.");
                return;
            }
            const modal = new bootstrap.Modal(modalElement);
            modal.show();
        });
    } else {
        console.error("Element with ID 'createPropTypeIcon' not found.");
    }

    // Save the PropType when the "Save PropType" button is clicked
    const savePropTypeBtn = document.getElementById('savePropTypeBtn');
    if (savePropTypeBtn) {
        savePropTypeBtn.addEventListener('click', async () => {
            const propTypeName = document.getElementById('propTypeName').value.trim();

            if (propTypeName) {
                try {
                    const response = await fetch('PropTypes/create-propType.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ name: propTypeName })
                    });

                    const result = await response.json();
                    if (response.ok && result.success) {
                        alert('PropType saved successfully!');
                        fetchPropTypes(); // Refresh the dropdown list
                        // Close the modal after success
                        const modalInstance = bootstrap.Modal.getInstance(document.getElementById('addPropTypeModal'));
                        if (modalInstance) {
                            modalInstance.hide();
                        }
                    } else {
                        alert('Failed to save PropType: ' + (result.error || 'Unknown error'));
                    }
                } catch (error) {
                    console.error('Error saving PropType:', error);
                    alert('An error occurred while saving the PropType.');
                }
            } else {
                alert('Please enter a PropType name');
            }
        });
    } else {
        console.error("Element with ID 'savePropTypeBtn' not found.");
    }
});



// Add event listener to the trash icon for deleting a PropType
document.getElementById('deletePropTypeIcon').addEventListener('click', () => {
    // Get the Bootstrap modal instance and show the modal
    const modal = new bootstrap.Modal(document.getElementById('deletePropTypeModal'));
    modal.show();
  });
  
  // When the PropType delete modal is about to be shown, populate the dropdown
  const deletePropTypeModalEl = document.getElementById('deletePropTypeModal');
  deletePropTypeModalEl.addEventListener('show.bs.modal', populatePropTypeDropdown);
  
  async function populatePropTypeDropdown() {
    try {
      const response = await fetch('PropTypes/get-propType.php'); // Adjust path if necessary
      if (!response.ok) {
        throw new Error('Failed to fetch PropTypes');
      }
      const propTypes = await response.json();
      const propTypeSelect = document.getElementById('propTypeModalDropdown');
    
      // Clear any existing options and add the default option
      propTypeSelect.innerHTML = '<option value="">Select PropType</option>';
    
      // Populate dropdown with fetched PropTypes
      propTypes.forEach(propType => {
        const option = document.createElement('option');
        option.value = propType.id;        // Adjust property name if needed
        option.textContent = propType.name;  // Adjust property name if needed
        propTypeSelect.appendChild(option);
      });
    } catch (error) {
      console.error('Error fetching PropTypes:', error);
    }
  }
  
  // Attach the Delete button event handler for PropType deletion
  const confirmDeletePropTypeBtn = document.getElementById('confirmDeletePropTypeBtn');
  confirmDeletePropTypeBtn.addEventListener('click', async function () {
    const propTypeSelect = document.getElementById('propTypeModalDropdown');
    const selectedPropTypeId = propTypeSelect.value;
  
    if (!selectedPropTypeId) {
      alert('Please select a PropType to delete.');
      return;
    }
  
    try {
      // Send the selected PropType's ID to the backend for deletion
      const response = await fetch('PropTypes/delete-propType.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: selectedPropTypeId }) // Sending the ID as JSON
      });
  
      const result = await response.json();
      if (response.ok && result.success) {
        alert('PropType deleted successfully.');
        // Refresh the dropdown to remove the deleted PropType
        populatePropTypeDropdown();
        // Hide the modal after deletion
        const modalInstance = bootstrap.Modal.getInstance(deletePropTypeModalEl);
        modalInstance.hide();
      } else {
        alert('Failed to delete PropType: ' + result.message);
      }
    } catch (error) {
      console.error('Error deleting PropType:', error);
      alert('An error occurred while deleting the PropType.');
    }
  });
  