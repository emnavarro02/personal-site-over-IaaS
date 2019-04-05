    <?php
    session_start();
    require_once('lib/info.php');
    require_once('lib/mail.php');

    $msg = array();
    $values = $_POST;

    if (!isset($values['email'])) {
        $msg['email'] = 'Email is mandatory';
    } else if (trim($values['email']) == '') {
        $msg['email'] = 'Email is mandatory';
    } else if (filter_var(trim($values['email']), FILTER_VALIDATE_EMAIL) === false) {
        $msg['email'] = 'Email is invalid';
    }

    if (!isset($values['msg'])) {
        $msg['msg'] = 'Message is mandatory';
    } else if (trim($values['msg']) == '') {
        $msg['msg'] = 'Message is mandatory';
    }

    if (count($msg)==0) {
        try {
            $mail = new myapp\Mail($config, $info);
            $mail->sendSelfNotification(trim($values['email']), trim($values['msg']));
            $mail->sendAutomaticResponse(trim($values['email']), trim($values['msg']));
            // Just for testing
            if (trim($values['email']) == 'a@a.pt') {
                throw new Exception("Error Processing Request", 1);
            }
            $_SESSION['msgOK'] = true;
        } catch (Exception $e) {
            $msg['global'] = '<b>There was an error sending the message.</b><br>"' . $e->getMessage() . '"';
        }
    }

    $_SESSION['msg'] = $msg;
    $_SESSION['values'] = $values;

    header('location: index.php');
