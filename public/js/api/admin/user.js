// check the cookies if the user is logged in
if(!Cookies.get('access_token')){
  // if not, redirect to login page
  window.location.href = '/login'
}
$(document).ready(() => {
  const getUserList = async () => {
    try {
      let option = {
        type: "GET",
        url: "/api/users/admin",
        dataType: "json",
        headers: {
          "Authorization": `Bearer ${Cookies.get("access_token")}`,
        },
        success: function (users) {
          data = users
        },

      }
      let data
      await $.ajax(option)
      return data
    } catch (error) {
      console.log(error);
    }
  }

  const populateUserList = async () => {
    let users = await getUserList()
    const user_list_content = $("#user-list-content")
    user_list_content.empty()
    users.forEach((user) => {
      let badge_bg = ''
      if (user.role === 'admin') {
        badge_bg = 'bg-danger'
      } else if (user.role === 'member') {
        badge_bg = 'bg-success'
      } else if (user.role === 'author') {
        badge_bg = 'bg-secondary'
      } else if (user.role === 'partner') {
        badge_bg = 'bg-warning'
      } else if (user.role === 'mentor') {
        badge_bg = 'bg-primary'
      }
      let html = `
          <tr>
          <td>
            <div class="d-flex px-2 py-1">
              <div class="d-flex flex-column justify-content-center">
                <h6 class="mb-0 text-sm">${user.fullname}</h6>
              </div>
            </div>
          </td>
          <td>
            <p class="text-xs font-weight-bold mb-0">${user.email}</p>
          </td>
          <td class="align-middle text-center text-xs">
            <span class="badge badge-sm ${badge_bg}">${user.role}</span>
          </td>
          <td class="align-middle">
            <a href="javascript:;" class="text-secondary font-weight-bold text-sm" data-toggle="tooltip" data-original-title="Edit user">
              Edit
            </a>
            <a href="javascript:;" class="text-secondary font-weight-bold text-sm" data-toggle="tooltip" data-original-title="Delete user">
              Delete
            </a>
          </td>
        </tr>
      `
      user_list_content.append(html)
    })
  }

  populateUserList()
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

function filterTable() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("search-input");
  filter = input.value.toUpperCase();
  table = document.getElementById("table-user");
  tr = table.getElementsByTagName("tr");


  for (i = 0; i < tr.length; i++) {

    td_name  = tr[i].getElementsByTagName("td")[0];
    td_email = tr[i].getElementsByTagName("td")[1];
    td_role  = tr[i].getElementsByTagName("td")[2];
    if (td_name || td_email) {
      txtValue_name  = td_name.textContent || td_name.innerText;
      txtValue_email = td_email.textContent || td_email.innerText;
      txtValue_role  = td_role.textContent || td_role.innerText;
      if (txtValue_name.toUpperCase().indexOf(filter) > -1 || txtValue_email.toUpperCase().indexOf(filter) > -1 || txtValue_role.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}