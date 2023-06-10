<?php
session_start();
if(isset($_POST['pass_but']) && isset($_SESSION['userId'])) {
    require '../helpers/init_conn_db.php';  
    $mobile_flag = false;
    $flight_id = $_POST['flight_id'];
    $passengers = $_POST['passengers'];
    $mob_len = count($_POST['mobile']);
    for($i=0;$i<$mob_len;$i++) {
        if(strlen($_POST['mobile'][$i]) !== 10) {
            $mobile_flag = true;
            break;            
        }
    }
    if($mobile_flag) {
        header('Location: ../pass_form.php?error=moblen');
        exit();         
    }
    $date_len = count($_POST['date']);
    for($i=0;$i<$date_len;$i++) {        
        $date_mnth = (int)substr($_POST['date'][$i],5,2);
        $flag = false;
        if($date_mnth > (int)date('m')){
          $flag = true;
        } else if($date_mnth == (int)date('m')){
          if((int)substr($_POST['date'][$i],8,2) >= (int)date('d')) {
            $flag = true;            
          } 
        }  
        if($flag) {
            header('Location: ../pass_form.php?error=invdate');
            exit();    
            break;
        }      
    }        
    $stmt = mysqli_stmt_init($conn);
    $sql = 'SELECT * FROM Passenger_profile';
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql)) {
        header('Location: ../pass_form.php?error=sqlerror');
        exit();            
    } else {
        mysqli_stmt_bind_param($stmt,'ii',$flight_id,$_SESSION['userId']);            
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $flag = false;
        while ($row = mysqli_fetch_assoc($result)) {
            $pass_id=$row['passenger_id'];
        }
    } 
    if(is_null($pass_id)) {
        $pass_id = 0;
        $stmt = mysqli_stmt_init($conn);
        $sql = 'ALTER TABLE Passenger_profile AUTO_INCREMENT = 1 ';
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql)) {
            header('Location: ../pass_form.php?error=sqlerror');
            exit();            
        } else {         
            mysqli_stmt_execute($stmt);
        }        
    }
    $stmt = mysqli_stmt_init($conn);
    $flag = false;
    for($i=0;$i<$date_len;$i++) {
        $sql = 'INSERT INTO Passenger_profile (user_id,mobile,dob,f_name,
        m_name,l_name,flight_id) VALUES (?,?,?,?,?,?,?)';            
        if(!mysqli_stmt_prepare($stmt,$sql)) {
            header('Location: ../pass_form.php?error=sqlerror');
            exit();            
        } else {
            mysqli_stmt_bind_param($stmt,'iissssi',$_SESSION['userId'],
                $_POST['mobile'][$i],$_POST['date'][$i],$_POST['firstname'][$i],
                $_POST['midname'][$i],$_POST['lastname'][$i],$flight_id);                           
            mysqli_stmt_execute($stmt);  
            $flag = true;        
        }
    }   
    if($flag) {
        $_SESSION['flight_id'] = $flight_id;
        $_SESSION['class'] = $_POST['class'];
        $_SESSION['passengers'] = $passengers;
        $_SESSION['price'] = $_POST['price'];
        $_SESSION['type'] = $_POST['type'];
        $_SESSION['ret_date'] = $_POST['ret_date'];
        $_SESSION['pass_id'] = $pass_id+1;
        header('Location: ../payment.php');
        exit();          
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);    

} else {
    header('Location: ../pass_form.php');
    exit();  
}