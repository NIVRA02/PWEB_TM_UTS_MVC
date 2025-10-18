<?php require APPROOT . '/app/views/inc/header.php'; ?>

<div class="mt-5">

    <a href="<?php echo URLROOT; ?>/lapor/lihat" class="btn btn-secondary mb-4">Kembali ke Daftar Laporan</a>

    <div class="card p-4">
        <div class="row">

            <div class="col-md-4">
                <img src="<?php echo URLROOT . '/uploads/' . $data['laporan']->foto; ?>" class="img-fluid rounded" alt="Foto <?php echo $data['laporan']->nama_lengkap; ?>">
            </div>


            <div class="col-md-8">
                <h2 class="mb-0"><?php echo $data['laporan']->nama_lengkap; ?></h2>
                <span class="badge bg-warning text-dark mb-3"><?php echo $data['laporan']->status_laporan; ?></span>
                
                <p><strong>Umur:</strong> <?php echo $data['laporan']->umur; ?> tahun</p>
                <p><strong>Jenis Kelamin:</strong> <?php echo $data['laporan']->jenis_kelamin; ?></p>
                <p><strong>Lokasi Terakhir Dilihat:</strong> <?php echo $data['laporan']->nama_kab . ', ' . $data['laporan']->nama_prov; ?></p>
                <p><strong>Dilaporkan oleh:</strong> <?php echo $data['laporan']->pelapor; ?> pada <?php echo date('d M Y, H:i', strtotime($data['laporan']->tanggal_lapor)); ?></p>
            </div>
        </div>
        <hr>
        <div>
            <h4>Kronologi Kejadian</h4>
            
            <p><?php echo nl2br(htmlspecialchars($data['laporan']->kronologi)); ?></p>
        </div>
        <div>
            <h4>Ciri-ciri</h4>
            <p><?php echo !empty($data['laporan']->ciri_ciri) ? nl2br(htmlspecialchars($data['laporan']->ciri_ciri)) : 'Tidak ada data.'; ?></p>
        </div>
        <div>
            <h4>Tanda Tangan Pelapor</h4>
            <img src="<?php echo $data['laporan']->tanda_tangan; ?>" alt="Tanda Tangan" style="background: white; border: 1px solid #ddd; border-radius: 5px; max-width: 250px;">
        </div>

        <hr>
        
     
        <?php if($data['laporan']->user_id == $_SESSION['user_id']) : ?>
            <div class="d-flex">
           
                <a href="<?php echo URLROOT; ?>/lapor/edit/<?php echo $data['laporan']->id; ?>" class="btn btn-dark">Edit Laporan</a>
                
            
                <form class="ms-2" action="<?php echo URLROOT; ?>/lapor/hapus/<?php echo $data['laporan']->id; ?>" method="post">
                    <input type="submit" value="Hapus Laporan" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus laporan ini secara permanen?');">
                </form>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require APPROOT . '/app/views/inc/footer.php'; ?>

