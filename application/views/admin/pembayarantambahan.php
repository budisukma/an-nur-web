<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 text-gray-800"><?= $title; ?></h1>

    <h6 class="mb-5">Pembayaran tambahan(Iuran) Qurban - Ifthar - Daf'ul dll</h6>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('success'); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>


    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('error'); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>


    <!-- Tombol untuk membuka modal -->
    <button type="button"
        id="formTambahPembayarBtn"
        class="btn mb-3 mr-2"
        data-toggle="modal"
        data-target="#formTambahPembayar"
        style="color: #fff; background-color: #075e42;">
        Tambah Pembayar
    </button>

    <button type="button"
        class="btn mb-3"
        id="formTambahIuran"
        data-toggle="modal"
        data-target="#formTambahIuran"
        style="color: #fff; background-color: #075e42;">
        Tambah Iuran
    </button>


    <?php if ($this->session->flashdata('message')): ?>
        <?= $this->session->flashdata('message'); ?>
    <?php endif; ?>

    <!-- Tombol Aksi untuk baris yang dipilih -->
    <!-- Form Aksi Berdasarkan NISN dan Tahun -->
    <form method="get" action="<?= base_url('admin/pembayarantambahan'); ?>">
        <div class="row mb-3 align-items-center">
            <div class="col-md-3">
                <input type="text" id="nisnInput" name="nisn" class="form-control" placeholder="NISN" value="<?= isset($_GET['nisn']) ? $_GET['nisn'] : '' ?>">
            </div>

            <div class="col-md-3">
                <select id="tahunInput" name="tahun" class="form-control" onchange="this.form.submit()">
                    <option value="">Tahun</option>
                    <?php for ($i = 2019; $i <= date('Y'); $i++): ?>
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
                <th>Daf'ul</th>
                <th>Qurban</th>
                <th>Ifthar</th>
                <th>Tahun Ajaran</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pembayaran as $p): ?>
                <tr data-nisn="<?= $p['nisn']; ?>" data-tahun="<?= date('Y'); ?>">
                    <td><?= $p['nisn']; ?></td>
                    <td><?= $p['nama']; ?></td>
                    <td><?= $p['kelas']; ?></td>
                    <td><?= $p['daful']; ?></td>
                    <td><?= $p['qurban']; ?></td>
                    <td><?= $p['ifthar']; ?></td>
                    <td><?= $p['tahun']; ?></td>
                    <td>
                        <a href="#"
                            class="btn btn-primary btn-sm btn-edit"
                            data-id="<?= $p['id']; ?>"
                            data-nisn="<?= $p['nisn'] ?>"
                            data-daful="<?= $p['daful'] ?>"
                            data-qurban="<?= $p['qurban'] ?>"
                            data-ifthar="<?= $p['ifthar'] ?>"
                            data-tahun="<?= $p['tahun'] ?>"
                            data-toggle="modal"
                            data-target="#modalEditPembayaran">
                            <i class="fas fa-edit"></i>
                        </a>




                        <a href="<?= base_url('admin/hapusPembayarTambahan/' . $p['id']); ?>"
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('Yakin ingin menghapus data ini?');">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                        <a href="<?= base_url('admin/print/' . $p['nisn'] . '/' . date('Y')); ?>" class="btn btn-secondary btn-sm"><i class="fas fa-print"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>


    </table>
    <!-- Form Tambah Pembayar -->
    <!-- Modal -->
    <div class="modal fade" id="formTambahPembayar" tabindex="-1" role="dialog" aria-labelledby="formTambahPembayar" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formTambahPembayar">Tambah Pembayar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form Tambah Data Santri -->
                    <form action="<?= base_url('admin/tambahPembayarTambahan'); ?>" method="post">
                        <div class="form-group">
                            <label for="nisn">Nisn</label>
                            <input type="text" name="nisn" class="form-control" placeholder="Nisn Santri" required>
                        </div>

                        <!-- Input  -->
                        <!-- Add these fields to the modal form -->
                        <div class="form-group">
                            <label for="daful">Daful</label>
                            <input type="date" class="form-control" name="daful" id="daful">
                        </div>

                        <div class="form-group">
                            <label for="qurban">Qurban</label>
                            <input type="date" class="form-control" name="qurban" id="qurban">
                        </div>

                        <div class="form-group">
                            <label for="ifthar">Ifthar</label>
                            <input type="date" class="form-control" name="ifthar" id="ifthar">
                        </div>


                        <div class="form-group mb-3">
                            <label for="tahun">Tahun Ajaran</label>
                            <input type="year" class="form-control" name="tahun" id="tahun" placeholder="2025" required>
                        </div>

                        <button type="submit" class="btn btn" style="color: #fff; background-color: #075e42;">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="formTambahIuran" tabindex="-1" role="dialog" aria-labelledby="formTambahIuran" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formTambahIuran">Tambah Iuran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form Tambah Iuran -->
                    <form action="<?= base_url('admin/tambahIuran'); ?>" method="post">
                        <div class="form-group">
                            <label for=iuran">Iuran</label>
                            <input type="text" id="iuran" name="iuran" placeholder="Nama Iuran" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn" style="color: #fff; background-color: #075e42;">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->
    <!-- Modal Edit Pembayaran -->
    <div class="modal fade" id="modalEditPembayaran" tabindex="-1" role="dialog" aria-labelledby="modalEditPembayaran" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="<?= base_url('admin/editTambahan') ?>" method="post">

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Pembayaran</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" id="editId" name="id">
                        <input type="hidden" id="editNisn" name="nisn">

                        <div class="form-group">
                            <label for="editNisnView">NISN</label>
                            <input type="text" id="editNisnView" class="form-control" disabled>
                        </div>

                        <div class="form-group">
                            <label for="editDaful">Daftar Ulang</label>
                            <input type="date" class="form-control" name="daful" id="editDaful">
                        </div>

                        <div class="form-group">
                            <label for="editIfthar">Ifthar</label>
                            <input type="date" class="form-control" name="ifthar" id="editIfthar">
                        </div>

                        <div class="form-group">
                            <label for="editQurban">Qurban</label>
                            <input type="date" class="form-control" name="qurban" id="editQurban">
                        </div>

                        <div class="form-group">
                            <label for="editTahun">Tahun Ajaran</label>
                            <input type="number" class="form-control" name="tahun" id="editTahun">
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

</div>
<script>
    $(document).on('click', '.btn-edit', function() {
        $('#editId').val($(this).data('id'));
        $('#editNisn').val($(this).data('nisn'));
        $('#editNisnView').val($(this).data('nisn'));
        $('#editDaful').val($(this).data('daful'));
        $('#editQurban').val($(this).data('qurban'));
        $('#editIfthar').val($(this).data('ifthar'));
        $('#editTahun').val($(this).data('tahun'));
    });
</script>