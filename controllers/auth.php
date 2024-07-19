<?php

session_start();

include 'dbController.php';

class Auth { 
    private $user_id;

    public function __construct(){}

    public function runQuery($sql,$query){ 
        $result = mysqli_query($sql,$query);
        return $result;
    }

    public function getCredentials($phone){ 
       $conn = mysqli_connect('localhost','root','','mtariri');
       $query = "SELECT * FROM `users` WHERE `phone_number` = $phone";
       $result = mysqli_query($conn,$query);
       foreach ($result as $user) {
         $this->user_id = $user['name'];
       }
    }

    public function checkAcc($phone){
        $query = "SELECT * FROM `users` WHERE `phone_number` = $phone";
        $conn = mysqli_connect('localhost','root','','mtariri');
        $result = $this->runQuery($conn,$query);
        if(empty($result)){ 
            echo "Not found";
             // User not found, add new user
             $insertQuery = "INSERT INTO `users` (phone_number) VALUES ('$phone')";
             mysqli_query($conn, $insertQuery);
             // Retrieve and set credentials (assuming getCredentials sets $this->user_id)
             $this->getCredentials($phone);
             // Set session variables
             $_SESSION['name'] = $this->user_id;
             $_SESSION['phone_number'] = $phone;

    // Redirect to home page
    header('Location: ./../home.php');
    exit;
        }else { 
            $this->getCredentials($phone);
            $_SESSION['name'] = $this->user_id;
            echo $_SESSION['name'];
            $_SESSION['phone_number'] = $phone;
            header('Location: ./../home.php');
        }
    }
}

if(isset($_POST['phone'])){ 
    $phone = $_POST['phone'];
    $trigger = new Auth();
    $trigger->checkAcc($phone);
}
?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title>My Mtariri - Mobile</title>
    <link rel="icon" href="./../public/assets/images/fav.png" sizes="32x32" />
    <link href="./../public/assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,700;0,800;0,900;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./../public/assets/css/splide.min.css">
    <link href="./../public/assets/css/style.css" rel="stylesheet">
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <a class="navbar-brand" href="#">
            <img src="./../public/assets/images/logo.png" style="height:40px;" alt="My Mtariri">
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

    <!-- Main Content -->
    <section class="services section bg-white mt-5">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="section-head text-center mx-auto narrow">
                        <img src="./../public/assets/images/logo.png" style="height:60px;" alt="">
                        <p class="section-subtitle mt-3 mb-0">
                            Welcome to My Mtariri Funeral Assurance App, Manage and View all your claims from Mtariri.
                        </p>
                        <section class="section">
                            <div class="container">
                                <form method="post" action="">
                                    <label for="phone">Your Phone Number</label>
                                    <input type="tel" class="form-control" name="phone" placeholder="" id="phone">
                                    <button type="submit" class="btn btn-warning mt-4 d-inline-block fw-bold shadow-sm" style="width:100%">Continue &rightarrow;</button>
                                </form>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-light text-center text-lg-start">
        <div class="container p-4">
            <div class="row">
                <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                    <h5 class="text-uppercase">My Mtariri</h5>
                    <p>Manage and View all your claims from Mtariri Funeral Assurance.</p>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Links</h5>
                    <ul class="list-unstyled mb-0">
                        <li><a href="#!" class="text-dark">Home</a></li>
                        <li><a href="#!" class="text-dark">Claims</a></li>
                         <li><a href="#!" class="text-dark">Profile</a></li>
                        <li><a href="#!" class="text-dark">Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Contact</h5>
                    <ul class="list-unstyled mb-0">
                        <li><a href="tel:+1234567890" class="text-dark">+123 456 7890</a></li>
                        <li><a href="mailto:info@mymtariri.com" class="text-dark">info@mymtariri.com</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="text-center p-3 bg-dark text-white">
            © 2024 My Mtariri
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
