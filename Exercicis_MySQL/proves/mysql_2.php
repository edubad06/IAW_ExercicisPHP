<?php
    $con=mysqli_connect("localhost", "root", "")
            or die(mysqli_connect_error($con));
    mysqli_query($con, "create database if not exists mibd")
            or die(mysqli_error($con));
    echo "Base de datos creada con éxito";
    mysqli_select_db($con, "mibd")
            or die(mysqli_error($con));
    mysqli_query($con, "create table if not exists mitabla (id int primary key auto_increment, name varchar(20))")
            or die(mysqli_error($con));
    echo "Tabla creada con éxito";
    mysqli_query($con, "insert into mitabla(name) values('pedro')")
            or die(mysqli_error($con));
    echo "Inserción realizada correctamente";
?>