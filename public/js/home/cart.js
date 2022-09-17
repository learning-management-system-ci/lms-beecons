$(document).ready(function () {

    //informasi apabila tidak ada items di keranjang
    const empty_cart = () => {
        if ($("table tr").length == 1 || $("table tr").length == 246) {

            $("table")
                .after('<div class="empty-cart-info d-flex justify-content-center align-items-center">' +
                    '<h6> Keranjang kamu kosong.Pilih course terbaik kami</h6>' +
                    '</div>')
        }
    }

    empty_cart()

    //popup ketika voucher berhasil diredeem
    const redeem_success = () => {
        Swal.fire({
            title: "<div class='redeem-success'> " +
                '<img class="mb-4 success-icon" src="image/cart/success-popup.png" alt=""> ' +
                '<h5 class="mt-4">Berhasil Ditambahkan<h5> ' +
                '<p>Voucher anda sudah ditambahkan di keranjang</p> ' +
                "</div>",
            focusConfirm: false,
            padding: '0px 0px 42px 50px',
            showConfirmButton: false,
            showCloseButton: true,
        })
    }

    //popup ketika voucher sudah digunakan
    const redeem_warning = () => {
        Swal.fire({
            title: "<div class='redeem-success'> " +
                '<img class="mb-4 success-icon" src="image/cart/warning-popup.png" alt=""> ' +
                '<h5 class="mt-4">Voucher sudah digunakan<h5> ' +
                '<p>Voucher anda sudah digunakan. Silahkan pilih yang tersedia</p> ' +
                "</div>",
            focusConfirm: false,
            padding: '0px 0px 42px 5px',
            showConfirmButton: false,
            showCloseButton: true,
        })
    }



    //hapus items dari keranjang
    $("table tr td").on('mousedown', '#remove', function () {
        $(this).parent().parent().remove()
        empty_cart()
    })

    //aksi tombol redeem
    $("#redeem").on("click", function (event) {
        event.preventDefault();
        Swal.fire({
            width: '300px',
            title: "<div class='redeem-loading'> " +
                '<img class="loading-icon" src="image/cart/redeem-loading.gif" alt=""> ' +
                '<h5>Wait a sec</h5> ' +
                '<p>Mohon tunggu selagi diproses</p> ' +
                "</div>",
            padding: '0px 0px 40px 6px',
            showConfirmButton: false,
            willClose: redeem_success,
            showClass: {
                popup: 'animate__animated animate__fadeIn animate__fast'
            },
        })
    })
})