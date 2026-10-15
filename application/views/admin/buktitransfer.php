<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 text-gray-800"><?= $title; ?></h1>

    <h6 class="mb-5">Menunggu proses Approve dari anda!</h6>

    <!-- Tombol untuk membuka modal -->
    <button type="button" class="btn mb-3" data-toggle="modal" data-target="#formTambahPembayar" style="color: #fff; background-color: #075e42;">
        Tambah Pembayar
    </button>

    <?php if ($this->session->flashdata('message')): ?>
        <?= $this->session->flashdata('message'); ?>
    <?php endif; ?>

    <!-- Tombol Aksi untuk baris yang dipilih -->
    <!-- Form Aksi Berdasarkan NISN dan Tahun -->
    <div class="row mb-3 align-items-center">
        <div class="col-md-2">
            <input type="text" id="nisnInput" class="form-control" placeholder="NISN">
        </div>
        <div class="col-md-2 justify-content-center">
            <select id="tahunInput" class="form-control">
                <option value="">Tahun</option>
                <?php for ($i = 2022; $i <= date('Y'); $i++): ?>
                    <option value="<?= $i; ?>"><?= $i; ?></option>
                <?php endfor; ?>
            </select>
        </div>
    </div>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Wali</th>
                <th>Jenis Pembayaran</th>
                <th>Image</th>
                <th>Approve</th>
                <th>Upload</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bukti_transfer as $p): ?>
                <tr data-nisn="<?= $p['id_wali']; ?>">
                    <td><?= $p['id']; ?></td>
                    <td><?= $p['id_wali']; ?></td>
                    <td><?= $p['jns_pembayaran']; ?></td>
                    <td><?= $p['image']; ?></td>
                    <td><?= $p['tgl_approve']; ?></td>
                    <td><?= $p['tgl_upload']; ?></td>
                    <td><?= $p['status']; ?></td>
                    <td>
                        <a href="<?= base_url('admin/edit/' . $p['id_wali']); ?>" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                        <a href="<?= base_url('admin/hapus/' . $p['id']); ?>"
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('Yakin ingin menghapus data ini?');">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                        <a href="<?= base_url('admin/print/' . $p['id_wali']); ?>" class="btn btn-secondary btn-sm"><i class="fas fa-print"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>


        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>NISN</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th>Jumlah</th>
                    <th>Sisa</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pembayaran as $p): ?>
                    <tr data-nisn="<?= $p['nisn']; ?>" data-tahun="<?= $p['tahun']; ?>">
                        <td><?= $p['nisn']; ?></td>
                        <td><?= $p['nama']; ?></td>
                        <td><?= $p['kelas']; ?></td>
                        <td><?= $p['juli']; ?></td>
                        <td><?= $p['agustus']; ?></td>
                        <td><?= $p['september']; ?></td>
                        <td><?= $p['oktober']; ?></td>
                        <td>
                            <a href="<?= base_url('admin/edit/' . $p['nisn']); ?>" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                            <a href="<?= base_url('admin/hapus/' . $p['id']); ?>"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Yakin ingin menghapus data ini?');">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                            <a href="<?= base_url('admin/print/' . $p['nisn'] . '/' . $p['tahun']); ?>" class="btn btn-secondary btn-sm"><i class="fas fa-print"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>


        </table>
        <!-- Form Tambah Data Santri -->
        <!-- Modal -->
        <div class="modal fade" id="formTambahPembayar" tabindex="-1" role="dialog" aria-labelledby="formTambahPembayarLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formTambahPembayarLabel">Tambah Pembayar</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Form Tambah Data Santri -->
                        <form action="<?= base_url('admin/tambah'); ?>" method="post">
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" name="nama" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="kelas">Kelas</label>
                                <input type="text" name="kelas" class="form-control" required>
                            </div>

                            <!-- Input tanggal per bulan -->
                            <?php
                            $bulan = ['juli', 'agustus', 'september', 'oktober', 'november', 'desember'];
                            foreach ($bulan as $b): ?>
                                <div class="form-group">
                                    <label for="tgl_<?= $b; ?>">Tanggal <?= ucfirst($b); ?></label>
                                    <input type="date" name="tgl_<?= $b; ?>" class="form-control">
                                </div>
                            <?php endforeach; ?>

                            <button type="submit" class="btn btn" style="color: #fff; background-color: #075e42;">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Modal -->

</div>

<script>
    document.querySelectorAll('.selectable-row').forEach(row => {
        row.addEventListener('click', function() {
            const id = this.dataset.id;
            document.getElementById('selectedId').value = id;
            document.getElementById('actionButtons').style.display = 'block';
        });
    });

    document.getElementById('btnEdit').addEventListener('click', function() {
        const id = document.getElementById('selectedId').value;
        window.location.href = "<?= base_url('admin/edit/'); ?>" + id;
    });

    document.getElementById('btnDelete').addEventListener('click', function() {
        const id = document.getElementById('selectedId').value;
        if (confirm('Yakin ingin menghapus data ini?')) {
            window.location.href = "<?= base_url('admin/hapus/'); ?>" + id;
        }
    });

    document.getElementById('btnPrint').addEventListener('click', function() {
        const id = document.getElementById('selectedId').value;
        window.open("<?= base_url('admin/cetak/'); ?>" + id, '_blank');
    });
</script>

<script>
    // fungsi filter untuk tabel / cara mencari data
    // ambil elemen
    const nisnInput = document.getElementById('nisnInput');
    const tahunInput = document.getElementById('tahunInput');

    [nisnInput, tahunInput].forEach(el =>
        el.addEventListener('input', filterTable)
    );

    function filterTable() {
        const nisnVal = nisnInput.value.trim().toLowerCase();
        const tahunVal = tahunInput.value;

        document.querySelectorAll('table tbody tr').forEach(row => {
            // baca data-attribute
            const rowNisn = row.dataset.nisn.toLowerCase();
            const rowTahun = row.dataset.tahun;

            // cek kecocokan
            const matchNisn = !nisnVal || rowNisn.includes(nisnVal);
            const matchTahun = !tahunVal || rowTahun === tahunVal;

            // tampilkan atau sembunyikan
            row.style.display = (matchNisn && matchTahun) ? '' : 'none';
        });
    }
</script>