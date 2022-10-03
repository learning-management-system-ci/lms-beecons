// function NotificationService () 
// {
//     // call function getNotification every 30 seconds and set notification
//     setInterval(async () => {
//         let notification = await getNotification();
//         setNotification(notification);
//     }
//     , 30000);
// }

function getNotification()
{
    try 
    {
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
    catch (error) 
    {
        console.log(error)
    }
}

async function setNotification() 
{
    const { id, notification:notifications } = await getNotification();

    let content = '';
    notifications.forEach(notification => {
        const {message, created_at} = notification;
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

    $('.notifications-list').html(content);
}

// call function setNotification every 15 seconds
setInterval(async () => {
    setNotification();
}, 15000);

