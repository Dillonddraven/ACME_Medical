<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';

// Check if visit ID is provided in URL
if (isset($_GET['id'])) {
    // If form submitted, update the visit record
    if (!empty($_POST)) {
        $patient_id = $_POST['patient_id'];
        $visit_date = $_POST['visit_date'];
        $doctor_seen = $_POST['doctor_seen'];
        $fev1_values = $_POST['fev1_values'];

        $stmt = $pdo->prepare('UPDATE visits SET patient_id = ?, visit_date = ?, doctor_seen = ?, fev1_values = ? WHERE id = ?');
        $stmt->execute([$patient_id, $visit_date, $doctor_seen, $fev1_values, $_GET['id']]);
        $msg = 'Visit Updated Successfully!';
    }

    // Retrieve visit to populate form
    $stmt = $pdo->prepare('SELECT * FROM visits WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $visit = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$visit) {
        exit('Visit not found!');
    }

    // Fetch all patients for dropdown
    $patients_stmt = $pdo->query('SELECT patient_id, patient_first_name, patient_last_name FROM patients');
    $patients = $patients_stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Update Visit')?>

<div class="content update">
	<h2>Update Visit #<?=$visit['id']?></h2>
    <form action="visits_update.php?id=<?=$visit['id']?>" method="post">
        <label for="patient_id">Select Patient</label>
        <select name="patient_id" id="patient_id" required>
            <?php foreach ($patients as $patient): ?>
                <option value="<?=$patient['patient_id']?>" <?=($patient['patient_id'] == $visit['patient_id']) ? 'selected' : ''?>>
                    <?=$patient['patient_first_name']?> <?=$patient['patient_last_name']?> (ID: <?=$patient['patient_id']?>)
                </option>
            <?php endforeach; ?>
        </select>

        <label for="visit_date">Visit Date</label>
        <input type="date" name="visit_date" value="<?=$visit['visit_date']?>" id="visit_date" required>

        <label for="doctor_seen">Doctor Seen</label>
        <input type="text" name="doctor_seen" value="<?=$visit['doctor_seen']?>" id="doctor_seen" required>

        <label for="fev1_values">FEV1 Values (comma-separated)</label>
        <input type="text" name="fev1_values" value="<?=$visit['fev1_values']?>" id="fev1_values" required>

        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?><p><?=$msg?></p><?php endif; ?>
</div>

<?=template_footer()?>
