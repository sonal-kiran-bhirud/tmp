billprofileview.php
<?php
session_start();


include('../connection.php');
$id =$_GET['id'];

$sql="SELECT * FROM billing_details WHERE id=$id";
$res = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($res);

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
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

    .profile{
      padding: 5% 4%;
      padding-right: 36%;
  }
  #container{
      box-shadow: 0px 30px 30px black;
      /* border-radius: 15px; */
  }
  #prof{
      height: 550px;
  }
  h6{
      color:  #80b3ff;
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




    

  .emp-profile{
    padding: 3%;
    margin-top: 3%;
    margin-bottom: 3%;
    border-radius: 0.5rem;
    background: #fff;
}
.profile-img{
    text-align: center;
}
.profile-img img{
    width: 70%;
    height: 100%;
}
.profile-img .file {
    position: relative;
    overflow: hidden;
    margin-top: -20%;
    width: 70%;
    border: none;
    border-radius: 0;
    font-size: 15px;
    background: #212529b8;
}
.profile-img .file input {
    position: absolute;
    opacity: 0;
    right: 0;
    top: 0;
}
.profile-head h5{
    color: #333;
}
.profile-head h6{
    color: #0062cc;
}
.profile-edit-btn{
    border: none;
    border-radius: 1.5rem;
    width: 70%;
    padding: 2%;
    font-weight: 600;
    color: #6c757d;
    cursor: pointer;
}
.proile-rating{
    font-size: 12px;
    color: #818182;
    margin-top: 5%;
}
.proile-rating span{
    color: #495057;
    font-size: 15px;
    font-weight: 600;
}
.profile-head .nav-tabs{
    margin-bottom:5%;
}
.profile-head .nav-tabs .nav-link{
    font-weight:600;
    border: none;
}
.profile-head .nav-tabs .nav-link.active{
    border: none;
    border-bottom:2px solid #0062cc;
}
.profile-work{
    padding: 14%;
    margin-top: -15%;
}
.profile-work p{
    font-size: 12px;
    color: #818182;
    font-weight: 600;
    margin-top: 10%;
}
.profile-work a{
    text-decoration: none;
    color: #495057;
    font-weight: 600;
    font-size: 14px;
}
.profile-work ul{
    list-style: none;
}
.profile-tab label{
    font-weight: 600;
}
.profile-tab p{
    font-weight: 600;
    color: purple;
}

.v1 {
  border-left: 2px solid purple;
  
  
 
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

    <div class="container emp-profile " style="height:500px; overflow: auto;">
    <form method="post">
        <div class="row">
            <div class="col-md-4">
                <div class="profile-img">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS52y5aInsxSm31CvHOFHWujqUx_wWTS9iM6s7BAm21oEN_RiGoog" alt=""/>
                    <div class="file btn btn-lg btn-primary">
                        Change Photo
                        <input type="file" name="file"/>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="profile-head">
                            <h5>
                              Patient Profile
                            </h5>
                            <!-- <h6>
                                Web Developer and Designer
                            </h6>
                            <p class="proile-rating">RANKINGS : <span>8/10</span></p> -->
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="" role="tab" aria-controls="home" aria-selected="true">About</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Reports</a>
                        </li>
                    </ul> -->
                </div>
            </div>
            <div class="col-md-2">
                <!-- <input type="submit" class="profile-edit-btn" name="btnAddMore" value="Edit Profile"/> -->
<!-- 
                <a href="editpatient.php?id=<?php echo $row['id'];?>" class="btn btn-primary"><i class="fas fa-edit"></i> Edit</a> -->
            </div>
        </div>
        <div class="row">
            
            <div class="col-md-8 ">
                <div class="tab-content profile-tab" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <h4>Details</h4>
                                <div class="row">
                                   
                                    

                                    

                                    <div class="col-md-3">
                                        <label>Name :-</label>
                                    </div>
                                    <div class="col-md-3">
                                    <p> <?php echo $row['fname']; ?></p>
                                    </div>

                                    <div class="col-md-3">
                                        <label>Aadhar :-</label>
                                    </div>
                                    <div class="col-md-3">
                                    <p> <?php echo $row['aadhar']; ?></p>
                                    </div>
                                </div><hr>



                               

                                

                                <div class="row">
                                    

                                    <div class="col-md-3">
                                        <label>Gender :-</label>
                                    </div>
                                    <div class="col-md-3">
                                    <p> <?php echo $row['gender']; ?></p>
                                    </div>
                                </div><hr>

                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Day Charges :-</label>
                                    </div>
                                    <div class="col-md-3">
                                    <p> <?php echo $row['day_charges']; ?></p>
                                    </div>

                                    <div class="col-md-3">
                                        <label>Doctor Fees :-</label>
                                    </div>
                                    <div class="col-md-3">
                                    <p> <?php echo $row['doctor_fee']; ?></p>
                                    </div>
</div><hr>


                                    <div class="row">
                                    <div class="col-md-3">
                                        <label>Nurse Fees :-</label>
                                    </div>
                                    <div class="col-md-3">
                                    <p> <?php echo $row['nurse_fee']; ?></p>
                                    </div>

                                    <div class="col-md-3">
                                        <label>Report Fees :-</label>
                                    </div>
                                    <div class="col-md-3">
                                    <p> <?php echo $row['reports_fee']; ?></p>
                                    </div>
                                </div><hr>

                                


                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Total Charges :-</label>
                                    </div>
                                    <div class="col-md-3">
                                    <p> <?php echo $row['total_charges']; ?></p>
                                    </div>

                                    <div class="col-md-3">
                                        <label>created_at :-</label>
                                    </div>
                                    <div class="col-md-3">
                                    <p> <?php echo $row['created_at']; ?></p>
                                    </div>
                                </div><hr>





                                <div class="row">
                                    <div class="col-md-3">
                                        <label>indate :-</label>
                                    </div>
                                    <div class="col-md-3">
                                    <p> <?php echo $row['indate']; ?></p>
                                    </div>

                                    <div class="col-md-3">
                                        <label>outdate :-</label>
                                    </div>
                                    <div class="col-md-3">
                                    <p> <?php echo $row['outdate']; ?></p>
                                    </div>
</div><hr>

                                    <div class="row">
                                    <div class="col-md-3">
                                        <label>additional_amount_0 :-</label>
                                    </div>
                                    <div class="col-md-3">
                                    <p> <?php echo $row['additional_amount_0']; ?></p>
                                    </div>

                                    <div class="col-md-3">
                                        <label>additional_description_0 :-</label>
                                    </div>
                                    <div class="col-md-3">
                                    <p> <?php echo $row['additional_description_0']; ?></p>
                                    </div>
                                </div><hr>

                                <div class="row">
                                    <div class="col-md-3">
                                        <label>total_days</label>
                                    </div>
                                    <div class="col-md-3">
                                    <p> <?php echo $row['total_days']; ?></p>
                                    </div>

                                  
                                </div><hr>
                                </div>
                                
                    </div>
          
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