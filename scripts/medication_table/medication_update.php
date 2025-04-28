<?php
require_once('../../app_config.php');
require_once(APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';
//Time zone 
date_default_timezone_set('American/Chicago');
//Chekc if the medication exist 
if (isset($_GET['medication_id'])){
    if(!empty($_POST)){
        //upates the medication record 
        $medication_id = isset($_POST['medication_id']) ? $_POST['medicaton_id'] : NULL;
        $medication_name = isset($POST['medication_name']) ? $_POST['medication_name'] : '';
        $medication_type = isset($POST['medication_type']) ? $_POST['medication_type'] : '';
        $medication_dosage = isset($POST['medication_dosage']) ? $_POST['medication_dosage'] : '';
        $medication_quantity = isset($POST['medication_quantity']) ? $_POST['medication_quantity'] : '';
        $medication_frequency = isset($POST['medication_frequency']) ? $_POST['medication_frequency'] : '';
        //Update the medical record 
        $stmt = $pdo->prepare('UPDATE medications SET medication_id = ?;');
        $stmt->execute([$medication_id, $medication_name, $medication_type, $medication_dosage, $medication_quantity, $medication_frequency, $_GET['medication_id']]);
        $msg = 'Update was Successful!';

    }
    //Grab medication from the medications table
    $stmt = $pdo->prepare('UPDATE medications SET medication_id = ?, medication_name = ?, medication_type = ? medication_dosage = ?, medication_quantity = ?, medication_frequency = ? WHERE medication_id = ?');
    $stmt->execute([$medication_id, $medication_name, $medication_type, $medication_dosage, $medication_frequency, $_GET['medication_id']]);
    $msg = 'Update was Successful!';
}
//Grab medication from the medications table
$stmt = $pdo->prepare('SELECT * FROM medications WHERE medication_id = ?');
$stmt->execute([$_GET['medication_id']]);
$medication = $stmt->fetch(PDO::FETCH_ASSOC);
if(!$medication){
    exit('Medication does not exist with the given ID!');
}else{
    exit('No ID specified!');
}
?>
<?=template_header('Update')?>
<div class="content update">
    <h2>Update Medication #<?=$medication['medication_id']?></h2>
    <form action="medications_update.php?medication_id=<?=$medication['medication_id']?>" method="post">
        <label for="medication_id">Medication ID</label>
            <input type="text" name="medication_id" placeholder="Ex. 1" value="<?=$medication['medication_id']?>" id="medication_id" readonly required>
        <label for="medication_name">Name</label>
            <input type="text" name="medication_name" placeholder="Ex. Bactrim" value="<?=$medication['medication_name']?>" id="medication_name" pattern = "[A-Za-z\-\s]{2,}" required>
        <label for="medication_type">Type</label>
            <input type="text" name="medication_type" placeholder="Ex. Antibiotic" value="<?=$medication['medication_type']?>" id="medication_type" pattern = "[A-Za-z\-\s]{2,}">
        <label for="medication_dosage">Dosage</label>
            <input type="text" name="medication_dosage" placeholder="Ex. 50mg" value="<?=$medication['medication_dosage']?>" id="medication_dosage" required>
        <label for="medication_quantity">Quantity</label>
            <input type="number" name="medication_quantity" value="<?=$medication['medication_quantity']?>" id="medication_quantity" min="1" pattern="[0-9]+" required>
        <label for="medication_frequency">Frequency</label>
            <select name = "medication_frequency" value="<?=$medication['medication_frequency']?>" id = "medication_frequency">
                <option value='<?php echo $medicaiton['frequency']?>' hidden selected><?php echo $medicaiton['frequency']?></option>
                <option value="" disabled>Please select an option</option>
                <option value = "QD">QD (Once Daily)</option>
                <option value = "BID">BID (Twice Daily)</option>
                <option value = "TID">TID (Three Times Daily)</option>
                <option value = "QHS">QHS (Once Every Night)</option>
            </select>
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>
<?=template_footer()?>