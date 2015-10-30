<!-- Lets users add information about actors, directors, movies, plus comments -->
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
    <link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min  .css">
    <link rel="stylesheet" type="text/css" href="css/styles.css"

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
      mysql_select_db("CS143", $db_connect)
     ?>
  </head>

  <!-- BODY -->
  <body>
  <!-- TODO: Add in fields for other info besides name -->
    <!-- TODO: Replace with radio button to select actor/director -->
    <div class="container">
      <h1>Add Actor</h1>
        <form method="GET">
          <textarea name="actor-name" cols="100" rows="1"></textarea>
          <br/>
          <input type="submit" value="Submit">
        </form>
    </div>

    <div class="container">
      <h1>Add Director</h1>
        <form method="GET">
          <textarea name="director-name" cols="100" rows="1"></textarea>
          <br/>
          <input type="submit" value="Submit">
        </form>
    </div>

    <!-- TODO: Movie info -->
    <!-- TODO: Movie comments -->
    <!-- TODO: Actor to movie relation -->
    <!-- TODO: Director to movie relation -->
    
    <!-- Never forget to close an opened resource -->
    <?php 
      mysql_close($db_connect);
     ?>

    <!-- JavaScript -->
    <script type="text/javascript" src="./js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="./js/bootstrap.min.js"></script>
  </body>
</html>



