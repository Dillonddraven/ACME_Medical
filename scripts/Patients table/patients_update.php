<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';
// Set timezone to America/Chicago
date_default_timezone_set('America/Chicago');
// Check if the contact id exists, for example //update.php?id=1 will get the contact with the id //of 1
if (isset($_GET['patient_id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, //but instead we update a record and not //insert
        $patient_id = isset($_POST['patient_id']) ? $_POST['patient_id'] : NULL;
        $patient_first_name = isset($_POST['patient_first_name']) ? $_POST['patient_first_name'] : '';
        $patient_last_name = isset($_POST['patient_last_name']) ? $_POST['patient_last_name'] : '';
        $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
        $birthdate = isset($_POST['birthdate']) ? $_POST['birthdate'] : '';
        $genetics = isset($_POST['genetics']) ? $_POST['genetics'] : '';
        $diabetes = isset($_POST['diabetes']) ? $_POST['diabetes'] : '';
        $other_conditions = isset($_POST['other_conditions']) ? $_POST['other_conditions'] : '';
        // Update the record
        $stmt = $pdo->prepare('UPDATE patients SET patient_id = ?, patient_first_name = ?, patient_last_name = ?, gender = ?, birthdate = ?, genetics = ?, diabetes = ?, other_conditions = ? WHERE patient_id = ?');
        $stmt->execute([$patient_id, $patient_first_name, $patient_last_name, $gender, $birthdate, $genetics, $diabetes, $other_conditions, $_GET['patient_id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM patients WHERE patient_id = ?');
    $stmt->execute([$_GET['patient_id']]);
    $patient = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$patient) {
        exit('Patient doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>
<?=template_header('Read')?>

<div class="content update">
	<h2>Update Patient #<?=$patient['patient_id']?></h2>
    <form action="patients_update.php?patient_id=<?=$patient['patient_id']?>" method="post">
        <label for="patient_id">Patient ID</label>
            <input type="text" name="patient_id" placeholder="Ex. 1" value="<?=$patient['patient_id']?>" id="patient_id" readonly required>
        <label for="patient_first_name">First Name</label>
            <input type="text" name="patient_first_name" placeholder="Ex. John" value="<?=$patient['patient_first_name']?>" id="patient_first_name" pattern = "[A-Za-z']{2,}" required>
        <label for="patient_last_name">Last Name</label>
            <input type="text" name="patient_last_name" placeholder="Ex. Doe" value="<?=$patient['patient_last_name']?>" id="patient_last_name" pattern = "[A-Za-z'\-\s]{2,}" required>
        <label for="gender">Gender</label>
            <select name = "gender" value="<?=$patient['gender']?>" id = "gender" required>
                <option value='<?php echo $patient['gender']?>' hidden selected><?php echo $patient['gender']?></option>
                <option value="" disabled>Please select an option</option>
                <option value = "Male">Male</option>
                <option value = "Female">Female</option>
                <option value = "Other">Other</option>
            </select>
        <label for="birthdate">Birthdate</label>
            <input type="date" name="birthdate" value="<?=$patient['birthdate']?>" id="birthdate" max="<?= date('Y-m-d'); ?>" required>
        <label for="genetics">Genetics</label>
            <input type="text" name="genetics" placeholder="Ex. Green Eyes" value="<?=$patient['genetics']?>" id="genetics">
        <label for="diabetes">Diabetes</label>
            <select name = "diabetes" value="<?=$patient['diabetes']?>" id = "diabetes" required>
                <option value='<?php echo $patient['diabetes']?>' hidden selected><?php echo $patient['diabetes']?></option>
                <option value="" disabled>Please select an option</option>
                <option value = "Yes">Yes</option>
                <option value = "No">No</option>
            </select>
        <label for="other_conditions">Other Conditions</label>
            <input type="text" name="other_conditions" placeholder="Ex. High Blood Pressure" value="<?=$patient['other_conditions']?>" id="other_conditions">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
