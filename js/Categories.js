
document.addEventListener('DOMContentLoaded', () => {
  // Fetch Categories from the PHP endpoint
  async function fetchCategories() {
    try {
      const response = await fetch('Categories/get-categories.php'); // Verify this path!
      if (!response.ok) {
        throw new Error('Failed to fetch categories');
      }
      const categories = await response.json();
    
      // Populate the select dropdown
      const categorySelect = document.getElementById('categorySelect');
      if (!categorySelect) {
        console.error("Element with ID 'categorySelect' not found.");
        return;
      }
    
      // Clear any existing options (optional)
      categorySelect.innerHTML = '<option value="">Select Category</option>';
    
      categories.forEach(category => {
        const option = document.createElement('option');
        // Adjust property names if needed: e.g., category.Id vs. category.id
        option.value = category.id;
        option.textContent = category.name;
        categorySelect.appendChild(option);
      });
    } catch (error) {
      console.error('Error fetching categories:', error);
    }
  }
  
  // Call fetchCategories when page loads
  fetchCategories();
  
  // Add event listener to the "+" icon for creating a category
  const createCategoryIcon = document.getElementById('createCategoryIcon');
  if (createCategoryIcon) {
    createCategoryIcon.addEventListener('click', () => {
      const modalElement = document.getElementById('addCategoryModal');
      if (!modalElement) {
        console.error("Modal with ID 'addCategoryModal' not found.");
        return;
      }
      const modal = new bootstrap.Modal(modalElement);
      modal.show();
    });
  } else {
    console.error("Element with ID 'createCategoryIcon' not found.");
  }
  
  // Save the category when the "Save Category" button is clicked
  const saveCategoryBtn = document.getElementById('saveCategoryBtn');
  if (saveCategoryBtn) {
    saveCategoryBtn.addEventListener('click', async () => {
      const categoryName = document.getElementById('categoryName').value.trim();
    
      if (categoryName) {
        try {
          const response = await fetch('Categories/create-categories.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({ name: categoryName })
          });
      
          const result = await response.json();
          if (response.ok) {
            alert('Category saved successfully!');
            // Close the modal after success
            const modalInstance = bootstrap.Modal.getInstance(document.getElementById('addCategoryModal'));
            if (modalInstance) {
              modalInstance.hide();
            }
          } else {
            alert('Failed to save category: ' + result.error);
          }
        } catch (error) {
          console.error('Error saving category:', error);
          alert('An error occurred while saving the category.');
        }
      } else {
        alert('Please enter a category name');
      }
    });
  } else {
    console.error("Element with ID 'saveCategoryBtn' not found.");
  }
});



// Add event listener to the trash icon for deleting a category
document.getElementById('deleteCategoryIcon').addEventListener('click', () => {
  // Get the Bootstrap modal instance and show the modal
  const modal = new bootstrap.Modal(document.getElementById('deleteCategoryModal'));
  modal.show();
});

// When the category delete modal is about to be shown, populate the dropdown
const deleteCategoryModalEl = document.getElementById('deleteCategoryModal');
deleteCategoryModalEl.addEventListener('show.bs.modal', populateCategoryDropdown);

async function populateCategoryDropdown() {
  try {
    const response = await fetch('Categories/get-categories.php'); // Adjust path if necessary
    if (!response.ok) {
      throw new Error('Failed to fetch categories');
    }
    const categories = await response.json();
    const categorySelect = document.getElementById('categoryModalDropdown');
  
    // Clear any existing options and add the default option
    categorySelect.innerHTML = '<option value="">Select Category</option>';
  
    // Populate dropdown with fetched categories
    categories.forEach(category => {
      const option = document.createElement('option');
      option.value = category.id;        // Adjust property name if needed
      option.textContent = category.name;  // Adjust property name if needed
      categorySelect.appendChild(option);
    });
  } catch (error) {
    console.error('Error fetching categories:', error);
  }
}

// Attach the Delete button event handler for category deletion
const confirmDeleteCategoryBtn = document.getElementById('confirmDeleteCategoryBtn');
confirmDeleteCategoryBtn.addEventListener('click', async function () {
  const categorySelect = document.getElementById('categoryModalDropdown');
  const selectedCategoryId = categorySelect.value;

  if (!selectedCategoryId) {
    alert('Please select a category to delete.');
    return;
  }

  try {
    // Send the selected category's ID to the backend for deletion
    const response = await fetch('Categories/delete-category.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ id: selectedCategoryId }) // Sending the ID as JSON
    });

    const result = await response.json();
    if (response.ok && result.success) {
      alert('Category deleted successfully.');
      // Refresh the dropdown to remove the deleted category
      populateCategoryDropdown();
      // Hide the modal after deletion
      const modalInstance = bootstrap.Modal.getInstance(deleteCategoryModalEl);
      modalInstance.hide();
    } else {
      alert('Failed to delete category: ' + result.message);
    }
  } catch (error) {
    console.error('Error deleting category:', error);
    alert('An error occurred while deleting the category.');
  }
});
