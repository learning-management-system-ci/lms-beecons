$(document).ready(function () {
    // call function setNotification every 15 seconds
    if (Cookies.get("access_token") != null) {
        handleCartNotification()
        setNotification();
        setInterval(async () => {
            setNotification();
        }, 15000);
    }

    $('.notifications-baca').on('click', function (e) {
        e.preventDefault();
    })
})

// handle cart notification
function handleCartNotification() {
    $.ajax({
        url: '/api/cart',
        method: 'GET',
        headers:
        {
            Authorization: 'Bearer ' + Cookies.get("access_token")
        },
        dataType: 'json',
    }).then((res) => {
        let cartCount = res.item.length;
        if (cartCount > 0) {
            $('#cart-count').append(
                `<div class="nav-btn-icon-amount">${cartCount}</div>`
            );
        }
    }).catch((err) => {
        // console.log(err)
    })
}

// handle notification
function getNotification() {
    try {
        return $.ajax(
            {
                url: '/api/notification',
                method: 'GET',
                headers:
                {
                    Authorization: 'Bearer ' + Cookies.get("access_token")
                },
                dataType: 'json',

            });
    }
    catch (error) {
        console.log(error)
    }
}

async function setNotification() {
    const notifications = await getNotification();

    if (notifications.length > 0) {
        $('nav #dropdown-notification').append(`
            <div class="nav-btn-icon-amount">${notifications.length}</div>
        `)

        let content = '';
        notifications.forEach(notification => {
            const { message, created_at } = notification;
            created_at_human = moment(created_at, 'YYYY-MM-DD hh:mm:ss').locale('id').fromNow();
            content += `
                <div class="notif unread">
                    <a href="" class="">
                        <div class="icon">
                            <img src="/image/home/notif-icon.png" alt="icon">
                        </div>
                        <div class="item">
                            <p>
                                ${message}
                            </p>
                            <span>${created_at_human}</span>
                        </div>
                    </a>
                </div>
                `;
        });

        $('.notifications-list').html(content);
    }
}