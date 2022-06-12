<?php
include_once 'database.php';
$con = db_connection_knihy();

$query = "SELECT d.id, d.nazev, a.jmeno, a.prijmeni FROM dilo d INNER JOIN autor a ON d.autor_id = a.id";
$result = mysqli_query($con, $query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <table style="border: solid 1px black;">
        <tbody>
            <tr>
                <th>Pořadí.</th>
                <th>Název díla.</th>
                <th>Autor díla.</th>
            </tr>
            <?php
            for ($i = 0; $i < mysqli_num_rows($result); $i++)
            {
                $row = mysqli_fetch_row($result);
                tableRow($row[0], $row[1], $row[2] . " " . $row[3]);
            }
            ?>
        </tbody>
    </table>
</body>

</html>

<?php

function tableRow($poradi, $nazevDila, $jmenoAutora)
{
    echo
    '
        <tr>
            <td>' . $poradi . '</td>
            <td>' . $nazevDila . '</td>
            <td>' . $jmenoAutora . '</td>
        </tr>
    ';
}