<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();

// Get current page number from query string, default to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$records_per_page = 5;

// Fetch paginated list of visits joined with patient info
$stmt = $pdo->prepare('
    SELECT visits.*, patients.patient_first_name, patients.patient_last_name 
    FROM visits 
    JOIN patients ON visits.patient_id = patients.patient_id 
    ORDER BY visit_date DESC 
    LIMIT :current_page, :record_per_page
');

$stmt->bindValue(':current_page', ($page - 1) * $records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();

// Get result set and total count of visits
$visits = $stmt->fetchAll(PDO::FETCH_ASSOC);
$total_visits = $pdo->query('SELECT COUNT(*) FROM visits')->fetchColumn();
?>

<?=template_header('Read Visits')?>

<div class="content read">
	<h2>Visit Records</h2>
	<a href="visits_create.php" class="create-contact">Add Visit</a>
	<table>
    <thead>
    <tr>
        <td>Patient ID</td>
        <td>Patient Name</td>
        <td>Date</td>
        <td>Doctor</td>
        <td>FEV1 Values</td>
        <td></td>
    </tr>
</thead>
<tbody>
    <?php foreach ($visits as $visit): ?>
    <tr>
        <td><?=$visit['patient_id']?></td>
        <td><?=$visit['patient_first_name']?> <?=$visit['patient_last_name']?></td>
        <td><?=$visit['visit_date']?></td>
        <td><?=$visit['doctor_seen']?></td>
        <td><?=$visit['fev1_values']?></td>
        <td class="actions">
            <a href="visits_update.php?id=<?=$visit['id']?>" class="edit">Edit</a>
            <a href="visits_delete.php?id=<?=$visit['id']?>" class="trash">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</tbody>
    </table>

    <!-- Pagination Controls -->
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="visits_read.php?page=<?=$page-1?>">Prev</a>
        <?php endif; ?>
        <?php if ($page*$records_per_page < $total_visits): ?>
            <a href="visits_read.php?page=<?=$page+1?>">Next</a>
        <?php endif; ?>
    </div>
</div>

<?=template_footer()?>
