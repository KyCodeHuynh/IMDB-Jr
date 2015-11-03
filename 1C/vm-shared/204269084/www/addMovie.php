<!DOCTYPE htmL> 
<html>
  <!-- HEAD -->
  <head>
    <title>Contribute to IMDB Jr.</title>

    <!-- Use UTF-8, and responsively match screen width 
         Add "user-scalable=0" if want to disable user zoom, 
         which is preceded by a 300 ms tap delay on iOS. -->
    <meta charset="UTF-8"> 
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.00"/>

    <!-- CSS stylesheets -->
    <link rel="stylesheet" type="text/css" href="css/foundation.min.css">
    <link rel="stylesheet" type="text/css" href="css/app.css">

    <!-- Database set-up -->
    <?php
      // Connect to database, with check for failure to connect
      // db_connect is a MySQL link identiifer, i.e., a name for the link
      $db_connect = mysql_connect("localhost", "cs143", "");  
      if ($db_connect->connect_error) {
        die("Connection failed: " . $db_connect->connect_error);
      }

      // TODO: Switch to "CS143" for production!
      // Select which database we'll use
      // Specifying a link identifier lets it know which link to use
      mysql_select_db("TEST", $db_connect)
     ?>
  </head>

  <!-- BODY -->
  <body>
    <div class="row">
      <div class="large-12 columns">
        <h1>Add Movie</h1>
        <form method="GET">
          <textarea name="director-name" cols="100" rows="1"></textarea>
          <br/>
          <!-- Since '#' means we go to the current page, the GET request
               URL parameters will be passed on from our filled-out forms -->
          <input type="submit" value="Submit">
        </form>
      </div>
    </div>

    <!-- TODO: Movie info -->
    <!-- TODO: Movie comments -->
    <!-- TODO: Movie reviews require a TIMESTAMP -->
    <!-- TODO: Actor to movie relation -->
    <!-- TODO: Director to movie relation -->

    <!-- Never forget to close an opened resource -->
    <?php 
      mysql_close($db_connect);
     ?>

    <!-- JavaScript -->
    <script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="js/foundation.min.js"></script
  </body>
</html>
