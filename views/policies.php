<?php 
session_start();
include './../controllers/dbController.php';

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_policy'])) {
        // Add policy
        $full_name = $_POST['full_name'];
        $id_number = $_POST['id_number'];
        $phone_number = $_POST['phone_number'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $premium_amount = $_POST['premium_amount'];
        $beneficiary_name = $_POST['beneficiary_name'];

        // Generate a random policy number
        $policy_number = generatePolicyNumber();

        $stmt = $conn->prepare("INSERT INTO policies (policy_number, full_name, id_number, phone_number, start_date, end_date, premium_amount, beneficiary_name) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $policy_number, $full_name, $id_number, $phone_number, $start_date, $end_date, $premium_amount, $beneficiary_name);
        $stmt->execute();
        $stmt->close();

        // Return a success message or new policy ID
        echo json_encode(array('status' => 'success', 'message' => 'Policy added successfully', 'policy_number' => $policy_number));
        exit;
    } elseif (isset($_POST['update_policy'])) {
        // Update policy
        $id = $_POST['id'];
        $policy_number = $_POST['policy_number'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $premium_amount = $_POST['premium_amount'];
        $beneficiary_name = $_POST['beneficiary_name'];

        $stmt = $conn->prepare("UPDATE policies SET policy_number = ?, start_date = ?, end_date = ?, premium_amount = ?, beneficiary_name = ? WHERE id = ?");
        $stmt->bind_param("sssssi", $policy_number, $start_date, $end_date, $premium_amount, $beneficiary_name, $id);
        $stmt->execute();
        $stmt->close();

        // Return a success message or updated policy ID
        echo json_encode(array('status' => 'success', 'message' => 'Policy updated successfully'));
        exit;
    } elseif (isset($_POST['delete_policy'])) {
        // Delete policy
        $id = $_POST['id'];

        $stmt = $conn->prepare("DELETE FROM policies WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();

        // Return a success message or confirmation
        echo json_encode(array('status' => 'success', 'message' => 'Policy deleted successfully'));
        exit;
    }
}

// Function to generate a random policy number
function generatePolicyNumber() {
    // Generate a random 10-character alphanumeric policy number
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $policy_number = '';
    $max = strlen($characters) - 1;
    for ($i = 0; $i < 10; $i++) {
        $policy_number .= $characters[mt_rand(0, $max)];
    }
    return $policy_number;
}

// Database connection
$conn = mysqli_connect("sql12.freesqldatabase.com", "sql12721141", "JBdRN9A7AP", "sql12721141");
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
               <a class="nav-link" href="./profile.php">Profile</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="./contact.php">Contact</a>
            </li>
         </ul>
      </div>
   </nav>

   <div class="main-container">
      <div class="profile-card">
         <div>
            <h5>Welcome, <?php echo $_SESSION['name']; ?></h5>
            <p>Manage all your policies here!</p>
         </div>
         <button class="btn btn-warning" id="add-policy-btn">Add new Policy</button>
      </div>

      <div id="add-policy-form" style="display: none;">
         <div class="card">
            <div class="card-body">
               <h5 class="card-title">Add New Funeral Policy</h5>
               <form id="policy-form" method="post" action="">
                  <input type="hidden" name="add_policy" value="true">
                  <div class="form-group">
                     <input type="text" class="form-control" name="full_name" placeholder="Full Name" required>
                  </div>
                  <div class="form-group">
                     <input type="text" class="form-control" name="id_number" placeholder="ID Number" required>
                  </div>
                  <div class="form-group">
                     <input type="text" class="form-control" name="phone_number" placeholder="Phone Number" required>
                  </div>
                  <div class="form-group">
                     <label>Start Date:</label>
                     <input type="date" class="form-control" name="start_date" required>
                  </div>
                  <div class="form-group">
                     <label>End Date:</label>
                     <input type="date" class="form-control" name="end_date" required>
                  </div>
                  <div class="form-group">
                     <input type="text" class="form-control" name="premium_amount" placeholder="Premium Amount" required>
                  </div>
                  <div class="form-group">
                     <input type="text" class="form-control" name="beneficiary_name" placeholder="Beneficiary Name" required>
                  </div>
                  <button type="submit" class="btn btn-primary">Save Policy</button>
                  <button type="button" class="btn btn-secondary" id="cancel-policy-btn">Cancel</button>
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
       if(!$policies) {
           echo '<div class="container">';
           echo '<div class="ml-4">';
           echo '<center>';
           echo "<img src='./../public/assets/images/not-found.png'/>";
           echo '<h6>No policies found</h6>';
           echo '<center>';
           echo '</div>';
           echo '</div>';
       }else { 
       foreach ($policies as $policy) {
           echo '<div class="menu-item">';
           echo '<div class="ml-3">';
           echo '<h6>' . $policy['start_date'] . '</h6>';
           echo '<p class="mb-0">' . $policy['policy_number'] . '</p>';
           echo '</div>';
           echo '<div class="ml-3">';
           echo '<p class="mb-0">' . $policy['details'] . '</p>';
           echo '</div>';
           echo '<button class="btn btn-warning">&rightarrow;</button>';
           echo '</div>';
       }
      }
       ?>
   </div>

   <!-- Footer -->
   <footer class="footer">
      <a href="./../home.php">
         <img src="./../public/assets/images/home.png" alt="Home Icon">
         <p>Home</p>
      </a>
      <a href="#">
         <img src="./../public/assets/images/piggy-bank.png" alt="Claims Icon">
         <p>Claims</p>
      </a>
      <a href="./profile.php">
         <img src="./../public/assets/fruit.png" alt="Profile Icon">
         <p>Profile</p>
      </a>
      <a href="./contact.php">
         <img src="./../public/assets/images/phone-call.png" alt="Contact Icon">
         <p>Contact</p>
      </a>
   </footer>

   <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
   <script>
      $(document).ready(function() {
         $('#add-policy-btn').click(function() {
            $('#add-policy-form').toggle(); // Show/hide the form
         });

         $('#policy-form').submit(function(e) {
            e.preventDefault(); // Prevent default form submission
            var formData = $(this).serialize(); // Serialize form data

            // AJAX request
            $.ajax({
               type: 'POST',
               url: '', // Current URL or PHP script URL
               data: formData,
               dataType: 'json', // Expect JSON response
               success: function(response) {
                  // Handle success response if needed
                  console.log(response); // Log response to console
                  // You may want to update the UI here (e.g., append new policy to list)
                  $('#add-policy-form').hide(); // Hide form after submission
                  location.reload(); // Refresh the page to show new policy (optional)
               },
               error: function(xhr, status, error) {
                  // Handle error
                  console.error(xhr.responseText); // Log error to console
               }
            });
         });

         $('#cancel-policy-btn').click(function() {
            $('#add-policy-form').hide(); // Hide form on cancel
         });
      });
   </script>
</body>
</html>