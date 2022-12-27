// check the cookies if the user is logged in
if(!Cookies.get('access_token')){
  // if not, redirect to login page
  window.location.href = '/login'
}

$(document).ready(() => {
  const getListOrder = async () => {
    let option = {
      type: "GET",
      url: document.location.origin + "/api/order/get-order-by-author",
      dataType: "json",
      headers: {
        "Authorization": `Bearer ${Cookies.get("access_token")}`,
      },
      success: function (transactions) {
        let course = transactions.course
        let bundling = transactions.bundling
        data = []
        course.forEach(transaction => {
          data.push({
            ...transaction,
            type: "course"
          })
        })
        bundling.forEach(transaction => {
          data.push({
            ...transaction,
            type: "bundling"
          })
        })
      },
    };
    let data
    await $.ajax(option)
    return data
  }

  const populateListOrder = async () => {
    let transactions = await getListOrder()
    const transaction_table = $("#transaction-table")
    const status_color = {
      SUCCESS: "bg-gradient-success",
      PENDING: "bg-gradient-warning",
      FAILED: "bg-gradient-danger"
    }
    console.log(transactions)

    transaction_table.dataTable({
      data: transactions,
      language: {
        paginate: {
          next: `<i class="ni ni-bold-right" aria-hidden="true"></i>`,
          previous: `<i class="ni ni-bold-left" aria-hidden="true"></i>`
        }
      },
      dom:  "<'row mx-4 mt-4'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row mx-4 mb-2'<'col-sm-12 col-md-6 text-sm'i><'col-sm-12 col-md-6'p>>",
      columns: [
        {
          data: "order_id",
          render: function (data, type, row, meta) {
            return `<a href="#" class="mb-0 text-sm px-3">${meta.row+1}</a>`
          }
        },
        {
          data: "order_time",
          render: function (data, type, row, meta) {
            return `<p class="mb-0 text-sm font-weight-bold px-3">${moment(data, 'YYYY/MM/DD hh:mm:ss').format('LLL')}</p>`
          }
        },
        {
          data: "title",
          render: function (data, type, row, meta) {
            return `<p class="text-sm font-weight-bold mb-0">${data}</p>`
          }
        },
        {
          data: "fullname",
          render: function (data, type, row, meta) {
            return `<span class="text-secondary text-sm font-weight-bold">${data}</span>`
          }
        },
        {
          data: "type",
          render: function (data, type, row, meta) {
            let type_color = data == "course" ? "bg-gradient-primary" : "bg-gradient-info"
            return `
              <span class="badge badge-sm ${type_color}">${data}</span>
            `
          }
        },
        {
          data: "transaction_status",
          render: function (data, type, row, meta) {
            return `
              <span class="badge badge-sm ${status_color[data]}">${data}</span>
            `
          }
        },
        {
          data: "order_id",
          render: function (data, type, row) {
            return `
            <a href="/admin/transaction/${data}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Detail Transaction">
              Detail
            </a>`
          }
        }

      ]
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