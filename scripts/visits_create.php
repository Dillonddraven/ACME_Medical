<?php
// Include configuration and utility functions
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');

// Connect to the database using PDO
$pdo = pdo_connect_mysql();
$msg = '';

// Fetch list of patients to populate dropdown in the form
$patients_stmt = $pdo->query('SELECT patient_id, patient_first_name, patient_last_name FROM patients');
$patients = $patients_stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission
if (!empty($_POST)) {
    // Get posted form data
    $patient_id = isset($_POST['patient_id']) ? $_POST['patient_id'] : null;
    $visit_date = isset($_POST['visit_date']) ? $_POST['visit_date'] : '';
    $doctor_seen = isset($_POST['doctor_seen']) ? $_POST['doctor_seen'] : '';
    $fev1_values = isset($_POST['fev1_values']) ? $_POST['fev1_values'] : '';

    // Only proceed if patient ID is provided
    if ($patient_id) {
        // Insert visit record into database
        $stmt = $pdo->prepare('INSERT INTO visits (patient_id, visit_date, doctor_seen, fev1_values) VALUES (?, ?, ?, ?)');
        $stmt->execute([$patient_id, $visit_date, $doctor_seen, $fev1_values]);
        $msg = 'Visit Created Successfully!';
    } else {
        $msg = 'Please select a patient!';
    }
}
?>


<?=template_header('Create Visit')?>

<div class="content update">
    <h2>Create Visit</h2>
    <form action="visits_create.php" method="post">
        <!-- Patient selection dropdown -->
        <label for="patient_id">Select Patient</label>
        <select name="patient_id" id="patient_id" required>
            <option value="">--Select Patient--</option>
            <?php foreach ($patients as $patient): ?>
                <option value="<?=$patient['patient_id']?>"><?=$patient['patient_first_name']?> <?=$patient['patient_last_name']?> (ID: <?=$patient['patient_id']?>)</option>
            <?php endforeach; ?>
        </select>

        <!-- Input for date of visit -->
        <label for="visit_date">Visit Date</label>
        <input type="date" name="visit_date" id="visit_date" required>

        <!-- Input for doctor's name -->
        <label for="doctor_seen">Doctor Seen</label>
        <input type="text" name="doctor_seen" placeholder="Dr. Smith" id="doctor_seen" required>

        <!-- Input for FEV1 values, comma-separated -->
        <label for="fev1_values">FEV1 Values (comma-separated)</label>
        <input type="text" name="fev1_values" placeholder="3.2L, 3.4L, 3.1L" id="fev1_values" required pattern="^(\s*\d+(\.\d+)?L\s*)(,\s*\d+(\.\d+)?L\s*)*$" title="Enter values like: 3.2L, 3.4L, 3.3L">

        <!-- Submit button -->
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?><p><?=$msg?></p><?php endif; ?>
</div>

<?=template_footer()?>
