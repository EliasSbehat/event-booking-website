<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout.head')
    <title>Details | Somerset Smartphone Quizzes</title>
</head>

<body>
    @include('layout.nav', ['status' => 'details'])
    
    <div class="text-center pt-4">
        <h4 class="mb-3">Details</h4>
    </div>
    <div class="container">
        <!-- Modal -->
        <div class="modal fade" id="add_list" tabindex="-1" aria-labelledby="requestLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="requestLabel">Add Event</h5>
                        <!-- <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button> -->
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="mb-4 col-md-6">
                                <label class="form-label" for="start-date-time">Start date time</label>
                                <input
                                    type="datetime-local"
                                    class="form-control form-control-lg w-50"
                                    id="start-date-time"
                                    name="start-date-time"
                                />
                                <input type="hidden" id="event_id" />
                            </div>
                            <div class="mb-4 col-md-6">
                                <label class="form-label" for="description">Description</label>
                                <textarea type="text" id="description" class="form-control form-control-lg" rows='3'></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label" for="title">Event Title</label>
                                    <input type="text" id="title" class="form-control form-control-lg" />
                                </div>
                                <div class="mb-4">
                                    <label class="form-label" for="location">Location</label>
                                    <input type="text" id="location" class="form-control form-control-lg" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="customFile">Image</label>
                                <input type="file" class="form-control form-control-lg w-50" id="customFile" />
                                <div class="mt-4" id="img_preview_box">
                                    <img src="" id="img_preview" alt="not selected" width='300'></img>
                                    <button type="button" class="btn btn-secondary d-none delete-img-btn"><i class="fas fa-trash-can"></i></button>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="mt-4 mb-4 p-5 bg-primary text-white rounded">
                            <h3>Price and Recurring</h3>
                            <p>You can add different prices for the event. Just click on ADD button and enter new price. You can also set number of available tickets for each group price (e.g. Adult tickets, Children tickets, ...). Also set if the event is recurring or not.</p>
                        </div> -->
                        <a class="btn btn-primary add-btn" role="button">Add</a>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Price</th>
                                    <th>Available tickets</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody id="price_tbody">

                            </tbody>
                        </table>
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
        
        <a class="btn btn-primary add-event-btn" role="button" data-mdb-toggle="modal" data-mdb-target="#add_list">Add</a>
        <hr />
        <table id="table_id" class="display mt-4">
            <thead>
                <tr>
                    <th>Event Title</th>
                    <th>Event Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="event_tbl">
            </tbody>
        </table>
    </div>
    <!-- Start wrapper-->


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
        $(".submit-btn").click(function(){
            addEvent();
        });
        function formatDate(dateString) {
            var date = moment(dateString);
            const formattedDate = date.format("dddd Do [of] MMMM YYYY [at] HH:mm");
            return formattedDate;
        }
        function addEvent() {
            const formData = new FormData();
            formData.append('start_date_time', $('input[name="start-date-time"]').val());
            formData.append('description', $('#description').val());
            formData.append('id', $('#event_id').val());
            formData.append('title', $('#title').val());
            formData.append('location', $('#location').val());
            formData.append('image', $('#customFile')[0].files[0]);
            var price_trs = $('#price_tbody').children();
            var price_ary = [];
            for (var i = 0; i < price_trs.length; i++) {
                var tr = price_trs[i];
                var type_td = $(tr).children()[0];
                var price_td = $(tr).children()[1];
                var ticket_td = $(tr).children()[2];
                var type = $(type_td).find('input').val();
                var price = $(price_td).find('input').val();
                var ticket = $(ticket_td).find('input').val();
                var obj = {
                    type: type,
                    price: price,
                    ticket: ticket
                }
                price_ary.push(obj);
            }
            formData.append('price_data', JSON.stringify(price_ary));
            $.ajax({
                url: '/eventmng/add',
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
        }
        $(document).on("click", ".delete-btn", function(){
            var id = $(this).attr("id");
            $.get(
                "/eventmng/delete-event",
                {
                    id, id
                }, function() {
                    window.location.reload();
                }
            );
        });
        $(document).on("click", ".edit-btn", function(){
            var id = $(this).attr("id");
            $('#add_list').modal('show');
            $("#event_id").val(id);
            $("#requestLabel").html("Edit Event");
            $.get(
                "/eventmng/getForEdit", {
                    event_id: id
                }, function(res) {
                    console.log(res);
                    $("#start-date-time").val(res[0][0]['start_date_time']);
                    $("#description").val(res[0][0]['description']);
                    $("#title").val(res[0][0]['title']);
                    $("#location").val(res[0][0]['location']);
                    $("#img_preview").attr('src', './uploads/'+res[0][0]['image']);
                    $(".delete-img-btn").removeClass("d-none");
                    for (var i=0; i<res[1].length; i++) {
                        var tr = `
                        <tr>
                            <td><input type="text" class="form-control" value="${res[1][i]['type']}" /></td>
                            <td>
                                <div class="input-group flex-nowrap">
                                    <input type="text" class="form-control" aria-describedby="addon-wrapping" value="${res[1][i]['price']}" />
                                    <span class="input-group-text" id="addon-wrapping">£</span>
                                </div>
                            </td>
                            <td><input type="number" class="form-control" value="${res[1][i]['ticket']}" /></td>
                            <td><button type="button" class="btn btn-secondary delete-row-btn"><i class="fas fa-trash-can"></i></button></td>
                        </tr>
                        `;
                        $("#price_tbody").append(tr);
                    }
                }, 'json'
            )
        });
        $(".cancel_btn").click(function(){
            window.location.reload();
        });
        function getEvents() {
            $('#table_id').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "type": "GET",
                    "url": "/eventmng/getMS",
                    "dataType": "json",
                    "contentType": 'application/json; charset=utf-8',
                },
                "lengthMenu": [
                    15, 50, 100
                ],
                "columns": [
                    { data: 'title', name: 'title' },
                    { data: 'start_date_time', name: 'start_date_time', render: function(data, type, row) {
                        return formatDate(data); // Format the date
                    }},
                    { data: 'action', name: 'action' },
                ]
            });
        }
        getEvents();
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
        $(".add-btn").click(function() {
            var tr = `
            <tr>
                <td><input type="text" class="form-control" /></td>
                <td>
                    <div class="input-group flex-nowrap">
                        <input type="text" class="form-control" aria-describedby="addon-wrapping" />
                        <span class="input-group-text" id="addon-wrapping">£</span>
                    </div>
                </td>
                <td><input type="number" class="form-control" /></td>
                <td><button type="button" class="btn btn-secondary delete-row-btn"><i class="fas fa-trash-can"></i></button></td>
            </tr>
            `;
            $("#price_tbody").append(tr);
        });
        
        $(document).on('click', '.delete-row-btn', function(){
            $(this).parent().parent().remove();
        });
    </script>
</body>

</html>