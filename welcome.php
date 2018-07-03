

    <?php

    // Initialize the session

    session_start();

     

    // If session variable is not set it will redirect to login page

    if(!isset($_SESSION['username']) || empty($_SESSION['username'])){

      header("location: welcome.php");

      exit;

    }

    ?>

     

    <!DOCTYPE html>

    <html lang="en">

    <head>

        <meta charset="UTF-8">

        <title>Welcome</title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">

        <style type="text/css">

            body{ font: 14px sans-serif; text-align: center; }

        </style>

    </head>

    <body>

        <div class="page-header">

            <h1>Hi, <b><?php echo htmlspecialchars($_SESSION['username']); ?></b>. You have successfully booked a ticket</h1>
           
           <style>
      #map {
        height: 400px;
        width: 100%;
       }
    </style>
  </head>
  <body>
    <h3>for any queries kindly call us on - <b>9821255811</b></h3>
    <h3>you can visit our store at the given location </h3>
    <div id="map"></div>
    <script>
      function initMap() {
        var uluru = {lat: 19.076774999999998, lng:  72.8977422};
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 4,
          center: uluru
        });
        var marker = new google.maps.Marker({
          position: uluru,
          map: map
        });
      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC1wqyOLmbCg4_UmOBz79U066vz7J9tbCw&callback=initMap">
    </script>


        </div>

        <p><a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a></p>
         

    </body>

    </html>

