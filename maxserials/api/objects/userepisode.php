<?php
class UserEpisode{
    private $table_name = "userepisode";
    public $id;
    public $note;
    public $user_id;
    public $serial_id;
    private $conn;
    public function __construct($connection){
        $this->conn = $connection;
    }
    function __destruct()
    {
       R::close();
    }
    public static function readAll($uid){
        $books = R::findALL("userepisode", "user_id = ?", [$uid]);
        $note_arr = array();
        foreach ($books as $bean) {
            $note_item = array(
                'id'          =>   $bean->id,
                'note'        =>   $bean->note,
                'user_id'     =>   $bean->user_id,
                'episode_id'   =>  $bean->episode_id
            );
            array_push($note_arr,  $note_item);
        }
        return $note_arr;
    }
    public function Exsist($_user_id, $_episode_id ){
        $bean = R::findOne("userepisode", 'user_id = :ui AND episode_id = :si', [':ui' => $_user_id, ':si' => $_episode_id]);
        return $bean ? true: false;
            
    }
    public function create($_user_id, $_episode_id){
        $ok = R::find('userepisode', 'user_id = :ui AND episode_id = :si', [':ui' => $_user_id, ':si' => $_episode_id]);
        $book = R::dispense('userepisode');
        $book->note = 0;
        $book->user_id = $_user_id;
        $book->episode_id =$_episode_id;
        $a = R::store($book);
    }
     public function delete($id){
        $bean = R::load('userepisode', $id);
        if ($bean->id!=0){
            R::trash($bean);
            return true;
        }
        else 
            return false;
    }
}
?>