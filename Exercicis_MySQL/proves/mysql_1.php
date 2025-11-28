<?php
    $nom = "Eduardo";
    $email = "edu@iticbcn.cat";
    $codigocurso = "IC01";

    $conexion=mysqli_connect("localhost", "root", "", "base1") or
        die("Problemas con la conexión");

    mysqli_query($conexion, "insert into alumnos (nombre, email, codigocurso) "
            . "values('$nom', '$email','$codigocurso')")
        or die("Problemas en el select".mysqli_error($conexion));
    
    mysqli_close($conexion);

    echo "El alumno fue dado de alta.";
?>