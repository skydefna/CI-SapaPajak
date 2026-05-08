<div id="up" class="pt-5"></div>
<div class="py-5">
    <div class="container px-lg-5">
        <div class="card mb-4">
            <div class="card-body py-2 pe-2">
                <form class="row g-3" id="searchForm" method="POST">
                    <div class="input-group border-0 shadow-none">
                        <span class="input-group-text border-0 shadow-none p-0"><i class="bx bx-search fs-4 lh-0"></i></span>
                        <input type="number" id="inputNumber" class="form-control border-0 shadow-none" name="cari" placeholder="Masukan 6 Digit Kode Tamu" aria-label="Masukan 6 Digit Kode Tamu" value="<?= $codeNull; ?>" min="0">
                        <script>
                            const inputElement = document.getElementById('inputNumber');

                            inputElement.addEventListener('input', () => {
                                if (inputElement.value.length > 6) {
                                    inputElement.value = inputElement.value.slice(0, 6); // Memotong nilai jika lebih dari 6 digit
                                }
                            });
                        </script>
                        <button style="border-radius: 7px;" class="btn btn-primary border-0" type="submit" id="button-addon2">Cari</button>
                    </div>
                </form>

                <script>
                    document.getElementById("searchForm").addEventListener("submit", function(event) {
                        event.preventDefault();
                        const inputVal = document.querySelector("input[name='cari']").value;
                        window.location.href = "<?= base_url('tamu/buku_tamu/'); ?>" + inputVal;
                    });
                </script>

            </div>
        </div>