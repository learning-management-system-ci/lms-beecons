if(!Cookies.get("access_token")){
  window.location.href = "/login"
}

$(document).ready(() => {
  const getCart = async () => {
    try {
      let option = {
        type: "GET",
        url: "http://localhost:8080/api/cart",
        dataType: "json",
        headers: {
          "Authorization": `Bearer ${Cookies.get("access_token")}`,
        },
        success: function (cart) {
          cart.item.forEach((item) => {
            if(item.bundling){
              item['type'] = 'bundling'
              item['detail'] = item.bundling
              item['thumbnail'] = item.bundling.thumbnail || 'image/cart/ux-banner.png'
            } else if (item.course) {
              item['type'] = 'course'
              item['detail'] = item.course
              item['thumbnail'] = item.course.thumbnail || 'image/cart/ux-banner.png'
            }

            delete item.bundling
            delete item.course
          })

          // rename cart.item to cart.items
          cart['items'] = cart.item
          delete cart.item
          data = cart
        }
      }
      let data
      await $.ajax(option)
      return data
    } catch (error) {
      console.log(error);
    }
  }

  const getCourse = async (id) => {
    try {
      let option = {
        type: "GET",
        url: `http://localhost:8080/api/course/detail/${id}`,
        dataType: "json",
        headers: {
          "Authorization": `Bearer ${Cookies.get("access_token")}`,
        },
        success: function (course) {
          let item = {
            type: "course",
            detail: {
              title: course.title,
              new_price: course.new_price,
              old_price: course.old_price,
              thumbnail: course.thumbnail || 'image/cart/ux-banner.png',
            },
            sub_total: course.new_price || course.old_price,
          }
          data = item
        }
      }
      let data
      await $.ajax(option)
      return data
    } catch (error) {
      console.log(error);
    }
  }

  const getBundle = async (id) => {
    try {
      let option = {
        type: "GET",
        url: `http://localhost:8080/api/bundling/detail/${id}`,
        dataType: "json",
        headers: {
          "Authorization": `Bearer ${Cookies.get("access_token")}`,
        },
        success: (bundle) => {
          let { bundling } = bundle
          console.log(bundling)
          let item = {
            type: "bundling",
            detail: {
              title: bundling.title,
              new_price: bundling.new_price,
              old_price: bundling.old_price,
              thumbnail: 'image/cart/ux-banner.png',
            },
            sub_total: bundling.new_price || bundling.old_price,
          }
          data = item
        }
      }
      let data
      await $.ajax(option)
      return data
    } catch (error) {
      console.log(error);
    }
  }

  const getListVoucher = async () => {
    try {
      let option = {
        type: "GET",
        url: "http://localhost:8080/api/voucher",
        dataType: "json",
        headers: {
          "Authorization": `Bearer ${Cookies.get("access_token")}`,
        },
        success: function (voucher) {
          data = voucher
        }
      }
      let data
      await $.ajax(option)
      return data
    } catch (error) {
      console.log(error);
    }
  }
  
  const getVoucher = async (code) => {
    try {
      let option = {
        type: "GET",
        url: `http://localhost:8080/api/voucher/code-detail?code=${code}`,
        dataType: "json",
        headers: {
          "Authorization": `Bearer ${Cookies.get("access_token")}`,
        },
        success: function (voucher) {
          data = voucher
        }
      }
      let data = null;
      await $.ajax(option)
      return data
    } catch (error) {
      console.log(error);
    }
  }

  const populateVoucher = async() => {
    let voucher = await getListVoucher()
    const checkout_voucherList_content = $("#cart-voucher-list")
    checkout_voucherList_content.empty()
    voucher.forEach((item) => {
      let voucher_item = `
      <div class="col-6 pb-3 pe-2 ps-0">
          <button class="cart-referral-modal-coucher-btn" data-code="${item.code}">
              <div class="referral-item">
                  <div class="icon">
                      <img src="/image/cart/voucher-icon.png" alt="">
                  </div>
                  <div class="disc">
                      ${item.discount_price}%
                  </div>
              </div>
          </button>
      </div>`
      checkout_voucherList_content.append(voucher_item)
    })

    $("#cart-voucher-list").children().each((index, element) => {
      $(element).on('click', () => {
        console.log("clicked")
        let thisPage = new URL(window.location.href);
        let code = $(element).children().data('code')
        thisPage.searchParams.append('code', code)
        window.location.href = thisPage
      })
    })
  }

  const checkout = async () => {
    try {
      let option = {
        type: "GET",
        url: "http://localhost:8080/api/order/generatesnap",
        dataType: "json",
        headers: {
          "Authorization": `Bearer ${Cookies.get("access_token")}`,
        },
        success: function (checkout_detail) {
          let { token } = checkout_detail

          window.snap.pay(token, {
            onSuccess: function(result){
              alert("payment success!"); console.log(result);
            },
            onPending: function(result){
              alert("wating your payment!"); console.log(result);
            },
            onError: function(result){
              alert("payment failed!"); console.log(result);
            },
            onClose: function(){
              alert('you closed the popup without finishing the payment');
            }
          }); 
        }
      }
      await $.ajax(option)
    } catch (error) {
      console.log(error);
    }
  }

  const renderView = async (data) => {
    const checkout_items_content = $("#checkout-items-content");
    const checkout_itemsCount_content = $("#checkout-itemsCount-content");
    const checkout_subtotal = $("#checkout-subtotal");
    const checkout_code_discount = $("#checkout-code-discount");
    const checkout_total = $("#checkout-total");
    const checkout_email = $("#checkout-email");
    const checkout_btn = $("#checkout-btn");
    const voucher_btn = $(".btn-modal-referral")
    let { items, user, sub_total, total, code } = data;
    let { email } = user;
    let itemsCount = items.length || 0;
    
    
    items.forEach((item) => {
      let { type, detail, sub_total} = item
      let { title, thumbnail } = detail
      let itemContent = `
      <div class="order-item mb-4">
        <div class="order-list-detail d-flex">
            <img src="${thumbnail}" alt="" width="150px">
            <div class="order-desc">
                <p class="mb-3 ${type}-badge">
                    ${type}
                </p>
                <h5 class="title">${title}</h5>
                <h5 class="desc">Pelajaran dasar yang dipelajari untuk menjadi frontend engineer</h5>
            </div>
        </div>
        <div class="order-list-subtotal mt-3">
            <hr>
            <div class="d-flex justify-content-between my-1">
                <h5>Subtotal</h5>
                <h5>${getRupiah(sub_total)}</h5>
            </div>
            <hr>
        </div>
      </div>
      `
      checkout_items_content.append(itemContent)
    })

    if (code) {
      sub_total = `${sub_total}`
      total = `${total - (sub_total * (code.discount_price / 100))}`
      checkout_code_discount.text(`${code.discount_price}%`)
    } else {
      sub_total = `${sub_total}`
      total = `${total}`
    }

    checkout_itemsCount_content.text(`Total (${itemsCount} item)`)
    checkout_subtotal.text(getRupiah(sub_total))
    checkout_total.text(getRupiah(total))
    checkout_email.text(email)

    // voucher button on click, call populate voucehr func
    voucher_btn.on("click", () => {
      populateVoucher()
    })

    // checkout button on click, call checkout func
    checkout_btn.on("click", () => {
      checkout()
    })
  }

  const renderCart = async () => {
    
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const id = urlParams.get('id') || null;
    const type = urlParams.get('type') || null;
    const code = urlParams.get('code') || null;
    let data = await getCart()
    

    if (id && type) {
      data.items = []
      if (type == 'course') {
        data.items.push(await getCourse(id))
      } else if (type == 'bundling'){
        data.items.push(await getBundle(id))
      }
      data.sub_total = data.items[0].sub_total
      data.total = data.items[0].sub_total
      console.log(data)
    } else {
      data = await getCart()
    }
    data['code'] = await getVoucher(code)

    console.log(data)
    renderView(data)

    return data
  }

  renderCart()

  
})