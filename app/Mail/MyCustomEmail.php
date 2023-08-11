<?php

namespace App\Mail;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MyCustomEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $senderEmail;
    public $recipientEmail;
	 
	  public function __construct($senderEmail, $recipientEmail)
    {
        $this->senderEmail = $senderEmail;
        $this->recipientEmail = $recipientEmail;
    }
	 
    public function build()
    {
        $mail = new PHPMailer(true);


        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.example.com'; // Your SMTP host
            $mail->SMTPAuth = true;
            $mail->Username = 'quiz@quizbooking.co.uk'; // Your SMTP username
            $mail->Password = 'SyqMr$4%Tuwu6z3d'; // Your SMTP password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 465;

            //Recipients
			$mail->setFrom($this->senderEmail, 'Your Name');
            $mail->addAddress($this->recipientEmail, 'Recipient Name');
			
            
            //Content
            $mail->isHTML(true);
			$data = DB::table('confirmation')->select('*')->first();
           $data = DB::table('confirmation')
            ->select('*')
            ->first();
       
            $mail->Subject = $data->subject;
            $mail->Body    = $data->content;

           // $mail->send();
              if( !$mail->send() ) {
                return back()->with("failed", "Email not sent.")->withErrors($mail->ErrorInfo);
            }
            
            else {
                return back()->with("success", "Email has been sent.");
            }
			die;
            // You can return a view to be used as the email body
            // return $this->view('emails.test.testmail');
        } catch (Exception $e) {
            // Handle exceptions
            return response()->json(['error' => 'Message could not be sent.']);
        }
    }
}


