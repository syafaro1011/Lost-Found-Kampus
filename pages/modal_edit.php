<div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title"><i class="bi bi-pencil-square"></i> Edit Laporan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../api.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body p-4">
                    <input type="hidden" name="action" value="update_item">
                    <input type="hidden" name="id" id="edit-id">

                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul Laporan</label>
                        <input type="text" name="judul" id="edit-judul" class="form-control" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Kategori</label>
                            <select name="category_id" id="edit-category" class="form-select" required>
                                <?php foreach($categories as $cat): ?>
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

                    <div class="mb-3">
                        <label class="form-label fw-bold">Lokasi</label>
                        <input type="text" name="lokasi" id="edit-lokasi" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi</label>
                        <textarea name="deskripsi" id="edit-deskripsi" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Foto Barang</label>
                        <input type="file" name="foto" class="form-control" accept="image/*">
                        <small class="text-muted italic">*Kosongkan jika tidak ingin mengubah foto</small>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning px-4">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>