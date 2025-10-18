<?php require APPROOT . '/app/views/inc/header.php'; ?>


<?php if(!isset($_SESSION)) { session_start(); } ?>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card card-body text-center mt-5">
            <h1 class="display-5 fw-bold"><?php echo $data['title']; ?></h1>
            <p class="fs-4"><?php echo $data['description']; ?></p>

            <?php if(isset($_SESSION['user_id'])) : ?>

                <p> selamat datang <strong><?php echo $_SESSION['user_name']; ?>.gmail.com</strong>!</p>
                <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                    <a href="<?php echo URLROOT; ?>/lapor/index" class="btn btn-primary btn-lg px-4 gap-3">Buat Laporan Baru</a>
                    <a href="<?php echo URLROOT; ?>/lapor/lihat" class="btn btn-secondary btn-lg px-4">Lihat Semua Laporan</a>
                </div>
                 <a href="<?php echo URLROOT; ?>/users/logout" class="btn btn-danger btn-sm mt-4">Logout</a>

            <?php else : ?>

                <p>Anda bisa ke halaman <a href="<?php echo URLROOT; ?>/users/login">Login</a> atau <a href="<?php echo URLROOT; ?>/users/register">Register</a>.</p>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php require APPROOT . '/app/views/inc/footer.php'; ?>

