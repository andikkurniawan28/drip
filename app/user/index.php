<?php
$title = humanize('user_list');
$masterActive = true;
$masterShow = true;

// Content
ob_start();
?>
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
<?php
$content = ob_get_clean();

// Master
require __DIR__ . '/../../template/master.php';
