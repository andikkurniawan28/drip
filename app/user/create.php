<?php
$title        = humanize('create_user');
$masterActive = true;
$masterShow   = true;

ob_start();

$stmt = $pdo->query("SELECT id, name FROM role ORDER BY name ASC");
$roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container-fluid py-0 px-0">
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

    <div class="card shadow-sm">
        <div class="card-body">
            <form id="createuserForm">
                <div class="mb-3">
                    <label for="name" class="form-label"><?= humanize('name') ?></label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label"><?= humanize('email') ?></label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label"><?= humanize('password') ?></label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="role_id" class="form-label"><?= humanize('role') ?></label>
                    <select class="form-select select2" id="role_id" name="role_id" required>
                        <option value="">-- Pilih Role --</option>
                        <?php foreach ($roles as $role): ?>
                            <option value="<?= htmlspecialchars($role['id']) ?>">
                                <?= htmlspecialchars($role['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-circle"></i> <?= humanize('submit') ?>
                </button>
                <a href="<?= $baseUrl ?>?r=user/index" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> <?= humanize('cancel') ?>
                </a>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.getElementById('createuserForm');
        form.addEventListener('submit', async function(e) {
            e.preventDefault();

            const data = {
                name: form.name.value,
                email: form.email.value,
                role_id: parseInt(form.role_id.value)
            };

            try {
                const res = await fetch('http://localhost:8080/user', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                const result = await res.json();

                if (!res.ok) throw new Error(result.message || 'failed to create user');

                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'user created successfully!',
                    timer: 1200,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = "<?= $baseUrl ?>?r=user/index";
                });

            } catch (err) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: err.message
                });
            }
        });
    });
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../../template/master.php';
?>