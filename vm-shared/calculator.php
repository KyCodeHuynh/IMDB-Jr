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
            <?php
            ?>
            <p>
                You entered: <?php echo $_GET["expr"]; ?>.
            </p>
        </div>
    </body>
</html>
