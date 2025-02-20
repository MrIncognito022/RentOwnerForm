async function fetchProjects() {
    try {
        const response = await fetch('Project/get-project.php'); // Ensure this path is correct
        if (!response.ok) {
            throw new Error('Failed to fetch projects');
        }
        
        const projects = await response.json();
        console.log(projects); // Debugging: Check if data is coming correctly

        const projectDropdown = document.getElementById('projectDropdown');
        if (!projectDropdown) {
            console.error("Dropdown element with ID 'projectDropdown' not found.");
            return;
        }

        // Clear previous options except the first default one
        projectDropdown.innerHTML = '<option value="">Select a Project</option>';

        // Populate the dropdown with project names
        projects.forEach(project => {
            const option = document.createElement('option');
            option.value = project.id; // Assuming 'id' is the primary key in the Project table
            option.textContent = project.name; // Assuming 'name' is the project name column
            projectDropdown.appendChild(option);
        });

    } catch (error) {
        console.error('Error fetching projects:', error);
    }
}

// Fetch projects when the page loads
document.addEventListener('DOMContentLoaded', fetchProjects);
