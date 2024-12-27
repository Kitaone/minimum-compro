<?php
namespace App\Http\Controllers;
use Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Session;
class ContentController extends Controller
{
    // public function __construct()
    // {
    // }
    public function homepage()
    {
        return response()->view('content.home');
    }
    public function sendEmail(Request $request)
    {
        $input = $request->all();
        $request->validate([
            'email' => 'required|email',
            'phone' => 'required',
            'message' => 'required',
        ]);
        $email = $input['email'];
        $phone = $input['phone'];
        $message = $input['message'];
        $ccEmails = explode(',', env('MAIL_CC'));
        // Create a new PHPMailer instance
        $mail = new PHPMailer(true);
        $mail->CharSet = "UTF-8";
        // Server settings
        $mail->isSMTP();
        $mail->SMTPSecure = 'ssl';
        //hostname masing-masing provider email
        $mail->Host = env('MAIL_HOST'); 
        $mail->SMTPDebug = 2;
        $mail->Port = env('MAIL_PORT');
        $mail->SMTPAuth = true;
        // timeout pengiriman (dalam detik)
        $mail->Timeout = 60; 
        $mail->SMTPKeepAlive = true;
        $mail->Username = env('MAIL_USERNAME'); // SMTP username
        $mail->Password = env('MAIL_PASSWORD'); // SMTP password
        // Recipients
        $mail->setFrom($email, 'Contact Form');
        $mail->addAddress(env('MAIL_FROM_ADDRESS'), 'Kita Tech Solution'); // Main recipient
        // CC recipient
        foreach ($ccEmails as $ccEmail) {
            $mail->addCC(trim($ccEmail));
        }
        $mail->addBCC(env('MAIL_BCC')); // BCC recipient
        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = 'New Contact Form KITA Tech Solution';
        $mail->Body = "
        <h4>Contact Form Kita Tech Solution</h4>
        <p><strong>Email:</strong> {$email}</p>
        <p><strong>Phone:</strong> {$phone}</p>
        <p><strong>Message:</strong> {$message}</p>
        ";
        $mail->send();
        return response()->json(['success' => true, 'message' => 'Email has been sent.']);
    }
    public function about()
    {
        return response()->view('content.about');
    }
    public function client()
    {
        return response()->view('content.client');
    }
    public function contact()
    {
        return response()->view('content.contact');
    }
    /**
     * Search method handler to handling search
     * request and it also check session to define
     * which languange should be displayed on the result
     *
     * @access public
     * @return
     */
    public function search()
    {
        return response()->view('content.search');
    }
}