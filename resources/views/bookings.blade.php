<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout.head')
    <title>Bookings | Somerset Smartphone Quizzes</title>
</head>

<body>
    @include('layout.nav', ['status' => 'bookings'])
    
    <div class="text-center pt-4">
        <h4 class="mb-3">Bookings</h4>
    </div>
    <div class="container">
   
        
        
        
        <table id="Bookingstable_id" class="display mt-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Event Title</th>
                    <th>Date</th>
                    <th>Tickets</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="event_tbl">
            </tbody>
        </table>
    </div>
    <!-- Start wrapper-->


    <script>
  
		function formatDate(dateString) {
            var date = moment(dateString);
            const formattedDate = date.format("dddd Do [of] MMMM YYYY [at] HH:mm");
            return formattedDate;
        }
        function getBookings() {
            $('#Bookingstable_id').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "type": "GET",
                    "url": "/bookingmng/getBK",
                    "dataType": "json",
                    "contentType": 'application/json; charset=utf-8',
                },
                "lengthMenu": [
                    15, 50, 100
                ],
                "columns": [
                    { data: 'OrderID', name: 'OrderID' },
                    { data: 'Customer_name', name: 'Customer_name' },
                    { data: 'title', name: 'title' },
                    { 
                        data: 'created_at',
                        name: 'created_at',
                        render: function(data, type, row) {
                            return formatDate(data); // Format the date
                        }
                    },
                    { 
                        data: 'eventDatab',
                        name: 'eventData',
                        render: function(eventDatab, type, row) {
                        // var eventArray = JSON.parse(eventData);
                            var eventArray = eventDatab;
                            var eventHtml = '';
                            
                            for (var i = 0; i < eventArray.length; i++) {
                                eventHtml += '<span><small>' + eventArray[i].event_type_value + 'x' + eventArray[i].event_type + '</small></span>';
                                eventHtml += '<br>';
                            }
                            
                            return eventHtml;
                        }
                    },
                    { 
                        data: 'Total',
                        name: 'Total',
                        render: function(data, type, row) {
                            return '£' + data;
                        }
                    },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action' , visible: false },
                ]
            });
        }

        getBookings();
    </script>
</body>

</html>