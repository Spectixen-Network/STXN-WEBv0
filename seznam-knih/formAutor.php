<?php
include_once 'database.php';
include_once '../functions/globalFunctions.php';
$con = db_connection_knihy();
$query = "SELECT * FROM zanr";
$result = mysqli_query($con, $query);
$zanry = mysqli_fetch_all($result);

$query = "SELECT * FROM smer";
$result = mysqli_query($con, $query);
$smery = mysqli_fetch_all($result);


html_start("Seznam Knih | Autor", "../css/style");
nav();
banner("Seznam Knih | Autor");
?>

<form action="saveAuthor.php" method="POST">
    <input type="text" name="jmenoPrijmeni" placeholder="Jméno Přijmení" required><br>
    <input type="text" name="skupina" placeholder="Skupina" required><br>
    <select name="zanry[]" multiple required>
        <option disabled>-----Vyber žánr-----</option>
        <?php
        for ($i = 0; $i < count($zanry); $i++)
        {
            option($zanry[$i][0], $zanry[$i][1]);
        }
        ?>
    </select><br><br>
    <select name="smery[]" multiple required>
        <option disabled>-----Vyber směr-----</option>
        <?php
        for ($i = 0; $i < count($smery); $i++)
        {
            option($smery[$i][0], $smery[$i][1]);
        }
        ?>
    </select><br>
    <input type="submit" value="Uložit">
</form>

<?php
footer();
html_end();


function option($id, $name)
{
    echo '<option value="' . $id . '">' . $name . '</option>';
}