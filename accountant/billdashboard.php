
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
    $sql_patient = "SELECT  fname AS fname, aadhar, gender, indate, outdate FROM patients WHERE aadhar = '$aadhar'";
    $result_patient = mysqli_query($conn, $sql_patient);


    $sql1 = "SELECT  * FROM fess";
    $result = mysqli_query($conn, $sql1);
    $row = mysqli_fetch_assoc($result);
   


   

   


    if ($result_patient === false) {
        echo "<p>Debug: SQL Error: " . $conn->error . "</p>";
    } elseif ($result_patient->num_rows > 0) {
        $row_patient = $result_patient->fetch_assoc();
   
        $patient_name = $row_patient["fname"];
        $aadhar = $row_patient["aadhar"];
        $gender = $row_patient["gender"];
        $indate = new DateTime($row_patient["indate"]);
        $outdate = new DateTime($row_patient["outdate"]);
        
        // Calculate total days
        $interval = $indate->diff($outdate);
        $totalDays = $interval->days;

        // Calculate billing details
        $dayCharges = $totalDays *  $row['perday_bed']; // 500 Rs per day
        $doctorFee = $row['doctor_fee']; // 500 Rs fixed doctor fee
        $visit_fee =  $row['doctor_revisit']; // 200 Rs fixed nurse fee
    

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
        $totalCharges = $dayCharges + $doctorFee + $visit_fee  + $totalAdditionalBillAmount;

        $sql_insert = "INSERT INTO billing_details ( fname, aadhar, gender, indate, outdate, total_days, day_charges, doctor_fee, visit_fee, total_charges";

// Add additional bill columns to SQL query
for($i = 0; $i < count($additionalBillAmounts); $i++) {
    $sql_insert .= ", additional_amount_$i, additional_description_$i";
}

$sql_insert .= ") VALUES ( '$patient_name', '$aadhar', '$gender', '{$row_patient['indate']}', '{$row_patient['outdate']}', '$totalDays', '$dayCharges', '$doctorFee', '$visit_fee',  '$totalCharges'";

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
  <title>Accountantfg Dashboard</title>
  <link rel="stylesheet" href="admin.css">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

  <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>


  <script src="https://kit.fontawesome.com/6ee00b2260.js" crossorigin="anonymous"></script>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: Arial, Helvetica, sans-serif;
    }

    .topnav {
      overflow: hidden;
      background-color: purple;


    }

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

    .topnav a {
      float: left;
      display: block;
      color: white;
      text-align: center;
      padding: 14px 16px;
      text-decoration: none;
      font-size: 17px;
    }

    .topnav a:hover {
      background-color: #ddd;
      color: black;
    }

    /* .topnav a.active {
  background-color: #2196F3;
  color: white;
} */

    .topnav .search-container {
      float: right;

      /* padding-right: 20px; */
    }

    .topnav input[type=text] {
      padding: 6px;
      margin-top: 8px;
      font-size: 17px;
      border: none;
    }

    .topnav .search-container button {
      float: right;
      padding: 6px 10px;
      margin-top: 8px;
      margin-right: 16px;
      background: #ddd;
      font-size: 17px;
      border: none;
      cursor: pointer;
    }

    .topnav .search-container button:hover {
      background: #ccc;
    }

    @media screen and (max-width: 600px) {
      .topnav .search-container {
        float: none;
      }

      .topnav a,
      .topnav input[type=text],
      .topnav .search-container button {
        float: none;
        display: block;
        text-align: left;
        width: 100%;
        margin: 0;
        padding: 14px;
      }

      .topnav input[type=text] {
        border: 1px solid #ccc;
      }
    }


    #img {
      padding-left: 10px;
  }

  .butt:hover {
      background-color: purple;
      color: aliceblue;
  }

  /* .home:hover{
      background-color: black;
      color: black;

  } */

 

  .patient:hover {
      color: black;
  }

  .text {
      color: black;
      font-weight: 900;
  }

  .cardsize {
    height:auto;
    width:auto;
  }

  .card {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
  }

  
  .geeks { 
          /* width: 20%;*/ 
          top: 20%;  
          position: absolute; 
          /* left: 40%;  */
          /* border-bottom: 5px solid black;  */
          overflow: hidden; 
          animation: animate 3s linear forwards; 
      } 

      .geeks h6 { 
          color: purple; 
      } 

   /* Custom CSS for animation */
@keyframes fadeIn {
from { opacity: 0; }
to { opacity: 1; }
}

@keyframes fadeOut {
from { opacity: 1; }
to { opacity: 0; }
}

/* Doctor name */


@keyframes animate { 
          0% { 
              width: 0px; 
              height: 0px; 
          } 

          30% { 
              width: 50px; 
              height: 0px; 
          } 

          60% { 
              width: 50px; 
              height: 80px; 
          } 
        }

        /* doctor name */

.fade-in {
animation: fadeIn 0.5s ease forwards;
}

.fade-out {
animation: fadeOut 0.5s ease forwards;
}
.scale:hover{
transform: scale(1.1,1.1);
}

/* doctor name text */
@keyframes typing {
      from { width: 0 }
      to { width: 100% }
  }

  .animated-text {
      overflow: hidden; /* Ensures text remains within the box */
      /* Simulates cursor */
      white-space: nowrap; /* Prevents text from wrapping */
      animation: typing 3s steps(40, end) ;
  }



  
    /* .menu ul,li:hover {
  display: inline-block;
} */

    /* *{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    
}
.user-img{
    width: 60px;
    height: 60px;
    border-radius: 100%;
    border: 1px solid #eee;
}



.sidebar{
    position: absolute;
    top: 0;
    left: 0;
    height: 130vh;
    width: 80px;
    background-color:purple ;
    padding: 0.4rem 0.8rem;
    transition: all 0.5s ease;
    position: fixed;
}


 .sidebar.active ~ .main-content{
    left: 250px;
    width: calc(100% - 250px);
}
.sidebar.active{
    width: 250px;
}
 .sidebar #btn{
    position: absolute;
    color: #fff;
    top: .2rem;
    left:50%;
    font-size: 1.2rem;
   line-height:40px;
    cursor: pointer;
    transform: translateX(-50%);
}

.sidebar.active #btn{
    left: 90%;

} 

.sidebar.top.logo{
    display: flex;
    color: #fff;
    height: 50px;
    width: 100%;
    align-items: center;
    pointer-events: none;
    opacity: 0;
}

.sidebar.active.top.logo{
    opacity: 1;
   
}

.top.logo i{
    font-size: 2rem;
    margin-right: 5px;
}

.user{
    display: flex;
    align-items: center;
    margin: 1rem 0;
}

.user p{
    color: #fff;
    opacity: 1;
    margin-left: 1rem;
   
} 

.bold{
    font-weight: 600;
}

.sidebar p{
    opacity: 0;
}
.sidebar.active p{
    opacity: 1;
}


.sidebar ul li{
    position: relative;
    list-style-type:none;
    height:50px;
    width: 90%;
    margin: 0.8rem auto;
    line-height: 50px;
    
}

.sidebar ul li a{
    
    color: #fff;
    text-decoration: none;
    display: flex;
    align-items: center;
    text-decoration: none;
    border-radius: 0.8rem;
    
    
}

.sidebar ul li a:hover{
    background-color: #fff;
    color: purple;
}

.sidebar ul li a i{
   min-width: 50px;
   text-align: center;
   height:50px;
   border-radius: 12px;
   line-height: 50px;
   
}

.sidebar .nav-item{
    opacity: 1;
    margin-left: 13px;
    
}

.sidebar ul li .tooltip{
    position: absolute;
    left:125px;
    top: 50%;
    transform: translateY(-50%, -50%);
    box-shadow: 0 0.5rem 0.8rem  rgba(0,0,0,0.2);
    border-radius: .6rem;
    padding: 0.4rem 1.2rem;
    line-height: 1.8rem;
    z-index:20;
    opacity: 0;
}

.sidebar ul li a:hover .tooltip{
    opacity: 1;
    
}

.sidebar.active ul li .tooltip{
    display: none;
}

.main-content{
    position: relative;
    min-height: 100vh;
    top: 0;
    left: 80px;
    width: calc(100% - 80px);
    height: 100vh;
    background-color: #f4f4f4;
    transition: all 0.5s ease;
    padding: 1rem;

} */

    .sidebar {
      position: fixed; /* Change from sticky to fixed */
      top: 0;
      left: 0;
      width: 80px;
      height: 100vh;
      background-color: purple;
      padding: 0.4rem 0.8rem;
      transition: all 0.5s ease;
      overflow-y: auto;
      overflow-x: hidden;
    }

    .accordion {
      font-family: Arial, Helvetica, sans-serif;
      background-color: purple;
      color: white;

      text-decoration: none;

      display: block;
      border: none;



      cursor: pointer;
      outline: none;

    }

    .accordion-button:hover {
      background-color: whitesmoke !important;
      color: purple !important;
    }

    .accordion-body a:hover {
      background-color: whitesmoke;
      color: purple;
    }

    .accordion-body a {
      padding: 6px 8px 6px 30px;
      text-decoration: none;
      font-size: 16px;
      color: white;
      display: block;
      border: none;
      background: none;
      width: 100%;
      text-align: left;
      cursor: pointer;
      outline: none;
    }

    .sidebar.active~.main-content {
      left: 250px;
      width: calc(100% - 250px);
    }

    .sidebar.active {
      width: 250px;
    }

    .sidebar #btn {
      position: absolute;
      color: #fff;
      top: .2rem;
      left: 50%;
      font-size: 1.2rem;
      line-height: 40px;
      cursor: pointer;
      transform: translateX(-50%);
    }

    .sidebar.active #btn {
      left: 90%;
    }

    .sidebar.top.logo {
      display: flex;
      color: #fff;
      height: 50px;
      width: 100%;
      align-items: center;
      pointer-events: none;
      opacity: 0;
    }

    .sidebar.active.top.logo {
      opacity: 1;
    }

    .top.logo i {
      font-size: 2rem;
      margin-right: 5px;
    }

    .user {
      display: flex;
      align-items: center;
      margin: 1rem 0;
    }

    .user p {
      color: #fff;
      opacity: 1;
      margin-left: 1rem;
    }

    .bold {
      font-weight: 600;
    }

    .sidebar p {
      opacity: 0;
    }

    .sidebar.active p {
      opacity: 1;
    }

    .sidebar ul li {
      position: relative;
      list-style-type: none;
      height: 50px;
      width: 90%;
      margin: 0.8rem auto;
      line-height: 50px;
    }

    .sidebar ul li a {
      color: #fff;
      text-decoration: none;
      display: flex;
      align-items: center;
      text-decoration: none;
      border-radius: 0.8rem;
    }

    .sidebar ul li a:hover {
      background-color: #fff;
      color: purple;
    }

    .sidebar ul li a i {
      min-width: 50px;
      text-align: center;
      height: 50px;
      border-radius: 12px;
      line-height: 50px;
    }

    .sidebar .nav-item {
      opacity: 1;
      margin-left: 13px;
    }

    .sidebar ul li .tooltip {
      position: absolute;
      left: 125px;
      top: 50%;
      transform: translateY(-50%, -50%);
      box-shadow: 0 0.5rem 0.8rem rgba(0, 0, 0, 0.2);
      border-radius: .6rem;
      padding: 0.4rem 1.2rem;
      line-height: 1.8rem;
      z-index: 20;
      opacity: 0;
    }

    .sidebar ul li a:hover .tooltip {
      opacity: 1;
    }

    .sidebar.active ul li .tooltip {
      display: none;
      /*display text size normal to bold  display:auto;*/
    }


    /* .sidebar.accordian#k#kk:hover{
   background-color: black;
   color: white;

} */

    .sidebar.active ul li .tooltip {
      display: none;
    }

    /* .accordion:hover {
    background-color: black;
    color: white;
} */

    .main-content {
      position: absolute;
      min-height: 100vh;
      top: 0;
      left: 80px;
      width: calc(100% - 80px);
      height: 100vh;
      background-color: #f4f4f4;
      transition: all 0.5s ease;
      padding: 1rem;
    }

    /* Change color of scrollbar in WebKit browsers */
    .sidebar::-webkit-scrollbar {
      width: 10px;
      /* Set the width of the scrollbar */
    }

    /* Change color of scrollbar thumb */
    .sidebar::-webkit-scrollbar-thumb {
      /* Set the color of the thumb */
      border-radius: 5px;
      /* Set the border radius of the thumb */
      height: 10px
    }

    /* Change color of scrollbar track */
    .sidebar::-webkit-scrollbar-track {
      background: #f1f1f1;
      /* Set the background color of the track */
    }


    #navbar {
      font-size: 12px;
      position: -webkit-sticky;
      position: sticky;
      top: 0;
      z-index: 2;
    }

    .container-fluid {
      background-color: purple;
      color: white;
      position: sticky;

    }


    .container-fluid a {
      float: left;
      display: block;
      background-color: purple;
      color: white;
      text-align: center;
      padding: 14px 16px;
      text-decoration: none;
      font-size: 17px;

    }

    .container-fluid a:hover {
      background-color: white;
      color: purple;
    }


    .dropdown-menu {
      background-color: purple;
      color: white;
    }

    .dropdown-menu:hover {
      background-color: white;
      color: purple;
    }

    .container-fluid .search-container {
      float: right;

      /* padding-right: 20px; */
    }

    .container-fluid input[type=text] {
      padding: 6px;
      margin-top: 8px;
      font-size: 17px;
      border: none;
    }

    .container-fluid .search-container button {
      float: right;
      padding: 6px 10px;
      margin-top: 8px;
      margin-right: 16px;
      height: 37px;
      background: white;
      font-size: 17px;
      border: none;
      cursor: pointer;
    }

    .container-fluid .search-container button:hover {
      background: white;

    }


    /* {$prefix}accordion-btn-focus-box-shadow: #{$accordion-button-focus-box-shadow}; */
  </style>

</head>

<body>


  <div class="sidebar">

  <?php include('includea/asidebar.php');?>

  </div>


  <script>
    /* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
    var dropdown = document.getElementsByClassName("dropdown-btn");
    var i;

    for (i = 0; i < dropdown.length; i++) {
      dropdown[i].addEventListener("click", function () {
        this.classList.toggle("active");
        var dropdownContent = this.nextElementSibling;
        if (dropdownContent.style.display === "block") {
          dropdownContent.style.display = "none";
        } else {
          dropdownContent.style.display = "block";
        }
      });
    }
  </script>


  <div class="main-content" style="padding: 0;">


    <nav class="navbar navbar-expand-lg bg-body-tertiary" id="navbar">
    <?php include('includea/anavbar.php');?>

    </nav>
    
    <div class="container">
        <button class="btn btn-danger">Back</button>
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
<tr>
                    <th>Addimited Days :</th>
                    <td><?php echo $totalDays; ?> days</td>
    </tr>
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
                        <td>visit Fee</td>
                        <td><?php echo $visit_fee; ?></td>
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
            <div class="edit-btn">
<!-- Example line with possible issues in HTML -->
<a href="billsedit.php?aadhar=<?php echo $row_patient['aadhar']; ?>" class="btn btn-primary">Edit Billing Details</a>
        </div>
        </div>
        <div class="print-btn">
            <button class="btn btn-primary" onclick="window.print()">Print</button>
        </div>
    </div>


</body>

<script>
  let btn = document.querySelector("#btn");
  let sidebar = document.querySelector(".sidebar");
  let searchBtn = document.querySelector(".bx-search");

  btn.onclick = function () {
    sidebar.classList.toggle("active");
  };
</script>

</html>