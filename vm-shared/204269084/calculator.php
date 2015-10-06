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
       
                    // Display nothing for blank expressions
                    if (empty($expr)) {
                        echo "";
                    } 

                    // Match to the regex that is a valid calculation 
                    // Also uses trim() to get rid of extra whitespace before or after
                    elseif (preg_match("/^\-?\d+(\.\d+)?\s*([\-\+\/\*]\-?\s*\d+(\.\d+)?)*/i", trim($expr))) {
                        $neg_replace = preg_replace('/\-{2}/', '+', $expr);

                        // Evaluates it the correct way (if it's "--", it will evaluate as a +)
                        if ($neg_replace) {
                            @eval("\$answer = $neg_replace;");
                        } else {
                            @eval("\$answer = $expr;");
                        }

                        // error_get_last() returns an array if there's any errors
                        // This catches any parse errors thrown from eval()
                        $error_catching = error_get_last();
                        if($error_catching) {
                            // Provides a graceful error message for division by zero
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

                ?>
            </p>
        </div>
    </body>
</html>

