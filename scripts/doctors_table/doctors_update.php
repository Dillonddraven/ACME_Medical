<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the doctor id exists, for example //update.php?id=1 will get the doctor with the id //of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, //but instead we update a record and not //insert
        $doctor_id = isset($_POST['doctor_id']) ? $_POST['doctor_id'] : NULL;
        $doctor_first_name = isset($_POST['doctor_first_name']) ? $_POST['doctor_first_name'] : '';
        $doctor_last_name = isset($_POST['doctor_last_name']) ? $_POST['doctor_last_name'] : '';
        $doctor_specialty = isset($_POST['doctor_specialty']) ? $_POST['doctor_specialty'] : '';
        // Update the record
        $stmt = $pdo->prepare('UPDATE doctors SET id = ?, name = ?, email = ?, phone = ?, title = ?, created = ? WHERE id = ?');
        $stmt->execute([$doctor_id, $doctor_first_name, $doctor_last_name, $doctor_specialty, $_GET['doctor_id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the doctors from the doctors table
    $stmt = $pdo->prepare('SELECT * FROM doctors WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $doctor = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$doctor) {
        exit('Doctor doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>
<?=template_header('Read')?>

<div class="content update">
    <h2>Update Doctor #<?=$doctor['doctor_id']?></h2>
    <form action="doctors_update.php?doctor_id=<?=$doctor['doctor_id']?>" method="post">
        <label for="doctor_id">Doctor ID</label>
            <input type="text" name="doctor_id" placeholder="Ex. 1" value="<?=$doctor['doctor_id']?>" id="doctor_id" readonly required>
        <label for="doctor_first_name"> First Name</label>
            <input type="text" name="doctor_first_name" placeholder="Ex. John" value="<?=$doctor['doctor_first_name']?>" id="doctor_first_name" pattern = "[A-Za-z']{2,}" required>
        <label for="doctor_last_name">Last Name</label>
            <input type="text" name="doctor_last_name" placeholder="Ex. Doe" value="<?=$doctor['doctor_last_name']?>" id="doctor_last_name" pattern = "[A-Za-z'\-\s]{2,}" required>
        <label for="doctor_specialty">Specialty</label>
            <input type="text" name="doctor_specialty" placeholder="Ex. Neurology" value="<?=$doctor['doctor_specialty']?>" id="doctor_specialty" pattern = "[A-Za-z'\-\s]{2,}" required>
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
