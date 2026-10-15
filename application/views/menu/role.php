<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg">
            <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>'); ?>

            <?= $this->session->flashdata('message'); ?>


            <a href="" class="btn m-3" style="color: #fff; background-color: #075e42;"
                data-toggle="modal"
                data-target="#tambahRole">
                Tambah Role
            </a>

            <table class=" table table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Role</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($role as $r) : ?>
                        <tr>
                            <th scope='row'><?= $i; ?></th>
                            <td><?= $r['role']; ?></td>
                            <td>
                                <a href="<?= base_url('menu/roleaccess/' . $r['id']); ?>" class="badge badge-warning">access</a>
                                <a href="<?= base_url('menu/edit/' . $r['id']); ?>" class="badge badge-success">Edit</a>
                                <a href="<?= base_url('admin/delete/' . $r['id']); ?>" class="badge badge-danger" onclick="return confirm('Yakin ingin hapus menu ini?');">Hapus</a>
                            </td>

                        </tr>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>




        </div>
    </div>
    <!-- modal tambah menu-->
    <div class="modal fade" id="tambahRole" tabindex="-1" role="dialog" aria-labelledby="tambahRole" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahRole">Tambah Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('menu/role'); ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control"
                                id="role"
                                name="role"
                                placeholder="Nama Role">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>