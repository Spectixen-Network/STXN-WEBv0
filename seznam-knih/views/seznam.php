<?php
session_start();
include_once '../else/database.php';
include_once '../../functions/globalFunctions.php';
$con = db_connection_knihy();

$query = "SELECT d.id, d.nazev, a.jmeno, a.prijmeni FROM dilo d INNER JOIN autor a ON d.autor_id = a.id";
$result = mysqli_query($con, $query);

html_start("Seznam knih | Seznam", "../../css/style");
nav();
banner("Seznam knih | Seznam");
?>

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

<?php
footer();
html_end();

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