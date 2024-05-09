<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
    <link rel="stylesheet" type="text/css" href="Login.css">
    <link rel="icon" href="jagran_logo1.jpg" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Quicksand&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div>
        <div class="form" id="login">
            <div class="box">
                <h3>LOGIN</h3>
                <div>
                    <?php
                        function test_input($data) {
                            $data = trim($data);
                            $data = stripslashes($data);
                            $data = htmlspecialchars($data);
                            return $data;
                        }
                        $error = array();
                        
                        if(isset($_POST['login']))
                        {
                            session_start();
                            $username=$password="";
                            if($_SERVER["REQUEST_METHOD"] == "POST")
                            {
                                $Username = $_POST['Username'];
                                $Password = $_POST['Password'];
                                //echo $username,"<br>";
                                //echo $password;

                                $link = mysqli_connect("localhost", "root", "");
                                if (mysqli_connect_errno()) {
                                    printf("Connect failed: %s\n", mysqli_connect_error());
                                    exit();
                                }
                                mysqli_select_db($link,"loginpage");
                                $results=mysqli_query($link,"select * from usertable where Username='$Username' and Password='$Password'") or 
                                die("failed to connect".mysqli_connect_error());
                                $row=mysqli_fetch_array($results);
                                
                                if (isset($row)){
                                    header('location: http://localhost/Mini%20Project/Code/index.html');
                                    echo 'success';
                                }
                                else {
                                    echo 'failure';
                                }
                            }
                        } 
                    ?>
                </div>
                <form action="login.php" method="POST" onsubmit="return validateForm('login')">
                    <input class="input" type="text" id="loginUsername" name="Username" placeholder="Username" required><br>
                    <input class="input" type="password" id="loginPassword" name="Password" placeholder="Password" required><br>
                    <input class="button" type="submit" name="login" value="LOGIN"><br>
                    <a id="oksignup" class="SIGN"> Sign Up here</a>
                </form>
            </div>
        </div>
        <div class="form reg" id="signup">
            <div class="box">
                <h3>SIGN UP</h3>
                <?php
                    if(isset($_POST['signup']))
                    {
                        $usernameSub=$password1=$password2="";
                        if($_SERVER["REQUEST_METHOD"] == "POST")
                        {
                            $usernameSub = test_input($_POST['Username']);
                            $password1 = test_input($_POST['Password']);
                            $password2 = test_input($_POST['ConfirmPassword']);

                            $link = mysqli_connect("localhost", "root", "");
                            if (mysqli_connect_errno()) {
                                printf("Connect failed: %s\n", mysqli_connect_error());
                                exit();
                            }
                            if(empty($usernameSub))
                                array_push($error, "Please fill username");
                            if(empty($password1))
                                array_push($error, "Please fill password");
                            if(empty($password2))
                                array_push($error, "Please fill confirm password");
                            if($password1 != $password2)
                                echo "Passwords don't match";
                            else if($password1 == $password2)
                            {
                                mysqli_select_db($link,"loginpage");
                                $results=mysqli_query($link,"insert into usertable(Username,Password) values('$usernameSub','$password1')") 
                                or die("failed to connect".mysqli_connect_error());
                                header('location: http://localhost/Mini%20Project/Code/index.html');
                                echo "Data Stored" ;
                            }
                            mysqli_close($link);
                        }
                    }
                ?>
                <form action="login.php" method="POST" onsubmit="return validateForm('signup')">
                    <input class="input" type="text" id="signupUsername" name="Username" placeholder="Username" required><br>
                    <input class="input" type="password" id="signupPassword" name="Password" placeholder="Password" required><br>
                    <input class="input" type="password" id="signupConfirmPassword" name="ConfirmPassword" placeholder="Confirm Password" required><br>
                    <input class="button" type="submit" name="signup" value="SIGN UP"><br>
                    <a id="oklogin" class="LOGIN">Login Here</a>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var attempts = 3; // Number of allowed login attempts
        var signupAttempts = 3; // Number of allowed signup attempts

        function validateForm(action) {
            if (action === "login") {
                if (attempts > 0) {
                    attempts--;
                    if (attempts === 0) {
                        alert("You have exceeded the maximum number of login attempts.");
                        document.querySelector('[name="Username"]').disabled = true;
                        document.querySelector('[name="Password"]').disabled = true;
                        document.querySelector('input[type="submit"]').disabled = true;
                    } else {
                        alert("You have " + attempts + " attempts left.");
                    }
                }
            } else if (action === "signup") {
                if (signupAttempts > 0) {
                    signupAttempts--;
                    if (signupAttempts === 0) {
                        alert("You have exceeded the maximum number of signup attempts.");
                        document.querySelector('[name="Username"]').disabled = true;
                        document.querySelector('[name="Password"]').disabled = true;
                        document.querySelector('[name="ConfirmPassword"]').disabled = true;
                        document.querySelector('input[type="submit"]').disabled = true;
                    } else {
                        alert("You have " + signupAttempts + " attempts left.");
                    }
                }
            }
            return false; // Prevent the form from being submitted
        }

        $(document).ready(function () {
            $('#oksignup').click(function () {
                $('#login').addClass("reg");
                $('#signup').removeClass("reg");
            });
            $('#oklogin').click(function () {
                $('#signup').addClass("reg");
                $('#login').removeClass("reg");
            });
        });
    </script>
</body>
</html>