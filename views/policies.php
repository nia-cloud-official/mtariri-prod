<?php 
session_start();
include './../controllers/dbController.php';

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_policy'])) {
        // Add policy
        $phone_number = $_POST['phone_number'];
        $policy_number = $_POST['policy_number'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $details = $_POST['details'];

        $stmt = $conn->prepare("INSERT INTO policies (phone_number, policy_number, start_date, end_date, details) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $phone_number, $policy_number, $start_date, $end_date, $details);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['update_policy'])) {
        // Update policy
        $id = $_POST['id'];
        $policy_number = $_POST['policy_number'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $details = $_POST['details'];

        $stmt = $conn->prepare("UPDATE policies SET policy_number = ?, start_date = ?, end_date = ?, details = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $policy_number, $start_date, $end_date, $details, $id);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['delete_policy'])) {
        // Delete policy
        $id = $_POST['id'];

        $stmt = $conn->prepare("DELETE FROM policies WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}

$conn = mysqli_connect("localhost", "root", "", "mtariri");
$result = $conn->query("SELECT * FROM policies");

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <title>Manage Policies - My Mtariri</title>
   <link rel="icon" href="./../public/assets/images/fav.png" sizes="32x32">
   <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
   <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
   <style>
      body {
         font-family: 'Montserrat', sans-serif;
         background-color: #f8f9fa;
      }
      .navbar {
         padding: 1rem;
         box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
         background-color: #fff;
      }
      .navbar-brand img {
         height: 40px;
      }
      .footer {
         padding: 1rem;
         background-color: #fff;
         position: fixed;
         bottom: 0;
         width: 100%;
         box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
         display: flex;
         justify-content: space-around;
         align-items: center;
         transition: background-color 0.3s ease;
      }
      .footer:hover {
         background-color: #f1f1f1;
      }
      .footer a {
         text-decoration: none;
         color: #333;
         text-align: center;
         transition: transform 0.3s ease, color 0.3s ease;
      }
      .footer a:hover {
         transform: scale(1.1);
         color: #007bff;
      }
      .footer img {
         height: 30px;
         margin-bottom: 0.5rem;
         transition: transform 0.3s ease;
      }
      .footer img:hover {
         transform: rotate(360deg);
      }
      .footer p {
         margin: 0;
         font-size: 0.75rem;
         color: #666;
         transition: color 0.3s ease;
      }
      .footer a:hover p {
         color: #007bff;
      }
      .main-container {
         padding: 1rem;
         padding-bottom: 5rem; /* to avoid content overlapping footer */
      }
      .stats-box {
         border-radius: 10px;
         box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
         transition: transform 0.2s;
         margin-bottom: 1rem;
      }
      .stats-box:hover {
         transform: scale(1.05);
      }
      .btn-warning {
         border-radius: 20px;
         padding: 10px 20px;
      }
      .section-head {
         margin-top: 2rem;
         margin-bottom: 2rem;
      }
      .section-head img {
         height: 60px;
      }
      .section-head p {
         font-size: 1rem;
      }
      .service-box {
         border-radius: 10px;
         box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
         padding: 1rem;
      }
      .card {
         border: none;
         border-radius: 15px;
         box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
         margin-bottom: 1rem;
      }
      .card img {
         border-radius: 15px;
      }
      .profile-card {
         display: flex;
         align-items: center;
         justify-content: space-between;
         padding: 1rem;
         background-color: #fff;
         border-radius: 15px;
         box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
         margin-bottom: 1rem;
      }
      .profile-card img {
         border-radius: 50%;
         width: 60px;
         height: 60px;
      }
      .menu-item {
         display: flex;
         align-items: center;
         justify-content: space-between;
         padding: 1rem;
         background-color: #fff;
         border-radius: 15px;
         box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
         margin-bottom: 1rem;
         transition: background-color 0.3s ease, transform 0.3s ease;
      }
      .menu-item:hover {
         background-color: #f1f1f1;
         transform: scale(1.02);
      }
      .menu-item img {
         width: 30px;
         height: 30px;
         transition: transform 0.3s ease;
      }
      .menu-item:hover img {
         transform: rotate(360deg);
      }
   </style>
</head>
<body>
   <!-- Navigation -->
   <nav class="navbar navbar-expand-lg navbar-light">
      <a class="navbar-brand" href="#">
         <img src="./../public/assets/images/logo.png" alt="My Mtariri">
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
         <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
               <a class="nav-link" href="#">Home</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="#">Claims</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="#">Profile</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="#">Contact</a>
            </li>
         </ul>
      </div>
   </nav>

   <div class="container main-container">
      <div class="profile-card">
         <div class="d-flex align-items-center">
            <img src="./../public/assets/fruit.png" alt="Profile Image">
            <div class="ml-3">
               <h5><?php echo $_SESSION['name']; ?></h5>
               <p class="mb-0">Hello <?php echo $_SESSION['name']; ?>👋</p>
            </div>
         </div>
         <button class="btn btn-warning">Logout</button>
      </div>

      <div class="card">
         <div class="card-body">
            <h5 class="card-title">Welcome to Policies</h5>
            <p class="card-text">Manage all your policies here!</p>
            <div class="d-flex justify-content-between">
                <form method="post" action="./../home.php">
                <button class="btn btn-outline-warning">&leftarrow; Back</button>
                </form>
               <form action="" method="post">
               <button class="btn btn-warning">Add new Policy</button>
               </form>
            </div>
         </div>
      </div>

      <?php
       $userlc = $_SESSION['phone_number'];

       // Prepare the SQL statement with a placeholder
       $query = "SELECT * FROM policies WHERE phone_number = ?";
       
       // Initialize the prepared statement
       $stmt = $conn->prepare($query);
       
       // Bind the parameter (s for string type)
       $stmt->bind_param("s", $userlc);
       
       // Execute the statement
       $stmt->execute();
       
       // Get the result
       $result = $stmt->get_result();
       
       // Fetch all rows
       $policies = $result->fetch_all(MYSQLI_ASSOC);
       
       foreach ($policies as $policy) {
       }
       ?>
      <div class="menu-item">
      <div class="ml-3">
            <h6><?php echo $policy['start_date'];?></h6>
            <p class="mb-0"><?php echo $policy['policy_number'];?></p>
         </div>
         <div class="ml-3">
            <p class="mb-0"><?php echo $policy['details'];?></p>
         </div>
         <button class="btn btn-warning">&rightarrow;</button>
      </div>
   </div>

   <!-- Footer -->
   <footer class="footer">
      <a href="#">
         <img src="./../public/assets/images/home.png" alt="Home Icon">
         <p>Home</p>
      </a>
      <a href="#">
         <img src="./../public/assets/images/piggy-bank.png" alt="Claims Icon">
         <p>Claims</p>
      </a>
      <a href="#">
         <img src="./../public/assets/fruit.png" alt="Profile Icon">
         <p>Profile</p>
      </a>
      <a href="#">
         <img src="./../public/assets/images/phone-call.png" alt="Contact Icon">
         <p>Contact</p>
      </a>
   </footer>

   <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
