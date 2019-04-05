    <?php
    require_once('lib/info.php');

    session_start();
    $msg= array();
    if (isset($_SESSION['msg'])) {
        $msg= $_SESSION['msg'];
    }
    $values= array('msg'=>'','email'=>'');
    $messageSent= false;
    if (count($msg)>0) {
        if (isset($_SESSION['values'])) {
            $values= $_SESSION['values'];
        }
    } else {
        if (isset($_SESSION['msgOK'])) {
            $messageSent= true;
        }
    }

    unset($_SESSION['msg']);
    unset($_SESSION['values']);
    unset($_SESSION['msgOK']);
    
    ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Cloud Computing Student</title>
    <!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <link rel="stylesheet" type="text/css" href="css/layout.css" />
</head>
<body>
    <div id="wrapper">
        <div id="headerwrap">
            <div id="header">
                <h1><?php echo $info->name;?></h1>
            </div>
        </div>
        <div id="leftcolumnwrap">
            <div id="leftcolumn">
            <img src="img/myphoto.png" alt="Photo">
            </div>
        </div>
        <div id="contentwrap">
            <div id="content">
            <h2>Personal Information</h2>
            <h4>Student Number</h4><p><?php echo $info->studentNumber;?></p>
            <h4>Short Name</h4><p><?php echo $info->shortname;?></p>
            <h4>Nationality</h4><p><?php echo $info->nationality;?></p>
            <h4>E-Mail</h4><p><?php echo $info->email1;?></p>
            <h4>Secondary E-Mail</h4><p><?php echo $info->email2;?></p>
            <h4>Other Information</h4>
            <p><?php echo $info->other;?></p>
         </div>
     </div>
     <div id="formwrap">     
        <?php if ($messageSent) : ?>
            <div class="info-msg">Message sent to <?php echo $info->name;?></div>
        <?php endif; ?>
        <?php if (array_key_exists("global", $msg)) : ?>
            <div class="error-global"><?php echo $msg["global"];?></div>
        <?php endif; ?>
        <h2>Contact me:</h2>
        <form method="POST" action="sendmessage.php">
            <label for="id_email">Your E-Mail</label>
            <br>
            <input type="email" name="email" id="id_email" size="100" required value='<?php echo $values["email"];?>'>
            <?php if (array_key_exists("email", $msg)) : ?>
                <span class="error"><?php echo $msg["email"];?></span><br>
            <?php endif; ?>
            <br>
            <label for="id_msg">Your Message</label>
            <br>
            <textarea name="msg" id="id_msg" required><?php echo $values["msg"];?></textarea>
            <?php if (array_key_exists("msg", $msg)) : ?>
                <span class="error"><?php echo $msg["msg"];?></span><br>
            <?php endif; ?>
            <br>
            <input type="submit" value="Send Message">
        </form>
    </div>
     <div id="footerwrap">
        <div id="footer">
            <p>MSC in Computer Engineering - Mobile Computing : Cloud Computing</p>
        </div>
    </div>
</div>
</body>
</html>