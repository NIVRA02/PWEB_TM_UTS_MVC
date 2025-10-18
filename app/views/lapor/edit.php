<?php require APPROOT . '/app/views/inc/header.php'; ?>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card card-body mt-5">
            <h2>Edit Laporan Orang Hilang</h2>
            <p>Silakan perbarui informasi di bawah ini.</p>
            <form action="<?php echo URLROOT; ?>/lapor/edit/<?php echo $data['id']; ?>" method="post" enctype="multipart/form-data">
                
           
                <div class="form-group mb-3">
                    <label for="nama_lengkap" class="form-label">Nama Lengkap: <sup>*</sup></label>
                    <input type="text" name="nama_lengkap" class="form-control <?php echo (!empty($data['nama_lengkap_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['nama_lengkap']; ?>">
                    <span class="invalid-feedback"><?php echo $data['nama_lengkap_err']; ?></span>
                </div>


                <div class="form-group mb-3">
                    <label for="umur" class="form-label">Umur (Tahun): <sup>*</sup></label>
                    <input type="number" name="umur" class="form-control <?php echo (!empty($data['umur_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['umur']; ?>">
                    <span class="invalid-feedback"><?php echo $data['umur_err']; ?></span>
                </div>
                

                <div class="form-group mb-3">
                    <label class="form-label">Jenis Kelamin: <sup>*</sup></label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jenis_kelamin" id="laki-laki" value="Laki-laki" <?php echo ($data['jenis_kelamin'] == 'Laki-laki') ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="laki-laki">Laki-laki</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jenis_kelamin" id="perempuan" value="Perempuan" <?php echo ($data['jenis_kelamin'] == 'Perempuan') ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="perempuan">Perempuan</label>
                        </div>
                    </div>
                </div>


                <div class="row mb-3">
                    <div class="col">
                        <label for="provinsi" class="form-label">Provinsi Terakhir Dilihat:</label>
                        <select name="provinsi" id="provinsi" class="form-select">
                            <option value="">Pilih Provinsi</option>
                            <?php foreach($data['provinsi'] as $prov): ?>
                                <option value="<?php echo $prov->id_prov; ?>" <?php echo ($data['provinsi_id'] == $prov->id_prov) ? 'selected' : ''; ?>><?php echo $prov->nama_prov; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col">
                        <label for="kabupaten" class="form-label">Kabupaten/Kota Terakhir Dilihat:</label>
                        <select name="kabupaten" id="kabupaten" class="form-select">
                            <option value="">Pilih Provinsi Dahulu</option>
                        </select>
                    </div>
                </div>


                <div class="form-group mb-3">
                    <label for="kronologi" class="form-label">Kronologi Kejadian: <sup>*</sup></label>
                    <textarea name="kronologi" class="form-control" rows="5"><?php echo $data['kronologi']; ?></textarea>
                </div>


                <div class="form-group mb-3">
                    <label for="ciri_ciri" class="form-label">Ciri-ciri Khusus (Opsional):</label>
                    <textarea name="ciri_ciri" class="form-control" rows="3"><?php echo $data['ciri_ciri']; ?></textarea>
                </div>


                <div class="form-group mb-3">
                    <label for="foto" class="form-label">Ganti Foto (Opsional):</label><br>
                    <small>Foto saat ini:</small><br>
                    <img src="<?php echo URLROOT . '/uploads/' . $data['foto']; ?>" width="100" class="mb-2 rounded"><br>
                    <input type="file" name="foto" class="form-control">
                </div>
                

                <div class="d-flex justify-content-between">
                     <a href="<?php echo URLROOT; ?>/lapor/detail/<?php echo $data['id']; ?>" class="btn btn-secondary">Batal</a>
                     <input type="submit" value="Update Laporan" class="btn btn-success">
                </div>

            </form>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const provSelect = document.getElementById('provinsi');
    const kabSelect = document.getElementById('kabupaten');
   
    const selectedKabId = '<?php echo $data['kabupaten_id']; ?>';

    
    function fetchKabupaten(provId, selectedKab = null) {
        if(provId) {
            fetch('<?php echo URLROOT; ?>/lapor/getKabupaten/' + provId)
                .then(response => response.json())
                .then(data => {
                    let options = '<option value="">Pilih Kabupaten/Kota</option>';
                    data.forEach(function(kabupaten) {
                        
                        const isSelected = kabupaten.id_kab == selectedKab ? 'selected' : '';
                        options += `<option value="${kabupaten.id_kab}" ${isSelected}>${kabupaten.nama_kab}</option>`;
                    });
                    kabSelect.innerHTML = options;
                });
        } else {
            kabSelect.innerHTML = '<option value="">Pilih Provinsi Dahulu</option>';
        }
    }

  
    if(provSelect.value){
        fetchKabupaten(provSelect.value, selectedKabId);
    }
    
 
    provSelect.addEventListener('change', function() {
        fetchKabupaten(this.value);
    });
});
</script>

<?php require APPROOT . '/app/views/inc/footer.php'; ?>

