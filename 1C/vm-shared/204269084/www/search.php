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
      <h1><a href="./search.php">Search</a></h1>
      <div class="large-12 columns">
        <div>
          <p>Search for an actor or movie in our database</p>    
          <form method="GET">
            <textarea name="query" cols="50" rows="6"></textarea>
            <br>
            <input type="submit" class="small submit button" value="Submit">
            <input type="reset" class="small secondary button" value="Reset">
          </form>  
          <?php 
              function makeMovieTable($tbl_results) {
                if (mysql_num_rows($tbl_results) == 0) {
                  print "Nothing was found for this query.";
                }
                // print out results in a table
                print "<table>";

                // find out how many columns there are
                $field_num = mysql_num_fields($tbl_results);

                // Create the first row - name and DOB
                print "<tr class='bold'>";
                print "<td>Movie Title</td>";
                print "<td>Year</td>";
                print "</tr>";

                while ($row = mysql_fetch_row($tbl_results)) {
                  print "<tr>";
                  print "<td><a href=\"./showMovie.php?mid=".$row[0]."\">".$row[1]."</a></td>";
                  print "<td>".$row[2]."</td>";
                  print "</tr>";
                }
              }

              function makeActorTable($tbl_results) {
                if (mysql_num_rows($tbl_results) == 0) {
                  print "Nothing was found for this query.";
                }
                // print out results in a table
                print "<table>";

                // find out how many columns there are
                $field_num = mysql_num_fields($tbl_results);

                // Create the first row - name and DOB
                print "<tr class='bold'>";
                print "<td>Actor Name</td>";
                print "<td>Date of Birth</td>";
                print "</tr>";


                while ($row = mysql_fetch_row($tbl_results)) {
                  print "<tr>";
                  print "<td><a href=\"./showActor.php?aid=".$row[0]."\">".$row[2]." ".$row[1]."</a></td>";
                  print "<td>".$row[4]."</td>";
                  print "</tr>";
                }

                print "</table>";
              }

              // Logic for Search Engine of mini IMDB site!
              // For Movies:
              //    1) Look for a movie title in the EXACT wording of the query
              //    2) Look for a movie title containing the exact wording of the query
              //    3) Look for a movie title containing all the words in the query (but could be spread out, in a different order)
              
              // For Actors/Actresses:
              //    1) If there is TWO words:
              //         a) Look for an exact first + last name pairing (either order)
              //         b) If nothing found, look for a first/last name pairing that starts with the query given
                
              //    2) If there's NOT TWO words (either 1, or >= 3):
              //         a) Pattern match for any first/last name that contains anything of what was queried 
              //         b) So if typing "Oprah" -- you would find "Oprah Winfrey"
              //         c) If typing "Win" -- you would find any value that has "Win" in the first or last name
              //         d) If typing anything greater than 3, we'll look for any pattern that matches all three, although its most likely improbable.. more for movie titles     
              $query = $_GET["query"];  
              if (empty($query)) {
                  echo "";
              } else {
                // if the input is not empty, query MySQL and get results
                print "<h2>Results From MySQL</h2>";
                $sanitized = mysql_real_escape_string($query, $db_connect);
                // Separate search words like "Tom Hanks" ."%"to include AND
                $separate_words = explode(" ", $sanitized);
                $and_words = "\"%".$separate_words[0]."%\"";
                $num_of_words = count($separate_words);
                $found_query = false;

                for ($k = 1; $k < $num_of_words; $k++) {
                    $and_words .= " AND "."\"%".$separate_words[$k]."%\"";
                }

                // Create MySQL Query
                $title = "SELECT * FROM Movie AS M WHERE M.title=\"".$sanitized."\";";

                print "CHECKING MOVIES... ";
                // SEND THE RESULT AS A QUERY TO THE DATABASE
                $title_results = mysql_query($title, $db_connect);

                if (mysql_num_rows($title_results) > 0) {
                  makeMovieTable($title_results);
                } else {
                  $statement = "SELECT * FROM Movie WHERE title LIKE \"%".$sanitized."%\";";
                  $results = mysql_query($statement, $db_connect);  
                  if (mysql_num_rows($results) > 0) {
                    makeMovieTable($results);
                  } else {
                    $statement2 = "SELECT * FROM Movie WHERE title LIKE ".$and_words.";";
                    $results2 = mysql_query($statement2, $db_connect);  
                    if (mysql_num_rows($results2) > 0) {
                      makeMovieTable($results2);
                    }                                   
                  }


                }

                // CHECKING ACTOR
                print "<br>CHECKING ACTORS...";

                // If there are two arguments for the query, then try first name, last name
                if(count($separate_words) == 2) {
                  $statement2 = "SELECT * FROM Actor AS A WHERE (A.first=\"".$separate_words[0]."\" AND "."A.last=\"".$separate_words[1]."\") OR (A.first=\"".$separate_words[1]."\" AND "."A.last=\"".$separate_words[0]."\");";

                  $results2 = mysql_query($statement2, $db_connect);                 

                  // If there was something found, then we end here
                  if(mysql_num_rows($results2) > 0) {
                    $found_query = true;
                    makeActorTable($results2);                      
                  } else {
                    // Look for for pattern where (first LIKE "tom", last LIKE "hanks") or (first LIKE "hanks", last LIKE "tom")
                    $statement3 = "SELECT * FROM Actor AS A WHERE (A.first LIKE \"".$separate_words[0]."%\" AND "."A.last LIKE \"".$separate_words[1]."%\") OR (A.first LIKE \"".$separate_words[1]."%\" AND "."A.last LIKE \"".$separate_words[0]."%\");";      
                    $results3 = mysql_query($statement3, $db_connect);                 
                    if(mysql_num_rows($results3) > 0) {
                      $found_query = true;
                      makeActorTable($results3);             
                    }
                  }
                } 

                // If the count is not two, try to find anything similar to the search query 
                else if($found_query == false) {
                  $statement4 = "SELECT * FROM Actor AS A WHERE A.first LIKE ".$and_words." OR A.last LIKE".$and_words.";";
                  $results3 = mysql_query($statement4, $db_connect);                
                  if(mysql_num_rows($results3) > 0) {
                    makeActorTable($results3);
                  }
                }
              }             
            mysql_close($db_connect); 
          ?>
        </div>
      </div>
    </div>
    
    <!-- Never forget to close an opened resource -->
    <?php 
      mysql_close($db_connect);
     ?>

    <!-- JavaScript -->
    <script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="js/foundation.min.js"></script>
  </body>
</html>



