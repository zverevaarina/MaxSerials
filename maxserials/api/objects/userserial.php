<?php
class UserSerials{
    private $table_name = "userserials";
    public $id;
    public $rating;
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
        $books = R::findAll("userserials", "user_id = ?", [$uid]);
        $serials_arr=array();
        foreach ($books as $bean) {
            $serials_item = array(
                'id'          =>   $bean->id,
                'note'         =>   $bean->note,
                'ratingU'     =>   $bean->rating_user_id,
                'user_id'     =>   $bean->user_id,
                'serial_id'   =>   $bean->serial_id
            );
        array_push($serials_arr,  $serials_item);
        }
        return $serials_arr;
    }
    public static function read($_user_id, $_serial_id ){
        $bean = R::findOne("userserials", 'user_id = :ui AND serial_id = :si', [':ui' => $_user_id, ':si' => $_serial_id]);
        if ($bean){
        $note_item = array(
                'id'          =>   $bean->id,
                'note'         =>   $bean->note,
                'ratingU'     =>   $bean->rating_user_id,
                'user_id'     =>   $bean->user_id,
                'serial_id'   =>   $bean->serial_id
            );
        return $note_item;
        }
        else 
            return NULL;
        
    }
    public function Exsist($_user_id, $_serial_id ){
        $bean = R::findOne("userserials", 'user_id = :ui AND serial_id = :si', [':ui' => $_user_id, ':si' => $_serial_id]);
        return $bean ? true: false;
            
    }
    public function NoteNo($_user_id, $_serial_id ){
        $b = R::findOne("userserials", 'user_id = :ui AND serial_id = :si', [':ui' => $_user_id, ':si' => $_serial_id]);
        if($b){
            $bean = R::load('userserials', $b->id);
            if ($bean->id != 0 ){
                $bean->note = 0;
                R::store($bean);
            }
            
            else return;
        }
        else
            return;

    }
    public function NoteYes($_user_id, $_serial_id ){
        $b = R::findOne("userserials", 'user_id = :ui AND serial_id = :si', [':ui' => $_user_id, ':si' => $_serial_id]);
        if($b){
            $bean = R::load('userserials', $b->id);
            if ($bean->id != 0 ){
                $bean->note = 1;
                R::store($bean);
            }
            
            else return;
        }
        else
            return;

    }
    public function ExNote($_user_id, $_serial_id ){
        $bean = R::findOne("userserials", 'user_id = :ui AND serial_id = :si', [':ui' => $_user_id, ':si' => $_serial_id]);
        if($bean){
            return $bean->note;
        }
    }
    public function create($_user_id, $_serial_id){
        $ok = R::find('userserials', 'user_id = :ui AND serial_id = :si', [':ui' => $_user_id, ':si' => $_serial_id]);
        $book = R::dispense('userserials');
        $book->rating_user_id = 0;
        $book->note = 1;
        $book->user_id = $_user_id;
        $book->serial_id =$_serial_id;
        R::store($book);
    }
     public function delete($id){
        $bean = R::load('userserials', $id);
        if ($bean->id!=0){
            R::trash($bean);
            return true;
        }
        else 
            return false;
    }
}
?>