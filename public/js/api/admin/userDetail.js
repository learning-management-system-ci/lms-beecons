let checkAuthor = jwt_decode(Cookies.get('access_token'))

const startSetting = () => {
  const setting_page = $("#setting")
  const profile_page = $("#profile")

  profile_page.removeClass("show active")
  setting_page.removeClass('d-none').addClass("show")
}

const stopSetting = () => {
  const setting_page = $("#setting")
  const profile_page = $("#profile")

  setting_page.removeClass("show").addClass('d-none')
  profile_page.removeClass('d-none').addClass("show active")
}

$('#learning-tab').on('click', function () {
  const setting_page = $("#setting")
  const profile_page = $("#profile")

  setting_page.removeClass("show").addClass('d-none')
  profile_page.removeClass('d-none')
})

$('#transaction-tab').on('click', function () {
  const setting_page = $("#setting")
  const profile_page = $("#profile")

  setting_page.removeClass("show").addClass('d-none')
  profile_page.removeClass('d-none')
})

const getUserData = async (id) => {
  try {
    let option = {
      type: "GET",
      url: `/api/users/${id}`,
      dataType: "json",
      headers: {
        "Authorization": `Bearer ${Cookies.get("access_token")}`,
      },
      success: function (user) {
        data = user
      },
    }
    let data
    await $.ajax(option)
    return data
  } catch (error) {
    console.log(error);
  }
}

const getListJob = async () => {
  try {
    let option = {
      type: "GET",
      url: `/api/jobs`,
      dataType: "json",
      headers: {
        "Authorization": `Bearer ${Cookies.get("access_token")}`,
      },
      success: function (jobs) {
        data = jobs
      },
    }
    let data
    await $.ajax(option)
    return data
  } catch (error) {
    console.log(error);
  }
}

const getListRole = async () => {
  try {
    let option = {
      type: "GET",
      url: `/api/users/role`,
      dataType: "json",
      headers: {
        "Authorization": `Bearer ${Cookies.get("access_token")}`,
      },
      success: function (roles) {
        data = roles
      },
    }
    let data
    await $.ajax(option)
    return data.role
  } catch (error) {
    console.log(error);
  }
}

const postUserProfileData = async () => {
  let url = window.location.href
  let user_id = url.substring(url.lastIndexOf('/') + 1)

  let data = {
    fullname: $("#fullname-input").val(),
    email: $("#email-input").val(),
    job: $("#job-input").val(),
    role: $("#role-input").val(),
    date_birth: $("#date-birth-input").val(),
    phone: $("#phone-input").val(),
    address: $("#address-input").val(),
  }

  let option = {
    type: "POST",
    url: `/api/users/admin/update/${user_id}`,
    dataType: "json",
    headers: {
      "Authorization": `Bearer ${Cookies.get("access_token")}`,
    },
    data: data,
    success: function (user) {
      console.log('berhasil')
      stopSetting()
    },
  }

  await $.ajax(option)
}

const populateProfileSection = async (data) => {
  let {
    fullname,
    date_birth,
    email,
    job_name,
    profile_picture,
    address,
    phone_number,
    role
  } = data

  console.log(role)

  let humanize_date_birth = moment(date_birth, 'YYYY MM DD').locale('id').format('LL')

  const profile_picture_content = $(".profile-picture-content")
  const fullname_content = $(".fullname-content")
  const date_birth_content = $(".date-birth-content")
  const email_content = $(".email-content")
  const job_name_content = $(".job-name-content")
  const address_content = $(".address-content")
  const phone_number_content = $(".phone-number-content")
  const role_profile = $(".role-name")

  profile_picture_content.attr("src", profile_picture)
  fullname_content.text(fullname)
  date_birth_content.text(humanize_date_birth)
  email_content.text(email)
  job_name_content.text(job_name)
  address_content.text(address)
  phone_number_content.text(phone_number)
  role_profile.text(role)
}

const populateSettingSection = async (data) => {
  let {
    fullname,
    date_birth = null,
    email,
    job_name,
    address,
    phone_number,
    role
  } = data

  let job_list = await getListJob();
  let role_list = await getListRole();

  const fullname_content = $(".fullname-content-setting")
  const date_birth_content = $(".date-birth-content-setting")
  const email_content = $(".email-content-setting")
  const job_name_content = $(".job-name-content-setting")
  const address_content = $(".address-content-setting")
  const phone_number_content = $(".phone-number-content-setting")
  const role_content = $(".role-content-setting")


  fullname_content.val(fullname)
  date_birth_content.val(date_birth)
  email_content.val(email)
  address_content.val(address)
  phone_number_content.val(phone_number)

  job_name_content.empty()

  job_list.forEach((job) => {
    // spread and rename job id into id and job name into name
    const { job_id: id, job_name: name } = job
    let is_selected = job == job_name ? "selected" : "";
    template = `
    <option value="${id}" ${is_selected}>${name}</option>
    `
    job_name_content.append(template)
  })

  role_content.empty()
  role_list.forEach((item) => {
    // spread and rename role id into id and role name into name
    let is_selected = item == role ? "selected" : "";
    template = `
      <option value="${item}" ${is_selected}>${item}</option>
    `
    role_content.append(template)
  })

}

const populateLearningSection = async (data) => {
  const user_course_list_content = $("#user-course-list-content")
  user_course_list_content.empty()

  data.forEach((course) => {
    const {
      title,
      video
    } = course

    let video_count = video.length
    let video_passed_count = video.filter((item) => item.score >= 50).length
    console.log(`video_count : ${video_count}`)
    console.log(`video_passed_count : ${video_passed_count}`)



    let progress = (video_passed_count / video_count) * 100

    let badge;
    if (progress == 100) {
      badge = "bg-success"
    } else if (progress >= 50) {
      badge = "bg-warning"
    } else {
      badge = "bg-danger"
    }

    const list_course_template = `
      <tr>
        <td>
          <div class="d-flex px-2 py-1">
            <div class="d-flex flex-column justify-content-center">
              <h6 class="mb-0 text-sm">${title}</h6>
            </div>
          </div>
        </td>
        <td>
        <span class="badge badge-sm ${badge}">${progress}%</span>
        </td>
      </tr>
    `

    user_course_list_content.append(list_course_template)
  })
  console.log("Learning Section")
  console.log(data)
}

const populateTransactionsSection = async (data) => {
  const user_transaction_list_content = $("#user-transaction-list-content")
  user_transaction_list_content.empty()

  data.forEach((transaction) => {
    const {
      gross_amount,
      transaction_status,
      order_time
    } = transaction

    let humanize_order_time = moment(order_time, 'YYYY/MM/DD hh:mm:ss').format('LLL')
    let humanize_gross_amount = getRupiah(gross_amount + '')
    let badge;
    if (transaction_status == "success") {
      badge = "bg-success"
    } else if (transaction_status == "pending") {
      badge = "bg-warning"
    } else {
      badge = "bg-danger"
    }

    const list_transaction_template = `
    <tr>
      <td>
        <div class="d-flex px-2 py-1">
          <div class="d-flex flex-column justify-content-center">
            <h6 class="mb-0 text-sm">${humanize_order_time}</h6>
          </div>
        </div>
      </td>
      <td>
        <span class="badge ${badge}">${transaction_status}</span>
      </td>
      <td>
        <p class="text-xs font-weight-bold mb-0">${humanize_gross_amount}</p>
      </td>
    </tr>`
    user_transaction_list_content.append(list_transaction_template)
  })
  console.log("Transaction Section")
  console.log(data)
}

const MainFunction = async () => {
  let url = window.location.href
  let user_id = url.substring(url.lastIndexOf('/') + 1)

  let user_data = await getUserData(user_id)
  await populateProfileSection(user_data)
  await populateSettingSection(user_data)
  await populateLearningSection(user_data['course'])
  await populateTransactionsSection(user_data['transaction'])

  // make paralel for 4 functions in promise all
  Promise.all([
    populateProfileSection(user_data),
    populateSettingSection(user_data),
    populateLearningSection(user_data['course']),
    populateTransactionsSection(user_data['transaction'])
  ])


}

$(document).ready(() => {
  MainFunction()
})