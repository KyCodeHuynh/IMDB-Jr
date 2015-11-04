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

      // Select which database we'll use
      // Specifying a link identifier lets it know which link to use
      mysql_select_db("CS143", $db_connect)
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

          <!-- It automatically enforces valid numbers for months and days -->
          <label>Year of Release</label>
          <input type="text" name="year" placeholder="YYYY" autocomplete="off">

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

          <label>Genre</label>
          <input type="checkbox" name="genre[]" value="Action"> Action
          <input type="checkbox" name="genre[]" value="Adult"> Adult
          <input type="checkbox" name="genre[]" value="Adventure"> Adventure
          <input type="checkbox" name="genre[]" value="Animation"> Animation
          <input type="checkbox" name="genre[]" value="Comedy"> Comedy
          <input type="checkbox" name="genre[]" value="Crime"> Crime
          <input type="checkbox" name="genre[]" value="Documentary"> Documentary
          <input type="checkbox" name="genre[]" value="Drama"> Drama
          <input type="checkbox" name="genre[]" value="Family"> Family
          <input type="checkbox" name="genre[]" value="Fantasy"> Fantasy
          <input type="checkbox" name="genre[]" value="Horror"> Horror
          <input type="checkbox" name="genre[]" value="Musical"> Musical
          <input type="checkbox" name="genre[]" value="Mystery"> Mystery
          <input type="checkbox" name="genre[]" value="Romance"> Romance
          <input type="checkbox" name="genre[]" value="Sci-Fi"> Sci-Fi
          <input type="checkbox" name="genre[]" value="Short"> Short
          <input type="checkbox" name="genre[]" value="Thriller"> Thriller
          <input type="checkbox" name="genre[]" value="War"> War     
          <input type="checkbox" name="genre[]" value="Western"> Western
          <br>

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
      $genre = $_GET['genre'];

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

        mysql_query($insert, $db_connect);

        // Insert into Movie Genre as well
        foreach($genre as $gen_select) {
          $genre_insert = "INSERT INTO MovieGenre (mid, genre) VALUES (%s, '%s');";
          $genre_insert = sprintf($genre_insert, $movie_id, $gen_select);
          mysql_query($genre_insert, $db_connect); 
        }

        // Debugging only
        // echo "<div class=\"row\">
        //       <div class=\"large-12 columns\">
        //         <p>
        //           Your ID update result was: 
        //           <pre>" .
        //               $movie_id
        //           .
        //             "</pre>
        //         </p>
        //       </div>
        //     </div>";

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
