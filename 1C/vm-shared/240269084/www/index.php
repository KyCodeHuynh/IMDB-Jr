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
    <link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min  .css">
    <link rel="stylesheet" type="text/css" href="css/styles.css"

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
    <div class="container theme-showcase">
      <div class="jumbotron">
          <h1>Welcome</h1>
      </div>

      <!-- TODO: replace with copy text -->
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Qui fugiat
        dolorem quo, quas, natus corporis nulla, officiis voluptas totam dolorum
        iste consequatur magnam officia ea. Iure sequi consectetur quis
        inventore! Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sit
        nisi modi optio, tempore similique officia, nostrum expedita id
        praesentium laboriosam eius, facilis quidem. Doloremque quibusdam
        mollitia sapiente qui? Tempore, voluptatem.
      </p>      

      <!-- TODO: Update to top-5 rated movies -->
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
    
    <!-- Never forget to close an opened resource -->
    <?php 
      mysql_close($db_connect);
     ?>

    <!-- JavaScript -->
    <script type="text/javascript" src="./js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="./js/bootstrap.min.js"></script>
  </body>
</html>



