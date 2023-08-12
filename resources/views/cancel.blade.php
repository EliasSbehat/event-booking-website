<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout.head')
    <title>Cancelled! | Somerset Smartphone Quizzes</title>
    <!-- include summernote css/js -->
</head>

<body>
    <div class="text-center pt-4">
        <!-- <h4 class="mb-3">Lists</h4> -->
    </div>
    <div class="container-md">
        <table class="table table-bordered event-tbl">
            <tbody id="event_tbody">
                <tr>
                    <td>Payment Cancelled Successfully!</td>
                </tr>
            </tbody>
        </table>
    </div>
    <script>
        $.get(
            "/settings/get",{}, function(res){
                if (res) {
                    $('title').text('Cancelled! | ' + res?.website_title);
                }
            },'json'
        )
        setTimeout(() => {
            window.location.href="/";
        }, 10000);
    </script>
  
</body>

</html>