$(document).ready(function () {
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
            $('#cart-count').text(cartCount);
        }).catch((err) => {
            console.log(err)
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
        const { id, notification: notifications } = await getNotification();

        let content = '';
        notifications.forEach(notification => {
            const { message, created_at } = notification;
            created_at_human = moment(created_at, 'YYYY-MM-DD hh:mm:ss').locale('id').fromNow();
            content += `
                <div class="notif">
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

        $('nav #dropdown-notification .nav-btn-icon-amount').html(notifications.length);
        $('.notifications-list').html(content);
    }

    // call function setNotification every 15 seconds
    if (Cookies.get("access_token") != null) {
        handleCartNotification()
        setNotification();
        setInterval(async () => {
            setNotification();
        }, 15000);
    }
})