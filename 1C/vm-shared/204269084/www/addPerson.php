<!-- Lets users add information about actors or directors -->
<!DOCTYPE htmL> 
<html>
  <!-- HEAD -->
  <head>
    <title>Add an Actor or Director</title>

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

  <!-- BODY -->
  <body>
    <div class="row">
      <h1><a href="./addPerson.php">Add an Actor or Director</a></h1>
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
            <label>Actor or Director?</label>
            <span>
              <input type="radio" name="person_type" value="Actor" autocomplete="off"><label>Actor</label>
              <input type="radio" name="person_type" value="Director" autocomplete="off" checked><label>Director</label>
            </span>
            <!-- Female or male? -->
            <br>
            <label>Sex</label>
            <span>
              <input type="radio" name="sex" value="female" autocomplete="off" checked><label>Female</label>
              <input type="radio" name="sex" value="male" autocomplete="off"><label>Male</label>
            </span>
            <br>
            <!-- TODO: Get a nicer submit button -->
            <input type="submit" class="small submit button" value="Submit">
            <input type="reset" class="small secondary button" value="Reset">  
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
        || empty($birth_date)
        || empty($death_date) 
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
        // Update the max ID for a new person
        $id_update = "UPDATE MaxPersonID SET id=id+1";
        mysql_query($id_update, $db_connect);

        // Get person's ID
        $id_query = "SELECT * FROM MaxPersonID;";
        $result = mysql_query($id_query, $db_connect);
        $person_id = mysql_fetch_row($result)[0];

        // TODO: Debugging only
        echo "<div class=\"row\">
                <div class=\"large-12 columns\">
                  <br>
                  <p>The attempted ID update:</p>
                  <pre>" .
                    $id_update
                  .
                  "</pre>

                  <br>
                  <p>The returned ID:</p>
                  <pre>" .
                    $person_id
                  .
                  "</pre>
                </div>
              </div>";

        if ($person_type == "Actor") {
          // Create SQL query of form INSERT INTO <table> VALUES (301, "Laro", ...)
          $insert = "INSERT INTO Actor (id, last, first, sex, dob, dod) 
            VALUES (%s, '%s', '%s', '%s', '%s', '%s');";
          $insert = sprintf($insert, $person_id, $last_name, $first_name, $sex, $birth_date, $death_date);
        }
        else {
          // Director has a slightly different schema
          // TODO: Director insert is not working for some reason
          $insert = "INSERT INTO Director (id, last, first, dob, dod) 
            VALUES (%s, '%s', '%s', '%s', '%s');";
          $insert = sprintf($insert, $person_id, $last_name, $first_name, $birth_date, $death_date);
        }
        
        echo "<div class=\"row\">
                <div class=\"large-12 columns\">
                  <br>
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

    <!-- Never forget to close an opened resource -->
    <?php 
      mysql_close($db_connect);
     ?>

    <!-- JavaScript -->
    <script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="js/foundation.min.js"></script
  </body>
</html>



