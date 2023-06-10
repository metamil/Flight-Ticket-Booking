<?php
if(isset($_POST['feed_but'])) {
    require '../helpers/init_conn_db.php';    
    $email = $_POST['email'];
    $q1 = $_POST['1'];
    $q2 = $_POST['2'];
    // $q3 = $_POST['3'];
    $stars = $_POST['stars'];
    if(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
        header('Location: ../feedback.php?error=invalidemail');
        exit();
    }
    $sql = 'INSERT INTO feedback (email,q1,q2,rate) VALUES (?,?,?,?)';
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql)) {
        header('Location: ../feedback.php?error=sqlerror');
        exit();            
    } else {
        mysqli_stmt_bind_param($stmt,'sssi',$email,$q1,$q2,$stars);            
        mysqli_stmt_execute($stmt); 
        header('Location: ../feedback.php?error=success');
        exit();       
        mysqli_stmt_close($stmt);
        mysqli_close($conn);          
    }

} else {
    header('Location: ../feedback.php');
    exit();  
}
