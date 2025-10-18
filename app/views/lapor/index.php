<?php require APPROOT . '/app/views/inc/header.php'; ?>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card card-body mt-5">
            <a href="<?php echo URLROOT; ?>/pages/index" class="btn btn-secondary mb-4" style="width: fit-content;"><i class="fa fa-arrow-left"></i> Kembali ke Dashboard</a>
            <h2>Buat Laporan Orang Hilang</h2>
            <p>Silakan isi semua data yang diperlukan di bawah ini.</p>
            <form action="<?php echo URLROOT; ?>/lapor/tambah" method="post" enctype="multipart/form-data">
                
                <!-- Nama Lengkap -->
                <div class="form-group mb-3">
                    <label for="nama_lengkap" class="form-label">Nama Lengkap Orang Hilang: <sup>*</sup></label>
                    <input type="text" name="nama_lengkap" class="form-control <?php echo (!empty($data['nama_lengkap_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['nama_lengkap']; ?>">
                    <span class="invalid-feedback"><?php echo $data['nama_lengkap_err']; ?></span>
                </div>

                <!-- Umur -->
                <div class="form-group mb-3">
                    <label for="umur" class="form-label">Umur (Tahun): <sup>*</sup></label>
                    <input type="number" name="umur" class="form-control <?php echo (!empty($data['umur_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['umur']; ?>">
                    <span class="invalid-feedback"><?php echo $data['umur_err']; ?></span>
                </div>

                <!-- Jenis Kelamin -->
                <div class="form-group mb-3">
                    <label class="form-label">Jenis Kelamin: <sup>*</sup></label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input <?php echo (!empty($data['jenis_kelamin_err'])) ? 'is-invalid' : ''; ?>" type="radio" name="jenis_kelamin" id="laki_laki" value="Laki-laki" <?php echo ($data['jenis_kelamin'] == 'Laki-laki') ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="laki_laki">Laki-laki</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input <?php echo (!empty($data['jenis_kelamin_err'])) ? 'is-invalid' : ''; ?>" type="radio" name="jenis_kelamin" id="perempuan" value="Perempuan" <?php echo ($data['jenis_kelamin'] == 'Perempuan') ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="perempuan">Perempuan</label>
                        </div>
                    </div>
                     <div class="text-danger" style="font-size: 0.875em;"><?php echo $data['jenis_kelamin_err']; ?></div>
                </div>

                <!-- Lokasi -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="provinsi" class="form-label">Provinsi Terakhir Terlihat: <sup>*</sup></label>
                        <select name="provinsi" id="provinsi" class="form-select <?php echo (!empty($data['provinsi_err'])) ? 'is-invalid' : ''; ?>">
                            <option value="">-- Pilih Provinsi --</option>
                            <?php foreach($data['provinsi'] as $prov): ?>
                                <option value="<?php echo $prov->id_prov; ?>" <?php echo ($data['provinsi_id'] == $prov->id_prov) ? 'selected' : ''; ?>><?php echo $prov->nama_prov; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span class="invalid-feedback"><?php echo $data['provinsi_err']; ?></span>
                    </div>
                    <div class="col-md-6">
                        <label for="kabupaten" class="form-label">Kabupaten/Kota Terakhir Terlihat: <sup>*</sup></label>
                        <select name="kabupaten" id="kabupaten" class="form-select <?php echo (!empty($data['kabupaten_err'])) ? 'is-invalid' : ''; ?>">
                            <option value="">-- Pilih Provinsi Dulu --</option>
                        </select>
                         <span class="invalid-feedback"><?php echo $data['kabupaten_err']; ?></span>
                    </div>
                </div>

                <!-- Kronologi -->
                <div class="form-group mb-3">
                    <label for="kronologi" class="form-label">Kronologi Kejadian: <sup>*</sup></label>
                    <textarea name="kronologi" class="form-control <?php echo (!empty($data['kronologi_err'])) ? 'is-invalid' : ''; ?>" rows="4" placeholder="Jelaskan secara singkat bagaimana orang tersebut hilang..."><?php echo $data['kronologi']; ?></textarea>
                    <span class="invalid-feedback"><?php echo $data['kronologi_err']; ?></span>
                </div>

                <!-- Ciri-ciri -->
                <div class="form-group mb-3">
                    <label for="ciri_ciri" class="form-label">Ciri-ciri Fisik / Pakaian Terakhir:</label>
                    <textarea name="ciri_ciri" class="form-control" rows="3" placeholder="Contoh: Tinggi 170cm, rambut ikal, menggunakan kemeja biru..."><?php echo $data['ciri_ciri']; ?></textarea>
                </div>
                
                <!-- Foto -->
                <div class="form-group mb-3">
                    <label for="foto" class="form-label">Foto Orang Hilang (Jelas): <sup>*</sup></label>
                    <input type="file" name="foto" class="form-control <?php echo (!empty($data['foto_err'])) ? 'is-invalid' : ''; ?>" accept="image/*">
                    <span class="invalid-feedback"><?php echo $data['foto_err']; ?></span>
                </div>

                <!-- Tanda Tangan -->
                <div class="form-group mb-3">
                    <label for="signature-pad" class="form-label text-center d-block">Tanda Tangan Pelapor: <sup>*</sup></label>
                    <div class="d-flex flex-column align-items-center">
                        <canvas id="signature-pad" class="signature-pad <?php echo (!empty($data['tanda_tangan_err'])) ? 'is-invalid' : ''; ?>"></canvas>
                        <input type="hidden" name="tanda_tangan" id="tanda_tangan">
                        <button type="button" id="clear-signature" class="btn btn-sm btn-secondary mt-2">Hapus Tanda Tangan</button>
                         <div class="invalid-feedback d-block text-center"><?php echo $data['tanda_tangan_err']; ?></div>
                    </div>
                </div>

                <!-- Persetujuan -->
                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" value="" id="persetujuan" required>
                    <label class="form-check-label" for="persetujuan">
                        Saya menyatakan bahwa data yang saya berikan adalah benar dan dapat dipertanggungjawabkan.
                    </label>
                </div>

                <div class="d-grid">
                    <input type="submit" value="Kirim Laporan" class="btn btn-primary btn-lg">
                </div>
            </form>
        </div>
    </div>
</div>

<?php require APPROOT . '/app/views/inc/footer.php'; ?>

<!-- Sisa script JavaScript tetap sama -->
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const provinsiSelect = document.getElementById('provinsi');
    const kabupatenSelect = document.getElementById('kabupaten');
    const selectedKabId = '<?php echo $data['kabupaten_id']; ?>'; 

    function fetchKabupaten(idProv, selectedKab = null) {
        if (idProv) {
            fetch('<?php echo URLROOT; ?>/lapor/getKabupaten/' + idProv)
                .then(response => response.json())
                .then(data => {
                    let options = '<option value="">-- Pilih Kabupaten/Kota --</option>';
                    data.forEach(kab => {
                        const isSelected = kab.id_kab == selectedKab ? 'selected' : '';
                        options += `<option value="${kab.id_kab}" ${isSelected}>${kab.nama_kab}</option>`;
                    });
                    kabupatenSelect.innerHTML = options;
                })
                .catch(error => {
                    console.error('Error:', error);
                    kabupatenSelect.innerHTML = '<option value="">Gagal memuat data</option>';
                });
        } else {
            kabupatenSelect.innerHTML = '<option value="">-- Pilih Provinsi Dulu --</option>';
        }
    }


    if (provinsiSelect.value) {
        fetchKabupaten(provinsiSelect.value, selectedKabId);
    }

    provinsiSelect.addEventListener('change', function() {
        fetchKabupaten(this.value);
    });

    const canvas = document.getElementById('signature-pad');
    const signaturePad = new SignaturePad(canvas, {
        backgroundColor: 'rgb(255, 255, 255)'
    });

    function resizeCanvas() {
        const ratio =  Math.max(window.devicePixelRatio || 1, 1);
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext("2d").scale(ratio, ratio);
        signaturePad.clear(); 
    }

    window.addEventListener("resize", resizeCanvas);
    resizeCanvas();

    document.getElementById('clear-signature').addEventListener('click', function () {
        signaturePad.clear();
    });

    const form = document.querySelector('form');
    form.addEventListener('submit', function (e) {
        if (!signaturePad.isEmpty()) {
            document.getElementById('tanda_tangan').value = signaturePad.toDataURL();
        } else {

        }
    });
});
</script>

