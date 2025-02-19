function showTab(tabId) {
    // Hide all form sections
    document.querySelectorAll('.form-section').forEach(section => {
        section.style.display = 'none';
    });

    // Show the selected section
    const tabElement = document.getElementById(tabId);
    if (!tabElement) {
        console.error("Element not found:", tabId);
        return;
    }
    tabElement.style.display = 'block';

    // Remove active class from all tabs
    document.querySelectorAll('.nav-item').forEach(tab => {
        tab.classList.remove('active');
    });

    // Add active class to the selected tab
    document.querySelector(`[data-tab="${tabId}"]`)?.classList.add('active');
}

// Set default tab and make tabs clickable
document.addEventListener("DOMContentLoaded", function () {
    showTab('basic');  // Default tab

    document.querySelectorAll('.nav-item').forEach(tab => {
        tab.addEventListener("click", function () {
            let tabId = this.getAttribute("data-tab");
            if (tabId) showTab(tabId);
        });
    });
});

// Toggle advanced search
function toggleAdvancedSearch() {
    document.getElementById("advancedSearch").classList.toggle("d-none");
}

// Toggle table columns
document.querySelectorAll(".column-toggle").forEach(checkbox => {
    checkbox.addEventListener("change", function () {
        let columnIndex = this.getAttribute("data-column");
        let table = document.querySelector("table");
        let cells = table.querySelectorAll(`th:nth-child(${+columnIndex + 1}), td:nth-child(${+columnIndex + 1})`);
        
        if (this.checked) {
            cells.forEach(cell => cell.style.display = "");
        } else {
            cells.forEach(cell => cell.style.display = "none");
        }
    });
});
