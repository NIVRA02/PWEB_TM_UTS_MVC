<?php require APPROOT . '/app/views/inc/header.php'; ?>

<div class="container mt-5">
    <a href="<?php echo URLROOT; ?>/pages/index" class="btn btn-light mb-3"><i class="fa fa-backward"></i> Kembali ke Dashboard</a>
    <h2 class="mb-3">Daftar Laporan Orang Hilang</h2>

    <?php if(!empty($data['laporan'])) : ?>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Nama Lengkap</th>
                    <th>Umur</th>
                    <th>Lokasi Hilang</th>
                    <th>Foto</th>
                    <th>Tanggal Lapor</th>
                    <th>Pelapor</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; foreach($data['laporan'] as $lpr) : ?>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <td><a href="<?php echo URLROOT; ?>/lapor/detail/<?php echo $lpr->id; ?>"><?php echo $lpr->nama_lengkap; ?></a></td>
                    <td><?php echo $lpr->umur; ?> tahun</td>
                    <td><?php echo $lpr->nama_kab . ', ' . $lpr->nama_prov; ?></td>
                    <td>
                        <img src="<?php echo URLROOT . '/uploads/' . $lpr->foto; ?>" alt="Foto <?php echo $lpr->nama_lengkap; ?>" width="100" class="img-thumbnail">
                    </td>
                    <td><?php echo date('d M Y, H:i', strtotime($lpr->tanggal_lapor)); ?></td>
                    <td><?php echo $lpr->pelapor; ?></td>
                    <td><span class="badge bg-warning text-dark"><?php echo $lpr->status_laporan; ?></span></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php else : ?>
        <p class="alert alert-info">Belum ada laporan yang dibuat.</p>
    <?php endif; ?>

</div>

<?php require APPROOT . '/app/views/inc/footer.php'; ?>
