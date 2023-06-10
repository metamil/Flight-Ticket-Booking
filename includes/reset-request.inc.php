<?php

use PHPMailer\PHPMailer\PHPMailer;

if(isset($_POST['reset-req-submit'])) {

    require '../helpers/init_conn_db.php';   
    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);
    $url = 'https://secret-journey-48226.herokuapp.com/views/create-new-pwd.php?selector='.$selector.'&validator='
        .bin2hex($token);
    $expires = date('U')+1800;
    $user_email = $_POST['user_email'];
    if(!filter_var($user_email,FILTER_VALIDATE_EMAIL)) {
        header('Location: ../reset-pwd.php?err=invalidemail');    
        exit();
    }    
    $sql = 'DELETE FROM PwdReset WHERE pwd_reset_email=?;';
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql)) { 
        header('Location: ../reset-pwd.php?err=sqlerr');    
        exit();            
    } else {
        mysqli_stmt_bind_param($stmt,'s',$user_email);            
        mysqli_stmt_execute($stmt);
    }     
    $sql = 'INSERT INTO PwdReset (pwd_reset_email,pwd_reset_selector,pwd_reset_token,
    pwd_reset_expires) VALUES (?,?,?,?);';
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql)) {
        header('Location: ../reset-pwd.php?err=sqlerr');     
        exit();            
    } else {
        $token_hash = password_hash($token,PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt,'ssss',$user_email,$selector,$token_hash,$expires);            
        mysqli_stmt_execute($stmt);
    } 

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    require_once "../vendor/autoload.php";
    include '../vendor/phpmailer/phpmailer/src/Exception.php';
    include '../vendor/phpmailer/phpmailer/src/PHPMailer.php';  
    try {     
        $mail = new PHPMailer(true);        
        $mail->IsSMTP();
        $mail->Mailer = "smtp";
        $mail->SMTPDebug  = 1;  
        $mail->SMTPAuth   = TRUE;
        $mail->SMTPSecure = "tls";
        $mail->Port       = 587;
        $mail->Host       = "smtp.gmail.com";
        $mail->Username   = "your_username";
        $mail->Password   = "your_password";
        $mail->IsHTML(true);
        $mail->SetFrom('test@gmail.com');
        $mail->AddAddress($user_email);    
        $mail->Subject = "Reset password request for site_name";
        $content = "
            <p>We receieved a password reset request, ignore if you did not issue a request</p> 
        ";
        $content .= '<p>Your password reset link:</br>';
        $content .='<a href="'.$url.'">'.$url.'</a></p>';                 

        $mail->MsgHTML($content); 
        $mail->Send();
        header('Location: ../reset-pwd.php?mail=success');       
    } 
    catch(Exception $e) {        
        // echo $mail->ErrorInfo;
        header('Location: ../reset-pwd.php?err=mailerr');      
    }
   
} else {
    header('Location: ../reset-pwd.php?');    
} 


