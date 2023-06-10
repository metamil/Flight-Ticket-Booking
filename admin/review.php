<?php include_once 'header.php'; 
require '../helpers/init_conn_db.php';?>

<style>
body{
  background-image: url('../assets/images/sky.jpg');
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-size: 100% 100%;    
}

.checked {
  color: cornflowerblue;
}
h1 {
    font-size: 50px !important;
    font-family: 'product sans';  
    margin-bottom: 20px;  
}

p.mail {
  font-family: 'product sans';  
  font-size: 38px;
}
p.ans {
  color: cornflowerblue;
  font-size: 18px;
}
p.quest {
  color: #4C53D3;
  font-size: 18px;
  font-weight: bold;
  /* text-align: center; */
}

div.review-bag {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);  
  background: whitesmoke;
  padding: 30px !important;
}
</style>
<?php if(isset($_SESSION['adminId'])) { ?>
<main>
<div class="container mt-4 mb-4">
  <h1 class="text-center mb-4 text-light">CUSTOMER REVIEWS</h1>
  <div class="row">
    <?php
    $sql = 'SELECT * FROM feedback ORDER BY feed_id DESC';
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt,$sql);                
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) { 
      $arr = [];
      for($i=0;$i<(int)$row['rate'];$i++) {
        array_push($arr,'checked');
      }     
      echo ' 
      <div class="col-md-6 mb-5">
      <div class="review-bag">  
        <p class="mail text-primary"> <i class="fa fa-user"></i> '.$row['email'].'</p>
        <p class="star">
          <span class="fa fa-star fa-lg '.$arr[0].'"></span>
          <span class="fa fa-star fa-lg '.$arr[1].'"></span>
          <span class="fa fa-star fa-lg '.$arr[2].'"></span>
          <span class="fa fa-star fa-lg '.$arr[3].'"></span>
          <span class="fa fa-star fa-lg '.$arr[4].'"></span>        
        </p>
        <p class="quest">What was your first impression when you entered the website?</p>
        <p class="ans">'.$row['q1'].'</p>
        <p class="quest">How did you first hear about us?</p>
        <p class="ans">'.$row['q2'].'</p>
        <p class="quest">Is there anything missing on this page?</p>
        <p class="ans">'.$row['q3'].'</p>
      </div> 
      </div>   ';      
    } ?> 
  </div>  
</div>
</main>
<?php } ?>
<?php include_once 'footer.php'; ?>
