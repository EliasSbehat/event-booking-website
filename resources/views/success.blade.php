<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout.head')
    <title>Success! | Somerset Smartphone Quizzes</title>
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
                    <td>Booking Successful! Wait for 10 seconds before redirecting.</td>
                </tr>
            </tbody>
        </table>
    </div>
    <script>
        setTimeout(() => {
            window.location.href="/";
        }, 3000);
    </script>
  
</body>

</html>