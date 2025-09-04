<?php
// app/user/index.php

$title        = humanize('user_list');
$masterActive = true;
$masterShow   = true;

// ambil data user + role
$stmt = $pdo->query("
    SELECT u.id, u.name, u.email, r.name AS role_name
    FROM user u
    JOIN role r ON r.id = u.role_id
    ORDER BY u.name ASC
");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Content
ob_start();
?>
<div class="container-fluid py-0 px-0">
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> <?= humanize('create') ?>
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table id="userTable" class="table table-bordered table-hover table-striped table-sm w-100 text-center">
                    <thead>
                        <tr>
                            <th><?= humanize('name') ?></th>
                            <th><?= humanize('role') ?></th>
                            <th><?= humanize('email') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $u): ?>
                        <tr>
                            <td><?= htmlspecialchars($u['name']) ?></td>
                            <td><?= htmlspecialchars($u['role_name']) ?></td>
                            <td><?= htmlspecialchars($u['email']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- DataTables Init -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        $('#userTable').DataTable({
            pageLength: 10,
            lengthChange: true,
            ordering: true,
            searching: true,
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

// Master Layout
require __DIR__ . '/../../template/master.php';
?>
