<?php
$homeActive = $homeActive ?? false;
$masterActive = $masterActive ?? false;
$masterShow = $masterShow ?? false;
?>

<!-- VIEW -->
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include __DIR__ . '/head.php'; ?>
</head>
<body id="page-top">
    <div id="wrapper">
        <?php include __DIR__ . '/sidebar.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include __DIR__ . '/topbar.php'; ?>
                <div class="container-fluid">
                    <?= $content ?? '' ?>
                </div>
            </div>
            <?php include __DIR__ . '/footer.php'; ?>
        </div>
    </div>
    <?php include __DIR__ . '/scroll_to_top.php'; ?>
    <?php include __DIR__ . '/logout_modal.php'; ?>
    <?php include __DIR__ . '/script.php'; ?>
</body>
</html>