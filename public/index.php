<?php
require __DIR__ . '/../vendor/autoload.php';
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Type your address and get the Coordinates</title>
</head>
<body>
<h1>Type your address and get the Coordinates</h1>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $coordinates = (new \GSoares\Google\Location\CoordinatesLocator())
        ->setStreet($_POST['street'])
        ->setNumber($_POST['number'])
        ->setDistrict($_POST['district'])
        ->setCity($_POST['city'])
        ->setState($_POST['state'])
        ->setPostcode($_POST['postcode'])
        ->setCountry($_POST['country'])
        ->locate();

    echo '<div style="padding: 20px; margin: 20px; background: yellowgreen">';

    if (!$coordinates) {
        echo '<p>No results founded...</p>';
    } else {
        echo "<p>
                <strong>Latitude</strong>: $coordinates->latitude
                <br/>
                <strong>Longitude</strong>: $coordinates->longitude
             </p>
        ";
    }

    echo '</div>';
}
?>

<form method="POST">
<?php
$array = [
    'postcode',
    'street',
    'number',
    'district',
    'city',
    'state',
    'country'
];
foreach ($array as $arr) {
    ?>
    <p>
        <label><?php echo ucfirst($arr) ?>:</label>
        <br/>
        <input type="text" value="<?php echo isset($_POST[$arr]) ? $_POST[$arr] : null ?>" name="<?php echo $arr ?>">
    </p>
<?php } ?>
<input type="submit">
</form>
</body>
</html>