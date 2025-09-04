<?php
$title        = humanize('user_list');
$masterActive = true;
$masterShow   = true;

ob_start();
?>

<div class="container-fluid py-0 px-0">
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="<?= $baseUrl ?>?r=user/create" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> <?= humanize('create') ?>
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table id="userTable" class="table table-bordered table-hover table-striped table-sm w-100 text-center">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th><?= humanize('name') ?></th>
                            <th><?= humanize('email') ?></th>
                            <th><?= humanize('role') ?></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    $('#userTable').DataTable({
        ajax: {
            url: "http://localhost:8080/user", // API Go
            type: "GET",
            crossDomain: true,
            dataSrc: "", // JSON langsung array
        },
        columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'email' },
            { data: 'role_id' }
        ],
        pageLength: 10,
        lengthChange: true,
        searching: true,
        ordering: true,
        language: {
            search: "Search:",
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ users",
            paginate: {
                first: "First",
                last: "Last",
                next: "Next",
                previous: "Prev"
            }
        }
    });
});
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../../template/master.php';
?>
