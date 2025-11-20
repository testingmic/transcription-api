<?php 

namespace App\Libraries;

use PHPMailer\PHPMailer\PHPMailer;

class Emailing {

    public $replacements = [];
    public $emailObject;

    public function __construct() {
        $this->replacements = [
            '__APPLOGO__' => '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z"></path><path fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M20 2v4"></path><path fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M22 4h-4"></path><circle fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" cx="4" cy="20" r="2"></circle></svg>',
            '__TITLE__' => configs('app_name'),
            '__TEAM__' => 'Team - ' . configs('app_name'),
            '__INVITE_URL__' => rtrim(configs('app_url'), '/') . '/auth/signup',
            '__YEAR__' => date('Y')
        ];

        $this->emailObject = new PHPMailer(true);

        $this->initialize();
    }

    /**
     * Initialize the email object
     * 
     * @return void
     */
    public function initialize()
    {

        // set the timeout to 15 seconds
        $timeout = 10;

        // set the time limit to 15 seconds
        set_time_limit($timeout);

        // set the email configs object
        $this->emailObject->isSMTP();
        $this->emailObject->SMTPDebug = 0;
        $this->emailObject->Timeout = $timeout;
        $this->emailObject->Host = configs('email.host');
        $this->emailObject->SMTPAuth = true;
        $this->emailObject->Username = configs('email.user');
        $this->emailObject->Password = configs('email.pass');
        $this->emailObject->SMTPSecure = 'tls';
        $this->emailObject->Port = configs('email.port');
        $this->emailObject->setFrom(configs('email.user'), configs('app_name'), false);
        $this->emailObject->isHTML(true);
    }

    /**
     * Send email
     * 
     * @param string $email
     * @param array $message
     * @param string $template
     * 
     * @return bool
     */
    public function send($email, array $message, string $template) {

        try {

            // load the email template
            $template = loadEmailTemplate($template);

            // replace the placeholders with the actual values
            foreach(array_merge($message, $this->replacements) as $key => $value) {
                $template = str_replace($key, $value, $template);
            }

            // Clear previous recipients
            $this->emailObject->clearAddresses();
            
            // Initialize email
            $this->emailObject->addAddress($email);

            // Set email details
            $this->emailObject->Subject = ($message['__subject__'] ?? configs('app_name'));
            $this->emailObject->Body = $template;
            
            return  $this->emailObject->send();

        } catch (\Exception $e) {
            return false;
        }

    }

    /**
     * Send email
     *
     * @param string $email
     * @param array $data
     * @param string $template
     *
     * @return false
     */
    public function sendRaw(string $email, array $data,  string $template) {
        // Todo:: validate the template
        try {
            if(configs('is_local')) {
                return true;
            }

            // Clear previous recipients
            $this->emailObject->clearAddresses();
            
            // Initialize email
            $this->emailObject->addAddress($email);

            // Set email details
            $this->emailObject->Subject = ($data['__subject__'] ?? 'Transc.io');
            $this->emailObject->Body = $template;

            return  $this->emailObject->send();

        } catch (\Exception $e) {
            return false;
        }

    }
}
