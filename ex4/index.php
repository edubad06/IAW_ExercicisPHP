<?php
$musica = $_GET['musica'];
if ($musica == "rock") {
    echo "T'agrada el Rock! 🤘";
} elseif ($musica == "pop") {
    echo "T'agrada el Pop! 🎤";
} elseif ($musica == "classic") {
    echo "T'agrada la música clàssica! 🎻";
} else {
    echo "T'agrada el Jazz! 🎷";
}
?>