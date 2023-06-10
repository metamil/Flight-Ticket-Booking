<?php
if(isset($_POST['new-pwd-submit'])) {
    require '../helpers/init_conn_db.php';   
    $selector = $_POST['selector'];
    $validator = $_POST['validator'];
    $password = $_POST['password'];
    $password_repeat = $_POST['password_repeat'];
    if($password !== $password_repeat) {
        header('Location: ../create-new-pwd.php?err=pwdnotmatch'); 
        exit();
    }
    $curr_date = date('U');
    $sql = 'SELECT * FROM PwdReset WHERE pwd_reset_selector=? AND pwd_reset_expires >='.$curr_date;
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql)) {        
        header('Location: ../create-new-pwd.php?err=sqlerr'); 
        exit();            
    } else {
        mysqli_stmt_bind_param($stmt,'s',$selector);            
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);        
        if(!$row = mysqli_fetch_assoc($result)) {
            header('Location: ../create-new-pwd.php?err=sqlerr'); 
            exit();
        } else {
            $token_bin = hex2bin($validator);
            $token_check = password_verify($token_bin,$row['pwd_reset_token']);
            if($token_check === false) {
                header('Location: ../create-new-pwd.php?err=pwdnotmatch'); 
                exit();                
            } else if($token_check === true) {
                $token_email = $row['pwd_reset_email'];
                $sql = 'SELECT * FROM Users WHERE email =?';
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt,$sql)) {
                    header('Location: ../create-new-pwd.php?err=sqlerr'); 
                    exit();            
                } else {
                    mysqli_stmt_bind_param($stmt,'s',$token_email);            
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);        
                    if(!$row = mysqli_fetch_assoc($result)) {
                        header('Location: ../create-new-pwd.php?err=sqlerr'); 
                        exit();
                    } else {
                        $pwd_hash = password_hash($password,PASSWORD_DEFAULT);
                        $sql = 'UPDATE Users SET password=? WHERE email=?';
                        $stmt = mysqli_stmt_init($conn);
                        if(!mysqli_stmt_prepare($stmt,$sql)) {
                            header('Location: ../create-new-pwd.php?err=sqlerr'); 
                            exit();            
                        } else {
                            mysqli_stmt_bind_param($stmt,'ss',$pwd_hash,$token_email);            
                            mysqli_stmt_execute($stmt);

                            $sql = 'DELETE FROM PwdReset WHERE pwd_reset_email=?';
                            $stmt = mysqli_stmt_init($conn);
                            if(!mysqli_stmt_prepare($stmt,$sql)) {
                                header('Location: ../create-new-pwd.php?err=sqlerr');       
                                exit();            
                            } else {
                                mysqli_stmt_bind_param($stmt,'s',$token_email);            
                                mysqli_stmt_execute($stmt);
                                header('Location: ../login.php?pwd=updated');    
                            }                            
                        }                        
                    }
                }                
            }
        }
    }        
    mysqli_stmt_close($stmt);
    mysqli_close($conn);    
} else {
    header('Location: ../create-new-pwd.php');    
} 
