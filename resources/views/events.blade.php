<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout.head')
    <title>Events | Somerset Smartphone Quizzes</title>
</head>

<body>
    @include('layout.nav', ['status' => 'events'])
    
    <div class="text-center pt-4">
        <h4 class="mb-3">Events</h4>
    </div>
    <div class="container">
        <hr />
        
        <a class="btn btn-primary save-btn" role="button">Save</a>&nbsp;&nbsp;&nbsp;&nbsp;
        <hr />
        <div class="row">
            <div class="col-md-6">
                <div class="mb-4">
                    <label class="form-label" for="webhook_url">Webhook URL</label>
                    <input type="text" id="webhook_url" class="form-control form-control-lg" />
                </div>
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
        $(document).ready(function() {
            function getData()
            {
                $.get(
                    "/webhook/get",{}, function(res){
                        console.log(res);
                        if (res) {
                            $('#webhook_url').val(res?.webhook_url);
                        }
                    },'json'
                )
            }
            getData();
            $(".save-btn").click(function(){
                var webhook_url = $('#webhook_url').val();
                $.get(
                    "/webhook/save",
                    {
                        webhook_url: webhook_url
                    }, function(res) {
                        
                    }
                )
            });
        });
    </script>
</body>

</html>