<html>
    <head>
        <title>MySQL Table Viewer</title>
    </head>
    <body>
        <?php
            $dbhost = "localhost";
            $dbuser = "root";
            $dbpass = "";
            $dbname = "universidad";
            $table = $_POST["table"];
            $conn = mysqli_connect($dbhost, $dbuser, $dbpass);
            if (!$conn)
                    die("Could not connect: ".mysqli_connect_error($conn));
            if (!mysqli_select_db($conn, $dbname))
                die("Can't select database");
            $result = mysqli_query($conn, "SELECT * FROM {$table}");
            if (!$result) die("Query to show fields from table failed!".mysqli_error($conn));
            $fields_num = mysqli_num_fields($result);
            echo "<h1>Table: {$table}</h1>";
            echo "<table border='1'><tr>";
            for($i=0; $i<$fields_num; $i++) {
                    $field = mysqli_fetch_field($result);
                    echo "<td><b>{$field->name}</b></td>";
            }
            echo "</tr>\n";
            while ($row = mysqli_fetch_row($result)) {
                    echo "<tr>";
                    foreach ($row as $cell) {
                            echo "<td>$cell</td>";
                    }
                    echo "</tr>\n";
            }
            mysqli_free_result($result); 
            mysqli_close($conn);
        ?>
    </body>
</html>