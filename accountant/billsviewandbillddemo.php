//billsviewandbilld demo




<?php
include('../connection.php');

function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

function isValidNumber($number) {
    return is_numeric($number) && $number >= 0;
}

if(isset($_POST['submit']) && isset($_POST['aadhar'])) {
    $aadhar = sanitizeInput($_POST['aadhar']);

    // Fetch patient details from the database
    $sql_patient = "SELECT id, fname AS fname, aadhar, gender, indate, outdate FROM patients WHERE aadhar = '$aadhar'";
    $result_patient = $conn->query($sql_patient);

    if ($result_patient === false) {
        echo "<p>Debug: SQL Error: " . $conn->error . "</p>";
    } elseif ($result_patient->num_rows > 0) {
        $row_patient = $result_patient->fetch_assoc();
        $patient_id = $row_patient["id"];
        $patient_name = $row_patient["fname"];
        $aadhar = $row_patient["aadhar"];
        $gender = $row_patient["gender"];
        $indate = new DateTime($row_patient["indate"]);
        $outdate = new DateTime($row_patient["outdate"]);
        
        // Calculate total days
        $interval = $indate->diff($outdate);
        $totalDays = $interval->days;

        // Calculate billing details
        $dayCharges = $totalDays * 500; 
        $doctorFee = 500; 
        $nurseFee = 200; 
        $reportsFee = 300; 

        // Additional bills
        $additionalBillAmounts = $_POST['billAmounts'];
        $additionalBillDescriptions = $_POST['billDescriptions'];
        foreach($additionalBillAmounts as $index => $amount) {
            $amount = sanitizeInput($amount);
            $description = sanitizeInput($additionalBillDescriptions[$index]);
            if(isValidNumber($amount)) {
                ${'additionalAmount' . $index} = $amount;
                ${'additionalDescription' . $index} = $description;
            }
        }

        // Calculate total additional bill amount
        $totalAdditionalBillAmount = array_sum($additionalBillAmounts);

        // Calculate total charges including additional bills
        $totalCharges = $dayCharges + $doctorFee + $nurseFee + $reportsFee + $totalAdditionalBillAmount;

        $sql_insert = "INSERT INTO billing_details (patient_id, fname, aadhar, gender, indate, outdate, total_days, day_charges, doctor_fee, nurse_fee, reports_fee, total_charges";

// Add additional bill columns to SQL query
for($i = 0; $i < count($additionalBillAmounts); $i++) {
    $sql_insert .= ", additional_amount_$i, additional_description_$i";
}

$sql_insert .= ") VALUES ('$patient_id', '$patient_name', '$aadhar', '$gender', '{$row_patient['indate']}', '{$row_patient['outdate']}', '$totalDays', '$dayCharges', '$doctorFee', '$nurseFee', '$reportsFee', '$totalCharges'";

// Add values for additional bills
for($i = 0; $i < count($additionalBillAmounts); $i++) {
    $additionalAmount = ${'additionalAmount' . $i};
    $additionalDescription = ${'additionalDescription' . $i};
    $sql_insert .= ", '$additionalAmount', '$additionalDescription'";
}

$sql_insert .= ")";

if ($conn->query($sql_insert) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql_insert . "<br>" . $conn->error;
}

    } else {
        echo "<p>No patient found with the provided Aadhar Card number.</p>";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing Details</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .personal-details table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .personal-details table th,
        .personal-details table td {
            border: none;
            padding: 5px;
            text-align: left;
        }
        .personal-details table th {
            width: 30%;
        }
        .bill-details {
            margin-bottom: 50px;
        }
        .bill-details table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .bill-details table th,
        .bill-details table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .bill-details table th {
            background-color: #f2f2f2;
        }
        .total-charges {
            text-align: right;
            font-size: 18px;
        }
        .print-btn {
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Billing Details</h2>
            <p>Bill Generated Date: <?php echo date('Y-m-d'); ?></p>
        </div>
        <div class="personal-details">
            <table class="table">
                <tbody>
                    <tr>
                        <th>Name:</th>
                        <td><?php echo $row_patient['fname']; ?></td>
                    </tr>
                    <tr>
                        <th>Aadhar Card:</th>
                        <td><?php echo $row_patient['aadhar']; ?></td>
                    </tr>
                    <tr>
                        <th>Gender:</th>
                        <td><?php echo $row_patient['gender']; ?></td>
                    </tr>
                    <tr>
                        <th>Indate:</th>
                        <td><?php echo $row_patient['indate']; ?></td>
                    </tr>
                    <tr>
                        <th>Outdate:</th>
                        <td><?php echo $row_patient['outdate']; ?></td>
                    </tr>

                    <th>Addimited Days :</th>
                    <td><?php echo $totalDays; ?> days</td>
                   <th> Note:- $500 (Per Day charges)</th>
                </tbody>
            </table>
        </div>
        <div class="bill-details">
            <h4>Billing Summary:</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Amount (Rs)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Day Charges (<?php echo $totalDays; ?> days)</td>
                        <td><?php echo $dayCharges; ?></td>
                    </tr>
                    <tr>
                        <td>Doctor Fee</td>
                        <td><?php echo $doctorFee; ?></td>
                    </tr>
                    <tr>
                        <td>Nurse Fee</td>
                        <td><?php echo $nurseFee; ?></td>
                    </tr>
                    <tr>
                        <td>Reports Fee</td>
                        <td><?php echo $reportsFee; ?></td>
                    </tr>
                    <?php
                    // Display additional bill details
                    if(isset($additionalBillAmounts) && isset($additionalBillDescriptions)) {
                        foreach($additionalBillAmounts as $index => $amount) {
                            echo "<tr>";
                            echo "<td>{$additionalBillDescriptions[$index]}</td>";
                            echo "<td>{$amount}</td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr class="total-charges">
                        <td>Total Charges:</td>
                        <td><?php echo $totalCharges; ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="print-btn">
            <button class="btn btn-primary" onclick="window.print()">Print</button>
        </div>
    </div>
</body>
</html>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter Aadhar Card Number</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Enter Aadhar Card Number</h2>
        <form method="POST" action="billsview.php">
            <div class="form-group">
                <label for="aadhar">Aadhar Card Number:</label>
                <input type="text" class="form-control" id="aadhar" name="aadhar" required>
            </div>
            <!-- Add fields for manual bill entry -->
            <div class="form-group">
                <label for="billDescription">Bill Description:</label>
                <input type="text" class="form-control" id="billDescription" name="billDescriptions[]" >
            </div>
            <div class="form-group">
                <label for="billAmount">Bill Amount:</label>
                <input type="number" class="form-control" id="billAmount" name="billAmounts[]" >
            </div>
            
            <!-- You can add more fields for additional bills if needed -->
            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
        </form>
    </div>
</body>
</html>

