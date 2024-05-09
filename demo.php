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
above is signup









<?php
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