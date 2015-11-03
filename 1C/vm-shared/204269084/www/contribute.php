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
      <h1>Add Person</h1>
      <div class="large-12 columns">
        <form method="GET">
          <!-- Fieldset just groups together related form data -->
          <fieldset>
            <legend>Actor/director information</legend>
            <!-- Names -->
            <span>
              <label>First name:</label>
              <input type="text" name="first_name" autocomplete="off">
              <label>Last name:</label>
              <input type="text" name="last_name" autocomplete="off">
            </span>
            <!-- DOB and DOD -->
            <br>
            <span>
              <label>Date of birth:</label>
              <input type="text" name="birth_date" placeholder="YYYY-MM-DD" autocomplete="off">
              <label>Date of death:</label>
              <input type="text" name="death_date" placeholder="NULL if N/A" autocomplete="off">
            </span>
            <!-- Actor or director? -->
            <br>
            <span>
              <input type="radio" name="person_type" value="actor" autocomplete="off"><label>Actor</label>
              <input type="radio" name="person_type" value="director" autocomplete="off"><label>Director</label>
            </span>
            <!-- Female or male? -->
            <br>
            <span>
              <input type="radio" name="sex" value="female" autocomplete="off"><label>Female</label>
              <input type="radio" name="sex" value="male" autocomplete="off"><label>Male</label>
            </span>
            <br>
            <!-- TODO: Get a nicer submit button -->
            <input type="submit" value="Submit">
          </fieldset>
        </form>
      </div>
    </div>

    <?php 
      // Show errors in PHP
      // ini_set('display_errors', 1);
      // ini_set('display_startup_errors', 1);
      // error_reporting(E_ALL);

      // Having a link identifier lets MySQL determine the character set to use
      // See: http://bit.ly/1isaeWS
      $person_type = mysql_real_escape_string($_GET['person_type'], $db_connect);
      $last_name = mysql_real_escape_string($_GET['last_name'], $db_connect);
      $first_name = mysql_real_escape_string($_GET['first_name'], $db_connect);
      $sex = mysql_real_escape_string($_GET['sex'], $db_connect);
      $birth_date = mysql_real_escape_string($_GET['birth_date'], $db_connect);
      $death_date = mysql_real_escape_string($_GET['death_date'], $db_connect);

      // Handle missing field input
      if ( empty($person_type) 
        || empty($last_name)
        || empty($first_name)
        || empty($sex)
        || empty($birth_date)
        || empty($death_date) 
      ) {
        echo "<div class=\"row\">
                <div class=\"large-12 columns\">
                  <p>
                    All fields are required. Please try again.
                  </p>
                </div>
              </div>";
      }
      else {
        // Update the max ID for a new person
        $id_update = "INSERT INTO MaxPersonID VALUES (id = (SELECT * FROM MaxPersonID) + 1);";
        mysql_query($id_update, $db_connect);
        echo "The result of the ID update: " . $id_update;

        // Get person's ID
        $id_query = "SELECT * FROM MaxPersonID;";
        $person_id = mysql_query($id_query, $db_connect);

        // Create SQL query of form INSERT INTO <table> VALUES (301, "Laro", ...)
        $insert = "INSERT INTO %s VALUES(%s, %s, %s, %s, %s, %s);";
        $insert = sprintf($insert, $person_type, $person_id, $last_name, $first_name, $sex, $birth_date, $death_date);
        
        echo "<div class=\"row\">
                <div class=\"large-12 columns\">
                  <p>Your query:</p>
                  <pre>" .
                    $insert
                  .
                  "</pre>
                </div>
              </div>";

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



