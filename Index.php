<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rental System - Add Owner</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .form-section { border: 1px solid #ccc; padding: 15px; margin-bottom: 20px; }
        .form-section h3 { margin-top: 0; }
        label { display: block; margin-top: 10px; }
        input[type="text"],
        input[type="number"],
        input[type="file"],
        textarea { width: 100%; padding: 8px; box-sizing: border-box; }
        input[type="checkbox"] { margin-right: 5px; }
        .submit-btn { margin-top: 20px; padding: 10px 20px; }
    </style>
</head>
<body>
    <h1>Add Rental Owner</h1>
    <form action="submit_form.php" method="POST" enctype="multipart/form-data">
        <!-- Owner Information -->
        <div class="form-section">
            <h3>Owner Information</h3>
            <label for="name">Name*</label>
            <input type="text" id="name" name="name" required>

            <label for="cast">Cast</label>
            <input type="text" id="cast" name="cast">

            <label for="cell">Cell*</label>
            <input type="text" id="cell" name="cell" required>

            <label for="cnic">CNIC*</label>
            <input type="text" id="cnic" name="cnic" required>

            <label for="lead">Lead</label>
            <input type="text" id="lead" name="lead">

            <label for="category">Category</label>
            <input type="text" id="category" name="category">

            <label for="prop_type">Property Type</label>
            <input type="text" id="prop_type" name="prop_type">

            <label for="status">Status</label>
            <input type="text" id="status" name="status">

            <label for="priority">Priority</label>
            <input type="text" id="priority" name="priority">

            <label>
                <input type="checkbox" name="overseas" value="1"> Overseas
            </label>
            <label>
                <input type="checkbox" name="investor" value="1"> Investor
            </label>
            <label>
                <input type="checkbox" name="builder" value="1"> Builder
            </label>

            <label for="owner_photo">Owner Photo</label>
            <input type="file" id="owner_photo" name="owner_photo" accept="image/*">
        </div>

        <!-- Property Features -->
        <div class="form-section">
            <h3>Property Features</h3>
            <label for="bedrooms">Bedrooms</label>
            <input type="number" id="bedrooms" name="bedrooms" min="0" value="0">

            <label for="bathrooms">Bathrooms</label>
            <input type="number" id="bathrooms" name="bathrooms" min="0" value="0">

            <label for="floor">Floor</label>
            <input type="text" id="floor" name="floor">

            <label for="block">Block</label>
            <input type="text" id="block" name="block">

            <label for="square_feet">Square Feet</label>
            <input type="text" id="square_feet" name="square_feet">

            <label>
                <input type="checkbox" name="drawing" value="1"> Drawing
            </label>
            <label>
                <input type="checkbox" name="roof" value="1"> Roof
            </label>
            <label>
                <input type="checkbox" name="separate_gate" value="1"> Separate Gate
            </label>
            <label>
                <input type="checkbox" name="dining" value="1"> Dining
            </label>
            <label>
                <input type="checkbox" name="store" value="1"> Store
            </label>
            <label>
                <input type="checkbox" name="basement" value="1"> Basement
            </label>
            <label>
                <input type="checkbox" name="common" value="1"> Common
            </label>
            <label>
                <input type="checkbox" name="mezzanine" value="1"> Mezzanine
            </label>
            <label>
                <input type="checkbox" name="west_open" value="1"> West Open
            </label>
            <label>
                <input type="checkbox" name="back" value="1"> Back
            </label>
            <label>
                <input type="checkbox" name="gas" value="1"> Gas
            </label>
            <label>
                <input type="checkbox" name="corner" value="1"> Corner
            </label>
            <label>
                <input type="checkbox" name="front" value="1"> Front
            </label>
            <label>
                <input type="checkbox" name="water" value="1"> Water
            </label>
        </div>

        <!-- Possession Details -->
        <div class="form-section">
            <h3>Possession Details</h3>
            <label for="possession">Possession</label>
            <input type="text" id="possession" name="possession">

            <label for="possession_in_words">Possession in Words</label>
            <input type="text" id="possession_in_words" name="possession_in_words">

            <label for="document_charges">Document Charges</label>
            <input type="number" id="document_charges" name="document_charges" step="0.01" value="0.00">

            <label for="flat_maintenance">Flat Maintenance</label>
            <input type="number" id="flat_maintenance" name="flat_maintenance" step="0.01" value="0.00">

            <label for="deposit">Deposit</label>
            <input type="number" id="deposit" name="deposit" step="0.01" value="0.00">

            <label for="rent">Rent</label>
            <input type="number" id="rent" name="rent" step="0.01" value="0.00">

            <label for="project_entry_fee">Project Entry Fee</label>
            <input type="number" id="project_entry_fee" name="project_entry_fee" step="0.01" value="0.00">

            <label for="office_charges">Office Charges</label>
            <input type="number" id="office_charges" name="office_charges" step="0.01" value="0.00">

            <label>
                <input type="checkbox" name="key_available" value="1"> Key Available
            </label>
        </div>

        <!-- Project Information -->
        <div class="form-section">
            <h3>Project Information</h3>
            <label for="project">Project</label>
            <input type="text" id="project" name="project">

            <label for="plot_no">Plot No</label>
            <input type="text" id="plot_no" name="plot_no">

            <label for="project_features">Project Features</label>
            <textarea id="project_features" name="project_features" rows="3"></textarea>

            <label for="location">Location</label>
            <input type="text" id="location" name="location">

            <label for="area">Area</label>
            <input type="text" id="area" name="area">

            <label>
                <input type="checkbox" name="project_bank_loan" value="1"> Project Bank Loan
            </label>
            <label>
                <input type="checkbox" name="project_completion_certificate" value="1"> Project Completion Certificate
            </label>
            <label for="builder_name">Builder Name</label>
            <input type="text" id="builder_name" name="builder_name">

            <label for="project_photo">Project Photo</label>
            <input type="file" id="project_photo" name="project_photo" accept="image/*">
        </div>

        <!-- Tenant Information -->
        <div class="form-section">
            <h3>Tenant Information</h3>
            <label for="tenant_name">Tenant Name</label>
            <input type="text" id="tenant_name" name="tenant_name">

            <label for="tenant_cnic">Tenant CNIC</label>
            <input type="text" id="tenant_cnic" name="tenant_cnic">

            <label for="tenant_cell">Tenant Cell</label>
            <input type="text" id="tenant_cell" name="tenant_cell">

            <label for="tenant_note">Tenant Note</label>
            <textarea id="tenant_note" name="tenant_note" rows="3"></textarea>
        </div>

        <!-- Reference Details -->
        <div class="form-section">
            <h3>Reference Details</h3>
            <label for="reference_name">Reference Name</label>
            <input type="text" id="reference_name" name="reference_name">

            <label for="reference_cnic">Reference CNIC</label>
            <input type="text" id="reference_cnic" name="reference_cnic">

            <label for="reference_cell">Reference Cell</label>
            <input type="text" id="reference_cell" name="reference_cell">

            <label for="reference_remarks">Reference Remarks</label>
            <textarea id="reference_remarks" name="reference_remarks" rows="3"></textarea>
        </div>

        <input type="submit" value="Submit" class="submit-btn">
    </form>
</body>
</html> -->
