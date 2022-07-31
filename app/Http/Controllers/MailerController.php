<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailerController extends Controller
{
    //
    // =============== [ Email ] ===================
    public function email() {
        return view("email");
    }
    public function composeEmail(Request $request) {
        require base_path("vendor/autoload.php");
        $mail = new PHPMailer(true);     // Passing `true` enables exceptions

        try {

            // Email server settings
            $mail->SMTPDebug = 2;
            $mail->isSMTP();
            $mail->Host = 'tsi-acsi.com.ph';             //  smtp host
            $mail->SMTPAuth = true;
            $mail->Username = 'mailer@tsi-acsi.com.ph';   //  sender username
            $mail->Password = 'Mailertsi2008';       // sender password
            $mail->SMTPSecure = 'tls';                  // encryption - ssl/tls
            $mail->Port = 587;                          // port - 587/465
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            
            $mail->setFrom('mailer@tsi-acsi.com.ph', 'TSI-ACSI Mailer');
            $mail->addAddress($request->emailRecipient);
            $mail->addCC($request->emailCc);
            $mail->addBCC($request->emailBcc);

            $mail->addReplyTo('mailer@tsi-acsi.com.ph', 'TSI-ACSI Mailer');

            if(isset($_FILES['emailAttachments'])) {
                for ($i=0; $i < count($_FILES['emailAttachments']['tmp_name']); $i++) {
                    $mail->addAttachment($_FILES['emailAttachments']['tmp_name'][$i], $_FILES['emailAttachments']['name'][$i]);
                }
            }


            $mail->isHTML(true);                // Set email content format to HTML

            $mail->Subject = $request->emailSubject;
            $mail->Body    = $request->emailBody;

            // $mail->AltBody = plain text version of email body;

            if( !$mail->send() ) {
                return 'Email not sent.';
            }
            
            else {
                return "Email has been sent.";
            }

        } catch (Exception $e) {
             return 'Message could not be sent.';
        }
    }
}
