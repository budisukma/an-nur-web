<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 text-gray-800"><?= $title; ?></h1>

    <h6 class="mb-5">Daftar pembayaran uang makan dan maintenance(Perawatan)</h6>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('error'); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>


    <?php if ($this->session->flashdata('message')): ?>
        <div class="alert alert-success">
            <?php echo $this->session->flashdata('message'); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>




    <!-- Tombol untuk membuka modal -->
    <button type="button" class="btn mb-3" data-toggle="modal" data-target="#formTambahPembayar" style="color: #fff; background-color: #075e42;">
        Tambah Pembayar
    </button>

    <!-- Tombol Aksi untuk baris yang dipilih -->
    <!-- Form Aksi Berdasarkan NISN dan Tahun -->
    <form method="get" action="<?= base_url('admin/pembayaransyariah'); ?>">
        <div class="row mb-3 align-items-center">
            <div class="col-md-3">
                <input type="text" id="nisnInput" name="nisn" class="form-control" placeholder="NISN" value="<?= isset($_GET['nisn']) ? $_GET['nisn'] : '' ?>">
            </div>

            <div class="col-md-3">
                <select id="tahunInput" name="tahun" class="form-control" onchange="this.form.submit()">
                    <option value="">Tahun</option>
                    <?php for ($i = 2018; $i <= date('Y'); $i++): ?>
                        <option value="<?= $i; ?>" <?= isset($_GET['tahun']) && $_GET['tahun'] == $i ? 'selected' : ''; ?>>
                            <?= $i; ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>
        </div>
    </form>


    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>NISN</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>SMT 1</th>
                <th>SMT 2</th>
                <th>SMT 3</th>
                <th>SMT 4</th>
                <th>SMT 5</th>
                <th>SMT 6</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pembayaran as $p): ?>
                <tr data-nisn="<?= $p['nisn']; ?>" data-tahun="<?= $p['tahun']; ?>">
                    <td><?= $p['nisn']; ?></td>
                    <td><?= $p['nama']; ?></td>
                    <td><?= $p['kelas']; ?></td>
                    <td><?= $p['smt1']; ?></td>
                    <td><?= $p['smt2']; ?></td>
                    <td><?= $p['smt3']; ?></td>
                    <td><?= $p['smt4']; ?></td>
                    <td><?= $p['smt5']; ?></td>
                    <td><?= $p['smt6']; ?></td>
                    <td>
                        <a href="#"
                            class="btn btn-primary btn-sm btn-edit"
                            data-id="<?= $p['id']; ?>"
                            data-nisn="<?= $p['nisn']; ?>"
                            data-smt1="<?= $p['smt1']; ?>"
                            data-smt2="<?= $p['smt2']; ?>"
                            data-smt3="<?= $p['smt3']; ?>"
                            data-smt4="<?= $p['smt4']; ?>"
                            data-smt5="<?= $p['smt5']; ?>"
                            data-smt6="<?= $p['smt6']; ?>"
                            data-tahun="<?= $p['tahun']; ?>"
                            data-toggle="modal"
                            data-target="#modalEditPembayaran">
                            <i class="fas fa-edit"></i>
                        </a>

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
                            <label for="nisn">Nisn</label>
                            <input type="text" name="nisn" class="form-control" required>
                        </div>

                        <!-- Input tanggal per bulan -->
                        <div class="form-group mb-3">
                            <label for="smt1">SMT 1</label>
                            <input type="date" class="form-control" name="smt1" id="smt1">
                        </div>
                        <div class="form-group mb-3">
                            <label for="smt2">SMT 2</label>
                            <input type="date" class="form-control" name="smt2" id="smt2">
                        </div>
                        <div class="form-group mb-3">
                            <label for="smt3">SMT 3</label>
                            <input type="date" class="form-control" name="smt3" id="smt3">
                        </div>
                        <div class="form-group mb-3">
                            <label for="smt4">SMT 4</label>
                            <input type="date" class="form-control" name="smt4" id="smt4">
                        </div>
                        <div class="form-group mb-3">
                            <label for="smt5">SMT 5</label>
                            <input type="date" class="form-control" name="smt5" id="smt5">
                        </div>
                        <div class="form-group mb-3">
                            <label for="smt6">SMT 6</label>
                            <input type="date" class="form-control" name="smt6" id="smt6">
                        </div>
                        <div class="form-group mb-3">
                            <label for="tahun">Tahun Ajaran</label>
                            <input type="year" class="form-control" name="tahun" id="tahun">
                        </div>



                        <button type="submit" class="btn btn" style="color: #fff; background-color: #075e42;">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->
    <!-- Modal Edit Pembayaran -->
    <div class="modal fade" id="modalEditPembayaran" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="<?= base_url('admin/edit') ?>" method="post">

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Pembayaran</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" name="id" id="editId">
                        <input type="hidden" name="nisn" id="editNisn">

                        <div class="form-group">
                            <label for="editNisnView">NISN</label>
                            <input type="text" id="editNisnView" class="form-control" disabled>
                        </div>

                        <?php for ($i = 1; $i <= 6; $i++): ?>
                            <div class="form-group">
                                <label for="editSmt<?= $i ?>">SMT <?= $i ?></label>
                                <input type="date" class="form-control" name="smt<?= $i ?>" id="editSmt<?= $i ?>">
                            </div>
                        <?php endfor; ?>

                        <div class="form-group">
                            <label for="editTahun">Tahun Ajaran</label>
                            <input type="text" class="form-control" name="tahun" id="editTahun">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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

<script>
    $(document).on('click', '.btn-edit', function() {
        $('#editId').val($(this).data('id')); // penting!
        $('#editNisn').val($(this).data('nisn'));
        $('#editNisnView').val($(this).data('nisn'));
        $('#editSmt1').val($(this).data('smt1'));
        $('#editSmt2').val($(this).data('smt2'));
        $('#editSmt3').val($(this).data('smt3'));
        $('#editSmt4').val($(this).data('smt4'));
        $('#editSmt5').val($(this).data('smt5'));
        $('#editSmt6').val($(this).data('smt6'));
        $('#editTahun').val($(this).data('tahun'));
    });
</script>