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
      <div class="large-12 columns">
          <h1><a href="./showActor.php">Actor Profile</a></h1>
      </div>  
          <?php 
              // // Prints out movie info from the table
              // function printMovieInfo($tbl_results) {
              //   // Sanity check
              //   if (mysql_num_rows($tbl_results) == 0) {
              //     print "This movie was not found in our database.";
              //   }

              //   // find out how many columns there are
              //   $field_num = mysql_num_fields($tbl_results);
              //   $movie_row = mysql_fetch_row($tbl_results);

              //   // Starts at j=1 to ignore the first mid
              //   for ($j = 1; $j < $field_num; $j++) {
              //     $field_name = mysql_field_name($tbl_results, $j);
              //     if($field_name != "mid") {
              //       $item = $movie_row[$j];
              //       print ucwords($field_name).": ".$item."<br>";
              //     }
              //   }
              // }

              // function printDirectorInfo($tbl_results) {
              //   if (mysql_num_rows($tbl_results) == 0) {
              //     print "No director was found in our database.";
              //   } else {
              //       // find out how many columns there are
              //     $field_num = mysql_num_fields($tbl_results);
              //     $row_num = mysql_num_rows($tbl_results);
              //     print "Director: ";

              //     // Changed to for loop to keep track of how many directors there are
              //     for($i = 0; $i < $row_num; $i++) {
              //       $dir_row = mysql_fetch_row($tbl_results);
              //       // Starts at j=1 to ignore the first mid
              //       for ($j = 1; $j < $field_num; $j++) {
              //         $field_name = mysql_field_name($tbl_results, $j);
              //         if($field_name == "last") {
              //           print $dir_row[$j+1]." ".$dir_row[$j]." (".$dir_row[$j+2].")";
              //           break;
              //         }
              //       }
              //       // Adds commas if there are multiple actors
              //       if (($i+1) < $row_num) {
              //         print ", ";
              //       }
              //     }
              //   }
              // }

              function printCharInfo($tbl_results) {
                if (mysql_num_rows($tbl_results) == 0) {
                  print "This actor has not been in any movies in our database.";
                } else {
                    // find out how many rows there are
                  $row_num = mysql_num_rows($tbl_results);
                  print "<h5> Movies this actor was in: </h5>";

                  // Since we customized our table to have "first name, last name, role, mid"
                  // I hard-coded the numbers for the display
                  // (Ideally we would want to use variables if we changed the order)
                  // MID IS AVAILABLE FOR LINKS
                  for($i = 0; $i < $row_num; $i++) {
                    $char_row = mysql_fetch_row($tbl_results);
                    print "Acted as \"".$char_row[0]."\" in <a href=\"./showMovie.php?mid=".$char_row[2]."\">".$char_row[1]."</a><br>";
                  }
                }
              }

              function printActorInfo($tbl_results) {
                // Sanity check
                if (mysql_num_rows($tbl_results) == 0) {
                  print "No actors/actresses were found in our database.";
                } else {
                  // Since we customized our table to have "first name, last name, role, mid"
                  // I hard-coded the numbers for the display
                  // (Ideally we would want to use variables if we changed the order)
                  $act_row = mysql_fetch_row($tbl_results);
                  print "Name: ".$act_row[2]." ".$act_row[1]."<br>";
                  print "Sex: ".$act_row[3]."<br>";
                  print "Date of Birth: ".$act_row[4]."<br>";
                  if ($act_row[5] == NULL) {
                    print "Date of Death: -- Still Alive --";
                  } else {
                    print "Date of Death: ".$act_row[5]."<br>";
                  }
                }
              }

              $aid = $_GET["aid"];  
              if (!empty($aid)) {
                $actor_query = "SELECT * FROM Actor WHERE id = ".$aid.";";
                $act_results = mysql_query($actor_query, $db_connect); 

                if (mysql_num_rows($act_results) == 0) {
                  print "This actor/actress was not found in our database.";
                } else {                 

                  // Print their information
                  printActorInfo($act_results);
                  print "<br><br>";
                  $char_query = "SELECT Ma.role, M.title, Ma.mid FROM MovieActor Ma, Movie M WHERE Ma.aid =".$aid." AND M.id = Ma.mid;";
                  $char_results = mysql_query($char_query, $db_connect); 
                  printCharInfo($char_results);

                  // print "<a href=\"./showActor.php?aid=".($aid+1)."\">CLICK ME BECAUSE YOU CAN </a>";
                  // Print what movies they were in
                  // printCharInfo($actor_results);

                  // $user_query1 = "SELECT * FROM Review WHERE mid=".$mid.";";
                  // $user_query2 = "SELECT AVG(rating) FROM Review WHERE mid=".$mid.";";
                  // $user_results = mysql_query($user_query1, $db_connect);   
                  // $user_average = mysql_query($user_query2, $db_connect); 
                  // $row_num = mysql_num_rows($user_results);
                  // if ($row_num != 0) {
                  //   $avg = mysql_fetch_row($user_average);
                  //   print "<h3>User Reviews || Average Rating (out of ".$row_num." reviews): ".$avg[0]."</h3>";
                  //   printCommentInfo($user_results, $row_num);
                  // } else {
                  //   print "There are no user reviews for this movie. <Add your review here!>";  
                  // }

                }
              }
          ?>
          <br>

          <!-- Submit this to the "search page" -->
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



