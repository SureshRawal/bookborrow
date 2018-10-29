<?php
include "learner.php";
class discussion{
    private $discussion_id;
    private $discussion;
    private $learner_id;
    private $visited;
    private $reply;
    private $post_date;

    private $learner;

    /**
     * @return learner
     */
    public function getLearner()
    {
        return $this->learner;
    }


    public function __construct()
    {
        $this->learner = new learner();
    }

    /**
     * @return mixed
     */
    public function getPostDate()
    {
        return $this->post_date;
    }

    /**
     * @param mixed $post_date
     */
    public function setPostDate($post_date)
    {
        $this->post_date = $post_date;
    }



    /**
     * @return mixed
     */
    public function getDiscussionId()
    {
        return $this->discussion_id;
    }

    /**
     * @param mixed $discussion_id
     */
    public function setDiscussionId($discussion_id)
    {
        $this->discussion_id = $discussion_id;
    }

    /**
     * @return mixed
     */
    public function getDiscussion()
    {
        return $this->discussion;
    }

    /**
     * @param mixed $discussion
     */
    public function setDiscussion($discussion)
    {
        $this->discussion = $discussion;
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
    public function getVisited()
    {
        return $this->visited;
    }

    /**
     * @param mixed $visited
     */
    public function setVisited($visited)
    {
        $this->visited = $visited;
    }

    /**
     * @return mixed
     */
    public function getReply()
    {
        return $this->reply;
    }

    /**
     * @param mixed $reply
     */
    public function setReply($reply)
    {
        $this->reply = $reply;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    public function postDiscussion(){
        $discussion = $this->getDiscussion();
        $learnerId = $this->getLearnerId();

        $postDiscussion = "insert into discussion(discussion,learner_id,visited,replied,post_date) 
                          values ('$discussion',$learnerId,0,0,now())";
        $this->learner->getDatabase()->insert($postDiscussion);
    }

    public function selectDiscussion(){
    $selectDiscussion= "Select * from discussion";
    return $this->learner->getDatabase()->select($selectDiscussion);

}

    public function selectDiscussionById($discussion_id){
        $selectDiscussionById = "select * from discussion where discussion_id=$discussion_id";
        return $this->learner->getDatabase()->select($selectDiscussionById);
    }

    public function discussionReply(){
        $replier_id = $this->getLearnerId();
        $discussion_id = $this->getDiscussionId();
        $reply = $this->getReply();

        $discussionReply ="insert into discussion_reply(replier_id,discussion_id,reply,reply_date) values ($replier_id,$discussion_id,'$reply',now())";
        $updateReplyCount = "update discussion set replied=replied+1 where discussion_id=$discussion_id";
        $this->learner->getDatabase()->insert($discussionReply);
        $this->learner->getDatabase()->update($updateReplyCount);
    }

    public function increaseVisit($discussion_id){
        $updateDiscussionVisit = "update discussion set visited=visited+1 where discussion_id=$discussion_id";
        $this->learner->getDatabase()->update($updateDiscussionVisit);
    }

    public function selectDiscussionReply(){
        $selectDiscussionReply = "Select * from discussion_reply";
        return $this->learner->getDatabase()->select($selectDiscussionReply);
    }

    public function selectDiscussionReplyById($discussion_id){
        $selectDiscussionReplyById = "Select * from discussion_reply where discussion_id=$discussion_id";
        return $this->learner->getDatabase()->select($selectDiscussionReplyById);
    }
}