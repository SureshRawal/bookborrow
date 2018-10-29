<?php
class selectFunction{

    public function countLearners(){
        $countLearnerSQL = "select * from learner";
        return $countLearnerSQL;
    }

    public function countBooks(){
        $countBooksSQL = "select * from book";
        return $countBooksSQL;
    }

    public function selectAllBorrowedBooks(){
        $selectAllBorrowedBooks = "select * from borrow";
        return $selectAllBorrowedBooks;
    }

    public function selectBorrowedBooks(){
        $selectAllBorrowedBooks = "select * from borrow b,learner l,book bo where b.borrower_id=l.learnerId and b.book_id=bo.book_id";
        return $selectAllBorrowedBooks;
    }

    public function countTotalVisit(){
        $countVisit = "select sum(visit_count) as count from learner";
        return $countVisit;
    }

    public function selectGiveaway($giveaway_id){
        $selectGiveaway = "select * from giveaway where giveaway_id=$giveaway_id";
        return $selectGiveaway;
    }

    public function claimGiveaway($learner_id,$giveaway_id){
        $claimGiveaway = "insert into claim(learner_id,giveaway_id,claim_date) values ($learner_id,$giveaway_id,now())";
        return $claimGiveaway;
    }

    public function checkLearnerClaim($learner_id,$giveaway_id){
        $checkLearnerClaim = "select * from claim where learner_id=$learner_id and giveaway_id=$giveaway_id";
        return $checkLearnerClaim;
    }

    public function selectClaim(){
        $selectClaim = "select * from claim c,learner l,giveaway g where l.learnerId=c.learner_id and c.giveaway_id=g.giveaway_id";
        return $selectClaim;
    }

    public function countBorrow(){
        $countBorrowSql = "select * from borrow";
        return $countBorrowSql;
    }

    public function countGiveaway(){
        $countGiveAwaySql = "select * from giveaway";
        return $countGiveAwaySql;
    }

}