<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body>

    <div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0 shadow">

                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title"><i class="bi bi-pencil-square"></i> Edit Laporan</h5>

                    <!-- Button Close -->
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="../api/api.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body p-4">
                        <input type="hidden" name="action" value="update_item">
                        <input type="hidden" name="id" id="edit-id">

                        <!-- Judul Laporan -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul Laporan</label>
                            <input type="text" name="judul" id="edit-judul" class="form-control" required>
                        </div>

                        <!-- Kategori dan Status -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Kategori</label>
                                <select name="category_id" id="edit-category" class="form-select" required>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?= $cat['id']; ?>"><?= $cat['nama_kategori']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Status</label>
                                <select name="status" id="edit-status" class="form-select">
                                    <option value="lost">Lost (Hilang)</option>
                                    <option value="found">Found (Ditemukan)</option>
                                    <option value="finished">Finished (Selesai)</option>
                                </select>
                            </div>
                        </div>

                        <!-- Lokasi -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Lokasi</label>
                            <input type="text" name="lokasi" id="edit-lokasi" class="form-control" required>
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Deskripsi</label>
                            <textarea name="deskripsi" id="edit-deskripsi" class="form-control" rows="3"></textarea>
                        </div>

                        <!-- Foto Barang -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Foto Barang</label>
                            <input type="file" name="foto" class="form-control" accept="image/*">
                            <small class="text-muted italic">*Kosongkan jika tidak ingin mengubah foto</small>
                        </div>
                    </div>

                    <!-- Simpan dan Batal -->
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning px-4">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        //Handler Edit
        var modalEdit = document.getElementById('modalEdit')
        modalEdit.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget

            // Mengisi input di dalam modal menggunakan data dari tombol
            document.getElementById('edit-id').value = button.getAttribute('data-id')
            document.getElementById('edit-judul').value = button.getAttribute('data-judul')
            document.getElementById('edit-lokasi').value = button.getAttribute('data-lokasi')
            document.getElementById('edit-deskripsi').value = button.getAttribute('data-deskripsi')
            document.getElementById('edit-status').value = button.getAttribute('data-status')
            document.getElementById('edit-category').value = button.getAttribute('data-category')
        })

        // Confirm Delete
        function confirmDelete(id) {
            if (confirm('Apakah Anda yakin ingin menghapus laporan ini?')) {
                // Animate card before delete
                event.target.closest('.item-card').style.animation = 'fadeOut 0.3s ease';
                setTimeout(() => {
                    window.location.href = '../api.php?action=delete&id=' + id;
                }, 300);
            }
        }

        // Form validation
        const formEdit = document.getElementById('formEdit');
        if (formEdit) {
            formEdit.addEventListener('submit', function (e) {
                e.preventDefault();

                // Show loading state
                const submitBtn = this.querySelector('button[type="submit"]');
                submitBtn.innerHTML = '<i class="bi bi-arrow-clockwise"></i> Menyimpan...';
                submitBtn.disabled = true;

                // Simulate API call
                setTimeout(() => {
                    alert('Laporan berhasil diupdate!');
                    bootstrap.Modal.getInstance(modalEdit).hide();
                    submitBtn.innerHTML = 'Simpan Perubahan';
                    submitBtn.disabled = false;
                }, 1000);
            });
        }
    </script>
</body>

</html>