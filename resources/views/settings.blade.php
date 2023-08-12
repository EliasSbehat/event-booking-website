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
                </div>
                <div class="mb-4">
                    <label class="form-label" for="website_email">Website Email</label>
                    <input type="text" id="website_email" class="form-control form-control-lg" />
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
                <label class="form-label" for="stripe_secret_ket">Stripe Secret Key</label>
                <input type="text" id="stripe_secret_ket" class="form-control form-control-lg" />
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
            $(".save-btn").click(function(){
                
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