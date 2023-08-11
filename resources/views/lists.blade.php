<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout.head')
    <title>Lists</title>
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
                    <td>There are no events currently scheduled</td>
                </tr>
            </tbody>
        </table>
    </div>

    <script>
        function getData() {
            $.get(
                "/eventmng/getData",
                {}, function(res) {
                    if (res) {
                        var eventHTML = "";
                        for (var i=0; i<res.length; i++) {
                            eventHTML += `<tr>
                                <td>
                                    <b>${res[i]['start_date_time']}</b>
                                    <br>
                                    <h3 style="color:#77A659;">${res[i]['title']}</h3>
                                    <span>${res[i]['location']}</span> <br>
                                    <p style="color:#77A659;">Themed Quizzes</p>
                                    <div class="mb-4" style="display: flex;gap: 2rem;">
                                        <img src="./uploads/${res[i]['image']}" width="200" />
                                        <div>${res[i]['description']}</div>
                                    </div>
                                    <div class="d-flex" style="gap: 1rem;">
                                        <a href="/buy/${res[i]['id']}" class="btn btn-primary buy-btn" role="button">Buy ticket</a>
                                        <div style="align-items: center; display: flex;">Available tickets: ${res[i]['total_ticket']}</div>
                                    </div>
                                </td>
                            </tr>`;
                        }
                        $("#event_tbody").html(eventHTML);
                    }
                }, 'json'
            );
        }
        getData();
    </script>
</body>

</html>