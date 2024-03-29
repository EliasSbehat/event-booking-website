<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout.head')
    <title>Email Template | Somerset Smartphone Quizzes</title>
    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
</head>

<body>
    @include('layout.nav', ['status' => 'confirmation'])
    
    <div class="text-center pt-4">
        <h4 class="mb-3">Email Template</h4>
    </div>
    <div class="container">
        <hr />
        
        <a class="btn btn-primary save-btn" role="button">Save</a>
        <hr />
        <div class="mb-4">
            <label class="form-label" for="subject">Subject</label>
            <input type="text" id="subject" class="form-control form-control-lg" />
        </div>
        <div id="summernote"></div>
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
        $.get(
            "/settings/get",{}, function(res){
                if (res) {
                    $('title').text('Email Template | ' + res?.website_title);
                }
            },'json'
        )
        $(document).ready(function() {
            function getConfirmation() {
                $.get(
                    "/confirmationmng/getConfirmation",
                    {}, function(res) {
                        if (res) {
                            $("#subject").val(res?.subject);
                            $('#summernote').summernote('code', res?.content);
                        }
                    }, 'json'
                );
            }
            getConfirmation();
            $('#summernote').summernote({
                placeholder: '',
                tabsize: 2,
                height: 250,
                toolbar: [
                ['font', ['bold', 'underline', 'clear']],
                ['para', ['ul', 'ol']],
                ['insert', ['link', 'video']],
                ]
            });
            $(".save-btn").click(function(){
                var subject = $("#subject").val();
                var content = $('#summernote').summernote('code');
                $.post(
                    "/confirmationmng/saveConfirmation",
                    {
                        subject: subject,
                        content: content
                    }, function(res) {
                        if (res==="success") {
                            alert("saved");
                        }
                    }
                );
            });
        });
    </script>
</body>

</html>