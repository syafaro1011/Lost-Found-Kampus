<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body>

    <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="bi bi-pencil-square"></i> Buat Laporan Baru
                    </h5>

                    <!-- Button Close -->
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="..//api/api.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body p-4">
                        <input type="hidden" name="action" value="insert_item">

                        <!-- Judul Laporan -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul Laporan</label>
                            <input type="text" name="judul" class="form-control"
                                placeholder="Contoh: Ditemukan Kunci Motor" required>
                        </div>

                        <!-- Kategori -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Kategori</label>
                                <select name="category_id" class="form-select" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <?php
                                    $stmt_cat = $pdo->query("SELECT * FROM categories");
                                    $categories = $stmt_cat->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($categories as $cat):
                                        ?>
                                        <option value="<?= $cat['id']; ?>"><?= $cat['nama_kategori']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Status</label>
                                <select name="status" class="form-select" required>
                                    <option value="lost">Saya Kehilangan (Lost)</option>
                                    <option value="found">Saya Menemukan (Found)</option>
                                </select>
                            </div>
                        </div>

                        <!-- Lokasi Kejadian -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Lokasi Kejadian</label>
                            <input type="text" name="lokasi" class="form-control" placeholder="Contoh: Di depan mebir"
                                required>
                        </div>

                        <!-- Deskripsi Barang -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Deskripsi Barang</label>
                            <textarea name="deskripsi" class="form-control" rows="3"
                                placeholder="Jelaskan ciri-ciri barang..." required></textarea>
                        </div>

                        <!-- Foto Barang -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Foto Barang</label>
                            <input type="file" name="foto" class="form-control" accept="image/*" required>
                        </div>
                    </div>

                    <!-- Simpan dan Batal -->
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary px-4">Simpan Laporan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>