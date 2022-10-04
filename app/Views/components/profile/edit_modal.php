<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php 
                use Firebase\JWT\JWT;
                $key = getenv('TOKEN_SECRET');

                if(get_cookie("access_token")){
                    $token = get_cookie("access_token");
                    $decoded = JWT::decode($token, $key, ['HS256']);
                }
                ?>
                <form action="<?= base_url('/api/users/update/'.$decoded->uid); ?>" id="edit"
                    class=" form d-flex flex-column">
                </form>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('document').ready(async function () {
        $.ajax({
            type: "GET",
            url: "/api/users/jobs",
            contentType: "application/json",
            headers: {
                "Authorization": "Bearer " + Cookies.get("access_token"),
                "Content-Type": "application/json"
            },
            success: function (data) {
                var resources = data
                    .sort((a, b) => a.job_id - b.job_id)
                    .map(({
                        job_id,
                        job_name,
                    }) => {
                        return (`
                                <option value="${job_id}">${job_name}</option>
                            `);
                    });

                $("select.form-select").html(resources);
            }
        });
    })
</script>
<<<<<<< HEAD
    $('document').ready(async function () {
        $.ajax({
            type: "GET",
            url: "/api/users/jobs",
            contentType: "application/json",
            headers: {
                "Authorization": "Bearer " + Cookies.get("access_token"),
                "Content-Type": "application/json"
            },
            success: function (data) {
                var resources = data
                    .sort((a, b) => a.job_id - b.job_id)
                    .map(({
                        job_id,
                        job_name,
                    }) => {
        contentType: "application/json",
        headers: {
            "Authorization": "Bearer " + Cookies.get("access_token"),
            "Content-Type": "application/json"
        },
        success: function (data) {
            $.ajax({
                type: "GET",
                url: "/api/users/jobs",
                contentType: "application/json",
                headers: {
                    "Authorization": "Bearer " + Cookies.get("access_token"),
                    "Content-Type": "application/json"
