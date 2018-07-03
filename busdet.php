

    <?php
    // Include config file
    require_once 'config.php';
    
    // Define variables and initialize with empty values

    $bus_agency = $from_location = $to_location =  $passenger_name = $date_of_travel = $contact = $age = $gender = "";
    $bus_agency_err = $from_location_err = $to_location_err = $passenger_name_err = $date_of_travel_err = $contact_err = $age_err = $gender_err = "";

     

    // Processing form data when form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // Validate bus_agency
        if(empty(trim($_POST["bus_agency"]))){
            $bus_agency_err = "Please enter a bus_agency.";
        } else{
            // Prepare a select statement
            $sql = "SELECT id FROM details WHERE bus_agency = ?";
            if($stmt = mysqli_prepare($link, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "s", $param_bus_agency);
                // Set parameters
                $param_bus_agency = trim($_POST["bus_agency"]);

                

                // Attempt to execute the prepared statement

                if(mysqli_stmt_execute($stmt)){
                   /* store result */

                     mysqli_stmt_store_result($stmt);

                    

                    if(mysqli_stmt_num_rows($stmt) == 10000){

                        $bus_agency_err = "This bus_agency is already taken.";

                    } else{

                        $bus_agency = trim($_POST["bus_agency"]);

                    }

                } else{

                    echo "Oops! Something went wrong. Please try again later.";

                }

            }

             

            // Close statement

            mysqli_stmt_close($stmt);

        }

        

        // Validate from_location

        if(empty(trim($_POST['from_location']))){
            $from_location_err = "Please enter a from_location.";     
        } elseif(strlen(trim($_POST['from_location'])) < 3){
            $from_location_err = "from_location must have atleast 3 characters.";
        } else{
            $from_location = trim($_POST['from_location']);
        }
       
        // Validate confirm to_location
        if(empty(trim($_POST["to_location"]))){
            $to_location_err = 'Please confirm to_location.';     
        } else{

            $to_location = trim($_POST['to_location']);

            

        }

        // Validate passenger_name

        if(empty(trim($_POST["passenger_name"]))){
            $passenger_name_err = "Please enter a firstname.";     
        } elseif(strlen(trim($_POST['passenger_name'])) < 2){
            $passenger_name_err = "firstname must have atleast 2 characters.";
        } else{
            $passenger_name = trim($_POST['passenger_name']);
        }
        

         // Validate date_of_travel

        if(empty(trim($_POST["date_of_travel"]))){
            $date_of_travel_err = "Please enter a lastname.";     
        } elseif(strlen(trim($_POST['date_of_travel'])) < 2){
            $date_of_travel_err = "lastname must have atleast 2 characters.";
        } else{
            $date_of_travel = trim($_POST['date_of_travel']);
        }
        
         // Validate age
        
        if(empty(trim($_POST["age"]))){
            $age_err = "Please enter a age.";     
        } 
        else{
            $age = trim($_POST['age']);
        }
        
         // Validate contact

        if(empty(trim($_POST["contact"]))){
            $contact_err = "Please enter a contact.";     
        } 
        else{
            $contact = trim($_POST['contact']);
        }

        // Validate date_of_travel

        if(empty(trim($_POST["gender"]))){
            $gender_err = "Please enter a eventname.";     
        } elseif(strlen(trim($_POST['date_of_travel'])) < 2){
            $gender_err = "event must have atleast 2 characters.";
        } else{
            $gender = trim($_POST['gender']);
        }

        // Check input errors before inserting in database

        if(empty($bus_agency_err) && empty($from_location_err) && empty($to_location_err) && empty($passenger_name_err) && empty($date_of_travel_err) && empty($age_err) && empty($contact_err)){

            

            // Prepare an insert statement

            $sql = "INSERT INTO details (bus_agency, from_location, to_location, passenger_name, date_of_travel, age, contact, gender ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

             

            if($stmt = mysqli_prepare($link, $sql)){

                // Bind variables to the prepared statement as parameters

                mysqli_stmt_bind_param($stmt, "ssssssss", $param_bus_agency, $param_from_location, $param_to_location ,$param_passenger_name, $param_date_of_travel, $param_age, $param_contact, $param_gender);

                

                // Set parameters

                $param_bus_agency = $bus_agency;
                $param_to_location = $to_location;
                $param_from_location = $from_location;
                $param_passenger_name = $passenger_name;
                $param_date_of_travel = $date_of_travel;
                $param_age = $age;
                $param_contact = $contact;
                $param_gender = $gender;
                

                // Attempt to execute the prepared statement

                if(mysqli_stmt_execute($stmt)){

                    // Redirect to login page

                    header("location: pay.php");

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

        <title>Fill in the details</title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">

        <style type="text/css">

            body{ font: 30px sans-serif;  color:black;}
            body {
                   background-image: url("bus_image3.jpg");

                  }
           
            .wrapper{ width: 350px; padding: 20px; }

        </style>

    </head>

    <body>
        
    
        <div class="wrapper">

            <h2>Fill the details</h2>

    

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                <div class="form-group <?php echo (!empty($bus_agency_err)) ? 'has-error' : ''; ?>">

                    <label>bus_agency</label>
                         <select name="bus_agency" class="form-control" value="<?php echo $bus_agency; ?>" >
                        <option value="Eagle falcon">Eagle falcon</option>
                        <option value="Sangita travel agency">Sangita travel agency</option>
                        <option value="N.B.S TRAVELS">N.B.S TRAVELS</option>
                         <option value="Daksh travels">Daksh travels</option>
                          <option value="Rajdhani travels">Rajdhani travels</option>
                           <option value="Citizen travels">Citizen travels</option>
                            <option value="Orange travels">Orange travels</option>
                             <option value="SRH travels">SRH travels</option>
                              <option value="Neeta tours and travels">Neeta tours and travels</option>

                    </select>


                    
                    <span class="help-block"><?php echo $bus_agency_err; ?></span>

                </div>    

                <div class="form-group <?php echo (!empty($from_location_err)) ? 'has-error' : ''; ?>">

                    <label>from_location</label>
                     <select name="from_location" class="form-control" value="<?php echo $from_location; ?>" >
                        <option value="mumbai">Mumbai</option>
                        <option value="pune">pune</option>
                        <option value="rajkot">rajkot</option>
                         <option value="ahmedabad">ahmedabad</option>
                          <option value="nagpur">nagpur</option>
                           <option value="banglore">banglore</option>
                            <option value="mysore">mysore</option>
                             <option value="rajasthan">rajasthan</option>
                              <option value="surat">surat</option>

                    </select>


                    <span class="help-block"><?php echo $from_location_err; ?></span>

                </div>

                <div class="form-group <?php echo (!empty($to_location_err)) ? 'has-error' : ''; ?>">

                    <label>to_location</label>
                     <select name="to_location" class="form-control" value="<?php echo $to_location; ?>" >
                        <option value="mumbai">Mumbai</option>
                     <option value="pune">pune</option>
                        <option value="rajkot">rajkot</option>
                         <option value="ahmedabad">ahmedabad</option>
                          <option value="nagpur">nagpur</option>
                           <option value="banglore">banglore</option>
                            <option value="mysore">mysore</option>
                             <option value="rajasthan">rajasthan</option>
                              <option value="surat">surat</option>

                    </select>

                    
                    <span class="help-block"><?php echo $to_location_err; ?></span>

                </div>

                
                 <div class="form-group <?php echo (!empty($date_of_travel_err)) ? 'has-error' : ''; ?>">

                    <label>date_of_travel</label>

                    <input type="date" name="date_of_travel"class="form-control" value="<?php echo $date_of_travel; ?>">

                    <span class="help-block"><?php echo $date_of_travel_err; ?></span>

                </div> 

                 <div class="form-group <?php echo (!empty($passenger_name_err)) ? 'has-error' : ''; ?>">

                    <label>passenger_name</label>

                    <input type="text" name="passenger_name"class="form-control" value="<?php echo $passenger_name; ?>">

                    <span class="help-block"><?php echo $passenger_name_err; ?></span>

                </div>    

                 

                <div class="form-group <?php echo (!empty($age_err)) ? 'has-error' : ''; ?>">

                    <label>age</label>

                    <input type="text" name="age"class="form-control" value="<?php echo $age; ?>">

                    <span class="help-block"><?php echo $age_err; ?></span>

                </div>       

                 <div class="form-group <?php echo (!empty($contact_err)) ? 'has-error' : ''; ?>">

                    <label>contact</label>

                    <input type="text" name="contact"class="form-control" value="<?php echo $contact; ?>">

                    <span class="help-block"><?php echo $contact_err; ?></span>

                </div>       
                
                <div class="form-group <?php echo (!empty($gender_err)) ? 'has-error' : ''; ?>">

                    <label>gender</label>
                     <select name="gender" class="form-control" value="<?php echo $gender; ?>" >
                        <option value="male">Male</option>
                     <option value="female">Female</option>
                       
                    </select>
                   
                    <span class="help-block"><?php echo $gender_err; ?></span>

                </div>       


                <div class="form-group">

                    <input type="submit" class="btn btn-primary" value="Submit">

                    <input type="reset" class="btn btn-default" value="Reset">

                </div>
               
              
            </form>

        </div>    

    </body>

    </html>

