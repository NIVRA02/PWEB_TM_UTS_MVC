<?php require APPROOT . '/app/views/inc/header.php'; ?>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card card-body mt-5">
            <a href="<?php echo URLROOT; ?>/pages/index" class="btn btn-secondary mb-4" style="width: fit-content;"><i class="fa fa-arrow-left"></i> Kembali ke Dashboard</a>
            <h2>Buat Laporan Orang Hilang</h2>
            <p>Silakan isi semua data yang diperlukan di bawah ini.</p>
            <form action="<?php echo URLROOT; ?>/lapor/index" method="post" enctype="multipart/form-data">
                

                <div class="form-group mb-3">
                    <label for="nama_lengkap" class="form-label">Nama Lengkap Orang Hilang: <sup>*</sup></label>
                    <input type="text" name="nama_lengkap" class="form-control" required>
                </div>


                <div class="form-group mb-3">
                    <label for="umur" class="form-label">Umur (Tahun): <sup>*</sup></label>
                    <input type="number" name="umur" class="form-control" required>
                </div>


                <div class="form-group mb-3">
                    <label class="form-label">Jenis Kelamin: <sup>*</sup></label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jenis_kelamin" id="laki_laki" value="Laki-laki" required>
                            <label class="form-check-label" for="laki_laki">Laki-laki</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jenis_kelamin" id="perempuan" value="Perempuan">
                            <label class="form-check-label" for="perempuan">Perempuan</label>
                        </div>
                    </div>
                </div>


                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="provinsi" class="form-label">Provinsi Terakhir Terlihat: <sup>*</sup></label>
                        <select name="provinsi" id="provinsi" class="form-select" required>
                            <option value="">-- Pilih Provinsi --</option>
                            <?php foreach($data['provinsi'] as $prov): ?>
                                <option value="<?php echo $prov->id_prov; ?>"><?php echo $prov->nama_prov; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="kabupaten" class="form-label">Kabupaten/Kota Terakhir Terlihat: <sup>*</sup></label>
                        <select name="kabupaten" id="kabupaten" class="form-select" required>
                            <option value="">-- Pilih Provinsi Dulu --</option>
                        </select>
                    </div>
                </div>


                <div class="form-group mb-3">
                    <label for="kronologi" class="form-label">Kronologi Kejadian: <sup>*</sup></label>
                    <textarea name="kronologi" class="form-control" rows="4" placeholder="Jelaskan secara singkat bagaimana orang tersebut hilang..." required></textarea>
                </div>


                <div class="form-group mb-3">
                    <label for="ciri_ciri" class="form-label">Ciri-ciri Fisik / Pakaian Terakhir:</label>
                    <textarea name="ciri_ciri" class="form-control" rows="3" placeholder="Contoh: Tinggi 170cm, rambut ikal, menggunakan kemeja biru..."></textarea>
                </div>
                

                <div class="form-group mb-3">
                    <label for="foto" class="form-label">Foto Orang Hilang (Jelas): <sup>*</sup></label>
                    <input type="file" name="foto" class="form-control" accept="image/*" required>
                </div>


                <div class="form-group mb-3">
                    <label for="signature-pad" class="form-label text-center d-block">Tanda Tangan Pelapor: <sup>*</sup></label>
                    <div class="d-flex flex-column align-items-center">
                        <canvas id="signature-pad" class="signature-pad"></canvas>
                        <input type="hidden" name="tanda_tangan" id="tanda_tangan">
                        <button type="button" id="clear-signature" class="btn btn-sm btn-secondary mt-2">Hapus Tanda Tangan</button>
                    </div>
                </div>



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


<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const provinsiSelect = document.getElementById('provinsi');
    const kabupatenSelect = document.getElementById('kabupaten');

    provinsiSelect.addEventListener('change', function() {
        const idProv = this.value;
        kabupatenSelect.innerHTML = '<option value="">Memuat...</option>';

        if (idProv) {
            fetch('<?php echo URLROOT; ?>/lapor/getKabupaten/' + idProv)
                .then(response => response.json())
                .then(data => {
                    kabupatenSelect.innerHTML = '<option value="">-- Pilih Kabupaten/Kota --</option>';
                    data.forEach(kab => {
                        kabupatenSelect.innerHTML += `<option value="${kab.id_kab}">${kab.nama_kab}</option>`;
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    kabupatenSelect.innerHTML = '<option value="">Gagal memuat data</option>';
                });
        } else {
            kabupatenSelect.innerHTML = '<option value="">-- Pilih Provinsi Dulu --</option>';
        }
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

        const data = signaturePad.toData();
        if (data) {
            signaturePad.fromData(data);
        }
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
            alert("Tanda tangan tidak boleh kosong.");
            e.preventDefault();
        }
    });
});
</script>

