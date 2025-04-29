<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare('SELECT * FROM visits WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $visit = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$visit) {
        exit('Visit not found!');
    }

    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            $stmt = $pdo->prepare('DELETE FROM visits WHERE id = ?');
            $stmt->execute([$_GET['id']]);
            $msg = 'Visit Deleted!';
        } else {
            header('Location: visits_read.php');
            exit;
        }
    }
} else {
    exit('No ID specified!');
}
?>
<?=template_header('Delete Visit')?>

<div class="content delete">
	<h2>Delete Visit #<?=$visit['id']?></h2>
    <?php if ($msg): ?>
        <p><?=$msg?></p>
    <?php else: ?>
        <p>Are you sure you want to delete visit #<?=$visit['id']?>?</p>
        <div class="yesno">
            <a href="visits_delete.php?id=<?=$visit['id']?>&confirm=yes">Yes</a>
            <a href="visits_delete.php?id=<?=$visit['id']?>&confirm=no">No</a>
        </div>
    <?php endif; ?>
</div>
<?=template_footer()?>

