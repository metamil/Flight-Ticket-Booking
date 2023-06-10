<?php
session_start();
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Assistant:wght@200&display=swap" rel="stylesheet">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <script src="https://kit.fontawesome.com/44f557ccce.js"></script>
        <title>Online Flight Booking</title>          
        <link rel = "icon" href =  
            "../assets/images/brand.png" 
        type = "image/x-icon">          
    </head>
<style>
@font-face {
  font-family: 'product sans';
  src: url('../assets/css/Product Sans Bold.ttf');
}
button.btn-outline-light:hover {
  color: cornflowerblue !important;
}
  .navbar-custom {
    /* background-color: #6495ED; */
    background-color: #3a3a3a;
    /* font-family: 'Bangers', cursive; */
    font-family: 'product sans', cursive;    
  }
  h4 {
    font-size: 23px !important;
  }
</style>
    <body>

        <nav class="navbar navbar-custom navbar-expand-lg navbar-dark">
          <a class="navbar-brand text-light" href="index.php"><h4>ADMIN PANEL</h4></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse"
            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
            aria-expanded="false" aria-label="Toggle navigation">

            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

          <?php
              if(isset($_SESSION['adminId'])) { ?>
                <ul class="navbar-nav mr-auto">

                <li class="nav-item">
                    <a class="nav-link" href="index.php">
                      <h5 class="ml-2"> Dashboard</h5>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a class="nav-link" href="flight.php">
                      <h5 class="ml-2"> Add Flight</h5>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="all_flights.php">
                      <h5>List Flights</h5>
                    </a>
                  </li>   
                  <li class="nav-item">
                    <a class="nav-link" href="list_airlines.php">
                      <h5>Manage Airlines</h5>
                    </a>
                  </li>              
                  <!-- <li class="nav-item">
                    <a class="nav-link" href="review.php">
                      <h4>Reviews</h4>
                    </a>
                  </li>                      -->
                </ul>
                <ul class="nav navbar-nav navbar-right">
                  <li class="nav-item">
                    <div class="dropdown mt-2">
                      <button class="btn bg-transparent dropdown-toggle text-white" type="button" 
                        id="dropdownMenuButton" data-toggle="dropdown" 
                          aria-haspopup="true" aria-expanded="false">
                        
                        <i class="fa fa-plus text-white"></i> Airlines </td>
                      </button>  
                      <div class="dropdown-menu">
                        <form class="px-2 py-2"  action="../includes/admin/airline.inc.php" method="post">
                          <div class="form-group">
                            <input type="text" class="form-control" name="airline" 
                              placeholder="Airlines Name">
                            <input type="number" class="form-control mt-3" name="seats" 
                              placeholder="Total Seats">                              
                          </div>  
                          <button type="submit" name="air_but" 
                            class="btn btn-success w-100">Submit</button>
                        </form>
                      </div>
                    </div>  
                  </li>
                  <li class="nav-item  p-1 border-light ">
                      <a class="nav-link" href="">
                          <i class="ml-1 fa fa-user text-light"></i>
                          <span class="nav_link text-light"
                            style="font-size: 20px;">
                          <?php echo  $_SESSION['adminUname']; ?>
                          </span>
                      </a>
                  </li>            
                </ul>                 
                <form action="../includes/logout.inc.php" method="POST">
                <button class="btn btn-outline-light m-2" type="submit">
                    Logout </button>
                </form> 
            </div>
            <?php } ?>

        </nav>
