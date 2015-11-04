<!DOCTYPE htmL> 
<html>
  <head>
    <title>IMDB Jr.</title>

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

      // Select which database we'll use
      // Specifying a link identifier lets it know which link to use
      mysql_select_db("CS143", $db_connect)
     ?>
  </head>

  <body>
      <div class="row">
          <h1>Welcome to IMDB Jr.!</h1>
      </div>

      <div class="row">
        <!-- TODO: Introduce a snazzy navbar! -->
        <ul>
          <li><a href="search.php">Search</a></li>
          <li><a href="showMovie.php?mid=3641">Show Movies</a></li>
          <li><a href="showActor.php?aid=3035">Show Actors</a></li>
          <li><a href="addPerson.php">Add an Actor or Director</a></li>
          <li><a href="addMovie.php">Add a Movie</a></li>
          <li><a href="addComments.php">Add Comments About a Movie</a></li>
          <li><a href="addDirector2Movie.php">Associate a Director with a Movie</a></li>
          <li><a href="addActor2Movie.php">Associate an Actor with a Movie</a></li>
        </ul>

        <p>Welcome to our Internet Movie Database! <br>
          Feel free to look around at some of your favorite films and actors! <br> 
          Who knows, maybe you'll be surprised by what you find...
        </p>

        <h2>Our Favorite Upcoming Movie</h2>
        <p>
          <div class="large-12 columns headline-movie">
            <img src="imgs/star-wars.jpg" alt="The Force Awakens" class="center">
          </div>
        </p>
      </div>

<!--       <div class="row">
        <div class="large-12 columns">
          <h2>Top 5 Rated Movies</h2>
          <?php 
            // A query is normally formed from GET'ed form
            // We sanitized it in all cases against malicious SQL queries
            $query = "SELECT * FROM Review LIMIT 5";
            $sanitized = mysql_real_escape_string($query, $db_connect);
            $results = mysql_query($sanitized, $db_connect);

            // Print out results
            print "<table>";

            // Get the number of columns
            $num_fields = mysql_num_fields($results);

            // First row is the names of the fields
            print "<tr>";
            for ($j = 0; $j < $num_fields; $j++) {
              // Args: results, field-offset
              $num_fields = mysql_field_name($results, $j);
              print "<th>$fieldname</th>";
            }
            print "</tr>";

            // Print remaining rows
            while ($row = mysql_fetch_row($results)) {
              print "<tr>";
              // Print all columns within a row
              for ($i = 0; $i < $num_fields; $i++) {
                $item = $row[$i];
                print "<td>$item</td>";
              }
              print "</tr>";
            }

            print "</table>";
           ?>
          </div>
        </div>
      </div> -->
    
    <!-- Never forget to close an opened resource -->
    <?php 
      mysql_close($db_connect);
     ?>

    <!-- JavaScript -->
    <script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="js/foundation.min.js"></script>
  </body>
</html>



