<?php include_once 'helpers/helper.php'; ?>
<?php subview('header.php');    ?>
<link rel="stylesheet" href="assets/css/form.css">
<style>

.rating {
  display: inline-block;
  position: relative;
  height: 50px;
  line-height: 50px;
  font-size: 50px;
}
.rating label {
  position: absolute;
  top: 0;
  left: 0;
  height: 100%;
  cursor: pointer;
}

.rating label:last-child {
  position: static;
}

.rating label:nth-child(1) {
  z-index: 5;
}

.rating label:nth-child(2) {
  z-index: 4;
}

.rating label:nth-child(3) {
  z-index: 3;
}

.rating label:nth-child(4) {
  z-index: 2;
}

.rating label:nth-child(5) {
  z-index: 1;
}

.rating label input {
  position: absolute;
  top: 0;
  left: 0;
  opacity: 0;
}

.rating label .icon {
  float: left;
  color: transparent;
}

.rating label:last-child .icon {
  color: #000;
}

.rating:not(:hover) label input:checked ~ .icon,
.rating:hover label:hover input ~ .icon {
  color: #09f;
}

.rating label input:focus:not(:checked) ~ .icon:last-child {
  color: #000;
  text-shadow: 0 0 5px #09f;
}  
body {
  background: #bdc3c7;  /* fallback for old browsers */
  background: -webkit-linear-gradient(to right, #2c3e50, #bdc3c7);  /* Chrome 10-25, Safari 5.1-6 */
  background: linear-gradient(to right, #2c3e50, #bdc3c7); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

}
@font-face {
  font-family: 'product sans';
  src: url('assets/css/Product Sans Bold.ttf');
  }
h1 {
  font-size: 50px !important;
  margin-bottom: 20px;  
  color: white;  
  font-family :'product sans' !important;
  text-align: center;
}

textarea {
  color: cornflowerblue !important;
  border :3px solid #31B0D5 !important;
  background-color: whitesmoke !important;
  font-weight: bold !important;
}
textarea:focus {
  outline-style: none !important;
  outline: none !important;
}
*:focus {
    outline: none !important;
}
input {
    border :0px !important;
    border-bottom: 2px solid #31B0D5 !important;
    color :cornflowerblue !important;
    border-radius: 0px !important;
    font-weight: bold !important;
    border: none;
    border-bottom: 2px solid #31B0D5;      
  }
  label {
    color : #79BAEC !important;
    font-size: 19px;
  }  
  div.form-group label {
    color: cornflowerblue !important;
    font-weight: bold;
  }
  div.rating label{
    font-size: 40px !important;
  }
.input-group {
  position: relative;
  display: inline-block;
  width: 100%;
}
.form-box {
  padding: 40px;
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);  
}
</style>

<main>
<?php
if(isset($_GET['error'])) {
    if($_GET['error'] === 'invalidemail') {
        echo '<script>alert("Invalid email")</script>';
    } else if($_GET['error'] === 'sqlerror') {
        echo"<script>alert('Database error')</script>";
    } else if($_GET['error'] === 'success') {
      echo"<script>alert('Thank you for your Feedback')</script>";
    } 
}
?>
<div class="container mb-4">
  <h1> <i class="far fa-comment-alt"></i> FEEDBACK</h1>
  <div class="row justify-content-center">
  <div class="col-md-6 bg-light form-box">
    <form action="includes/feedback.inc.php" method="POST">
      <div class="row justify-content-center">  
          <div class="col-12 ">              
            <div class="input-group">
                <label for="user_id">Email</label>
                <input type="text" name="email" id="user_id" required >
              </div>              
          </div>                      
          <div class="col-12 mt-4">
            <div class="form-group">         
              <label for="exampleFormControlTextarea1">What was your first impression
                  when you entered the website?</label>     
              <textarea class="form-control" id="exampleFormControlTextarea1" name="1"                
                rows="3" required></textarea>
            </div>                
          </div>             
          
          <div class="col-12 mt-4">
            <div class="form-group">         
              <select class="mt-4" name="2" style="border: 0px; border-bottom: 
              2px solid #31B0D5; background-color: whitesmoke !important;
              font-weight: bold !important;color :cornflowerblue !important;
              width:100%" required>
                <option  selected disabled>How did you first hear about us?</option>
                <option >Search Engine</option>
                <option >Social Media</option>
                <option >Friend/Relative</option>
                <option >Word of Mouth</option>
                <option >Television</option>
                <option>Other</option>
              </select> 
            </div>                
          </div>                   
          
          <div class="col-12 mt-4">
            <div class="form-group">         
              <label for="exampleFormControlTextarea1">Is there anything missing on this page?</label>     
              <textarea class="form-control" id="exampleFormControlTextarea1" name="3"                
                rows="3" required></textarea>
            </div>                
          </div>          
      </div>  
    
      <div class="row">
        <div class="rating ml-3">  
          <label>
            <input type="radio" name="stars" value="1" required />
            <span class="icon">★</span>
          </label>
          <label>
            <input type="radio" name="stars" value="2" required />
            <span class="icon">★</span>
            <span class="icon">★</span>
          </label>
          <label>
            <input type="radio" name="stars" value="3" required />
            <span class="icon">★</span>
            <span class="icon">★</span>
            <span class="icon">★</span>
          </label>
          <label>
            <input type="radio" name="stars" value="4" required />
            <span class="icon">★</span>
            <span class="icon">★</span>
            <span class="icon">★</span>
            <span class="icon">★</span>
          </label>
          <label>
            <input type="radio" name="stars" value="5" required />
            <span class="icon">★</span>
            <span class="icon">★</span>
            <span class="icon">★</span>
            <span class="icon">★</span>
            <span class="icon">★</span>
          </label>
        </div>
      </div>
      <div class="row">
        <div class="col text-center">
          <button name="feed_but" type="submit" 
            class="btn btn-primary mt-3">
            <div style="font-size: 1.5rem;">
            <i class="fa fa-lg fa-arrow-right"></i>  
            </div>
          </button>
        </div>
      </div>

    </form>
  </div>
  </div>
</div>
<?php subview('footer.php'); ?> 
<script>
  $(document).ready(function(){
  $('.input-group input').focus(function(){
    me = $(this) ;
    $("label[for='"+me.attr('id')+"']").addClass("animate-label");
  }) ;
  $('.input-group input').blur(function(){
    me = $(this) ;
    if ( me.val() == ""){
      $("label[for='"+me.attr('id')+"']").removeClass("animate-label");
    }
  }) ;
  // $('#test-form').submit(function(e){
  //   e.preventDefault() ;
  //   alert("Thank you") ;
  // })
});
</script>
</main>
<footer>
	<em><h5 class="text-light text-center p-0 brand mt-2">
				<img src="assets/images/airtic.png" 
					height="40px" width="40px" alt="">				
			Online Flight Booking</h5></em>
	<p class="text-light text-center">&copy; <?php echo date('Y');?> - Developed By Sujoy Dcunha, Christina Pereira, Mark Coutinho</p>
</footer>