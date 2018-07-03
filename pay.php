
    <?php
    // Include config file
    require_once 'config.php';
    
    // Define variables and initialize with empty values

    $cardname = $cardnumber = $expmonth =  $expyear = $cvv = "";
     $cardname_err = $cardnumber_err = $expmonth_err =  $expyear_err = $cvv_err = "";
     

    // Processing form data when form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // Validate cardname
        if(empty(trim($_POST["cardname"]))){
            $cardname_err = "Please enter a cardname.";
        } else{
            // Prepare a select statement
            $sql = "SELECT id FROM payment WHERE cardname = ?";
            if($stmt = mysqli_prepare($link, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "s", $param_cardname);
                // Set parameters
                $param_cardname = trim($_POST["cardname"]);

                

                // Attempt to execute the prepared statement

                if(mysqli_stmt_execute($stmt)){
                   /* store result */

                     mysqli_stmt_store_result($stmt);

                    

                    if(mysqli_stmt_num_rows($stmt) == 10000){

                        $cardname_err = "This cardname is already taken.";

                    } else{

                        $cardname = trim($_POST["cardname"]);

                    }

                } else{

                    echo "Oops! Something went wrong. Please try again later.";

                }

            }

             

            // Close statement

            mysqli_stmt_close($stmt);

        }

        

        // Validate cardnumber

        if(empty(trim($_POST['cardnumber']))){
            $cardnumber_err = "Please enter a cardnumber.";     
        } elseif(strlen(trim($_POST['cardnumber'])) < 6){
            $cardnumber_err = "cardnumber must have atleast 6 characters.";
        } else{
            $cardnumber = trim($_POST['cardnumber']);
        }
       
        // Validate confirm cardnumber
        if(empty(trim($_POST["expmonth"]))){
            $expmonth_err = 'Please confirm cardnumber.';     
        } else{

            $expmonth = trim($_POST['expmonth']);

            

        }

        // Validate expyear

        if(empty(trim($_POST["expyear"]))){
            $expyear_err = "Please enter a firstname.";     
        } elseif(strlen(trim($_POST['expyear'])) < 2){
            $expyear_err = "firstname must have atleast 2 characters.";
        } else{
            $expyear = trim($_POST['expyear']);
        }
        

         // Validate cvv

        if(empty(trim($_POST["cvv"]))){
            $cvv_err = "Please enter a cvv.";     
        } elseif(strlen(trim($_POST['cvv'])) < 3){
            $cvv_err = "lastname must have atleast 3 characters.";
        } else{
            $cvv = trim($_POST['cvv']);
        }
        
         
      

        // Check input errors before inserting in database

        if(empty($cardname_err) && empty($cardnumber_err) && empty($expmonth_err) && empty($expyear_err) && empty($cvv_err)){

            

            // Prepare an insert statement

            $sql = "INSERT INTO payment (cardname, cardnumber, expyear, expmonth, cvv ) VALUES ( ?, ?, ?, ?, ?)";

             

            if($stmt = mysqli_prepare($link, $sql)){

                // Bind variables to the prepared statement as parameters

                mysqli_stmt_bind_param($stmt, "sssss", $param_cardname, $param_cardnumber, $param_expyear,$param_expmonth , $param_cvv);

                

                // Set parameters

                $param_cardname = $cardname;

                $param_cardnumber =  $cardnumber;
                $param_expyear = $expyear;
                $param_expmonth = $expmonth;
                
                 $param_cvv = password_hash($cvv, PASSWORD_DEFAULT); // Creates a password hash
               
             

                // Attempt to execute the prepared statement

                if(mysqli_stmt_execute($stmt)){

                    // Redirect to login page

                    header("location: welcome.php");

                } else{

                    echo "Something went wrong. Please try again later.";

                }

            }

             

            // Close statement

            mysqli_stmt_close($stmt);

        }

        

        // Close connection

        mysqli_close($link);

    }

    ?>

     


<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">

        <style type="text/css">

body {
  font-family: Arial;
  font-size: 17px;
  padding: 8px;
}

* {
  box-sizing: border-box;
}

.row {
  display: -ms-flexbox; /* IE10 */
  display: flex;
  -ms-flex-wrap: wrap; /* IE10 */
  flex-wrap: wrap;
  margin: 0 -16px;
}

.col-25 {
  -ms-flex: 25%; /* IE10 */
  flex: 25%;
}

.col-50 {
  -ms-flex: 50%; /* IE10 */
  flex: 50%;
}

.col-75 {
  -ms-flex: 75%; /* IE10 */
  flex: 75%;
}

.col-25,
.col-50,
.col-75 {
  padding: 0 16px;
}

.container {
  background-color: #f2f2f2;
  padding: 5px 20px 15px 20px;
  border: 1px solid lightgrey;
  border-radius: 3px;
}

input[type=text] {
  width: 100%;
  margin-bottom: 20px;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 3px;
}

label {
  margin-bottom: 10px;
  display: block;
}

.icon-container {
  margin-bottom: 20px;
  padding: 7px 0;
  font-size: 24px;
}

.btn {
  background-color: #4CAF50;
  color: white;
  padding: 12px;
  margin: 10px 0;
  border: none;
  width: 100%;
  border-radius: 3px;
  cursor: pointer;
  font-size: 17px;
}

.btn:hover {
  background-color: #45a049;
}

a {
  color: #2196F3;
}

hr {
  border: 1px solid lightgrey;
}

span.price {
  float: right;
  color: grey;
}

/* Responsive layout - when the screen is less than 800px wide, make the two columns stack on top of each other instead of next to each other (also change the direction - make the "cart" column go on top) */
@media (max-width: 800px) {
  .row {
    flex-direction: column-reverse;
  }
  .col-25 {
    margin-bottom: 20px;
  }
}
</style>
</head>
<body>
 
<div class="row">
  <div class="col-75">
    <div class="container">
       <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      
        <div class="row">
          <div class="col-50">
            

            

          <div class="col-50">

            <h3>Payment</h3>
            <label for="fname">Accepted Cards</label>
            <div class="icon-container">
              <i class="fa fa-cc-visa" style="color:navy;"></i>
              <i class="fa fa-cc-amex" style="color:blue;"></i>
              <i class="fa fa-cc-mastercard" style="color:red;"></i>
              <i class="fa fa-cc-discover" style="color:orange;"></i>
            </div>
            <div class="form-group <?php echo (!empty($cardname_err)) ? 'has-error' : ''; ?>">
            <label for="cname">Name on Card</label>
            <input type="text" id="cname" name="cardname" placeholder="John More Doe" value="<?php echo $cardname; ?>">
            <span class="help-block"><?php echo $cardname_err; ?></span>

                </div>    


            <div class="form-group <?php echo (!empty($cardnumber_err)) ? 'has-error' : ''; ?>">
            <label for="ccnum">Credit card number</label>
            <input type="text" id="ccnum" name="cardnumber" placeholder="1111-2222-3333-4444" value="<?php echo $cardnumber; ?>">
            <span class="help-block"><?php echo $cardnumber_err; ?></span>

                </div>    

            <div class="form-group <?php echo (!empty($expmonth_err)) ? 'has-error' : ''; ?>">
            <label for="expmonth">Exp Month</label>

             <select name="expmonth" class="form-control" value="<?php echo $expmonth; ?>" >
                        <option value="january">january</option>
                        <option value="february">february</option>
                        <option value="march">march</option>
                         <option value="april">april</option>
                          <option value="may">may</option>
                           <option value="june">june</option>
                            <option value="july">july</option>
                             <option value="august">august</option>
                              <option value="september">september</option>
                               <option value="october">october</option>
                                <option value="november">november</option>
                                 <option value="december">december</option>

                    </select>

           
            <div class="row" >
              <span class="help-block"><?php echo $expmonth_err; ?></span>

                </div>    
              


              <div class="col-50"> 
               <div class="form-group <?php echo (!empty($expyear_err)) ? 'has-error' : ''; ?>">
               <label for="expyear">Exp Year</label>
                <input type="text" id="expyear" name="expyear" placeholder="2018" value="<?php echo $expyear; ?>">
                <span class="help-block"><?php echo $expyear_err; ?></span>

                </div>    
              </div>

              <div class="col-50">
                <div class="form-group <?php echo (!empty($cvv_err)) ? 'has-error' : ''; ?>">
                <label for="cvv">CVV</label>
                <input type="text" id="cvv" name="cvv" placeholder="352" value="<?php echo $cvv; ?>">
                <span class="help-block"><?php echo $cvv_err; ?></span>

                </div>    
              </div>
            </div>
          </div>
          
        </div>
        
        <input type="submit" value="Continue to checkout" class="btn">
      </form>
    </div>
  </div>
  
</div>

</body>
</html>
