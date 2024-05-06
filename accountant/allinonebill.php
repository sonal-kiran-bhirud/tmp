<?php
include('../connection.php');

function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

function isValidNumber($number) {
    return is_numeric($number) && $number >= 0;
}

// Check if form is submitted and process the data
if(isset($_POST['submit']) && isset($_POST['aadhar'])) {
    $aadhar = sanitizeInput($_POST['aadhar']);

    // Fetch patient details from the database
    $sql_patient = "SELECT  fname AS fname, patient, aadhar, gender, indate, outdate FROM patients WHERE aadhar = '$aadhar'";
    $result_patient = mysqli_query($conn, $sql_patient);

    if ($result_patient === false) {
        echo "<p>Debug: SQL Error: " . $conn->error . "</p>";
    } elseif ($result_patient->num_rows > 0) {
        $row_patient = $result_patient->fetch_assoc();

        $patient_name = $row_patient["fname"];
        $aadhar = $row_patient["aadhar"];
        $patient = $row_patient["patient"];
        $gender = $row_patient["gender"];
        $indate = new DateTime($row_patient["indate"]);
        $outdate = new DateTime($row_patient["outdate"]);

        // Calculate total days
        $interval = $indate->diff($outdate);
        $totalDays = $interval->days;

        // Fetch billing details
        $sql1 = "SELECT  * FROM fess";
        $result = mysqli_query($conn, $sql1);
        $row = mysqli_fetch_assoc($result);

        // Calculate billing details
        $dayCharges = $totalDays * $row['perday_bed']; // 500 Rs per day
        $doctorFee = $row['doctor_fee']; // 500 Rs fixed doctor fee

        // Additional bills
        $additionalBillAmounts = isset($_POST['billAmounts']) ? $_POST['billAmounts'] : [];
        $additionalBillDescriptions = isset($_POST['billDescriptions']) ? $_POST['billDescriptions'] : [];

        if (!empty($additionalBillAmounts) && !empty($additionalBillDescriptions)) {
            foreach($additionalBillAmounts as $index => $amount) {
                $amount = sanitizeInput($amount);
                $description = sanitizeInput($additionalBillDescriptions[$index]);
                if(isValidNumber($amount)) {
                    ${'additionalAmount' . $index} = $amount;
                    ${'additionalDescription' . $index} = $description;
                }
            }
        }

        // Calculate total additional bill amount
        $totalAdditionalBillAmount = !empty($additionalBillAmounts) ? array_sum($additionalBillAmounts) : 0;

        // Calculate total charges including additional bills
        $totalCharges = $dayCharges + $doctorFee + $totalAdditionalBillAmount;

        // Insert billing details into the database
        $sql_insert = "INSERT INTO billing_details (fname, aadhar, patient, gender, indate, outdate, total_days, day_charges, doctor_fee, total_charges";

        // Add additional bill columns to SQL query
        for($i = 0; $i < count($additionalBillAmounts); $i++) {
            $sql_insert .= ", additional_amount_$i, additional_description_$i";
        }

        $sql_insert .= ") VALUES ('$patient_name', '$aadhar', '$patient', '$gender', '{$row_patient['indate']}', '{$row_patient['outdate']}', '$totalDays', '$dayCharges', '$doctorFee', '$totalCharges'";

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
    <title>Billing System</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <?php if(isset($row_patient)): ?>
            <div id="printbill">
                <h2 class="mb-4">Billing Details</h2>
                <!-- Display patient details -->
                <div class="row mb-3">
                    <div class="col-sm-6">
                        <p><strong>Patient Name:</strong> <?php echo $row_patient['fname']; ?></p>
                        <p><strong>Patient Type:</strong> <?php echo $row_patient['patient']; ?></p>
                        <p><strong>Aadhar Card:</strong> <?php echo $row_patient['aadhar']; ?></p>
                        <p><strong>Gender:</strong> <?php echo $row_patient['gender']; ?></p>
                        <p><strong>Indate:</strong> <?php echo $row_patient['indate']; ?></p>
                        <p><strong>Outdate:</strong> <?php echo $row_patient['outdate']; ?></p>
                        <p><strong>Admitted Days:</strong> <?php echo $totalDays; ?> days</p>
                    </div>
                </div>

                <!-- Display billing details -->
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
                        <!-- Display additional bill details -->
                        <?php if(!empty($additionalBillAmounts) && !empty($additionalBillDescriptions)): ?>
                            <?php foreach($additionalBillAmounts as $index => $amount): ?>
                                <tr>
                                    <td><?php echo $additionalBillDescriptions[$index]; ?></td>
                                    <td><?php echo $amount; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td><b>Total Charges:</b></td>
                            <td><b><?php echo $totalCharges; ?></b></td>
                        </tr>
                    </tfoot>
                </table>

                <div class="mb-3">
                    <button class="btn btn-primary" onclick="printDiv('printbill')">Print</button>
                </div>
            </div>
        <?php else: ?>
            <!-- Form to enter Aadhar Card Number -->
            <div class="card">
                <div class="card-header">
                    <h2>Enter Aadhar Card Number</h2>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <div class="form-group">
                            <label for="aadhar">Aadhar Card Number:</label>
                            <input type="text" class="form-control" id="aadhar" name="aadhar" required>
                        </div>
                        
                        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script>
        function printDiv(printbill) {
            var printContents = document.getElementById(printbill).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>
</body>
</html>
