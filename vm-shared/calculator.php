<!DOCTYPE html>
<html>
    <head>
        <title>Calculator: CS 143</title>
        <style type="text/css">
            .centered {
                text-align: left;
                border: 0px;
                padding: 0;
                margin-left: auto;
                margin-right: auto;
                display: table;
            }
        </style>
    </head>
    <body>
        <div class="centered">
            <h1>A Simple Calculator</h1>

            <p>Enter an expression to evaluate: </p>
            <p>
                <form method="get">
                    <input type="text" name="expr">
                    <input type="submit" value="Evaluate">
                </form>
            </p>
            
            <p>A few notes:</p>
            <ul>
                <li>Only numbers, periods, and the operators 
                +, -, /, * can be entered.</li>
                <li>Standard PEMDAS operator precedence is followed.</li>
                <li>Parantheses are not supported.</li>
                <li>Invalid input will result in graceful error messages.</li>
            </ul>

            <h2>Answer</h2>
            <p>
                <?php
                    $expr = $_GET["expr"];
                    // Strip out trailing whitespace and newlines
                    // $expr = trim($expr);
       
                    // Display nothing for blank expressions
                    if (empty($expr)) {
                        echo "";
                    }

                    // Quick regexp reference found here:
                    // https://secure.php.net/manual/en/function.preg-match.php

                    // Invalid expression if anything but digits, operators, and periods.
                    elseif (preg_match("/[^0-9\/\*\+\-\. ]/i", $expr)) {
                        echo "Invalid expression. Please try again.";
                    }

                    // Invalid if space before decimal point 
                    elseif (preg_match("/\s\./i", $expr)) {
                        echo "Invalid expression. Please try again.";
                    }

                    // Invalid if double decimal points
                    elseif (preg_match("/\.\./i", $expr)) {

                    }

                    // TRY ALL IN DEMO
                    // TODO: Catch divide by 0 exception. Could do clever regexp instead.
                    // TODO: Catch --- or ++ or ** or // (BUT -- allowed?)
                    // TODO: Double-check Piazza for other cases
                    // TODO: Double decimal points
                    // TODO: Multiple decimal points
                    // TODO: Space after decimal point

                    else {
                        try {
                            // Try @ sign to suppress error, then use get_last_error()
                            // to see if we get divide by zero message
                            eval("\$answer = $expr;");
                        }
                        catch (Exception $e) {
                            echo 'Error details: ' . $e->getMessage() . "\n";
                        }
                        echo $expr . " = " . $answer; 
                    }
                ?>
            </p>
        </div>
    </body>
</html>

