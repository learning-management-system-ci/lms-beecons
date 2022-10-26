$(document).ready(function () {
    if (Cookies.get('access_token')) {
        handleCartApi()
    }

    //aksi tombol redeem
    $("#cart-form-redeem").on("submit", function (event) {
        event.preventDefault();
        Swal.fire({
            // width: '300px',
            title: "<div class='redeem-loading'> " +
                '<img class="loading-icon" src="image/cart/redeem-loading.gif" alt=""> ' +
                '<h4>Sedang diproses</h4> ' +
                // '<p>Mohon tunggu selagi diproses</p> ' +
                "</div>",
            text: 'Mohon tunggu sebentar.',
            // padding: '0px 0px 40px 6px',
            showConfirmButton: false,
            willClose: redeem_success,
            showClass: {
                popup: 'animate__animated animate__fadeIn animate__fast'
            },
        })
    })

    //popup ketika voucher berhasil diredeem
    function redeem_success() {
        Swal.fire({
            title: "<div class='redeem-success'> " +
                '<img class="mb-4 success-icon" src="image/cart/success-popup.png" alt=""> ' +
                '<h5 class="mt-4">Berhasil digunakan<h5> ' +
                // '<p>Voucher anda sudah ditambahkan di keranjang</p> ' +
                "</div>",
            text: 'Kode voucher sudah berhasil digunakan.',
            focusConfirm: false,
            // padding: '0px 0px 42px 50px',
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

    //informasi apabila tidak ada items di keranjang
    function empty_cart() {
        if ($("table tr").length == 1 || $("table tr").length == 246) {

            $("table")
                .after('<div class="empty-cart-info d-flex justify-content-center align-items-center">' +
                    '<h6> Keranjang kamu kosong, pilih course terbaik kamu.</h6>' +
                    '</div>')
            
            $('#cart-count .nav-btn-icon-amount').remove()
            
            $('#cart .cart-total').html('Rp. 0')
        }
    }

    async function handleCartApi() {
        try {
            const res = await $.ajax({
                url: '/api/cart',
                method: 'GET',
                dataType: 'json',
                headers: {
                    Authorization: 'Bearer ' + Cookies.get("access_token")
                }
            })

            const cartList = res.item
            const total = cartList.reduce((prev, curr) => prev + parseInt(curr.sub_total), 0)
            
            if (cartList.length == 0) {
                empty_cart()
            } else {
                $('#cart-list tbody').html(cartList.map((item) => {
                    return `
                        <tr>
                            <td class="d-flex align-items-center mb-4 mt-4">
                                <button class="cart-btn-remove" value=${item.cart_id}>
                                    <img src="image/cart/xbutton.png" alt="">
                                </button>
                                <img src=${"image/cart/frontend-banner.png"} alt="">
                                <h6>${item.course.title}</h6>
                            </td>
                            <td>
                                <div class="price">
                                    <span class="strike">
                                        ${getRupiah(item.course.old_price)}
                                        <span class="discount">${diskon(item.course.old_price, item.sub_total)}%</span>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="price">
                                    <p>${getRupiah(item.sub_total)}</p>
                                </div>
                            </td>
                        </tr>
                    `
                }))

                $('#cart-count').append(
                    `<div class="nav-btn-icon-amount">${cartList.length}</div>`
                );

                $('#cart .cart-total').html(getRupiah(total + ''))
                
                $('#cart .cart-btn-remove').on('click', function(e) {
                    const cart_id = $(this).val()

                    $.ajax({
                        url: `/api/cart/delete/${cart_id}`,
                        method: 'DELETE',
                        dataType: 'json',
                        headers: {
                            Authorization: 'Bearer ' + Cookies.get("access_token")
                        }
                    }).then((res) => {
                        $(this).parent().parent().remove()
                        handleCartApi()
                    })
                })
            }
        } catch (error) {
            empty_cart()
        }
    }

    function diskon(total, discounted) {
        return Math.round((total - discounted) / total * 100)
    }
})