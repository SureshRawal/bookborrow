<?php

include "database.php";

class learner{
    private $database;

    public function __construct(){
        $this->database = new database();
    }

    private $name;
    private $email;
    private $password;
    private $learnerId;
    private $confirmPassword;
    private $newPassword;

    /**
     * @return mixed
     */
    public function getNewPassword()
    {
        return $this->newPassword;
    }

    /**
     * @param mixed $newPassword
     */
    public function setNewPassword($newPassword)
    {
        $this->newPassword = $newPassword;
    }



    /**
     * @return database
     */
    public function getDatabase()
    {
        return $this->database;
    }


    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getLearnerId()
    {
        return $this->learnerId;
    }

    /**
     * @param mixed $learnerId
     */
    public function setLearnerId($learnerId)
    {
        $this->learnerId = $learnerId;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getConfirmPassword()
    {
        return $this->confirmPassword;
    }

    /**
     * @param mixed $confirmPassword
     */
    public function setConfirmPassword($confirmPassword)
    {
        $this->confirmPassword = $confirmPassword;
    }




    /*
     * Registration
     */
    public function register(){
        $name = $this->getName();
        $email = $this->getEmail();
        $password = $this->getPassword();
        $confirmPassword = $this->getConfirmPassword();

        //null validation
        if($name == "" or $password == "" or $email == "" or $confirmPassword == ""){
            echo '<div class="alert alert-danger" role="alert">';
            echo 'Please fill up all the fields';
            echo '</div>';
        }
        else{

            //confirming password
            if($confirmPassword==$password){
                $checkEmail = "Select email from learner where email = '$email'";

                //checking whether same email exist or not
                if($this->database->checkRows($checkEmail) > 0){
                    echo '<div class = "alert alert-danger" role="alert">';
                    echo 'Email already exist! <strong>Please try again</strong>';
                    echo '</div>';

                }else{
                    $register = "insert into learner(name,email,password) values('$name','$email','$password')";
                    $this->database->insert($register);

                    echo '<div class="alert alert-success" role="alert">';
                    echo 'Congratulation! Click here to <a href="login.php">login</a>';
                    echo '</div>';
                }

            }
            //if password and confirm password does not match
            else{
                echo '<div class="alert alert-danger" role="alert">';
                echo 'Please type Password again';
                echo '</div>';
            }
        }
    }
    /*
     * End of Registration
     */

    /*
     * Login
     */
    public function login(){
        //checking cookies
        if(isset($_COOKIE['block'])){
            echo '<div class="alert alert-danger" role="alert">';
            echo 'Sorry You have been blocked for one minute!';
            echo '</div>';
            return;
        }

        $email= $this->getEmail();
        $password = $this->getPassword();

        //null validation
        if($email=="" or $password==""){
            echo '<div class="alert alert-danger" role="alert">';
            echo 'Please fill up empty fields';
            echo '</div>';
        }else{
            //admin login
            if($email=="admin@admin.com" and $password=="admin"){

                session_start();
                $_SESSION['id']= "admin";
                header("location:admin.php");

            }
            else{
                //learner login
                $checkEmail = "Select * from learner where email = '$email'";

                if($data = $this->database->select($checkEmail)){
                    foreach($data as $row){
                        $fetchPassword = $row['password'];
                        $learnerId=$row['learnerId'];
                        $login_count=$row['login_count'];

                        //verifying password
                        if ($password == $fetchPassword){

                            session_start();
                            $_SESSION['id']=$learnerId;
                            $_SESSION['name']= $row['name'];
                            $updateLoginCount="update learner set login_count=0 where learnerId=$learnerId";
                            $this->database->update($updateLoginCount);
                            $updateVisitCount="update learner set visit_count=visit_count+1 where learnerId=$learnerId";
                            $this->database->update($updateVisitCount);
                            header("location:dashboard.php");

                        }
                        //if password does not match
                        else{
                            $updateLoginCount="update learner set login_count=login_count + 1 where learnerId=$learnerId";
                            $this->database->update($updateLoginCount);

                            //if user has failed login attempt for 3 times
                            if($login_count==2){
                                setcookie('block',$login_count,time()+120);

                                $updateLoginCount="update learner set login_count=0 where learnerId=$learnerId";
                                $this->database->update($updateLoginCount);
                                echo '<div class="alert alert-danger" role="alert">';
                                echo 'Sorry You have been blocked for one minute!';
                                echo '</div>';

                            }else{
                                echo '<div class="alert alert-danger" role="alert">';
                                echo 'Password does not match!';
                                echo '</div>';
                            }
                        }

                    }
                }
                //if email does not exist
                else{
                    echo '<div class="alert alert-danger" role="alert">';
                    echo 'Email does not exist!';
                    echo '</div>';
                }
            }
        }
    }
    /*
     * End of Login
     */

    public function selectLearners(){
        $selectLearners="select * from learner";
        return $this->database->select($selectLearners);
    }

    public function countLearners(){
        $countLearnerSQL = "select * from learner";
        return $this->database->checkRows($countLearnerSQL);
    }

    public function selectLearnerByID($learner_id){
        $selectLearnerByID = "select * from learner where learnerId=$learner_id";
        return $this->database->select($selectLearnerByID);
    }

    public function changePassword($learnerId){
        $password = $this->getPassword();
        $newPassword = $this->getNewPassword();
        $confirmPassword = $this->getConfirmPassword();

        $checkPassword = "select * from learner where learnerId=$learnerId ";

        if ($data=$this->database->select($checkPassword)){
            foreach ($data as $row){
                $fetchPassword = $row["password"];
                if ($fetchPassword==$password){
                    if ($newPassword==$confirmPassword){
                        $changePassword ="update learner set password='$newPassword' where learnerId=$learnerId";
                        $this->database->update($changePassword);
                        echo '<div class="alert alert-success" role="alert">';
                        echo "Password Change successfully";
                        echo '</div>';
                    }else{
                        echo '<div class="alert alert-danger" role="alert">';
                        echo 'Please Confirm Password Again';
                        echo '</div>';
                    }

                }else{
                    echo '<div class="alert alert-danger" role="alert">';
                    echo 'Old Password Does Not Match';
                    echo '</div>';
                }
            }
        }
    }






}

