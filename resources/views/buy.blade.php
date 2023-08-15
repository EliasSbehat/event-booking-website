<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout.head')
    <title>Buy Tickets | Somerset Smartphone Quizzes</title>
    <!-- include summernote css/js -->
</head>
    <script src="https://js.stripe.com/v3/"></script>
<body>
    <div class="text-center pt-4">
        <!-- <h4 class="mb-3">Lists</h4> -->
    </div>
    <div class="container-md">
        <p><a href="/"><b><</b> Back to list</a></p>
        <form name="scheckout" id="scheckout" action="/create-checkout-session" method="POST">

            <h4>Event Details</h4>
            <div id="event_details">
                <!-- <h3 style="color:#77A659;" class="title"></h3>
                <p class="date"></p> -->
            </div>
            <img src="" alt="" class="img-src">
            <h4>Choose Tickets To Purchase</h4>
            <div class="prices">
                
            </div>
            <div>
                <p class="d-none">Price £<span class="price">0.00</span></p>
                <p class="d-none">Tax £0.00</p>
                <p>Total price £<span class="total_price">0.00</span></p>
                <p class="d-none">Deposit £<span class="deposit">0.00</span></p>
            </div>
            <h4>Your Details</h4>
            
            
            
            <input type="hidden" id="event_id" name="event_id" value="{{$event_id}}" />
            <input type="hidden" class="deposit_input" id="deposit_input" name="deposit_input" value="" />
            <input type="hidden" class="title_value" id="title_value" name="title_value" value="" />
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-4">
                        <label class="form-label" for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control" required />
                    </div>
                
                </div>
                <div class="col-md-6">
                    <div class="mb-4">
                        <label class="form-label" for="name">Name</label>
                        <input type="text" id="name" name="name" class="form-control" required />
                    </div>
                </div>
                <!-- <div class="mb-4">
                    <label class="form-label" for="name">Payment method</label>
                    <select class="form-control" id="">
                        <option value="">Credit / Debit Card</option>
                    </select>
                </div> -->
                <div class="d-flex" style="gap:2rem; margin-top: 2rem;margin-bottom: 4rem;">
                    <!--<button type="button" class="btn btn-primary submit-btn">Submit</button>-->
                    <input type="button" class="btn btn-primary-stripe submit-btn" value="Submit">
                    <button type="button" class="btn btn-secondary cancel_btn">Cancel</button>
                </div>
            </div>
            @csrf
		</form>
    </div>

    <script>
        $.get(
            "/settings/get",{}, function(res){
                if (res) {
                    $('title').text('Buy Tickets | ' + res?.website_title);
                }
            },'json'
        )
        function formatCurrency(number) {
            var formattedNumber = parseFloat(number).toFixed(2);
            return formattedNumber;
        }
        function getData() {
            $.get(
                "/eventmng/getForEdit", {
                    event_id: $('#event_id').val()
                }, function(res) {
                    console.log(res);
                    var date = moment(res[0][0]['start_date_time']);
                    const formattedDate = date.format("dddd Do [of] MMMM YYYY [at] HH:mm");
                    var event_detail_html = `<b>${formattedDate}</b>
                        <br><h3 style="color:#77A659;">${res[0][0]['title']}</h3>
                        <span style="font-weight: 700;">${res[0][0]['location']}</span> <br>
                        <div class="lists-description" style="display: flex;gap: 2rem; padding-top: 1.5rem;">
                            <img src="../uploads/${res[0][0]['image']}" width="200" style="object-fit: contain;" />
                            <div>${res[0][0]['description']}</div>
                        </div>`;
                    // $(".title").html(res[0][0]['title']);
                    $(".title_value").val(res[0][0]['title']);
                    $('#event_details').html(event_detail_html);
                    // $(".date").html(formattedDate);
                    for (var i=0; i<res[1].length; i++) {
                        $('.prices').append(`
                                <div>
                                <label class="form-label">${res[1][i]['type']}</label><br>
								<input type="hidden" name="event_type[]" value="${res[1][i]['type']}">
                                <div class="input-group flex-nowrap w-50">
                                    <input type="text" name="event_type_value[]" required id="pr" pid="${res[1][i]['price']}" tid="${res[1][i]['ticket']}" class="form-control" aria-describedby="addon-wrapping" value=0 />
                                    <span class="input-group-text" id="addon-wrapping">x £ ${ formatCurrency(res[1][i]['price']) }</span>
                                </div><br></div>`);
                    }
                }, 'json'
            )
        }
        
        getData();
        $(document).on('change', '#pr', function(){
            var prices = $('.prices').children();
            var total_price = 0;
            for (var i=0; i<prices.length; i++) {
                var prs = prices[i];
                var pr = $(prs).find('#pr').attr('pid');
                var tqr = $(prs).find('#pr').attr('tid');
                var quantity = $(prs).find('#pr').val();
                if ((tqr*1) < (quantity*1)) {
                    alert('Please try reducing the number of tickets');
                    $(prs).find('#pr').val(0);
                } else {
                    total_price += (pr*quantity);
                }
            }
            $(".price").html(total_price);
            $(".total_price").html(formatCurrency(total_price));
            $(".deposit").html(total_price);
            $(".deposit_input").val(total_price);
        });
        $('.cancel_btn').click(function(){
            window.location.href = "/";
        });
        $('.submit-btn').click(function(){
            var price = $(".deposit_input").val();
            var email = $('#email').val();
            var name = $('#name').val();
            // localStorage.setItem('price', price);
            // localStorage.setItem('email', email);
            // localStorage.setItem('name', name);
            // localStorage.setItem('event_id', $('#event_id').val());
            if (email=="" || name=="" || price=='') {
                alert("Please fill the all fields.");
            } else {
                $("#scheckout").submit();
            }

        });
    </script>
</body>

</html>