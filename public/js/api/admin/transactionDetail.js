// check the cookies if the user is logged in
if(!Cookies.get('access_token')){
  // if not, redirect to login page
  window.location.href = '/login'
}

$(document).ready(() => {
  const getDetailOrder = async (id) => {
    let option = {
      type: "GET",
      url: `/api/order`,
      dataType: "json",
      headers: {
        "Authorization": `Bearer ${Cookies.get("access_token")}`,
      },
      success: function (transactions) {
        datas = transactions.order
        data = datas.filter(x => x.order_id == id)[0];
        data.items = [];
        data["course-item"].forEach((course) => {
          let { title, new_price: price } = course
          data.items.push({
            title,
            type: "course",
            price,
          })
        })
        data["bundling-item"].forEach((course) => {
          let { title, new_price: price } = course
          data.items.push({
            title,
            type: "bundling",
            price,
          })
        })

        // delete data["course-item"] and data["bundling-item"]
        delete data["course-item"]
        delete data["bundling-item"]
      },
    }
    let data
    await $.ajax(option)
    return data
  }

  const populateOrderItems = (data) => {
    const item_list_content = $("#item-list-content")
    item_list_content.empty()
    const type_color = {
      course: "bg-gradient-primary",
      bundling: "bg-gradient-info",
    }
    data.forEach((item) => {
      let { title, type, price } = item
      let html = `
        <tr>
          <td>
            <div class="d-flex px-2 py-1">
              <div class="d-flex flex-column justify-content-center">
                <h6 class="mb-0 text-sm">${title}</h6>
              </div>
            </div>
          </td>
          <td>
            <span class="badge badge-sm ${type_color[type]}">${type}</span>
          </td>
          <td>
            <span class="text-secondary text-sm font-weight-bold">${getRupiah(price)}</span>
          </td>
        </tr>
      `
      item_list_content.append(html)
    })
  }

  const populateDetailOrder = async () => {
    let url = window.location.href
    let transaction_id = url.substring(url.lastIndexOf('/') + 1)
    let transaction = await getDetailOrder(transaction_id)

    const transaction_id_content = $(".transactionId-content")
    const username_content = $(".username-content")
    const order_date_content = $(".orderDate-content")
    const status_content = $(".status-content")
    const amount_content = $(".amount-content")

    const status_color = {
      SUCCESS: "bg-gradient-success",
      PENDING: "bg-gradient-warning",
      FAILED: "bg-gradient-danger"
    }

    let {
      fullname,
      total_price,
      transaction_status: status,
      order_date,
      transaction_date = moment(order_date, 'YYYY/MM/DD hh:mm:ss').format('LLL'),
      items
    } = transaction

    console.log(transaction_id_content)
    transaction_id_content.text(transaction_id)
    username_content.text(fullname)
    order_date_content.text(transaction_date)
    status_content.text(status)
    status_content.addClass(status_color[status])
    amount_content.text(getRupiah(total_price))

    populateOrderItems(items)
  }

  populateDetailOrder()
})