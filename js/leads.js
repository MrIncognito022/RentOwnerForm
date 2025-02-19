
// Fetch leads data from PHP endpoint
async function fetchLeads() {
  try {

    const response = await fetch('Leads/get-leads.php'); // Path to the PHP API
    if (!response.ok) {
      throw new Error('Failed to fetch leads');
    }
    const leads = await response.json();

    // Populate the select dropdown

    const leadSelect = document.getElementById('leadSelect');
    leads.forEach(lead => {
      const option = document.createElement('option');
      option.value = lead.Id; // Assuming 'id' is the unique identifier
      option.textContent = lead.LeadName; // Assuming 'name' is a field in the database
      leadSelect.appendChild(option);
    });
  } catch (error) {
    console.error('Error fetching leads:', error);
  }
}

// Call fetchLeads function when page loads
document.addEventListener('DOMContentLoaded', fetchLeads);


// Add event listener to the "+" icon
document.getElementById('createLeadIcon').addEventListener('click', () => {
  // Get the Bootstrap modal instance and show the modal
  const modal = new bootstrap.Modal(document.getElementById('addLeadModal'));
  modal.show();
});

// Save the lead when the "Save Lead" button is clicked
document.getElementById('saveLeadBtn').addEventListener('click', async () => {
  const leadName = document.getElementById('leadName').value.trim();

  if (leadName) {
    try {
      const response = await fetch('Leads/create-leads.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ LeadName: leadName }) // Send lead name in the request body
      });

      const result = await response.json();
      if (response.ok) {
        alert('Lead saved successfully!');
        // You can close the modal here after success if needed:
        const modal = bootstrap.Modal.getInstance(document.getElementById('addLeadModal'));
        modal.hide();
      } else {
        alert('Failed to save lead: ' + result.message);
      }
    } catch (error) {
      console.error('Error saving lead:', error);
      alert('An error occurred while saving the lead.');
    }
  } else {
    alert('Please enter a lead name');
  }
});




// Add event listener to the "+" icon
document.getElementById('deleteLeadIcon').addEventListener('click', () => {
  // Get the Bootstrap modal instance and show the modal
  const modal = new bootstrap.Modal(document.getElementById('deleteLeadModal'));
  modal.show();
});


// When the modal is about to be shown, populate the dropdown
const deleteLeadModalEl = document.getElementById('deleteLeadModal');
deleteLeadModalEl.addEventListener('show.bs.modal', populateLeadDropdown);

async function populateLeadDropdown() {
  try {
    const response = await fetch('Leads/get-leads.php');
    if (!response.ok) {
      throw new Error('Failed to fetch leads');
    }
    const leads = await response.json();
    const leadSelect = document.getElementById('leadModalDropdown');

  
    leadSelect.innerHTML = '<option value="">Select Lead</option>';

    
    leads.forEach(lead => {
      const option = document.createElement('option');
      option.value = lead.Id;         
      option.textContent = lead.LeadName; // Adjust if your JSON property is named differently
      leadSelect.appendChild(option);
    });
  } catch (error) {
    console.error('Error fetching leads:', error);
  }
}


 // Attach the Delete button event handler
 const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
 confirmDeleteBtn.addEventListener('click', async function () {
   const leadSelect = document.getElementById('leadModalDropdown');
   const selectedLeadId = leadSelect.value;

   if (!selectedLeadId) {
     alert('Please select a lead to delete.');
     return;
   }

   try {
     // Send the selected lead's ID to the backend for deletion
     const response = await fetch('Leads/delete-lead.php', {
       method: 'POST',
       headers: { 'Content-Type': 'application/json' },
       body: JSON.stringify({ Id: selectedLeadId }) // Sending the ID as JSON
     });

     const result = await response.json();
     if (response.ok && result.success) {
       alert('Lead deleted successfully.');
       // Optionally refresh the dropdown or remove the deleted lead from the list
       populateLeadDropdown();
       // Hide the modal after deletion
       const modalInstance = bootstrap.Modal.getInstance(deleteLeadModalEl);
       modalInstance.hide();
     } else {
       alert('Failed to delete lead: ' + result.message);
     }
   } catch (error) {
     console.error('Error deleting lead:', error);
     alert('An error occurred while deleting the lead.');
   }
 });







