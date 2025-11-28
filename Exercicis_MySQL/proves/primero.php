<html>
    <head>
        <title>MySQL Table Viewer</title>
    </head>
    <body>
        <?php
        $dbhost = "localhost";
        $dbuser = "root";
        $dbpass = "";
        $dbname="universidad";
        $conn = mysqli_connect($dbhost, $dbuser, $dbpass);
        if (!$conn) {
            die("Could not connect: ".mysqli_connect_error($conn));
        }    
        if (!mysqli_select_db($conn, $dbname)) {
            die ("Can't select database");
        }
        $result = mysqli_query($conn, "SHOW TABLES"); 
        if (!$result) {
            die("Query to show fields from table failed");
        }
        $num_row = mysqli_num_rows($result);
        echo "<h1>Choose one table:</h1>";
        echo "<form action=\"showtable.php\" method=\"POST\">";
        echo "<select name=\"table\" size=\"1\" Font size=\"+2\">";
        for ($i=0;$i<$num_row; $i++) {
            $tablename=mysqli_fetch_row($result);
            echo "<option value=\"{$tablename[0]}\" >{$tablename[0]}</option>";
        } 
        echo "</select>";
        echo "<div><input type=\"submit\" value=\"submit\"></div>";
        echo "</form>";
        mysqli_free_result($result);
        mysqli_close($conn);
        ?>
    </body>
</html>