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
    <link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" type="text/css" href="css/styles.css">

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
    <h1>Add Person</h1>
    <div class="container">
      <form method="GET">
        <!-- Fieldset just groups together related form data -->
        <fieldset>
          <legend>Actor/director information</legend>
          <!-- Names -->
          <span>
            First name:
            <input type="text" name="first_name">
            Last name:
            <input type="text" name="last_name">
          </span>
          <!-- DOB and DOD -->
          <br>
          <span>
            Date of birth:
            <input type="text" name="birth_date" placeholder="YYYY-MM-DD">
            Date of death:
            <input type="text" name="death_date" placeholder="NULL if N/A">
          </span>
          <!-- Actor or director? -->
          <br>
          <span>
            <input type="radio" name="person_type" value="actor" checked>Actor
            <input type="radio" name="person_type" value="director">Director 
          </span>
          <!-- Female or male? -->
          <br>
          <span>
            <input type="radio" name="sex" value="female" checked>Female
            <input type="radio" name="sex" value="male">Male
          </span>
          <br>
          <input type="submit" value="Submit">
        </fieldset>
      </form>
    </div>

    <?php 
      // Having a link identifier lets MySQL determine the character set to use
      // See: http://bit.ly/1isaeWS
      $person_type = mysql_real_escape_string($_GET['person_type']), $db_connect);
      $person_id = 0; // TODO: Get ID
      $last_name = mysql_real_escape_string($_GET['last_name'], $db_connect);
      $first_name = mysql_real_escape_string($_GET['first_name'], $db_connect);
      $sex = mysql_real_escape_string($_GET['sex']), $db_connect);
      $birth_date = mysql_real_escape_string($_GET['birth_date'], $db_connect);
      $death_date = mysql_real_escape_string($_GET['death_date'], $db_connect);

      // TODO: Handle missing field input
      // if (empty($query)) {
      //   echo "All fields are required. Please try again."
      // }
      // else

      // Create SQL query of form INSERT INTO <table> VALUES (301, "Laro", ...)
      $insert = "INSERT INTO " . $person_type 
              . "VALUES" . "("
              . $person_id . ","
              . $last_name . ","
              . $first_name . ","
              . $sex . ","
              . $birth_date . ","
              . $death_date . 
              . ")";

      // Apply the query 
      mysql_query($insert, $db_connect);
     ?>

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
    <!-- TODO: Movie reviews require a TIMESTAMP -->
    <!-- TODO: Actor to movie relation -->
    <!-- TODO: Director to movie relation -->

    <!-- Never forget to close an opened resource -->
    <?php 
      mysql_close($db_connect);
     ?>

    <!-- JavaScript -->
    <script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
  </body>
</html>



