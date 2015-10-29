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
    <link rel="stylesheet" type="text/css" href="./css/bootstrap-theme.min.css">
    <link rel="stylesheet" type="text/css" href="./css/styles.css"

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
      mysql_select_db("CS143", $db_connect);
     ?>
      <style type="text/css">
        .centered {
            text-align: left;
            border: 0px;
            padding: 0;
            margin-left: auto;
            margin-right: auto;
            display: table;
        }

        #example {
          font-style: italic;
        }

        table, th, td {
          text-align: center;
          border: 1px solid black;
          border-spacing: 1;
          padding: 2;
        }

        .bold {
          font-weight: bold;
        }
    </style>
  </head>

  <body>
    <div class="container theme-showcase">
      <div class="jumbotron">
          <h1>Search</h1>
      </div>
      	<p>Search for an actor or movie in our database</p>    
      	<form method="GET">
					<textarea name="query" cols="50" rows="6"></textarea>
					<br>
          <input type="submit" value="Submit">
		    </form>  

            <?php 

                function makeTable($tbl_results) {
                  if (count($tbl_results) == 0) {
                    print "Nothing was found for this query.";
                  }
                  // print out results in a table
                  print "<table>";

                  // find out how many columns there are
                  $field_num = mysql_num_fields($tbl_results);

                  // Create the first row - names
                  print "<tr class='bold'>";
                  for ($j = 0; $j < $field_num; $j++) {
                    $field_name = mysql_field_name($tbl_results, $j);
                    print "<td>$field_name</td>";
                  }
                  print "</tr>";

                  while ($row = mysql_fetch_row($tbl_results)) {
                    print "<tr>";
                    for ($i = 0; $i < $field_num; $i++) {
                      $item = $row[$i];
                      print "<td>$item</td>";
                    }     
                    print "</tr>";
                  }
                  print "</table>";
                }


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
                $or_words = "\"%".$separate_words[0]."%\"";
                $last_words = "A.last=\""."$separate_words[0]"."\"";
                $num_of_words = count($separate_words);

                for ($k = 1; $k < $num_of_words; $k++) {
                    $and_words .= " AND "."\"%".$separate_words[$k]."%\"";
                }

                for ($k = 1; $k < $num_of_words; $k++) {
                    $or_words .= " OR "."\"%".$separate_words[$k]."%\"";
                }

                print $and_words;

                // Create MySQL Query
                $statement = "SELECT * FROM Movie AS M WHERE M.title LIKE ".$and_words.";";

                print $statement;

                print "CHECKING MOVIES...";
                // SEND THE RESULT AS A QUERY TO THE DATABASE
                $results = mysql_query($statement, $db_connect);                 
                makeTable($results);

                // CHECKING ACTOR
                print "LOOKING AT ACTORS NOW...";

                // If there are two arguments for the query, then try first name, last name
                if(count($separate_words) == 2) {
                  $statement2 = "SELECT * FROM Actor AS A WHERE (A.first=\"".$separate_words[0]."\" AND "."A.last=\"".$separate_words[1]."\") OR (A.first=\"".$separate_words[1]."\" AND "."A.last=\"".$separate_words[0]."\");";

                  print $statement2;
                  $results2 = mysql_query($statement2, $db_connect);                 
                  makeTable($results2);
                } 
                if(count($results2) == 1) {
                  $statement3 = "SELECT * FROM Actor AS A WHERE A.first LIKE ".$or_words." OR A.last LIKE".$or_words.";";

                  print $statement3;
                  $results3 = mysql_query($statement3, $db_connect);                 
                  makeTable($results3);
                }



 




                // AFTER PLAYING WITH THE SEARCH ENGINE, this is what I've figured out...
                // MOVIES should work fine -- i just try to find anything close 

                // FOR ACTORS/ACTRESSES..
                // If there's two arguments, then im going to assume they are a first and last name
                // and will look for them either (last, first) or (first, last) and get that.
                // HOW ABOUT THIS -- if you find something, just display THAT.

                // If you can't find something after looking EXACTLY for that, then search a little 
                // harder and try for %Tom% and %Hanks% to see what you get. 











                }             
          mysql_close($db_connect); 
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



