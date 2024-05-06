<?php

// Include the database connection file
include('../connection.php');

// Check if ID is provided in the URL
if(isset($_GET['aadhar'])) {
    

    // Fetch billing details based on the provided ID
   $sql = "SELECT * FROM `billing_details` WHERE aadhar = '$aadhar'";
    $res = mysqli_query($conn, $sql);

    // Check if a record is found
    if(mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
    } else {
        // Handle the case when no record is found for the given ID
        echo "No billing details found for the provided ID.";
        exit(); // Stop further execution
    }   
} else {
    // Handle the case when no ID is provided in the URL
    echo "No ID provided.";
    exit(); // Stop further execution
}

// Check if the form is submitted for updating billing details
if(isset($_POST['update'])) {
    // Get values from the form
    $total_days = $_POST['total_days'];
    $day_charges = $_POST['day_charges'];
    $doctorFee = $_POST['doctor_fee'];
    $visit_fee = $_POST['doctor_revisit'];
    $additionalDescription = $_POST['additionalDescription'];
    $additionalAmount = $_POST['additionalAmount'];

    // Update the billing details in the database
    $sql_update = "UPDATE billing_details SET total_days='$total_days', day_charges='$day_charges', additionalDescription='$additionalDescription', additionalAmount='$additionalAmount' WHERE aadhar='$aadhar'";
    $result_update = mysqli_query($conn, $sql_update);

    if($result_update) {
        echo "Billing details updated successfully.";
    } else {
        echo "Error updating billing details: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Billing Details</title>
</head>
<body>
    <h2>Edit Billing Details</h2>
    <form method="post" action="">
        <input type="hidden" name="id" value="<?php echo $id; ?>">

        Total Days: <input type="text" name="total_days" id="total_days" value="<?php echo $row['total_days']; ?>" placeholder="Total Days"><br>

        Day Charges: <input type="text" name="day_charges" id="day_charges" value="<?php echo $row['day_charges']; ?>" placeholder="Day Charges"><br>

        Additional Description: <input type="text" name="additionalDescription" id="additionalDescription" value="<?php echo $row['additionalDescription']; ?>" placeholder="Additional Description"><br>

        Additional Amount: <input type="text" name="additionalAmount" id="additionalAmount" value="<?php echo $row['additionalAmount']; ?>" placeholder="Additional Amount"><br>

        <input type="submit" value="Update" name="update">
    </form>
</body>
</html>
