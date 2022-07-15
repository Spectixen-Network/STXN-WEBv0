<?php
session_start();

include_once '../functions/globalFunctions.php';
include_once 'Car.php';

if (isset($_POST["restart"]))
{
    unset($_SESSION["CAR"]);
    unset($_SESSION["CAR_DISTANCE"]);
    unset($_SESSION["CAR_GEAR"]);
    unset($_SESSION["CAR_FUEL"]);
    header("Location: roadTrip.php");
}

html_start("Car", "css/global", "css/car");
nav();
banner("Car Road Trip");

$car = new Car();

if (isset($_SESSION["CAR"]))
{
    $car->set_distance($_SESSION["CAR_DISTANCE"]);
    $car->set_gearShift($_SESSION["CAR_GEAR"]);
    $car->set_storedFuel($_SESSION["CAR_FUEL"]);
}
else
{
    $_SESSION["CAR_DISTANCE"] = $car->get_distance();
    $_SESSION["CAR_GEAR"] = $car->get_gearShift();
    $_SESSION["CAR_FUEL"] = $car->get_storedFuel();
    $_SESSION["CAR"] = 1;
}

if (isset($_POST))
{
    if (isset($_POST["shiftUp"]))
    {
        $car->shift_up();
        $car->set_distance($_POST["travelledDistance"]);
        $car->set_storedFuel($_POST["storedFuel"]);
        $_SESSION["CAR_GEAR"] = $car->get_gearShift();
    }
    if (isset($_POST["fillTheTank"]))
    {
        $car->fill_up_the_tank();
        $car->set_distance($_POST["travelledDistance"]);
        $_SESSION["CAR_FUEL"] = $car->get_storedFuel();
        $_SESSION["CAR_GEAR"] = $car->get_gearShift();
    }
    if (isset($_POST["outOfFuel"]))
    {
        $car->out_of_fuel();
    }
}

?>

<div class="carStatistics">
    <h1>Car statisctics</h1>

    <p id="distance">Travelled distance: <?php echo $car->get_distance(); ?> / 100</p>
    <p id="gear">Current gear shift: <?php echo $car->get_gearShift(); ?> / 3</p>
    <p id="fuel">Fuel consumption: <?php echo $car->get_gearShift(); ?> / 3</p>
    <p id="storedFuel">Stored fuel: <?php echo $car->get_storedFuel(); ?> / 60</p>
</div>
<div class="carControlls row">
    <h1>Car controlls</h1>
    <div class="col">
        <form method="POST">
            <input type="hidden" name="shiftUp" value="1">
            <input type="hidden" id="travelledDistance1" name="travelledDistance" value="<?php echo $car->get_distance(); ?>">
            <input type="hidden" id="storedFuelinp" name="storedFuel" value="<?php echo $car->get_storedFuel(); ?>">
            <button type="submit">Shift up</button>
        </form>
    </div>
    <div class="col">
        <form method="POST">
            <input type="hidden" id="travelledDistance2" name="travelledDistance" value="<?php echo $car->get_distance(); ?>">
            <input type="hidden" name="fillTheTank" value="1">
            <button type="submit">Fill up the tank</button>
        </form>
    </div>
    <div class="col">
        <form method="POST">
            <input type="hidden" name="restart" value="1">
            <button type="submit">Restart</button>
        </form>
    </div>
    <form method="POST" id="outOfFuelForm">
        <input type="hidden" name="outOfFuel" value="1">
    </form>
</div>

<script>
// NOT MY FUNCTION
function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}
// ---------------
let distance = <?php echo $car->get_distance(); ?>;
let fuel = <?php echo $car->get_storedFuel(); ?>;
let docDistance1 = document.getElementById("travelledDistance1");
let docDistance2 = document.getElementById("travelledDistance2");
let docFuel = document.getElementById("storedFuelinp");

let fuelForm = document.getElementById("outOfFuelForm");
async function trav() {
    do {

        fuel -= <?php echo $car->get_gearShift(); ?>;
        if (fuel <= 0) {
            fuel = 0;
            document.getElementById("storedFuel").innerHTML = "Stored fuel: " + fuel + " / 60";
            document.getElementById("gear").innerHTML = "Current gear shift: 0 / 3";
            document.getElementById("fuel").innerHTML = "Fuel consumption: 0 / 3";
            docDistance1.value = distance;
            docDistance2.value = distance;
            docFuel.value = fuel;
            break;
        }

        distance += <?php echo $car->get_gearShift(); ?>;
        if (distance >= 100) {
            distance = 100;
            document.getElementById("distance").innerHTML = "Travelled distance: " + distance + " / 100";
            document.getElementById("gear").innerHTML = "Current gear shift: 0 / 3";
            document.getElementById("fuel").innerHTML = "Fuel consumption: 0 / 3";
            docDistance1.value = distance;
            docDistance2.value = distance;
            docFuel.value = fuel;
            break;
        }
        await sleep(1000);

        document.getElementById("distance").innerHTML = "Travelled distance: " + distance + " / 100";
        document.getElementById("storedFuel").innerHTML = "Stored fuel: " + fuel + " / 60";

        docDistance1.value = distance;
        docDistance2.value = distance;
        docFuel.value = fuel;


    } while (distance <= 103);
}
trav();
</script>

<?php


footer();
html_end();