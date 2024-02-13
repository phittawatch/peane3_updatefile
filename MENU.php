<?php 
    session_start();
    include 'connect.php';
    if (!isset($_SESSION['user_id_input'])) {
        $_SESSION['msg'] = "กรุณาล็อกอินก่อน!";
        header('location: login_process.php');
        exit();
    }
    if (isset($_GET['logout'])){
        session_destroy();
        unset($_SESSION['user_id_input']);
        header('location: login_process.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PEA NE3 Computer and Network</title>
  <link rel="icon" type="image/png" href="logopea2.png" sizes="16x16">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light"
  rel="stylesheet" type="text/css">
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <style>

    body {
      font-family: 'Open Sans', sans-serif;
      display: flex;
      flex-direction: column;
      align-items: center;
      height: 100vh;
      margin: 0;
      background-color: whitesmoke; /* Light grey background */
    }

    .header-content {
      display: flex;
      align-items: center;

    }

    .header {
      position: relative;
      font-family: 'Open Sans', sans-serif;
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      padding: 15px;
      background-color: purple;
      color: white;
      width: 100%;
    }

    .header-title {
      font-size: 32px;
      font-weight: bold;
      margin-bottom: 10px;
      margin-left: 30px;
    }
    .logo{
      width: 100px;
      height: 60px;
      margin-bottom: 5px;
    }

    .button-container {
      position: relative;
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 30px; 
    }

    .color-button {
      font-family: 'Open Sans', sans-serif;
      font-weight: bold;
      width: 250px;
      height: 100px;
      margin: 30px;
      background-color: purple;
      color: white;
      border-radius: 15px;
      cursor: pointer;
      transition: background-color 0.3s ease, transform 0.2s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 18px;
    }

    .color-button:hover {
      z-index: 0;
      background-color: white;
      color: purple;
      transform: scale(1.1);
    }

    .color-button:active {
      background-color: purple; /* Change color back to purple on click */
    }

    .sub-buttons {
      font-weight: lighter;
      top: 100%; /* Position sub-buttons below the button */
      left: 0;
      gap: 4px;
      background-color: #fff;
      border: 1px solid #ccc;
      border-radius: 8px;
      display: none; /* Hide sub-buttons by default */
      flex-direction: column;
      padding: 10px;


    }
    .sub-buttons.active {
  display: flex;
}

    .sub-button {
      position: relative;
      margin-top: 5px;
      cursor: pointer;
    }
  </style>
</head>
<body>



<div class="container-fluid">
  
                <nav class="navbar navbar-expand navbar-light bg-gradient-primary topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <a href="index.php">
                      <img src="pealogo-removebg.png" alt="Logo" class="logo">
                   </a>

                  

                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-secondary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                          </div>
                                      </div> 
                                  </form>
                              </div>
                          </li>


                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php
                                    // Assuming the user's name and surname are stored in a session variable
                                    session_start();
                                    if (isset($_SESSION['user_name']) && isset($_SESSION['user_surname'])) {
                                        echo '<span class="mr-2 d-none d-lg-inline text-white-600 small">' . $_SESSION['user_name'] . ' ' . $_SESSION['user_surname'] . '</span>';
                                    } else {
                                        // If not in session, fetch from the database
                                        include 'connect.php';
                                        $user_id_in = $_SESSION['user_id_input'];
                                        $sql_user_info = "SELECT name, surname FROM users_id WHERE user_id_database = '$user_id_in'";
                                        $result_user_info = $conn->query($sql_user_info);
                                        
                                        if ($result_user_info->rowCount() > 0) {
                                            $user_info = $result_user_info->fetch(PDO::FETCH_ASSOC);
                                            echo '<span class="mr-2 d-none d-lg-inline text-white-600 small">' . $user_info['name'] . ' ' . $user_info['surname'] . '</span>';
                                        } else {
                                            // Default if user info not found
                                            echo '<span class="mr-2 d-none d-lg-inline text-white-600 small">User</span>';
                                        }
                                    }
                                    ?>
                                    
                                <img class="img-profile rounded-circle"
                                    src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>

                
</div>             
<!--
  <div class="button-container">
    <div class="color-button" onclick="toggleSubButtons('PEANE3')">กฟฉ.3
      <div class="sub-buttons" id="PEANE3SubButtons">
        <div class="sub-button" onclick="subButtonClick('กฟจ.นครราชสีมา')">กฟจ.นครราชสีมา</div>
        <div class="sub-button" onclick="subButtonClick('กฟส.โนนสูง')">กฟส.โนนสูง</div>
        <div class="sub-button" onclick="subButtonClick('กฟส.โนนไทย')">กฟส.โนนไทย</div>
        <div class="sub-button" onclick="subButtonClick('กฟส.จอหอ')">กฟส.จอหอ</div>
        <div class="sub-button" onclick="subButtonClick('กฟย.ขามสะแกแสง')">กฟย.ขามสะแกแสง</div>
        <div class="sub-button" onclick="subButtonClick('กฟย.พระทองคำ')">กฟย.พระทองคำ</div>
      </div>
    </div>
  -->


  <div class="button-container">
    <div class="color-button" onclick="toggleSubButtons('KORAT1')">กฟจ.นครราชสีมา
      <div class="sub-buttons" id="KORAT1SubButtons">
        <div class="sub-button" onclick="subButtonClick('กฟจ.นครราชสีมา')">กฟจ.นครราชสีมา</div>
        <div class="sub-button" onclick="subButtonClick('กฟส.โนนสูง')">กฟส.โนนสูง</div>
        <div class="sub-button" onclick="subButtonClick('กฟส.โนนไทย')">กฟส.โนนไทย</div>
        <div class="sub-button" onclick="subButtonClick('กฟส.จอหอ')">กฟส.จอหอ</div>
        <div class="sub-button" onclick="subButtonClick('กฟย.ขามสะแกแสง')">กฟย.ขามสะแกแสง</div>
        <div class="sub-button" onclick="subButtonClick('กฟย.พระทองคำ')">กฟย.พระทองคำ</div>
      </div>
    </div>

    <div class="color-button" onclick="toggleSubButtons('KORAT2')">กฟจ.นครราชสีมา2(หัวทะเล)
      <div class="sub-buttons" id="KORAT2SubButtons">
        <div class="sub-button" onclick="subButtonClick('กฟจ.นครราชสีมา2(หัวทะเล)')">กฟจ.นครราชสีมา2(หัวทะเล)</div>
        <div class="sub-button" onclick="subButtonClick('กฟส.จักราช')">กฟส.จักราช</div>
        <div class="sub-button" onclick="subButtonClick('กฟย.เฉลิมพระเกียรติ')">กฟย.เฉลิมพระเกียรติ</div>
        <div class="sub-button" onclick="subButtonClick('กฟย.ห้วยแถลง')">กฟย.ห้วยแถลง</div>
    </div>
  </div>
    <div class="color-button" onclick="toggleSubButtons('KORAT3')">กฟจ.นครราชสีมา3(สุรนารี)
      <div class="sub-buttons" id="KORAT3SubButtons">
        <div class="sub-button" onclick="subButtonClick('กฟจ.นครราชสีมา3(สุรนารี)')">กฟจ.นครราชสีมา3(สุรนารี)</div>
        <div class="sub-button" onclick="subButtonClick('กฟย.ขามทะเลสอ')">กฟย.ขามทะเลสอ</div>
      </div>
        </div>
        <div class="color-button" onclick="toggleSubButtons('CHAIYAPHUM')">กฟจ.ชัยภูมิ
            <div class="sub-buttons" id="CHAIYAPHUMSubButtons">
              <div class="sub-button" onclick="subButtonClick('กฟจ.ชัยภูมิ')">กฟจ.ชัยภูมิ</div>
              <div class="sub-button" onclick="subButtonClick('คลังพัสดุ กฟจ.ชัยภูมิ')">คลังพัสดุ กฟจ.ชัยภูมิ</div>
              <div class="sub-button" onclick="subButtonClick('กฟส.แก้งคร้อ')">กฟส.แก้งคร้อ</div>
              <div class="sub-button" onclick="subButtonClick('กฟส.จัตุรัส')">กฟส.จัตุรัส</div>
              <div class="sub-button" onclick="subButtonClick('กฟส.หนองบัวแดง')">กฟส.หนองบัวแดง</div>
              <div class="sub-button" onclick="subButtonClick('กฟส.บำเหน็จนรงค์')">กฟส.บำเหน็จนรงค์</div>
              <div class="sub-button" onclick="subButtonClick('กฟย.บ้านเขว้า')">กฟย.บ้านเขว้า</div>
              <div class="sub-button" onclick="subButtonClick('กฟย.คอนสวรรค์')">กฟย.คอนสวรรค์</div>
              <div class="sub-button" onclick="subButtonClick('กฟย.เนินสง่า')">กฟย.เนินสง่า</div>
              <div class="sub-button" onclick="subButtonClick('กฟย.หนองบัวระเหว')">กฟย.หนองบัวระเหว</div>
              <div class="sub-button" onclick="subButtonClick('กฟย.ภัคดีชุมพล')">กฟย.ภัคดีชุมพล</div>
              <div class="sub-button" onclick="subButtonClick('กฟย.เทพสถิต')">กฟย.เทพสถิต</div>
            </div>
              </div>
    
        <div class="color-button" onclick="toggleSubButtons('BURIRAM')">กฟจ.บุรีรัมย์
            <div class="sub-buttons" id="BURIRAMSubButtons">
              <div class="sub-button" onclick="subButtonClick('กฟจ.บุรีรัมย์')">กฟจ.บุรีรัมย์</div>
              <div class="sub-button" onclick="subButtonClick('คลังพัสดุ กฟจ.บุรีรัมย์')">คลังพัสดุ กฟจ.บุรีรัมย์</div>
              <div class="sub-button" onclick="subButtonClick('กฟส.คูเมือง')">กฟส.คูเมือง</div>
              <div class="sub-button" onclick="subButtonClick('กฟส.กระสัง')">กฟส.กระสัง</div>
              <div class="sub-button" onclick="subButtonClick('กฟส.สตึก')">กฟส.สตึก</div>
              <div class="sub-button" onclick="subButtonClick('กฟส.ลำปลายมาศ')">กฟส.ลำปลายมาศ</div>
              <div class="sub-button" onclick="subButtonClick('กฟส.พุธไทสง')">กฟส.พุธไทสง</div>
              <div class="sub-button" onclick="subButtonClick('กฟย.แคนดง')">กฟย.แคนดง</div>
              <div class="sub-button" onclick="subButtonClick('กฟย.หนองหงส์')">กฟย.หนองหงส์</div>
              <div class="sub-button" onclick="subButtonClick('กฟย.นาโพธิ์')">กฟย.นาโพธิ์</div>
              <div class="sub-button" onclick="subButtonClick('กฟย.บ้านใหม่ไชยพจน์')">กฟย.บ้านใหม่ไชยพจน์</div>
              <div class="sub-button" onclick="subButtonClick('PEA Shop บุรีรัมย์')">PEA Shop บุรีรัมย์</div>
            </div>
              </div>

        <div class="color-button" onclick="toggleSubButtons('SURIN')">กฟจ.สุรินทร์
            <div class="sub-buttons" id="SURINSubButtons">
                <div class="sub-button" onclick="subButtonClick('คลังพัสดุ กฟจ.สุรินทร์')">คลังพัสดุ กฟจ.สุรินทร์</div>
                <div class="sub-button" onclick="subButtonClick('กฟจ.สุรินทร์')">กฟจ.สุรินทร์</div>
              <div class="sub-button" onclick="subButtonClick('กฟส.ศีขรภูมิ')">กฟส.ศีขรภูมิ</div>
              <div class="sub-button" onclick="subButtonClick('กฟส.ท่าตูม')">กฟส.ท่าตูม</div>
              <div class="sub-button" onclick="subButtonClick('กฟส.รัตนบุรี')">กฟส.รัตนบุรี</div>
              <div class="sub-button" onclick="subButtonClick('PEA Shop ตลาดไนท์บาซ่า สุรินทร์')">PEA Shop ตลาดไนท์บาซ่า สุรินทร์</div>
              <div class="sub-button" onclick="subButtonClick('กฟย.สนม')">กฟย.สนม</div>
              <div class="sub-button" onclick="subButtonClick('กฟย.ลำดวน')">กฟย.ลำดวน</div>
              <div class="sub-button" onclick="subButtonClick('กฟย.จอมพระ')">กฟย.จอมพระ</div>
              <div class="sub-button" onclick="subButtonClick('กฟย.สำโรงทาบ')">กฟย.สำโรงทาบ</div>
              <div class="sub-button" onclick="subButtonClick('กฟย.ชุมพลบุรี')">กฟย.ชุมพลบุรี</div>
              <div class="sub-button" onclick="subButtonClick('กฟย.โนนนารายณ์')">กฟย.โนนนารายณ์</div>
            </div>
              </div>

        <div class="color-button" onclick="toggleSubButtons('NANGRONG')">กฟอ.นางรอง
            <div class="sub-buttons" id="NANGRONGSubButtons">
                <div class="sub-button" onclick="subButtonClick('กฟอ.นางรอง')">กฟอ.นางรอง</div>
                <div class="sub-button" onclick="subButtonClick('คลังพัสดุ กฟอ.นางรอง')">คลังพัสดุ กฟอ.นางรอง</div>
                <div class="sub-button" onclick="subButtonClick('กฟส.ประโคนชัย')">กฟส.ประโคนชัย</div>
              <div class="sub-button" onclick="subButtonClick('กฟส.หนองกี่')">กฟส.หนองกี่</div>
              <div class="sub-button" onclick="subButtonClick('กฟส.ละหานทราย')">กฟส.ละหานทราย</div>
              <div class="sub-button" onclick="subButtonClick('กฟส.บ้านกรวด')">กฟส.บ้านกรวด</div>
              <div class="sub-button" onclick="subButtonClick('กฟย.ปะคำ')">กฟย.ปะคำ</div>
              <div class="sub-button" onclick="subButtonClick('กฟย.พลับพลาชัย')">กฟย.พลับพลาชัย</div>
              <div class="sub-button" onclick="subButtonClick('กฟย.โนนดินแดง')">กฟย.โนนดินแดง</div>
            </div>
              </div>

        <div class="color-button" onclick="toggleSubButtons('PAKCHONG')">กฟอ.ปากช่อง
            <div class="sub-buttons" id="PAKCHONGSubButtons">
                <div class="sub-button" onclick="subButtonClick('กฟอ.ปากช่อง')">กฟอ.ปากช่อง</div>
                <div class="sub-button" onclick="subButtonClick('คลังพัสดุ กฟอ.ปากช่อง')">คลังพัสดุ กฟอ.ปากช่อง</div>
                <div class="sub-button" onclick="subButtonClick('กฟส.หมูสี')">กฟส.หมูสี</div>
                <div class="sub-button" onclick="subButtonClick('กฟย.กลางดง')">กฟย.กลางดง</div>
              <div class="sub-button" onclick="subButtonClick('กฟย.คลองม่วง')">กฟย.คลองม่วง</div>
            </div>
              </div>

      <div class="color-button" onclick="toggleSubButtons('SEKIW')">กฟอ.สีคิ้ว
            <div class="sub-buttons" id="SEKIWSubButtons">
                <div class="sub-button" onclick="subButtonClick('กฟอ.สีคิ้ว')">กฟอ.สีคิ้ว</div>
                <div class="sub-button" onclick="subButtonClick('คลังพัสดุ กฟอ.สีคิ้ว')">คลังพัสดุ กฟอ.สีคิ้ว</div>
                <div class="sub-button" onclick="subButtonClick('กฟส.สูงเนิน')">กฟส.สูงเนิน</div>
                <div class="sub-button" onclick="subButtonClick('กฟส.ด่านขุนทด')">กฟส.ด่านขุนทด</div>
              <div class="sub-button" onclick="subButtonClick('กฟย.เทพารักษ์')">กฟย.เทพารักษ์</div>
              <div class="sub-button" onclick="subButtonClick('กฟย.ห้วยบง')">กฟย.ห้วยบง</div>
            </div>
              </div>
         
        <div class="color-button" onclick="toggleSubButtons('BUAYAI')">กฟอ.บัวใหญ่
            <div class="sub-buttons" id="BUAYAISubButtons">
                <div class="sub-button" onclick="subButtonClick('กฟอ.บัวใหญ่')">กฟอ.บัวใหญ่</div>
                <div class="sub-button" onclick="subButtonClick('คลังพัสดุ กฟส.บัวใหญ่')">คลังพัสดุ กฟส.บัวใหญ่</div>
                <div class="sub-button" onclick="subButtonClick('กฟส.ประทาย')">กฟส.ประทาย</div>
                <div class="sub-button" onclick="subButtonClick('กฟส.คง')">กฟส.คง</div>
                <div class="sub-button" onclick="subButtonClick('กฟย.บัวลาย')">กฟย.บัวลาย</div>
              <div class="sub-button" onclick="subButtonClick('กฟย.แก้งสนามนาง')">กฟย.แก้งสนามนาง</div>
              <div class="sub-button" onclick="subButtonClick('กฟย.บ้านเหลื่อม')">กฟย.บ้านเหลื่อม</div>
              <div class="sub-button" onclick="subButtonClick('กฟย.โนนแดง')">กฟย.โนนแดง</div>
            </div>
              </div>

        <div class="color-button" onclick="toggleSubButtons('CHOCKCHAI')">กฟอ.โชคชัย
            <div class="sub-buttons" id="CHOCKCHAISubButtons">
                <div class="sub-button" onclick="subButtonClick('กฟอ.โชคชัย')">กฟอ.โชคชัย</div>
                <div class="sub-button" onclick="subButtonClick('คลังพัสดุ กฟอ.โชคชัย')">คลังพัสดุ กฟอ.โชคชัย</div>
                <div class="sub-button" onclick="subButtonClick('กฟส.ครบุรี')">กฟส.ครบุรี</div>
                <div class="sub-button" onclick="subButtonClick('กฟส.หนองบุญมาก')">กฟส.หนองบุญมาก</div>
              <div class="sub-button" onclick="subButtonClick('กฟส.เสิงสาง')">กฟส.เสิงสาง</div>
            </div>
              </div>

        <div class="color-button" onclick="toggleSubButtons('PIMAI')">กฟอ.พิมาย
            <div class="sub-buttons" id="PIMAISubButtons">
                <div class="sub-button" onclick="subButtonClick('กฟอ.พิมาย')">กฟอ.พิมาย</div>
                <div class="sub-button" onclick="subButtonClick('คลังพัสดุ กฟอ.พิมาย')">คลังพัสดุ กฟอ.พิมาย</div>
                <div class="sub-button" onclick="subButtonClick('กฟส.ชุมพวง')">กฟส.ชุมพวง</div>
                <div class="sub-button" onclick="subButtonClick('กฟส.เมืองยาง')">กฟย.เมืองยาง</div>
            </div>
              </div>

        <div class="color-button" onclick="toggleSubButtons('PHUKEAW')">กฟอ.ภูเขียว
            <div class="sub-buttons" id="PHUKEAWSubButtons">
                <div class="sub-button" onclick="subButtonClick('กฟอ.ภูเขียว')">กฟอ.ภูเขียว</div>
                <div class="sub-button" onclick="subButtonClick('กฟส.เกษตรสมบูรณ์')">กฟส.เกษตรสมบูรณ์</div>
                <div class="sub-button" onclick="subButtonClick('กฟย.บ้านแท่น')">กฟย.บ้านแท่น</div>
                <div class="sub-button" onclick="subButtonClick('กฟย.คอนสาร')">กฟย.คอนสาร</div>
            </div>
              </div>

        <div class="color-button" onclick="toggleSubButtons('PRASAT')">กฟอ.ปราสาท
            <div class="sub-buttons" id="PRASATSubButtons">
                <div class="sub-button" onclick="subButtonClick('กฟอ.ปราสาท')">กฟอ.ปราสาท</div>
                <div class="sub-button" onclick="subButtonClick('กฟส.สังขะ')">กฟส.สังขะ</div>
                <div class="sub-button" onclick="subButtonClick('กฟย.พนมดงรัก')">กฟย.พนมดงรัก</div>
                <div class="sub-button" onclick="subButtonClick('กฟย.กาบเชิง')">กฟย.กาบเชิง</div>
                <div class="sub-button" onclick="subButtonClick('กฟย.บัวเชด')">กฟย.บัวเชด</div>
                <div class="sub-button" onclick="subButtonClick('กฟย.ศรีณรงค์')">กฟย.ศรีณรงค์</div>
            </div>
              </div>

              <div class="color-button" onclick="toggleSubButtons('PAKTHONGCHAI')">กฟอ.ปักธงชัย
                <div class="sub-buttons" id="PAKTHONGCHAISubButtons">
                    <div class="sub-button" onclick="subButtonClick('กฟอ.ปักธงชัย')">กฟอ.ปักธงชัย</div>
                    <div class="sub-button" onclick="subButtonClick('กฟส.วังน้ำเขียว')">กฟส.วังน้ำเขียว</div>
                    </div>
                </div>
              
    


  </div>

  
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ข้อความจากระบบ</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">คุณต้องการจะ Logout?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login_process.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
    <script src="js/demo/datatables-demo.js"></script>
  

<script>
    let hideTimeout;
  
    document.addEventListener('mouseover', function(event) {
      if (!event.target.classList.contains('color-button') && !event.target.classList.contains('sub-button')) {
        hideTimeout = setTimeout(function() {
          const subButtons = document.querySelectorAll('.sub-buttons');
          subButtons.forEach(function(subButton) {
            subButton.style.display = 'none';
          });
        }, 10000000);
      }
    });
  
        function toggleSubButtons(buttonId) {
        const subButtons = document.getElementById(buttonId + 'SubButtons');
        const allPurpleButtons = document.querySelectorAll('.color-button');
        clearTimeout(hideTimeout); 
    
        if (subButtons.style.display === 'flex') {
            subButtons.style.display = 'none';

        } else {

            const container = document.querySelector('.button-container');
            container.style.position = 'relative';
            container.style.zIndex = 1;
            

            const allSubButtons = document.querySelectorAll('.sub-buttons');
            allSubButtons.forEach(function (subButton) {
            subButtons.style.zIndex = 8;
            subButtons.style.position='sticky';
            });
            subButtons.style.display = 'flex';
            
        }
        }
  
    function subButtonClick(subButtonValue) {
      // alert(`คุณได้กด: ${subButtonValue}`);
      fetch(`select2.php?subButtonValue=${subButtonValue}`)
        .then(response => response.text())
        .then(data => console.log(data))
        .catch(error => console.error('Error:', error));
        window.open(`select_switch_process.php?subButtonValue=${subButtonValue}`, '_blank');

      
    }
  
    document.addEventListener('mouseover', function(event) {
      const subButtons = document.querySelectorAll('.sub-buttons');
      subButtons.forEach(function(subButton) {
        if (event.target.closest('.sub-buttons') !== subButton) {
          subButton.style.display = 'none';
        }
      });
    });
  </script>


  

</body>
</html>
