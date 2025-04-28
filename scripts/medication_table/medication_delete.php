<?php
require_once('../../app_config.php');
require_once(AAP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';

if (isset($_GET['medication_id'])){
    // Selct the reocrd that will be deleted

    $stmt = $pdo->prepare('SELECT * FROM medications WHERE medication_id = ?');
    $stmt->execute([$_GET['medication_id']]);
    $medication = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$medication){
        exit('That Medication does not exit with the ID you specified!');

    }
    //Ensure the user confirms before they proceed with deletion
    if(isset($_GET['confim'])){
        if ($_GET['confirm']== 'yes'){
            //User clicks "Yes", delete the record 
            $stmt = $pdo->prepare('DELETE FROM medications WHERE medication_id = ?');
            $stmt->execute([$_GET['medication_id']]);
            $msg = 'The medicaiton record has been deleted';
        }else{
            // The user slected the no button, do not delete record and redirect them back to the read page
            header('Location: medications_read.php');
            exit;

        }
        }
    }else {
        exit('No ID specified!');
    }

?>
<?=template_header('Delete')?>

<div class='content delete'>
    <h2>Delete Medication #<?=$medication['medication_id']?></h2>
    <?php if ($msg): ?>
        <p><?=$msg?></p>
        <?php else: ?> 
        <p>Are you sure you want to delete medication #<?=$medication['medication_id']?>?</p>
        <div class="yesno">
            <a href="medications_delete.php?medication_id=<?=medication['medication_id']?>&confirm=yes">Yes</a>
            <a href="medications_delete.php?medication_id=<?=medication['medication_id']?>&confirm=no">No</a>
        </div>
        <?php endif; ?>
        </div> 
<?=template_footer()?>
