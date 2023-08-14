<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout.head')
    <title>Lists | Somerset Smartphone Quizzes</title>
    <!-- include summernote css/js -->
</head>

<body>
    <div class="text-center pt-4">
        <!-- <h4 class="mb-3">Lists</h4> -->
    </div>
    <div class="container-md">
        <div style="display:flex; justify-content: center;">
            <img src="" alt="No set website image" class="website_image" style="object-fit: contain;" />
        </div>
        <table class="table table-bordered event-tbl">
            <tbody id="event_tbody">
                <tr>
                    <td>There are no events currently scheduled</td>
                </tr>
            </tbody>
        </table>
    </div>

    <script>
        $.get(
            "/settings/get",{}, function(res){
                if (res) {
                    $('title').text('Lists | ' + res?.website_title);
                    $('.website_image').attr('src', '/uploads/website/'+res?.website_image);
                }
            },'json'
        )
        function getData() {
            $.get(
                "/eventmng/getData",
                {}, function(res) {
                    if (res) {
                        var eventHTML = "";
                        for (var i=0; i<res.length; i++) {
                            var date = moment(res[i]['start_date_time']);
                            const formattedDate = date.format("dddd Do [of] MMMM YYYY [at] HH:mm");
                            eventHTML += `<tr>
                                <td>
                                    <b>${formattedDate}</b>
                                    <br>
                                    <h3 style="color:#77A659;">${res[i]['title']}</h3>
                                    <span>${res[i]['location']}</span> <br>
                                    <div class="mb-4 lists-description" style="display: flex;gap: 2rem;">
                                        <img src="./uploads/${res[i]['image']}" width="200" style="object-fit: contain;" />
                                        <div>${res[i]['description']}</div>
                                    </div>
                                    <div class="d-flex" style="gap: 1rem;">
                                        <a href="/buy/${res[i]['id']}" class="btn btn-primary buy-btn" role="button">Buy ticket</a>
                                        <div style="align-items: center; display: flex;">Available tickets: ${res[i]['total_ticket']}</div>
                                    </div>
                                </td>
                            </tr>`;
                        }
                        if (res.length>0) {
                            $("#event_tbody").html(eventHTML);
                        }
                    }
                }, 'json'
            );
        }
        getData();
    </script>
</body>

</html>