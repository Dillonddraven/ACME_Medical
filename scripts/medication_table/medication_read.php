<?php

require_once('../../app_config.php');
require_once(APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');

$pdo= pdo_connect_mysql();
$page = (isset($_GET['page']) && is_numeric($_GET['page'])) ? (int)$_GET['page'] : 1;

$records_per_page = 5;

//Prep the SQL statemtent and grab the reocrds from the medications table (the limit will determine the page)
$stmt = $pdo->prepare('SELECT * FROM medications ORDER BY medication_id LIMIT : current_page, record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();

//Grab records so they can be displayed within our template 
$medications = $stmt->fecthALL(PDO::FETCH_ASSOC);
//Get the total number of medications, this is so we can determine whether there should be a next and previous button
$num_medications = $pdo->query('SELECT COUNT(*) FROM medications')->fetchColumn();
?>
<?=template_header('Read')?>

<div class="content read">
    <h2> Read Medications</h2>
    <a href="medications_create.php" class="create-contract">Create Medication</a>
    <table>
        <thead>
            <tr>
                <td>Medication ID</td>
                <td>Name</td>
                <td>Type</td>
                <td>Dosage</td>
                <td>Quantity</td>
                <td>Frequency</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach($medicaitons as $medication): ?>
                <tr>
                    <td><?=$medication['medication_id']?></td>
                    <td><?=$medication['medication_name']?></td>
                    <td><?=$medication['medication_type']?></td>
                    <td><?=$medication['medication_dosage']?></td>
                    <td><?=$medication['medication_quantity']?></td>
                    <td><?=$medication['medication_frequency']?></td>
                    <td class='actions'>
                        <a href="medications_update.php?medication_id=<?=$medication['medication_id']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                        <a href="medications_delete.php?medication_id=<?=$medication['medication_id']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
            </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
            <table>
                <div class='pagination'>
                    <?php if ($page > 1): ?>
                        <a href= "medications_read.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a> 
                    <?php // Remove the unnecessary endif statement
                    ?>
                    </div>
                    <a href="medications_read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
                    <?php endif; ?>
                    </div>
                    <a class="back" href="..\landingPage.php">Back</a>
                    </div>
                    <?=template_footer()?>