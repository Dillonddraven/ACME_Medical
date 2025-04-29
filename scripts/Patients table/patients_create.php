<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';

// Fetch all patients for the dropdown
$stmt = $pdo->query('SELECT patient_id, patient_first_name, patient_last_name FROM patients ORDER BY patient_last_name ASC');
$patients = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Set timezone
date_default_timezone_set('America/Chicago');

// Check if POST data exists
if (!empty($_POST)) {
    $patient_id = $_POST['patient_id'] ?? null;
    $vest = $_POST['vest'] ?? 'No';
    $acapella = $_POST['acapella'] ?? 'No';
    $pulmozyme = $_POST['pulmozyme'] ?? 'No';
    $pulmozyme_quantity = $_POST['pulmozyme_quantity'] ?? null;
    $pulmozyme_date = $_POST['pulmozyme_date'] ?? null;
    $inhaled_tobi = $_POST['inhaled_tobi'] ?? 'No';
    $inhaled_colistin = $_POST['inhaled_colistin'] ?? 'No';
    $hypertonic_saline = $_POST['hypertonic_saline'] ?? 'No';
    $azithromycin = $_POST['azithromycin'] ?? 'No';
    $clarithromycin = $_POST['clarithromycin'] ?? 'No';
    $inhaled_gentamicin = $_POST['inhaled_gentamicin'] ?? 'No';
    $enzymes = $_POST['enzymes'] ?? 'No';
    $enzyme_type_dosage = $_POST['enzyme_type_dosage'] ?? null;

    $stmt = $pdo->prepare('INSERT INTO prescriptions (patient_id, vest, acapella, pulmozyme, pulmozyme_quantity, pulmozyme_date, inhaled_tobi, inhaled_colistin, hypertonic_saline, azithromycin, clarithromycin, inhaled_gentamicin, enzymes, enzyme_type_dosage) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    
    $stmt->execute([$patient_id, $vest, $acapella, $pulmozyme, $pulmozyme_quantity, $pulmozyme_date, $inhaled_tobi, $inhaled_colistin, $hypertonic_saline, $azithromycin, $clarithromycin, $inhaled_gentamicin, $enzymes, $enzyme_type_dosage]);

    $msg = 'Prescription created successfully!';
}
?>

<?=template_header('Create Prescription')?>

<div class="content update">
    <h2>Create Prescription</h2>
    <form action="prescriptions_create.php" method="post">

        <label for="patient_id">Select Patient</label>
        <select name="patient_id" id="patient_id" required>
            <option value="" disabled selected>Select a patient</option>
            <?php foreach ($patients as $patient): ?>
                <option value="<?=htmlspecialchars($patient['patient_id'])?>">
                    <?=htmlspecialchars($patient['patient_last_name'] . ", " . $patient['patient_first_name'])?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="vest">Vest</label>
        <select name="vest" id="vest" required>
            <option value="Yes">Yes</option>
            <option value="No">No</option>
        </select>

        <label for="acapella">Acapella</label>
        <select name="acapella" id="acapella" required>
            <option value="Yes">Yes</option>
            <option value="No">No</option>
        </select>

        <label for="pulmozyme">Pulmozyme</label>
        <select name="pulmozyme" id="pulmozyme" required>
            <option value="Yes">Yes</option>
            <option value="No">No</option>
        </select>

        <label for="pulmozyme_quantity">Pulmozyme Quantity</label>
        <input type="text" name="pulmozyme_quantity" id="pulmozyme_quantity" placeholder="Ex. 3 months">

        <label for="pulmozyme_date">Pulmozyme Date Received</label>
        <input type="date" name="pulmozyme_date" id="pulmozyme_date">

        <label for="inhaled_tobi">Inhaled Tobi</label>
        <select name="inhaled_tobi" id="inhaled_tobi" required>
            <option value="Yes">Yes</option>
            <option value="No">No</option>
        </select>

        <label for="inhaled_colistin">Inhaled Colistin</label>
        <select name="inhaled_colistin" id="inhaled_colistin" required>
            <option value="Yes">Yes</option>
            <option value="No">No</option>
        </select>

        <label for="hypertonic_saline">Hypertonic Saline</label>
        <select name="hypertonic_saline" id="hypertonic_saline" required>
            <option value="Yes 3%">Yes 3%</option>
            <option value="Yes 7%">Yes 7%</option>
            <option value="No">No</option>
        </select>

        <label for="azithromycin">Azithromycin</label>
        <select name="azithromycin" id="azithromycin" required>
            <option value="Yes">Yes</option>
            <option value="No">No</option>
        </select>

        <label for="clarithromycin">Clarithromycin</label>
        <select name="clarithromycin" id="clarithromycin" required>
            <option value="Yes">Yes</option>
            <option value="No">No</option>
        </select>

        <label for="inhaled_gentamicin">Inhaled Gentamicin</label>
        <select name="inhaled_gentamicin" id="inhaled_gentamicin" required>
            <option value="Yes">Yes</option>
            <option value="No">No</option>
        </select>

        <label for="enzymes">Enzymes</label>
        <select name="enzymes" id="enzymes" required>
            <option value="Yes">Yes</option>
            <option value="No">No</option>
        </select>

        <label for="enzyme_type_dosage">Enzyme Type/Dosage</label>
        <input type="text" name="enzyme_type_dosage" id="enzyme_type_dosage" placeholder="Ex. Creon 2400">

        <input type="submit" value="Create Prescription">

    </form>

    <?php if ($msg): ?>
        <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
