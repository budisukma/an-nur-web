
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 text-gray-800"><?= $title; ?></h1>

    <h6 class="mb-5">Santri dapat pulang ketika sudah lunas semua pembayaran!</h6>

    <!-- Tombol untuk membuka modal -->
    <button type="button" class="btn mb-3" data-toggle="modal" data-target="#formTambahPembayar" style="color: #fff; background-color: #075e42;">
        Tambah Pembayar
    </button>
    <div class="row text-center justify-content-center">
        <?php
        // Simulasi data array
        $iuran = [
            ['judul' => 'iuran uang ifthor', 'gambar' => 'surat1.png'],
            ['judul' => 'iuran uang qurban', 'gambar' => 'surat2.png'],
            ['judul' => 'iuran uang acara', 'gambar' => 'surat3.png'],
        ];

        foreach ($iuran as $item): ?>
            <div class="col-md-4 mb-4">
                <div class="card border-0">
                    <img src="<?= base_url('assets/img/' . $item['gambar']) ?>" class="card-img-top img-fluid" alt="<?= $item['judul'] ?>">
                    <div class="card-body text-center">
                        <h6 class="card-title text-dark"><?= $item['judul'] ?></h6>
                        <a href="#" class="btn btn-success btn-sm px-4">Cetak</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>





</div>