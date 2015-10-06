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

                    // match to the regex that is a valid calculation 
                    // also uses trim() to rid of extra whitespace before or after
                    elseif (preg_match("/^\-?\d+(\.\d+)?\s*([\-\+\/\*]\-?\s*\d+(\.\d+)?)*/i", trim($expr))) {
                        $neg_replace = preg_replace('/\-{2}/', '+', $expr);

                        // evaluates the correct way (if it's "--", it will evaluate as a +)
                        if ($neg_replace) {
                            @eval("\$answer = $neg_replace;");
                        } else {
                            @eval("\$answer = $expr;");
                        }

                        // error_get_last() returns an array if there's any errors
                        // this catches any parse errors thrown from eval()
                        $error_catching = error_get_last();
                        if($error_catching) {
                            // provides a graceful message for division by zero
                            if ($error_catching['message'] == "Division by zero") {
                                echo "Division by zero error!";
                            } else {
                                echo "Invalid expression. Please try again.... pls";                                
                            }    
                        } else {
                            echo $expr . " = " . $answer; 
                        }                       
                    } 
                    else {
                        echo "Invalid expression. Please try again.";
                    }


                    // elseif (preg_match("/[^\.\/]+\-\-[^\.\/]+$/i", "23--4", $matches)) {
                    //     echo "the one i found was " . $matches[0]."<br>";
                    //     echo "the two i found was " . $matches[1]."<br>";
                    // }

                    // Quick regexp reference found here:
                    // // https://secure.php.net/manual/en/function.preg-match.php

                    // // Invalid expression if anything but digits, operators, and periods.
                    // elseif (preg_match("/[^0-9\/\*\+\--?\. ]/i", $expr)) {
                    //     echo "Invalid expression. Please try again. PLEASE";
                    // }

                    // // Invalid if space before decimal point 
                    // // Crystal: What was this for? 

                    // // Invalid if double decimal points
                    // elseif (preg_match("/\.\./i", $expr)) {
                    //     echo "Invalid expression. Please try again.";
                    // }

                    // // Catch -- situations and replace with +

                    // // TRY ALL IN DEMO
                    // // TODO: Catch divide by 0 exception. Could do clever regexp instead.
                    // // TODO: Catch --- or ++ or ** or // (BUT -- allowed?)
                    // // TODO: Double-check Piazza for other cases
                    // // TODO: Double decimal points
                    // // TODO: Multiple decimal points
                    // // TODO: Space after decimal point

                    // else {
                    //     @eval("\$answer = $expr;");
                    //     // returns an array if there's any errors
                    //     // catches any parse errors thrown from eval()
                    //     if(error_get_last()) {
                    //         echo "Invalid expression. Please try again.";
                    //     } else {
                    //         echo $expr . " = " . $answer; 
                    //     }
                    // }
                ?>
            </p>
        </div>
    </body>
</html>

