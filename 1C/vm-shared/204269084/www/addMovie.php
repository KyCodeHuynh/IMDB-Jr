<!DOCTYPE htmL> 
<html>
  <!-- HEAD -->
  <head>
    <title>Add a Movie</title>

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
        <h1><a href="./addMovie.php">Add a Movie</a></h1>
      </div>
    </div>

    <div class="row">
      <form method="GET">
        <fieldset>
        <legend>Movie Information</legend>

          <label>Movie Title</label>
          <input type="text" name="title" autocomplete="off">

          <!-- TODO: Use this date type across other pages too?
          It automatically enforces valid numbers for months and days -->
          <label>Year of Release</label>
          <input type="text" name="year" placeholder="YYYY-MM-DD" autocomplete="off">

          <label>MPAA Rating</label>
          <select name="rating">
            <option value="G">G</option>
            <option value="PG">PG</option>
            <option value="PG-13">PG-13</option>
            <option value="R">R</option>
            <option value="UR">UR</option>
          </select>

          <label>Production Company</label>
          <input type="text" name="company">

          <input type="submit" class="small submit button" value="Submit">
          <input type="reset" class="small secondary button" value="Reset">
        </fieldset>
      </form>
    </div>

    <?php 
      // Grab field values
      $title = mysql_real_escape_string($_GET['title']);
      $year = mysql_real_escape_string($_GET['year']);
      $rating = mysql_real_escape_string($_GET['rating']);
      $company = mysql_real_escape_string($_GET['company']);

      if ( empty($title) 
        || empty($year)
        || empty($rating)
        || empty($company)
      ) {
        echo "<div class=\"row\">
                <div class=\"large-12 columns\">
                  <p>
                    All fields are required.
                  </p>
                </div>
              </div>";
      }
      else {
        // Update the max ID for a new movie
        $id_update = "UPDATE MaxMovieID SET id=id+1;";
        mysql_query($id_update, $db_connect);

        // Get person's ID
        $id_query = "SELECT * FROM MaxMovieID;";
        $result = mysql_query($id_query, $db_connect);
        $movie_id = mysql_fetch_row($result)[0];

        // Set-up SQL query 
        $insert = "INSERT INTO Movie (id, title, year, rating, company)
          VALUES (%s, '%s', '%s', '%s', '%s');";
        $insert = sprintf($insert, $movie_id, $title, $year, $rating, $company);

        // TODO: Debugging only
        echo "<div class=\"row\">
              <div class=\"large-12 columns\">
                <p>
                  Your ID update result was: 
                  <pre>" .
                      $movie_id
                  .
                    "</pre>
                </p>
              </div>
            </div>";

        // TODO: This insert is failing. 
        mysql_query($insert, $db_connect);

        echo "<div class=\"row\">
              <div class=\"large-12 columns\">
                <p>
                  Thanks!
                </p>
              </div>
            </div>";
      }
     ?>

    <!-- Never forget to close an opened resource -->
    <?php 
      mysql_close($db_connect);
     ?>

    <!-- JavaScript -->
    <script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="js/foundation.min.js"></script
  </body>
</html>
