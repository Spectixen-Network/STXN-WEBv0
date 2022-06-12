<?php
session_start();
include_once '../else/database.php';
include_once '../../functions/globalFunctions.php';
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

<div class="container d-flex justify-content-center">

    <form action="../saves/saveAutor.php" method="POST">
        <div style="height: 44.5vh;">
            <div class="knihy-forms">
                <div class="input-group mb-1">
                    <span class="input-group-text">Jméno a Příjmení</span>
                    <input type="text" name="jmeno" class="form-control" required>
                    <input type="text" name="prijmeni" class="form-control" required>
                </div>
                <div class="input-group mb-1">
                    <span class="input-group-text" id="inputGroup-sizing-default">Skupina</span>
                    <input type="text" class="form-control" name="skupina">
                </div>
                <div class="input-group mb-1">
                    <label class="input-group-text" for="inputGroupSelect02">Směry</label>
                    <select name="smery[]" class="form-select" id="inputGroupSelect02" style="overflow: auto;" multiple required>
                        <?php
                        for ($i = 0; $i < count($smery); $i++)
                        {
                            option($smery[$i][0], $smery[$i][1]);
                        }
                        ?>
                    </select><br>
                </div>
                <div class="input-group d-grid gap-2 col-6 mx-auto">
                    <button type="submit" class="btn btn-primary">Přidat</button>
                </div>
            </div>
        </div>
    </form>
</div>

<?php
footer();
html_end();


function option($id, $name)
{
    echo '<option value="' . $id . '">' . $name . '</option>';
}