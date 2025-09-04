<!-- jQuery (gunakan bawaan SB Admin 2 saja) -->
<script src="<?= $baseUrl ?>/lib/startbootstrap-sb-admin-2-gh-pages/vendor/jquery/jquery.min.js"></script>
<script src="<?= $baseUrl ?>/lib/startbootstrap-sb-admin-2-gh-pages/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?= $baseUrl ?>/lib/startbootstrap-sb-admin-2-gh-pages/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?= $baseUrl ?>/lib/startbootstrap-sb-admin-2-gh-pages/js/sb-admin-2.min.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<!-- Sweet Alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function () {
    // Inisialisasi DataTables
    $('.datatable').DataTable({
        responsive: true,
        autoWidth: false,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search..."
        }
    });

    // Inisialisasi Select2
    $('.select2').select2({
        theme: 'bootstrap4',
        placeholder: '-- Pilih --',
        allowClear: true,
        width: '100%'
    });
});
</script>
