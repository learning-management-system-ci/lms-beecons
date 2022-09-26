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
                <form action="<?= base_url('/api/users/update/'.$decoded->uid); ?>" id="edit">
                </form>
                <script
                    src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js">
                </script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.min.js"></script>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
                <script type="text/javascript">
                    $(function () {
                        $('#datepicker').datepicker({
                            locale: 'id'
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $.ajax({
        type: "GET",
        url: "/api/profile",
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
            var resources = () => {
                return (`
                    <label for="email" class="form-label">Email</label>
                    <input type="text" id="email" value="${data.email}" class="form-control" disabled aria-describedby="passwordHelpBlock">
                    <label for="fullname" class="form-label">Nama Lengkap</label>
                    <input type="text" id="fullname" name="fullname" value="${data.fullname ? data.fullname : ""}" class="form-control" aria-describedby="passwordHelpBlock">
                    <label for="date" class="col-1 col-form-label">Date</label>
                    <div class="input-group date" id="datepicker">
                        <input type="text" class="form-control" id="date" name="date" value="${data.date_birth ? data.date_birth : ""}"/>
                        <span class="input-group-append">
                        <span class="input-group-text bg-light d-block">
                            <i class="fa fa-calendar"></i>
                        </span>
                        </span>
                    </div>
                    <label for="job" class="form-label">Pekerjaan</label>
                    <select class="form-select form-select-sm" id="job_id" aria-label=".form-select-sm example">
                        <option selected>Open this select menu</option>    
                    </select> 
                    <label for="address" class="form-label">Alamat</label>
                    <textarea class="form-control expand" name="address" rows="1" value="${data.address ? data.address : ""}" id="address" required></textarea>
                    <label for="phone_number" class="form-label">Nomor HP</label> 
                    <input type="text" id="phone_number" name="phone_number" value="${data.phone_number ? data.phone_number : ""}" class="form-control" aria-describedby ="passwordHelpBlock" >    
                    <label for="linkedin" class="form-label">LinkedIn</label> 
                    <input type="text" id="linkedin" name="linkedin" value="${data.linkedin ? data.linkedin : ""}" class="form-control" aria-describedby="passwordHelpBlock">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                `);
            };

            $("form#edit").html(resources);
        }
    });

    $("#edit").submit(function (event) {
        // Stop form from submitting normally
        event.preventDefault();

        // Get some values from elements on the page:
        var $form = $(this),
            csrf_test_name_passed = $form.find("input[name='csrf_test_name']").val(),
            name_passed = $form.find("input[name='fullname']").val(),
            address_passed = $form.find("input[name='address']").val(),
            phone_number_passed = $form.find("input[name='phone_number']").val(),
            linkedin_passed = $form.find("input[name='linkedin']").val(),
            url = $form.attr("action");
        job_passed = $('#job_id').attr('selected', 'selected');

        $.ajax({
            type: "PUT",
            url: url,
            data: {
                name: name_passed,
                address: address_passed,
                phone_number: phone_number_passed,
                linkedin: linkedin_passed,
                job_id: job_passed,
            },
            success: function () {
                window.location.reload();
            },
            error: function (data, status) {
                console.log(data, status)
            }
        });
    });
</script>