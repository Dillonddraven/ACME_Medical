<?php
require_once ('../../app_config.php');
require_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';

// Set timezone to America/Chicago
date_default_timezone_set('America/Chicago');

if(!=empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, //we must check if the POST variables exist if not we //can default them to blank
    $medication_id = isset($_POST['medication_id']) && !empty($_POST['medication_id']) && $_POST['medication_id'] != 'auto' ? $_POST['medication_id'] : NULL;
    // Check if POST variable "name" exists, if not default //the value to blank, basically the same for all //variables
    $medication_name = isset($_POST['medication_name']) ? $_POST['medication_name'] : '';
    $medication_type = isset($_POST['medication_type']) ? $_POST['medication_type'] : '';
    $medication_dosage = isset($_POST['medication_dosage']) ? $_POST['medication_dosage'] : '';
    $medication_quantity = isset($_POST['medication_quantity']) ? $_POST['medication_quantity'] : '';
    $medication_frequency = isset($_POST['medication_frequency']) ? $_POST['medication_frequency'] : '';

    // Insert new record into the medications table
    $stmt = $pdo->prepare('INSERT INTO medications VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([$medication_id, $medication_name, $medication_type, $medication_dosage, $medication_quantity, $medication_frequency]);
    
    // Output message
    $msg = 'Created Successfully!';
}
?> 

<div class="content update">
    <h2>Create Medication</h2>
    <form action="medications_create.php" method="POST">
       <label for="medication_id">Medication ID</label>
            <input type="text" name="medication_id" placeholder="Ex. 26" value="auto" id="medication_id" readonly required>
        <label for="medication_name">Name</label>
            <input type="text" name="medication_name" placeholder="Ex. Bactrim" id="medication_name" pattern = "[A-Za-z'\-\s]{2,}" required>
        <label for="medication_type">Type</label>
            <input type="text" name="medication_type" placeholder="Ex. Antibiotic" id="medication_type" pattern = "[A-Za-z'\-\s]{2,}">
        <label for="medication_dosage">Dosage</label>
            <input type="text" name="medication_dosage" placeholder="Ex. 50mg" id="medication_dosage" required>
        <label for="medication_quantity">Quantity</label>
            <input type="number" name="medication_quantity" placeholder="Ex. 14" id="medication_quantity" min="1" pattern="[0-9]+" required>
        <label for="medication_frequency">Frequency</label>
            <select name = "medication_frequency" id = "medication_frequency">
                <option value="" disabled selected>Please select an option</option>
                <option value = "QD">QD (Once Daily)</option>
                <option value = "BID">BID (Twice Daily)</option>
                <option value = "TID">TID (Three Times Daily)</option>
                <option value = "QHS">QHS (Once Every Night)</option>
            </select>
        <input type="submit" value="Create">

</form> 

</div>