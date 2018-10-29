<?php
class borrow{
    private $borrowId;
    private $borrowerId;
    private $bookId;
    private $borrowDays;

    /**
     * @return mixed
     */
    public function getBorrowId()
    {
        return $this->borrowId;
    }

    /**
     * @param mixed $borrowId
     */
    public function setBorrowId($borrowId)
    {
        $this->borrowId = $borrowId;
    }

    /**
     * @return mixed
     */
    public function getBorrowerId()
    {
        return $this->borrowerId;
    }

    /**
     * @param mixed $borrowerId
     */
    public function setBorrowerId($borrowerId)
    {
        $this->borrowerId = $borrowerId;
    }

    /**
     * @return mixed
     */
    public function getBookId()
    {
        return $this->bookId;
    }

    /**
     * @param mixed $bookId
     */
    public function setBookId($bookId)
    {
        $this->bookId = $bookId;
    }

    /**
     * @return mixed
     */
    public function getBorrowDays()
    {
        return $this->borrowDays;
    }

    /**
     * @param mixed $borrowDays
     */
    public function setBorrowDays($borrowDays)
    {
        $this->borrowDays = $borrowDays;
    }

    public function borrowBook(){
        $borrowerId =$this->getBorrowerId();
        $bookId =$this->getBookId();
        $borrowDays =$this->getBorrowDays();

        $borrowBook ="insert into borrow(borrower_id,book_id,borrow_days,borrow_start_date,borrow_end_date,status) values ($borrowerId,$bookId,$borrowDays,now(),DATE_ADD(now(), INTERVAL $borrowDays DAY),true)";
        return $borrowBook;
    }

    public function checkLearnerBookBorrow($borrower_id){
        $checkBookBorrow = "select * from borrow where borrower_id=$borrower_id";
        return $checkBookBorrow;
    }

    public function increasePoints($borrower_id){
        $increasePoints = "update borrow set borrower_points=borrower_points+1,updated_at=now() where borrow_id=$borrower_id";
        return $increasePoints;
    }

    public function updateBadPoints($borrow_id){
        $updateBadPoints = "update borrow set updated_at=now() where borrow_id=$borrow_id";
        return $updateBadPoints;
    }

    public function increaseGoodPoints($borrower_id){
        $increaseGoodPoints = "update learner set good_points=good_points+1 where learnerId=$borrower_id";
        return $increaseGoodPoints;
    }

    public function increaseBadPoints($borrower_id){
        $increaseBadPoints = "update learner set bad_points=bad_points+1 where learnerId=$borrower_id";
        return $increaseBadPoints;
    }

    public function setBorrowerPoints($borrow_id,$point){
        $setBorrowerPoints = "update borrow set borrower_points='$point' where borrow_id=$borrow_id";
        return $setBorrowerPoints;
    }

    public function checkBookBorrow($book_id){
        $checkBookBorrow = "select * from borrow where book_id=$book_id";
        return $checkBookBorrow;
    }

    public function returnBook($book_id){
        $returnBook = "update borrow set status=false where book_id=$book_id";
        return $returnBook;
    }

    public function returnBookBorrow($borrow_id){
        $returnBook = "update borrow set status=false where borrow_id=$borrow_id";
        return $returnBook;
    }

    public function getLearnerBorrowBooks($learner_id){
        $getLearnerBorrowBooks = "select * from book b,borrow bo where b.book_id=bo.book_id and bo.borrower_id=$learner_id";
        return $getLearnerBorrowBooks;
    }

}