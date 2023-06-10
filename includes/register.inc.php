<?php
if(isset($_POST['signup_submit'])) {
    require '../helpers/init_conn_db.php';    
    $username = $_POST['username'];
    $email_id = $_POST['email_id'];
    $password = $_POST['password'];
    $password_repeat = $_POST['password_repeat'];
    if(!filter_var($email_id,FILTER_VALIDATE_EMAIL)) {
        header('Location: ../register.php?error=invalidemail');
        exit();
    }
    else if($password !== $password_repeat) {
        header('Location: ../register.php?error=pwdnotmatch');
        exit();
    }
    else {
        $username_sql = 'SELECT username FROM Users WHERE username=?';
        $email_sql = 'SELECT email FROM Users WHERE email=?';
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$username_sql)) {
            header('Location: ../register.php?error=sqlerror');
            exit();            
        } else {
            mysqli_stmt_bind_param($stmt,'s',$username);            
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);            
            $username_check = mysqli_stmt_num_rows($stmt);
            if($username_check > 0) {
                header('Location: ../register.php?error=usernameexists');
                exit();                  
            } else {
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt,$email_sql)) {
                    header('Location: ../register.php?error=sqlerror');
                    exit();            
                } else {
                    mysqli_stmt_bind_param($stmt,'s',$email_id);            
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_store_result($stmt);
                    $email_check = mysqli_stmt_num_rows($stmt);
                    if($email_check > 0) {
                        header('Location: ../register.php?error=emailexists');
                        exit();   
                    } else {
                        $sql = 'INSERT INTO Users (username,email,password) VALUES (?,?,?)';
                        $stmt = mysqli_stmt_init($conn);
                        if(!mysqli_stmt_prepare($stmt,$sql)) {
                            header('Location: ../register.php?error=sqlerror');
                            exit();            
                        } else {
                            $pwd_hash = password_hash($password, PASSWORD_DEFAULT);
                            mysqli_stmt_bind_param($stmt,'sss',$username,$email_id,$pwd_hash);            
                            mysqli_stmt_execute($stmt);  
                            
                            // LOGIN USer                            
                            $sql = 'SELECT * FROM Users WHERE username=? OR email=?;';
                            $stmt = mysqli_stmt_init($conn);
                            if(!mysqli_stmt_prepare($stmt,$sql)) {
                                header('Location: ../index.php?error=sqlerror');
                                exit();            
                            } else {
                                mysqli_stmt_bind_param($stmt,'ss',$username,$username);            
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);
                                if($row = mysqli_fetch_assoc($result)) {
                                    $pwd_check = password_verify($password,$row['password']);
                                    if($pwd_check == false) {
                                        header('Location: ../index.php?error=wrongpwd');
                                        exit();    
                                    }
                                    else if($pwd_check == true) {
                                        session_start();
                                        $_SESSION['userId'] = $row['user_id'];
                                        $_SESSION['userUid'] = $row['username'];
                                        $_SESSION['userMail'] = $row['email'];                                        
                                        header('Location: ../index.php?login=success');
                                        exit();                  
                                    } else {
                                        header('Location: ../index.php?error=invalidcred');
                                        exit();                    
                                    }
                                }
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
    header('Location: ../register.php');
    exit();  
}
