<?php
session_start();


include('../connection.php');

$sql = "SELECT * from `billing_details`";

$res = mysqli_query($conn, $sql);

if($res){
    echo "success";
}
else {
    echo "fail";
}








?>







<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Accountant Dashboard</title>
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
    .table th {
        background-color:purple;
        color:white;
      
    }
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


  <div class="main-content">


    <nav class="navbar navbar-expand-lg bg-body-tertiary" id="navbar">
    <?php include('includea/anavbar.php');?>

    </nav>



        <div class="container  ">
           

                    <div class="row table-responsive">
                      <div class="col-sm-8">
                      <h2 style="text-align:center;">Bill Records</h2>
                      </div>
                      <div class="col-sm-4">
                              <div class="input-group  mb-3">
                                   <input type="text" class="form-control shadow-none" placeholder="Search" aria-label="Recipient's username" aria-describedby="button-addon2" id="search" onkeyup="searchfun()">
                                 <button class="btn btn-outline-dark " type="button" id="button-addon2" style="z-index: 1;"><i class="fa-solid fa-magnifying-glass"></i></button>
                                </div>
                       </div>


                       <form action="#" method="get">
                                    <div class="row">
                       <h5>Date-<?php echo $currentDate = date("Y-m-d"); ?></h5>
                         
                           
                                
                                        <div class="col-sm-4">
                                                <label for="fdate">From Date</label>
                                                <input type="date" name="fdate" class="form-control">
                                        </div>
                                        <div class="col-sm-4">
                                                <label for="tdate">To Date</label>
                                                <input type="date" name="tdate" class="form-control">
                                        </div>
                                        <div class="col-4">
                                            <br>
                                            
                                            <button class="btn btn-secondary" name="search" id="btn">Search</button>
                                        </div>
                                    </div>


                      
                      <hr>
                      
                      <table class="table table-bordered table-hover mt-4" id="mytable">    
                            <thead>
                                <tr>
                                <th>Sr. No</th>
                                <th>Patient Name</th>
                                <th>Aadhar</th>
                                <!-- <th>Contact</th> -->
                                <!-- <th>Email</th> -->
                                <!-- <th>DOB</th> -->
                                <!-- <th>Blood</th> -->
                                <th>Gender</th>
                                <!-- <th>Address</th> -->
                                <th>Day_charges</th>
                                <th>Doctor_fees</th>
                                <th>Total Charges</th>
                                <th>Created_at</th>
                                <th>Action  </th>
                              
                                </tr> 
                            </thead>
                            <tbody>
                            <?php
                                $cn =1;
                                while($row = mysqli_fetch_assoc($res)){
                                ?>
                                <tr>
                                    <td><?php echo $cn++ ?></td>            
                                    <td><?php echo $row['fname'] ?></td>
                                    <td><?php echo $row['aadhar'] ?></td>
                                    <td><?php echo $row['gender'] ?></td>
                                    <td><?php echo $row['day_charges'] ?></td>
                                    <td><?php echo $row['doctor_fee'] ?></td>
                                    <td><?php echo $row['total_charges'] ?></td>
                                    <td><?php echo $row['created_at'] ?></td>
                                  
                                    <td style="text-align:center;"><a href="billprofile.php?id=<?php echo $row['id']; ?>" style="text-align: center;">View</a></td>
                                    <!-- <td style="text-align:center;"><a href="editdr.php?id=<?php echo $row['id']; ?>" ><i class="fa fa-pencil" style="font-size:20px; color:black;"></i></a>&nbsp;&nbsp;&nbsp;
                                    <a href="#" onclick="showDeleteConfirmation(event, <?php echo $row['id']; ?>)"><i class="fa fa-trash" style="font-size:20px; color:red;"></i></a></td> -->
                                </tr>
                            </tbody>
                            <?php } ?>

                          
<script>
                    function searchfun(){
                        let filter = document.getElementById('search').value.toUpperCase();
                        let mytab = document.getElementById('mytable');
                        let tr = mytab.getElementsByTagName('tr');

                        for(var i=0;i<tr.length;i++){


                            
                                
                                    let td= tr[i].getElementsByTagName('td')[1];
                                    let td2= tr[i].getElementsByTagName('td')[2];
                                    
                                    
                                    // console.log(td);
                                    if(td || td2){
                                        let textvalue = td.textContent || td.innerHTML;
                                        let textvalue2 = td2.textContent || td2.innerHTML;
                                        
                                        
                                        if(textvalue.toUpperCase().indexOf(filter)>-1) {
                                            tr[i].style.display=""; 
                                            
                                        }else if(textvalue2.toUpperCase().indexOf(filter)>-1) {
                                            tr[i].style.display=""; 
                                        
                                        }else{
                                            tr[i].style.display="none"; 

                                        }
                                    }
                                    // elseif(td2){
                                    //     let textvalue2 = td2.textContent || td2.innerHTML;
                                    //     if(textvalue2.toUpperCase().indexOf(filter)>-1){
                                    //         tr[i].style.display=""; 
                                    //     } else {
                                    //         tr[i].style.display="none"; 
                                    //     }
                                    // }

                        }

                    }
                    
                            
                            
                </script>
                        </table>
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