// check the cookies if the user is logged in
if(!Cookies.get('access_token')){
  // if not, redirect to login page
  window.location.href = '/login'
}

$(document).ready(() => {
  const getListOrder = async () => {
    let option = {
      type: "GET",
      url: "/api/order",
      dataType: "json",
      headers: {
        "Authorization": `Bearer ${Cookies.get("access_token")}`,
      },
      success: function (transactions) {
        data = transactions.order
      },
    };
    let data
    await $.ajax(option)
    return data
  }

  const populateListOrder = async () => {
    let transactions = await getListOrder()
    const transaction_list_content = $("#transaction-list-content")
    transaction_list_content.empty()
    transactions.forEach((transaction) => {
      let {
        fullname,
        total_price,
        transaction_status,
        order_id,
        order_date,
        transaction_date = moment(order_date, 'YYYY/MM/DD hh:mm:ss').format('LLL'),
      } = transaction

      let status_color = {
        SUCCESS: "bg-gradient-success",
        PENDING: "bg-gradient-warning",
        FAILED: "bg-gradient-danger"
      }

      let html = `
      <tr>
        <td>
          <p class="mb-0 text-sm font-weight-bold px-3">${transaction_date}</p>
        </td>
        <td>
          <p class="text-sm font-weight-bold mb-0">${fullname}</p>
        </td>
        <td class="align-middle text-center">
          <span class="text-secondary text-sm font-weight-bold">${getRupiah(total_price)}</span>
        </td>
        <td class="align-middle text-center text-sm">
          <span class="badge badge-sm ${status_color[transaction_status]}">${transaction_status}</span>
        </td>
        <td class="align-middle">
          <a href="/admin/transaction/${order_id}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
            Detail
          </a>
        </td>
      </tr>`

      transaction_list_content.append(html)
    })
  }

  populateListOrder()
})

function sortTable(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("table-user");
  switching = true;
  // Set the sorting direction to ascending:
  dir = "asc";
  /* Make a loop that will continue until
  no switching has been done: */
  while (switching) {
    // Start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /* Loop through all table rows (except the
    first, which contains table headers): */
    for (i = 1; i < (rows.length - 1); i++) {
      // Start by saying there should be no switching:
      shouldSwitch = false;
      /* Get the two elements you want to compare,
      one from current row and one from the next: */
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
      /* Check if the two rows should switch place,
      based on the direction, asc or desc: */
      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          // If so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          // If so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      /* If a switch has been marked, make the switch
      and mark that a switch has been done: */
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      // Each time a switch is done, increase this count by 1:
      switchcount ++;
    } else {
      /* If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again. */
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}