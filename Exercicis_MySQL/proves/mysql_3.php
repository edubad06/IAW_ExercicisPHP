<?php
    $con=mysqli_connect("localhost", "root", "", "mibd")
            or die("Error conexión ".mysqli_connect_error($con));
    $SQL="select id, name from mitabla;";
    $registros=mysqli_query($con, $SQL)
            or die(mysqli_error($con));
    echo "<table border=1> <tr> <td>id <td>nombre";
    while($registro=mysqli_fetch_row($registros) ) {
        echo "<tr><td>".$registro[0]."<td>".$registro[1];
    }
    echo "</table>";
    mysqli_close($con);
?>