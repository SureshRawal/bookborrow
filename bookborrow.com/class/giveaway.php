<?php
include "database.php";
class giveaway{

    private $database;

    public function __construct(){
        $this->database = new database();
    }

    /**
     * @return database
     */
    public function getDatabase()
    {
        return $this->database;
    }

    private $bookName;
    private $author;
    private $ISBN;
    private $publicationDate;
    private $publisher;
    private $bookDescription;
    private $bookImage;
    private $book_genre;
    private $carousel_index;
    private $points;

    /**
     * @return mixed
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * @param mixed $points
     */
    public function setPoints($points)
    {
        $this->points = $points;
    }

    /**
     * @return mixed
     */
    public function getCarouselIndex()
    {
        return $this->carousel_index;
    }

    /**
     * @param mixed $carousel_index
     */
    public function setCarouselIndex($carousel_index)
    {
        $this->carousel_index = $carousel_index;
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

    public function addGiveaway(){
        $bookName= $this->getBookName();
        $author= $this->getAuthor();
        $ISBN = $this->getISBN();
        $publicationDate= $this->getPublicationDate();
        $publisher= $this->getPublisher();
        $bookDescription= $this->getBookDescription();
        $bookImage= $this->getBookImage();
        $bookGenre = $this->getBookGenre();
        $points = $this->getPoints();

        $addGiveaway = "insert into giveaway(book_name,author,ISBN,publication_date,publisher,book_description,book_image,book_genre,created_date,carousel_index,points)
                    values ('$bookName','$author','$ISBN','$publicationDate','$publisher','$bookDescription','$bookImage','$bookGenre',now(),2,$points)";
        $this->database->insert($addGiveaway);
    }

    public function editGiveaway($giveaway_id){
        $bookName= $this->getBookName();
        $author= $this->getAuthor();
        $ISBN = $this->getISBN();
        $publicationDate= $this->getPublicationDate();
        $publisher= $this->getPublisher();
        $points = $this->getPoints();
        $carousel_index = $this->getCarouselIndex();
        $bookDescription= $this->getBookDescription();
        $bookGenre = $this->getBookGenre();

        $editGiveaway = "update giveaway
                        set book_name='$bookName',
                            author='$author',
                            ISBN='$ISBN',
                            publication_date='$publicationDate',
                            publisher='$publisher',
                            book_description='$bookDescription',
                            book_genre='$bookGenre',
                            carousel_index='$carousel_index',
                            points='$points'
                        where giveaway_id=$giveaway_id";
        $this->database->update($editGiveaway);
    }

    public function deleteGiveaway($giveaway_id){
        $deleteGiveaway = "delete from giveaway where giveaway_id=$giveaway_id";
        $this->database->delete($deleteGiveaway);
    }


    public function selectGiveaway(){
        $selectGiveAway = "select * from giveaway";
        return $this->database->select($selectGiveAway);
    }

    public function selectGiveawayById($giveaway_id){
        $selectGiveawayById = "select * from giveaway where giveaway_id=$giveaway_id";
        return $this->database->select($selectGiveawayById);
    }


    public function selectClaimBooks($learner_id){
        $selectClaimBooks = "select * from claim c,giveaway g where c.giveaway_id=g.giveaway_id and learner_id=$learner_id";
        return $this->database->select($selectClaimBooks);
    }


}