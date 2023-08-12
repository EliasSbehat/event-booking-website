<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout.head')
    <title>Settings | Somerset Smartphone Quizzes</title>
</head>

<body>
    @include('layout.nav', ['status' => 'settings'])
    
    <div class="text-center pt-4">
        <h4 class="mb-3">Settings</h4>
    </div>
    <div class="container">
        <hr />
        
        <a class="btn btn-primary save-btn" role="button">Save</a>&nbsp;&nbsp;&nbsp;&nbsp;
        <button type="button" class="btn btn-primary" data-mdb-toggle="modal" data-mdb-target="#pwd_modal">
            Password Setting
        </button>
        <div class="modal fade" id="pwd_modal" tabindex="-1" aria-labelledby="requestLabels" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="requestLabels">Set Password</h5>
                        <!-- <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button> -->
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="mb-4">
                                <label class="form-label" for="password">Password</label>
                                <input
                                    type="text"
                                    class="form-control form-control-lg w-50"
                                    id="password"
                                    name="password"
                                />
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="password">Confirm Password</label>
                                <input
                                    type="password"
                                    class="form-control form-control-lg w-50"
                                    id="confirm_password"
                                    name="password"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary cancel_btn">Cancel</button>
                        <!-- <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Cancel</button> -->
                        <button type="button" class="btn btn-primary submit-btn">Save</button>
                    </div>
                </div>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-md-6">
                <div class="mb-4">
                    <label class="form-label" for="website_title">Website Title</label>
                    <input type="text" id="website_title" class="form-control form-control-lg" />
                    <input type="hidden" id="setting_id" />
                </div>
                <div class="mb-4">
                    <label class="form-label" for="website_email">Website Email</label>
                    <input type="email" id="website_email" class="form-control form-control-lg" />
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="customFile">Website Image</label>
                <input type="file" class="form-control form-control-lg w-50" id="customFile" />
                <div class="mt-4" id="img_preview_box">
                    <img src="" id="img_preview" alt="not selected" width='300'></img>
                    <button type="button" class="btn btn-secondary d-none delete-img-btn"><i class="fas fa-trash-can"></i></button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="mb-4 col-md-6">
                <label class="form-label" for="stripe_pub_key">Stripe Publishable Key</label>
                <input type="text" id="stripe_pub_key" class="form-control form-control-lg" />
            </div>
        </div>
        <div class="row">
            <div class="mb-4 col-md-6">
                <label class="form-label" for="stripe_secret_key">Stripe Secret Key</label>
                <input type="text" id="stripe_secret_key" class="form-control form-control-lg" />
            </div>
        </div>
    </div>

    <script>
        if (sessionStorage.getItem('auth')!='true') {
            let password = prompt("Please enter your password:");
            $.get(
                "/getpwd",{
                    password: password
                }, function(res){
                    if (res === "success") {
                        // return true;
                        sessionStorage.setItem('auth', 'true');
                    } else {
                        window.location.href="./";
                    }
                }
            )
        }
        $('.submit-btn').click(function(){
            if ($("#password").val()==$("#confirm_password").val()) {
                $.get(
                    "/pwdset",
                    {
                        password: $("#password").val()
                    }, function() {
                        window.location.reload();
                    }
                )
            } else {
                alert("please confirm the password.");
            }
        });
        $(document).ready(function() {
            function getSetting()
            {
                $.get(
                    "/settings/get",{}, function(res){
                        console.log(res);
                        if (res) {
                            $('#website_title').val(res?.website_title);
                            $('title').text('Settings | ' + res?.website_title);
                            $('#website_email').val(res?.website_email);
                            $('#stripe_pub_key').val(res?.stripe_public_key);
                            $('#stripe_secret_key').val(res?.stripe_secret_key);
                            $("#img_preview").attr('src', './uploads/website/'+res?.website_image);
                            $(".delete-img-btn").removeClass("d-none");
                            $('#setting_id').val(res?.id);
                        }
                    },'json'
                )
            }
            getSetting();
            $(".save-btn").click(function(){
                const formData = new FormData();
                formData.append('website_title', $('#website_title').val());
                formData.append('website_email', $('#website_email').val());
                formData.append('stripe_pub_key', $('#stripe_pub_key').val());
                formData.append('stripe_secret_key', $('#stripe_secret_key').val());
                formData.append('id', $('#setting_id').val());
                
                formData.append('image', $('#customFile')[0].files[0]);
                $.ajax({
                    url: '/settings/add',
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response == "success") {
                            window.location.reload();
                        }
                    }
                });
            });
            $('#customFile').on('change', handleFileSelect);
            function handleFileSelect(event) {
                const file = event.target.files[0];
                const reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function() {
                    $("#img_preview").attr('src', reader.result);
                    $(".delete-img-btn").removeClass("d-none");
                }
            }
            $(".delete-img-btn").click(function() {
                $("#img_preview").attr('src', "");
                $(".delete-img-btn").addClass("d-none");
            });
        });
    </script>
</body>

</html>