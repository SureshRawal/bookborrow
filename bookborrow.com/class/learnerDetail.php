<?php
include "learner.php";
class learnerDetail{

    private $learner;
    private $dateOfBirth;
    private $gender;
    private $mobileNumber;
    private $educationLevel;
    private $college;
    private $detailsOneSelf;
    private $favoriteQuotation;
    private $address;

    public function __construct()
    {
        $this->learner =  new learner();
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }



    /**
     * @return learner
     */
    public function getLearner()
    {
        return $this->learner;
    }



    /**
     * @return mixed
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * @param mixed $dateOfBirth
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param mixed $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * @return mixed
     */
    public function getMobileNumber()
    {
        return $this->mobileNumber;
    }

    /**
     * @param mixed $mobileNumber
     */
    public function setMobileNumber($mobileNumber)
    {
        $this->mobileNumber = $mobileNumber;
    }

    /**
     * @return mixed
     */
    public function getEducationLevel()
    {
        return $this->educationLevel;
    }

    /**
     * @param mixed $educationLevel
     */
    public function setEducationLevel($educationLevel)
    {
        $this->educationLevel = $educationLevel;
    }

    /**
     * @return mixed
     */
    public function getCollege()
    {
        return $this->college;
    }

    /**
     * @param mixed $college
     */
    public function setCollege($college)
    {
        $this->college = $college;
    }

    /**
     * @return mixed
     */
    public function getDetailsOneSelf()
    {
        return $this->detailsOneSelf;
    }

    /**
     * @param mixed $detailsOneSelf
     */
    public function setDetailsOneSelf($detailsOneSelf)
    {
        $this->detailsOneSelf = $detailsOneSelf;
    }

    /**
     * @return mixed
     */
    public function getFavoriteQuotation()
    {
        return $this->favoriteQuotation;
    }

    /**
     * @param mixed $favoriteQuotation
     */
    public function setFavoriteQuotation($favoriteQuotation)
    {
        $this->favoriteQuotation = $favoriteQuotation;
    }

    public function saveProfile(){
        $address = $this->getAddress();
        $dateOfBirth = $this->getDateOfBirth();
        $gender = $this->getGender();
        $mobileNumber = $this->getMobileNumber();
        $educationLevel = $this->getEducationLevel();
        $college = $this->getCollege();
        $detailsOneSelf = $this->getDetailsOneSelf();
        $favoriteQuotation = $this->getFavoriteQuotation();
        $learnerId = $this->learner->getLearnerId();

        if(!$this->checkLearnerProfile($learnerId)){
            $profile = "insert into learner_details(address,date_of_birth,gender,mobile_number,education_level,college,details_oneself,favorite_quotation,learner_id) VALUES('$address','$dateOfBirth','$gender','$mobileNumber','$educationLevel','$college','$detailsOneSelf','$favoriteQuotation',$learnerId)";
            $this->learner->getDatabase()->insert($profile);
            echo '<div class="alert alert-success" role="alert">';
            echo 'Congratulations! You have successfully created your profile.';
            echo '</div>';
        }else{
            echo 'You have already create your profile';
        }
    }

    public function checkLearnerProfile($learner_id){
        $checkLearnerProfile = "select * from learner_details where learner_id=$learner_id";
        return $this->learner->getDatabase()->checkRows($checkLearnerProfile);
    }

    public function selectLearnerProfile($learner_id){
        $selectLearnerProfile = "select * from learner_details where learner_id=$learner_id";
        return $this->learner->getDatabase()->select($selectLearnerProfile);
    }

    public function selectProfile($learner_id){
        $selectLearnerProfile = "select * from learner_details ld,learner l where l.learnerId=ld.learner_id and  learner_id=$learner_id";
        return $this->learner->getDatabase()->select($selectLearnerProfile);
    }

    public function editLearnerProfile($learner_id){
        $address = $this->getAddress();
        $dateOfBirth = $this->getDateOfBirth();
        $gender = $this->getGender();
        $mobileNumber = $this->getMobileNumber();
        $educationLevel = $this->getEducationLevel();
        $college = $this->getCollege();
        $detailsOneSelf = $this->getDetailsOneSelf();
        $favoriteQuotation = $this->getFavoriteQuotation();

        $editLearnerProfile="update learner_details
                                set address='$address',
                                date_of_birth='$dateOfBirth',
                                gender = '$gender',
                                mobile_number='$mobileNumber',
                                education_level='$educationLevel',
                                college='$college',
                                details_oneself='$detailsOneSelf',
                                favorite_quotation='$favoriteQuotation'
                                where learner_id=$learner_id
                                ";
        $this->learner->getDatabase()->update($editLearnerProfile);
        echo '<div class="alert alert-success" role="alert">';
        echo 'Profile Changed Successfully';
        echo '</div>';
    }


}