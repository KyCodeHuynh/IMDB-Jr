<!DOCTYPE html>
	<?php
		$db_connect = mysql_connect("localhost", "cs143", "");
		// Sanity check to make sure the connection is established
		if ($db_connect->connect_error) {
			die("Connection failed: " . $db_connect->connect_error);
		}

		// Select Database to work with
		mysql_select_db("TEST", $db_connect);
	?>
    <head>
        <title>CS 143: Project 1B Query Page</title>
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
        <div class="centered">
            <h1>Project 1B Query Page</h1>
            <h4>Type an SQL query in the following box: </h4>
            <span id="example">Example: SELECT * FROM Actor WHERE id=10;</span>
            <p>
                <form method="GET">
					<textarea name="query" cols="50" rows="8"></textarea>
					<br>
                    <input type="submit" value="Submit">
				</form>
            </p>
            <?php 
                $query = $_GET["query"];  
				if (empty($query)) {
                    echo "";
                } else {
                	// if the input is not empty, query MySQL and get results
	            	print "<h2>Results From MySQL</h2>";
	            	$sanitized = mysql_real_escape_string($query, $db_connect);
	            	$results = mysql_query($sanitized, $db_connect);                	

	            	// print out results in a table
	            	print "<table>";
                    
                    // find out how many columns there are
                    $field_num = mysql_num_fields($results);

                    // Create the first row - names
                    print "<tr class='bold'>";
                    for ($j = 0; $j < $field_num; $j++) {
                    	$field_name = mysql_field_name($results, $j);
                    	print "<td>$field_name</td>";
                    }
                    print "</tr>";

                    while ($row = mysql_fetch_row($results)) {
                    	print "<tr>";
						for ($i = 0; $i < $field_num; $i++) {
							$item = $row[$i];
							print "<td>$item</td>";
						}	    
						print "</tr>";
					}

					print "</table>";

                }           	

            ?>
        </div>
        <?php 
        	mysql_close($db_connect); 
        ?>
    </body>
</html>

<?php

?>