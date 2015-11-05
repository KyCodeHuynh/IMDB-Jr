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
      mysql_select_db("CS143", $db_connect);
     ?>
  </head>

  <body>

  <div class="row">
      <div class="large-12 large-centered columns">
        <ul class="button-group">
          <li><a class="button" href="search.php">Search</a></li>
          <li><a class="button" href="showMovie.php">Show Movies</a></li>
          <li><a class="button" href="showActor.php">Show Actors</a></li>
          <li><a class="button" href="addPerson.php">Add an Actor or Director</a></li>
          <li><a class="button" href="addMovie.php">Add a Movie</a></li>
          <li><a class="button" href="addComments.php">Add Comments About a Movie</a></li>
          <li><a class="button" href="addDirector2Movie.php">Associate a Director with a Movie</a></li>
          <li><a class="button" href="addActor2Movie.php">Associate an Actor with a Movie</a></li>
        </ul>
      </div>
    </div>
    <div class="row">
      <div class="large-12 columns">
          <h1><a href="./showMovie.php">Movie Profile</a></h1>
      </div>  
          <?php 
              // Prints out movie info from the table
              function printMovieInfo($tbl_results) {
                // Sanity check
                if (mysql_num_rows($tbl_results) == 0) {
                  print "This movie was not found in our database for display.";
                }

                // find out how many columns there are
                $field_num = mysql_num_fields($tbl_results);
                $movie_row = mysql_fetch_row($tbl_results);

                // Starts at j=1 to ignore the first mid
                for ($j = 1; $j < $field_num; $j++) {
                  $field_name = mysql_field_name($tbl_results, $j);
                  if($field_name != "mid") {
                    $item = $movie_row[$j];
                    print ucwords($field_name).": ".$item."<br>";
                  }
                }
              }

              function printDirectorInfo($tbl_results) {
                if (mysql_num_rows($tbl_results) == 0) {
                  print "No director was found in our database.<br>";
                } else {
                    // find out how many columns there are
                  $field_num = mysql_num_fields($tbl_results);
                  $row_num = mysql_num_rows($tbl_results);
                  print "Director: ";

                  // Changed to for loop to keep track of how many directors there are
                  for($i = 0; $i < $row_num; $i++) {
                    $dir_row = mysql_fetch_row($tbl_results);
                    // Starts at j=1 to ignore the first mid
                    for ($j = 1; $j < $field_num; $j++) {
                      $field_name = mysql_field_name($tbl_results, $j);
                      if($field_name == "last") {
                        print $dir_row[$j+1]." ".$dir_row[$j]." (".$dir_row[$j+2].")";
                        break;
                      }
                    }
                    // Adds commas if there are multiple actors
                    if (($i+1) < $row_num) {
                      print ", ";
                    }
                  }
                  print "<br>";
                }
              }

              function printActorInfo($tbl_results) {
                if (mysql_num_rows($tbl_results) == 0) {
                  print "No actors/actresses were found in our database.<br>";
                } else {
                    // find out how many rows there are
                  $row_num = mysql_num_rows($tbl_results);
                  print "<h3> Actors/Actresses featured in this film: </h3>";

                  // Since we customized our table to have "first name, last name, role, mid"
                  // I hard-coded the numbers for the display
                  // (Ideally we would want to use variables if we changed the order)
                  for($i = 0; $i < $row_num; $i++) {
                    $act_row = mysql_fetch_row($tbl_results);                   
                    print "<a href=\"./showActor.php?aid=".$act_row[3]."\">".$act_row[0]." ".$act_row[1]."</a> as ".$act_row[2]."<br>" ;
                  }
                }
              }

              function printCommentInfo($tbl_results, $row_num) {
                // Since we customized our table to have "first name, last name, role, mid"
                // I hard-coded the numbers for the display
                // (Ideally we would want to use variables if we changed the order)
                for($i = 0; $i < $row_num; $i++) {
                  $act_row = mysql_fetch_row($tbl_results);
                  // We want to have the name first, then their time stamp under, then their comment
                  print $act_row[0]." || ".$act_row[1]." || Rating: ".$act_row[3]."<br>Comment: ".$act_row[4]."<br><br>";
                }
              }

              function printGenreInfo($tbl_results) {
                if (mysql_num_rows($tbl_results) == 0) {
                  print "No genre was found in our database.<br>";
                } else {
                    // find out how many columns there are
                  $field_num = mysql_num_fields($tbl_results);
                  $row_num = mysql_num_rows($tbl_results);
                  print "Genre: ";

                  // Changed to for loop to keep track of how many directors there are
                  for ($i = 0; $i < $row_num; $i++) {
                    // Starts at j=1 to ignore the first mid
                    $gen_row = mysql_fetch_row($tbl_results);
                    print $gen_row[1];

                    if (($i+1) < $row_num) {
                      print ", ";
                    }
                  }
                  print "<br>";
                }



              }              

              $mid = $_GET["mid"];  
              if (!empty($mid)) {
                $movie_query = "SELECT * FROM Movie WHERE id = ".$mid.";";
                $mov_results = mysql_query($movie_query, $db_connect); 

                if (mysql_num_rows($mov_results) == 0) {
                  print "This movie was not found in our database.<br>";
                } else {
                  //Not every movie has a genre.. so we have to do a left outer join or a separate query
                  $movie_genre = "SELECT * FROM MovieGenre WHERE mid = ".$mid.";";
                  $genre_results = mysql_query($movie_genre, $db_connect);

                  $director_query = "SELECT * FROM Director AS D WHERE D.id IN (SELECT did FROM MovieDirector WHERE mid = ".$mid.");";
                  $director_results = mysql_query($director_query, $db_connect);

                  $actor_query = "SELECT Act.first, Act.last, Mov.role, Act.id FROM MovieActor AS Mov, Actor AS Act WHERE Mov.mid = ".$mid." AND Act.id = Mov.aid;";
                  $actor_results = mysql_query($actor_query, $db_connect);                  

                  printMovieInfo($mov_results); 
                  printDirectorInfo($director_results);
                  printGenreInfo($genre_results);
                  printActorInfo($actor_results);

                  $user_query1 = "SELECT * FROM Review WHERE mid=".$mid.";";
                  $user_query2 = "SELECT AVG(rating) FROM Review WHERE mid=".$mid.";";
                  $user_results = mysql_query($user_query1, $db_connect);   
                  $user_average = mysql_query($user_query2, $db_connect); 
                  $row_num = mysql_num_rows($user_results);
                  print "<br>";
                  print "<h3>User Reviews</h3>";
                  if ($row_num != 0) {
                    $avg = mysql_fetch_row($user_average);
                    print "<h5>Average Rating (out of ".$row_num." reviews): ".$avg[0]."</h5>";
                    printCommentInfo($user_results, $row_num);
                  } else {
                    print "There are no user reviews for this movie. <br>";
                  }
                  print "<a href=\"./addComments.php?\">Add your review here!</a><br>";  
                }
              }
          ?>
          <br>

          <?php
            if (isset($_POST["searchButton"])) {
              header ( "Location: ./search.php?query=".$_POST["query"] );
              exit;
            }
          ?>

          <!-- Submit this to the "search page" -->
          <p>Search for a Movie or Actor/Actress:</p>
          <form method="POST">
            <textarea name="query" cols="50" rows="1"></textarea>
            <input type="submit" class="small submit button" value="Submit" id ="searchButton" name="searchButton">
            <input type="reset" class="small secondary button" value="Reset">
          </form>  
    </div>
    
    <!-- Never forget to close an opened resource -->
    <?php 
      mysql_close($db_connect);
     ?>

    <!-- JavaScript -->
    <script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="js/foundation.min.js"></script
  </body>
</html>



