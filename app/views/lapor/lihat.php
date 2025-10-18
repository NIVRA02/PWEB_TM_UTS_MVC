<?php require APPROOT . '/app/views/inc/header.php'; ?>

<div class="card card-body mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Daftar Laporan Orang Hilang</h2>
        <a href="<?php echo URLROOT; ?>/pages/index" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Kembali ke Dashboard</a>
    </div>
    
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama Lengkap</th>
                    <th scope="col">Umur</th>
                    <th scope="col">Lokasi Hilang</th>
                    <th scope="col">Foto</th>
                    <th scope="col">Tanggal Lapor</th>
                    <th scope="col">Pelapor</th>
                    <th scope="col" style="min-width: 200px;">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($data['laporan'])): ?>
                    <?php $count = 1; ?>
                    <?php foreach($data['laporan'] as $lpr) : ?>
                        <tr>
                            <th scope="row"><?php echo $count++; ?></th>
                            <td><a href="<?php echo URLROOT; ?>/lapor/detail/<?php echo $lpr->id; ?>"><?php echo $lpr->nama_lengkap; ?></a></td>
                            <td><?php echo $lpr->umur; ?> tahun</td>
                            <td><?php echo $lpr->nama_kab; ?>, <?php echo $lpr->nama_prov; ?></td>
                            <td>
                                <img src="<?php echo URLROOT . '/uploads/' . $lpr->foto; ?>" alt="Foto <?php echo $lpr->nama_lengkap; ?>">
                            </td>
                            <td><?php echo date('d M Y, H:i', strtotime($lpr->tanggal_lapor)); ?></td>
                            <td><?php echo $lpr->pelapor; ?></td>
                            <td>
                                <?php
                                    $statusClass = '';
                                    if ($lpr->status_laporan == 'Ditemukan Selamat') {
                                        $statusClass = 'status-ditemukan';
                                    } elseif ($lpr->status_laporan == 'Dalam Pencarian') {
                                        $statusClass = 'status-pencarian';
                                    }
                                ?>

                                <!-- Cek apakah user adalah pemilik laporan -->
                                <?php if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $lpr->user_id): ?>
                                    <!-- Jika PEMILIK, tampilkan form dropdown -->
                                    <form action="<?php echo URLROOT; ?>/lapor/ubahStatus/<?php echo $lpr->id; ?>" method="post" class="status-form">
                                        <select name="status" class="form-select status-select <?php echo $statusClass; ?>" onchange="this.form.submit()">
                                            <option value="Dalam Pencarian" <?php echo ($lpr->status_laporan == 'Dalam Pencarian') ? 'selected' : ''; ?>>Dalam Pencarian</option>
                                            <option value="Ditemukan Selamat" <?php echo ($lpr->status_laporan == 'Ditemukan Selamat') ? 'selected' : ''; ?>>Ditemukan Selamat</option>
                                            <option value="Ditemukan Meninggal" <?php echo ($lpr->status_laporan == 'Ditemukan Meninggal') ? 'selected' : ''; ?>>Ditemukan Meninggal</option>
                                        </select>
                                    </form>
                                <?php else: ?>
                                    <!-- Jika BUKAN PEMILIK, tampilkan sebagai badge biasa -->
                                    <span class="badge <?php echo $statusClass; ?>"><?php echo $lpr->status_laporan; ?></span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center">Belum ada laporan yang dibuat.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require APPROOT . '/app/views/inc/footer.php'; ?>

