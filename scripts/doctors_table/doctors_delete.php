<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';
// Check that the doctor ID exists
if (isset($_GET['doctor_id'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM doctors WHERE doctor_id = ?');
    $stmt->execute([$_GET['doctor_id']]);
    $doctor = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$doctor) {
        exit('Doctor doesn\'t exist with that ID!');
    }
    // Make sure the user confirms before deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM doctors WHERE doctor_id = ?');
            $stmt->execute([$_GET['doctor_id']]);
            $msg = 'You have deleted the doctor!';
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: doctors_read.php');
            exit;
        }
    }
} else {
    exit('No ID specified!');
}
?>
<?=template_header('Delete')?>

<div class="content delete">
	<h2>Delete Doctor #<?=$doctor['doctor_id']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Are you sure you want to delete doctor #<?=$doctor['doctor_id']?>?</p>
    <div class="yesno">
        <a href="doctors_delete.php?id=<?=$doctor['doctor_id']?>&confirm=yes">Yes</a>
        <a href="doctors_delete.php?id=<?=$doctor['doctor_id']?>&confirm=no">No</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>
