<!DOCTYPE htmL> 
<html>
  <head>
    <title>Associate an Actor with a Movie</title>

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
      mysql_select_db("CS143", $db_connect)
     ?>
  </head>

  <body>
      <div class="row">
          <h1><a href="./addActor2Movie.php">Associate an Actor with a Movie</a></h1>
      </div>

      <div class="row">
        <form method="GET">
          <fieldset>
          <legend>Acting Credits</legend>

            <label>Movie Title</label>
            <input type="text" name="title" autocomplete="off">

            <label>Actor's First Name</label>
            <input type="text" name="first_name" autocomplete="off">

            <label>Actor's Last Name</label>
            <input type="text" name="last_name" autocomplete="off">

            <label>Actor's Role</label>
            <input type="text" name="role" autocomplete="off">

            <input type="submit" class="small submit button" value="Submit">
            <input type="reset" class="small secondary button" value="Reset">
          </fieldset>
        </form>
      </div>

    <?php 
      // Grab field values
      $title = mysql_real_escape_string($_GET['title']);
      $first_name = mysql_real_escape_string($_GET['first_name']);
      $last_name = mysql_real_escape_string($_GET['last_name']);
      $role = mysql_real_escape_string($_GET['role']);

      if ( empty($title) 
        || empty($first_name)
        || empty($last_name)
        || empty($role)
      ) {
        echo "<div class=\"row\">
                <div class=\"large-12 columns\">
                  <p>
                    All fields are required.
                  </p>
                </div>
              </div>";
      } else {
        // Set-up SQL query 
        $movie_statement = "SELECT id FROM Movie WHERE title=\"".$title."\";";
        $mid_query = mysql_query($movie_statement, $db_connect);

        if (mysql_num_rows($mid_query) == 0) {
          print "This is not a valid movie.";
        } else {
          $mid_row = mysql_fetch_row($mid_query);
          $mid = $mid_row[0];

          // Set-up SQL query 
          $actor_state = "SELECT id FROM Actor WHERE first=\"".$first_name."\" AND last=\"".$last_name."\";";
          $act_query = mysql_query($actor_state, $db_connect);

          if (mysql_num_rows($act_query) == 0) {
            print "This is not a valid actor.";
          } else {
            $aid_row = mysql_fetch_row($act_query);
            $aid = $aid_row[0];
            $insert = "INSERT INTO MovieActor (mid, aid, role) VALUES ('%s', '%s', '%s');";
            $insert = sprintf($insert, $mid, $aid, $role);          
            mysql_query($insert, $db_connect);
            echo "<div class=\"row\">
                  <div class=\"large-12 columns\">
                    <p>
                      Thanks!
                    </p>
                  </div>
                </div>";
          }
        }
      }
     ?>

      <!-- Never forget to close an opened resource -->
      <?php 
        mysql_close($db_connect);
       ?>

      <!-- JavaScript -->
      <script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
      <script type="text/javascript" src="js/foundation.min.js"></script>
  </body>
</html>