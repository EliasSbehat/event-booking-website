<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Mail\MyCustomEmail;
use Illuminate\Support\Facades\Mail;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Stripe;
use Carbon\Carbon;

class StripePaymentController extends Controller

{

    /**

     * success response method.

     *

     * @return \Illuminate\Http\Response

     */

    public function stripe()
    {

        return view('stripe');

    }
	public function confirmation_email($recipientEmail, $RecipientName, $event_id, $order_id)
    {
     
        $senderEmail = 'quiz@quizbooking.co.uk';
        //require_once base_path("vendor/autoload.php");
        $mail = new PHPMailer(true);
        try {
            //Server settings
            //$mail->SMTPDebug = 4; // Enable verbose debug output
            $mail->isSMTP();
            $mail->Host = 'quizbooking.co.uk'; // Your SMTP host
            $mail->SMTPAuth = true;
            $mail->Username = 'quiz@quizbooking.co.uk'; // Your SMTP username
            $mail->Password = 'SyqMr$4%Tuwu6z3d'; // Your SMTP password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            //Recipients
            $mail->setFrom($senderEmail, 'Somerset Smartphone Quizzes');
            $mail->addAddress($recipientEmail, $RecipientName);
            
            
            //Content
            $mail->isHTML(true);
            $data = DB::table('confirmation')->select('*')->first();
            $data = DB::table('confirmation')
                ->select('*')
                ->first();
            $eventData = DB::table('events')
                ->select('*')
                ->where('id', $event_id)
                ->first();
            $orderData = DB::table('bookings')
                ->select("*")
                ->where('OrderID', $order_id)
                ->first();
            
            $subject = $data->subject;
            $content = $data->content;

            $date = Carbon::createFromFormat('Y-m-d H:i:s', $eventData->start_date_time);
            $formattedDate = $date->format('l jS \of F Y \a\t H:i');

            $subject = str_replace("{EventTitle}", $eventData->title, $subject);
            $subject = str_replace("{Name}", $orderData->Customer_name, $subject);
            $subject = str_replace("{EventDateTime}", $formattedDate, $subject);
            $subject = str_replace("{EventLocation}", $eventData->location, $subject);
            $subject = str_replace("{TotalPrice}", $orderData->Total, $subject);

            $eventHtml = '';
            $eventAry = json_decode($orderData->eventData);
            for ($i = 0; $i < count($eventAry); $i++) {
                $eventHtml .= '<span><small>' . $eventAry[$i]->event_type_value . ' x ' . $eventAry[$i]->event_type . '</small></span>&nbsp;&nbsp;&nbsp;';
                $eventHtml .= '<br>';
            }

            $content = str_replace("{EventTitle}", $eventData->title, $content);
            $content = str_replace("{Name}", $orderData->Customer_name, $content);
            $content = str_replace("{EventDateTime}", $formattedDate, $content);
            $content = str_replace("{EventLocation}", $eventData->location, $content);
            $content = str_replace("{TotalPrice}", $orderData->Total, $content);
            $content = str_replace("{TicketsPurchased}", $eventHtml, $content);
            
            $mail->Subject = $subject;
            $mail->Body    = $content;
            $mail->send();
            
            // You can return a view to be used as the email body
            // return $this->view('emails.test.testmail');
        } catch (Exception $e) {
            // Handle exceptions
        //return response()->json(['error' => 'Message could not be sent.'.$e->getMessage()]);
        }
    }
	public function success()
    {
        $stripe = new \Stripe\StripeClient('sk_test_51Nb0Q2ICth3bN2l6NST7mTH01Wuwr2b4nTMDwxk5rccuIO93YUaLD0ShdhCaS3FACVILXAvlubbk15ykYO4WtJac00UXf9f0it');
        try {
            $OrderID=$_GET['OrderID'];
            $session = $stripe->checkout->sessions->retrieve($_GET['session_id']);
            $email= $session->customer_details->email;
            $status=$session->status;
            DB::table('bookings')->where('OrderID', $OrderID)->update([
                'status' => $status
            ]);
        
            $recipientEmail = $email;
            $this->confirmation_email($recipientEmail, $_GET['name'], $_GET['event_id'], $OrderID);


            http_response_code(200);
        } catch (Error $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
        return view('success');

    }

	public function cancel()
    {
        $stripe = new \Stripe\StripeClient('sk_test_51Nb0Q2ICth3bN2l6NST7mTH01Wuwr2b4nTMDwxk5rccuIO93YUaLD0ShdhCaS3FACVILXAvlubbk15ykYO4WtJac00UXf9f0it');
        try {
            $OrderID=$_GET['OrderID'];
            $session = $stripe->checkout->sessions->retrieve($_GET['session_id']);
            $email= $_GET['email'];
            $status=$session->status;
            DB::table('bookings')->where('OrderID', $OrderID)->update([
                'status' => $status
            ]);
            http_response_code(200);
        } catch (Error $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
        return view('cancel');
    }

    public function stripePostCheckout(Request $request) {
        $title = $request->post('title_value');
        $name = $request->post('name');
        $email = $request->post('email');
        $deposit_input = $request->post('deposit_input');
        $event_id = $request->post('event_id');
        $event_types = $request->post('event_type');
        $event_type_values = $request->post('event_type_value');
        $OrderID = Str::random(30);
        
        foreach ($event_types as $key => $data) {
            $eventData[$key]["event_type"] = $data;
            $eventData[$key]["event_type_value"] = $event_type_values[$key];
        }
        
        $eventData = json_encode($eventData);
            
        DB::table('bookings')->insert([
            'OrderID' => $OrderID,
            'Customer_name' => $name,
            'Customer_email' => $email,
            'event_id' => $event_id,
            'title' => $title,
            'eventData' => $eventData,
            'Total' => $deposit_input,
        ]);
			 
        // require 'vendor/autoload.php';
        \Stripe\Stripe::setApiKey('sk_test_51Nb0Q2ICth3bN2l6NST7mTH01Wuwr2b4nTMDwxk5rccuIO93YUaLD0ShdhCaS3FACVILXAvlubbk15ykYO4WtJac00UXf9f0it');
        header('Content-Type: application/json');
        $YOUR_DOMAIN = 'https://quizbooking.co.uk';
        $checkout_session = \Stripe\Checkout\Session::create([
            /* 'line_items' => [[
                # TODO: replace this with the `price` of the product you want to sell
                'price' => '9',
                'quantity' => 1,
            ]], */
            'line_items' => [
                [   'quantity' => 1, 
                    'price_data' => [
                        'currency' => 'GBP', 
                        'product_data' => [ 
                            'name' => 'Stripe payment (Unique ID: '. $OrderID . ')' 
                        ],
                        'unit_amount' => $deposit_input*100,
                        
                    ],
                ],
            ],
            'payment_method_types' => [
                'card',
            ],

            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/success?OrderID='.$OrderID.'&session_id={CHECKOUT_SESSION_ID}&name='.$name.'&event_id='.$event_id,
            'cancel_url' => $YOUR_DOMAIN . '/cancel?OrderID='.$OrderID.'&session_id={CHECKOUT_SESSION_ID}&email='.$email,
        ]);
    
        header("HTTP/1.1 303 See Other");
        //header("Location: " . $checkout_session->url);
        return redirect()->to($checkout_session->url);
        //echo '<pre>'; print_r($checkout_session->url);
	}
  

    /**

     * success response method.

     *

     * @return \Illuminate\Http\Response

     */

    public function stripePost(Request $request)

    {

        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        Stripe\Charge::create ([

                "amount" => 100 * 100,

                "currency" => "usd",

                "source" => $request->stripeToken,

                "description" => "Test payment from itsolutionstuff.com." 

        ]);
        Session::flash('success', 'Payment successful!');

        return back();
    }

}