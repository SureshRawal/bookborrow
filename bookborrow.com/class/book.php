<?php
include "learner.php";

class book {
    private $learner;

    public function __construct(){
        $this->learner = new learner();
    }

    private $bookName;
    private $author;
    private $ISBN;
    private $publicationDate;
    private $publisher;
    private $bookDescription;
    private $bookImage;
    private $book_genre;
    private $learner_id;
    private $max_borrow;

    /**
     * @return mixed
     */
    public function getMaxBorrow()
    {
        return $this->max_borrow;
    }

    /**
     * @param mixed $max_borrow
     */
    public function setMaxBorrow($max_borrow)
    {
        $this->max_borrow = $max_borrow;
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
    public function getLearnerId()
    {
        return $this->learner_id;
    }

    /**
     * @param mixed $learner_id
     */
    public function setLearnerId($learner_id)
    {
        $this->learner_id = $learner_id;
    }



    /**
     * @return mixed
     */
    public function getBookGenre()
    {
        return $this->book_genre;
    }

    /**
     * @param mixed $book_genre
     */
    public function setBookGenre($book_genre)
    {
        $this->book_genre = $book_genre;
    }



    /**
     * @return mixed
     */
    public function getBookName()
    {
        return $this->bookName;
    }

    /**
     * @param mixed $bookName
     */
    public function setBookName($bookName)
    {
        $this->bookName = $bookName;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function getISBN()
    {
        return $this->ISBN;
    }

    /**
     * @param mixed $ISBN
     */
    public function setISBN($ISBN)
    {
        $this->ISBN = $ISBN;
    }

    /**
     * @return mixed
     */
    public function getPublicationDate()
    {
        return $this->publicationDate;
    }

    /**
     * @param mixed $publicationDate
     */
    public function setPublicationDate($publicationDate)
    {
        $this->publicationDate = $publicationDate;
    }

    /**
     * @return mixed
     */
    public function getPublisher()
    {
        return $this->publisher;
    }

    /**
     * @param mixed $publisher
     */
    public function setPublisher($publisher)
    {
        $this->publisher = $publisher;
    }

    /**
     * @return mixed
     */
    public function getBookDescription()
    {
        return $this->bookDescription;
    }

    /**
     * @param mixed $bookDescription
     */
    public function setBookDescription($bookDescription)
    {
        $this->bookDescription = $bookDescription;
    }

    /**
     * @return mixed
     */
    public function getBookImage()
    {
        return $this->bookImage;
    }

    /**
     * @param mixed $bookImage
     */
    public function setBookImage($bookImage)
    {
        $this->bookImage = $bookImage;
    }

    public function addBook(){
        $bookName= $this->getBookName();
        $author= $this->getAuthor();
        $ISBN = $this->getISBN();
        $publicationDate= $this->getPublicationDate();
        $publisher= $this->getPublisher();
        $bookDescription= $this->getBookDescription();
        $maxBorrow = $this->getMaxBorrow();
        $bookImage= $this->getBookImage();
        $bookGenre = $this->getBookGenre();
        $learner_id=$this->getLearnerId();

        $addBook = "insert into book(book_name,author,ISBN,publication_date,publisher,book_description,book_image,book_genre,max_borrow,learner_id,created_date)
                    values ('$bookName','$author','$ISBN','$publicationDate','$publisher','$bookDescription','$bookImage','$bookGenre',$maxBorrow,$learner_id,now())";
        $this->learner->getDatabase()->insert($addBook);
    }

    public function selectBook(){
        $selectBooks = "Select * from book";
        return $this->learner->getDatabase()->select($selectBooks);
    }

    public function selectBookByID($book_id){
        $selectBookByID = "select * from book where book_id=$book_id";
        return $this->learner->getDatabase()->select($selectBookByID);
    }

    public function editBook($book_id){
        $bookName= $this->getBookName();
        $author= $this->getAuthor();
        $ISBN = $this->getISBN();
        $publicationDate= $this->getPublicationDate();
        $publisher= $this->getPublisher();
        $bookDescription= $this->getBookDescription();
        $bookGenre = $this->getBookGenre();

        $editBook = "update book
                        set book_name='$bookName',
                            author='$author',
                            ISBN='$ISBN',
                            publication_date='$publicationDate',
                            publisher='$publisher',
                            book_description='$bookDescription',
                            book_genre='$bookGenre'
                        where book_id=$book_id";
        $this->learner->getDatabase()->update($editBook);
        header("location:my_books.php");
    }

    public function deleteBook($book_id){
        $deleteBook = "delete from book where book_id=$book_id";
        $this->learner->getDatabase()->delete($deleteBook);
        header("location:my_books.php");
    }

    public function countBooks(){
        $countBookSql = "select * from book";
        return $this->learner->getDatabase()->checkRows($countBookSql);
    }

    public function countBorrow(){
        $countBorrowSql = "select * from borrow";
        return $this->learner->getDatabase()->checkRows($countBorrowSql);
    }

    public function countGiveaway(){
        $countGiveAwaySql = "select * from giveaway";
        return $this->learner->getDatabase()->checkRows($countGiveAwaySql);
    }

    public function selectBookLearner(){
        $selectBookLearner = "select * from book b,learner l where l.learnerId=b.learner_id";
        return $this->learner->getDatabase()->select($selectBookLearner);
    }

    public function selectBookLearnerName($learner_id){
        $selectBookLearnerName = "select * from book b,learner l where l.learnerId=b.learner_id and l.learnerId=$learner_id";
        return $this->learner->getDatabase()->select($selectBookLearnerName);
    }

    public function selectBookLearnerByGenre($book_genre){
        $selectBookLearner = "select * from book b,learner l where l.learnerId=b.learner_id and b.book_genre='$book_genre'";
        return $this->learner->getDatabase()->select($selectBookLearner);
    }

    public function searchBook($search){
        $searchBook = "
                    SELECT * FROM book b
                    WHERE book_name LIKE '%".$search."%'
                    OR author LIKE '%".$search."%' 
                    OR ISBN LIKE '%".$search."%' 
                    OR publication_date LIKE '%".$search."%' 
                    OR publisher LIKE '%".$search."%'
                    OR book_genre LIKE '%".$search."%'
                	";
        return $this->learner->getDatabase()->select($searchBook);

    }

    public function selectGiveaway(){
        $selectGiveAway = "select * from giveaway";
        return $this->learner->getDatabase()->select($selectGiveAway);
    }

    public function rateBooks($rating,$book_id){
        $rateBooks = "update book set rating=rating+$rating where book_id=$book_id";
        $this->learner->getDatabase()->update($rateBooks);
    }


}