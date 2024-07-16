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
       $query = "SELECT * FROM `users` WHERE `phone` = $phone";
       $result = mysqli_query($conn,$query);
       foreach ($result as $user) {
         $this->user_id = $user['fullname'];
       }
    }

    public function checkAcc($phone){
        $query = "SELECT * FROM `users` WHERE `phone` = $phone";
        $conn = mysqli_connect('localhost','root','','mtariri');
        $result = $this->runQuery($conn,$query);
        if(empty($result)){ 
            echo "Not found";
        }else { 
            $this->getCredentials($phone);
            $_SESSION['name'] = $this->user_id;
            echo $_SESSION['name'];
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
<link
    href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,700;0,800;0,900;1,700;1,800;1,900&display=swap"
    rel="stylesheet">
<link rel="stylesheet" href="./../public/assets/css/splide.min.css">
<link href="./../public/assets/css/style.css" rel="stylesheet">
<section class="services section bg-white">
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
                                <label for="Phone Number">Your Phone Number</label>
                                <input type="tel" class="form-control" name="phone" placeholder="" id="">
                                <button type="submit" class="btn btn-warning mt-4 d-inline-block fw-bold shadow-sm"
                                style="width:100%">Continue &rightarrow;</button>
                            </form>
                        </div>
                    </section>

                </div>
            </div>
        </div>
    </div>
</section>
<!-- Services End-->