        <div class="inputTamu">
            <h5 class="text-center">Pilih Jenis Tamu</h5>
            <div class="row row-cols-1 row-cols-md-3 row-cols-sm-2 g-4 d-flex justify-content-center animate__animated animate__fadeIn mt-3">
                <!-- START CARD TAMU PERSONAL -->
                <div onclick="window.location.href = '<?= base_url('/tamu/personal'); ?>';" class="col cardBotton">
                    <div onclick="buttonPersonal()" class="card h-100">
                        <img src="<?= base_url("/"); ?>assets/img/illustrations/undraw_businessman_re_mlee.png" alt=". . ." class="removeCont img-fluid img-thumbnail mx-5 mt-5">
                        <div class="card-body text-center">
                            <i class='bx bxs-user removeNavCont fs-1 m-3'></i>
                            <h5 class="card-title">Tamu Personal</h5>
                            <p class="card-text">Tokoh Masyarakat, Wajib Pajak, Pejabat Khusus, dll.</p>
                            <a class="stretched-link fw-bold text-primary">Pilih <i class="bx bxs-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
                <!-- END CARD TAMU PERSONAL -->

                <!-- START CARD TAMU ORGANISASI -->
                <!--<div onclick="window.location.href = '<?= base_url('/tamu/organisasi'); ?>';" class="col cardBottonDis">-->
                <div class="col">
                    <div onclick="buttonOrganisasi()" class="shadow-none card h-100">
                        <img src="<?= base_url("/"); ?>assets/img/illustrations/undraw_stand_out_-1-oag.svg" alt=". . ." class="removeCont img-fluid img-thumbnail mx-5 mt-5 cardBottonDis">
                        <div class="card-body text-center">
                            <i class='bx bxs-group removeNavCont fs-1 m-3 cardBottonDis'></i>
                            <h5 class="card-title cardBottonDis">Tamu Organisasi</h5>
                            <p class="card-text cardBottonDis">Instansi Pemerintahan, Perusahaan Swasta, dll.</p>
                            <a class="stretched-link fw-bold text-primary cardBottonDis">Pilih <i class="bx bxs-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
                <!-- END CARD TAMU ORGANISASI -->

            </div>
        </div>
    </div>
</div>