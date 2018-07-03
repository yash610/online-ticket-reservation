

    <?php
    // Include config file
    require_once 'config.php';
    
    // Define variables and initialize with empty values

    $username = $password = $confirm_password =  $first_name = $last_name = $contact = $email = $event_name = "";
    $username_err = $password_err = $confirm_password_err = $first_name_err = $last_name_err = $contact_err = $email_err = $event_name_err = "";

     

    // Processing form data when form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // Validate username
        if(empty(trim($_POST["username"]))){
            $username_err = "Please enter a username.";
        } else{
            // Prepare a select statement
            $sql = "SELECT id FROM users WHERE username = ?";
            if($stmt = mysqli_prepare($link, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "s", $param_username);
                // Set parameters
                $param_username = trim($_POST["username"]);

                

                // Attempt to execute the prepared statement

                if(mysqli_stmt_execute($stmt)){
                   /* store result */

                     mysqli_stmt_store_result($stmt);

                    

                    if(mysqli_stmt_num_rows($stmt) == 1){

                        $username_err = "This username is already taken.";

                    } else{

                        $username = trim($_POST["username"]);

                    }

                } else{

                    echo "Oops! Something went wrong. Please try again later.";

                }

            }

             

            // Close statement

            mysqli_stmt_close($stmt);

        }

        

        // Validate password

        if(empty(trim($_POST['password']))){
            $password_err = "Please enter a password.";     
        } elseif(strlen(trim($_POST['password'])) < 6){
            $password_err = "Password must have atleast 6 characters.";
        } else{
            $password = trim($_POST['password']);
        }
       
        // Validate confirm password
        if(empty(trim($_POST["confirm_password"]))){
            $confirm_password_err = 'Please confirm password.';     
        } else{

            $confirm_password = trim($_POST['confirm_password']);

            if($password != $confirm_password){

                $confirm_password_err = 'Password did not match.';

            }

        }

        // Validate first_name

        if(empty(trim($_POST["first_name"]))){
            $first_name_err = "Please enter a firstname.";     
        } elseif(strlen(trim($_POST['first_name'])) < 2){
            $first_name_err = "firstname must have atleast 2 characters.";
        } else{
            $first_name = trim($_POST['first_name']);
        }
        

         // Validate last_name

        if(empty(trim($_POST["last_name"]))){
            $last_name_err = "Please enter a lastname.";     
        } elseif(strlen(trim($_POST['last_name'])) < 2){
            $last_name_err = "lastname must have atleast 2 characters.";
        } else{
            $last_name = trim($_POST['last_name']);
        }
        
         // Validate email
        
        if(empty(trim($_POST["email"]))){
            $email_err = "Please enter a email.";     
        } 
        else{
            $email = trim($_POST['email']);
        }
        
         // Validate contact

        if(empty(trim($_POST["contact"]))){
            $contact_err = "Please enter a contact.";     
        } 
        else{
            $contact = trim($_POST['contact']);
        }

      

        // Check input errors before inserting in database

        if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($first_name_err) && empty($last_name_err) && empty($email_err) && empty($contact_err)){

            

            // Prepare an insert statement

            $sql = "INSERT INTO users (username, password, first_name, last_name, email, contact ) VALUES ( ?, ?, ?, ?, ?, ?)";

             

            if($stmt = mysqli_prepare($link, $sql)){

                // Bind variables to the prepared statement as parameters

                mysqli_stmt_bind_param($stmt, "ssssss", $param_username, $param_password, $param_first_name, $param_last_name, $param_email, $param_contact);

                

                // Set parameters

                $param_username = $username;

                $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
                $param_first_name = $first_name;
                $param_last_name = $last_name;
                $param_email = $email;
                $param_contact = $contact;
             

                // Attempt to execute the prepared statement

                if(mysqli_stmt_execute($stmt)){

                    // Redirect to login page

                    header("location: login.php");

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

    <html lang="en">

    <head>

        <meta charset="UTF-8">

        <title>Sign Up</title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">

        <style type="text/css">

            body{ font: 14px sans-serif;  }
            body { background-color: lightblue;
                 }
           
            .wrapper{ width: 350px; padding: 20px; }

        </style>

    </head>

    <body>

        <div class="wrapper">

            <h2>Sign Up</h2>

            <p>Please fill this form to create an account.</p>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">

                    <label>Username</label>

                    <input type="text" name="username"class="form-control" value="<?php echo $username; ?>">

                    <span class="help-block"><?php echo $username_err; ?></span>

                </div>    

                <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">

                    <label>Password</label>

                    <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">

                    <span class="help-block"><?php echo $password_err; ?></span>

                </div>

                <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">

                    <label>Confirm Password</label>

                    <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">

                    <span class="help-block"><?php echo $confirm_password_err; ?></span>

                </div>

                 <div class="form-group <?php echo (!empty($first_name_err)) ? 'has-error' : ''; ?>">

                    <label>first_name</label>

                    <input type="text" name="first_name"class="form-control" value="<?php echo $first_name; ?>">

                    <span class="help-block"><?php echo $first_name_err; ?></span>

                </div>    

                 <div class="form-group <?php echo (!empty($last_name_err)) ? 'has-error' : ''; ?>">

                    <label>last_name</label>

                    <input type="text" name="last_name"class="form-control" value="<?php echo $last_name; ?>">

                    <span class="help-block"><?php echo $last_name_err; ?></span>

                </div> 

                <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">

                    <label>email</label>

                    <input type="text" name="email"class="form-control" value="<?php echo $email; ?>">

                    <span class="help-block"><?php echo $email_err; ?></span>

                </div>       

                 <div class="form-group <?php echo (!empty($contact_err)) ? 'has-error' : ''; ?>">

                    <label>contact</label>

                    <input type="text" name="contact"class="form-control" value="<?php echo $contact; ?>">

                    <span class="help-block"><?php echo $contact_err; ?></span>

                </div>       
                
              


                <div class="form-group">

                    <input type="submit" class="btn btn-primary" value="Submit">

                    <input type="reset" class="btn btn-default" value="Reset">

                </div>
               
                <p>Already have an account? <a href="../event/login.php">Login here</a>.</p>

            </form>

        </div>    

    </body>

    </html>

