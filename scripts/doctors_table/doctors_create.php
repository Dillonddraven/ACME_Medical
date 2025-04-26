<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, //we must check if the POST variables exist if not we //can default them to blank
    $doctor_id = isset($_POST['doctor_id']) && !empty($_POST['doctor_id']) && $_POST['doctor_id'] != 'auto' ? $_POST['doctor_id'] : NULL;
    // Check if POST variable "name" exists, if not default //the value to blank, basically the same for all //variables
    $doctor_id= isset($_POST['doctor_id']) ? $_POST['doctor_id'] : '';
    $doctor_first_name = isset($_POST['doctor_first_name']) ? $_POST['doctor_first_name'] : '';
    $doctor_last_name = isset($_POST['doctor_last_name']) ? $_POST['doctor_last_name'] : '';
    $doctor_specialty = isset($_POST['doctor_specialty']) ? $_POST['doctor_specialty'] : '';
    $created = isset($_POST['created']) ? $_POST['created'] : date('Y-m-d H:i:s');
    // Insert new record into the doctors table
    $stmt = $pdo->prepare('INSERT INTO doctors VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([$doctor_id, $name, $email, $phone, $title, $created]);
    // Output message
    $msg = 'Created Successfully!';
}
?>
<?=template_header('Create')?>

<div class="content update">
<h2>Create Doctor</h2>
    <form action="doctors_create.php" method="post">
        <label for="doctor_id">Doctor ID</label>
            <input type="text" name="doctor_id" placeholder="Ex. 26" value="auto" id="doctor_id" readonly required>
        <label for="doctor_first_name">First Name</label>
            <input type="text" name="doctor_first_name" placeholder="Ex. Sally" id="doctor_first_name" pattern = "[A-Za-z']{2,}" required>
        <label for="doctor_last_name">Last Name</label>
            <input type="text" name="doctor_last_name" placeholder="Ex. Smith" id="doctor_last_name" pattern = "[A-Za-z'\-\s]{2,}" required>
        <label for="doctor_specialty">Specialty</label>
            <input type="text" name="doctor_specialty" placeholder="Ex. Pediatrics" id="doctor_specialty" pattern = "[A-Za-z'\-\s]{2,}" required>
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
