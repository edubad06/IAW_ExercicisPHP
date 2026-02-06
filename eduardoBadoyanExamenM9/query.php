<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "gamezone";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Error de connexió: " . mysqli_connect_error());
}

$nom_equip = $_POST['nom_equip'];

$sql = "SELECT p.*, eL.nom AS nom_local, eV.nom AS nom_visitant 
FROM partides p 
JOIN equips eL ON p.id_equip_local = eL.id 
JOIN equips eV ON p.id_equip_visitant = eV.id 
WHERE eL.nom = '$nom_equip' OR eV.nom = '$nom_equip'";

$resultat_consulta = mysqli_query($conn, $sql);

if (mysqli_num_rows($resultat_consulta) > 0) {
    $total_partides = 0;
    $victories = 0;
    $derrotes = 0;
    $empats = 0;

    echo "<h2>Resultats per a l'equip: " . $nom_equip . "</h2>";
    echo "<table border='1'>
            <tr>
                <th>Data</th>
                <th>Joc</th>
                <th>Equip Rival</th>
                <th>Punts Propis</th>
                <th>Punts Rival</th>
                <th>Resultat</th>
            </tr>";

    while ($fila = mysqli_fetch_assoc($resultat_consulta)) {
        $total_partides++;
        
        if ($fila['nom_local'] == $nom_equip) {
            $rival = $fila['nom_visitant'];
            $punts_propis = $fila['punts_local'];
            $punts_rival = $fila['punts_visitant'];
        } else {
            $rival = $fila['nom_local'];
            $punts_propis = $fila['punts_visitant'];
            $punts_rival = $fila['punts_local'];
        }

        if ($punts_propis > $punts_rival) {
            $res_text = "Victòria";
            $victories++;
        } elseif ($punts_propis < $punts_rival) {
            $res_text = "Derrota";
            $derrotes++;
        } else {
            $res_text = "Empat";
            $empats++;
        }

        echo "<tr>
                <td>{$fila['data']}</td>
                <td>{$fila['joc']}</td>
                <td>{$rival}</td>
                <td>{$punts_propis}</td>
                <td>{$punts_rival}</td>
                <td>{$res_text}</td>
              </tr>";
    }
    echo "</table>";
    echo "<ul>
            <li>Total partides: $total_partides</li>
            <li>Victòries: $victories</li>
            <li>Derrotes: $derrotes</li>
            <li>Empats: $empats</li>
          </ul>";
} else {
    echo "<p>No s'han trobat partides per a l'equip indicat.</p>";
}

mysqli_close($conn);
?>