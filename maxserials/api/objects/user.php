<?php
class User{
    private $table_name = "user";
    public $id;
    public $name;
    public $facts;
    public $password;
    public $email;
  	public $photo;
    private $conn;
    public $ans_ex=false;
    public function __construct($connection){
        $this->conn = $connection;
    }
   function __destruct()
    {
       R::close();
    }
    public function jsonEncodeCyr($str) {
        $arr_replace_utf = array('\u00ab','\u00bb','\u2014 ','\u0410', '\u0430','\u0411','\u0431','\u0412','\u0432',
        '\u0413','\u0433','\u0414','\u0434','\u0415','\u0435','\u0401','\u0451','\u0416',
        '\u0436','\u0417','\u0437','\u0418','\u0438','\u0419','\u0439','\u041a','\u043a',
        '\u041b','\u043b','\u041c','\u043c','\u041d','\u043d','\u041e','\u043e','\u041f',
        '\u043f','\u0420','\u0440','\u0421','\u0441','\u0422','\u0442','\u0423','\u0443',
        '\u0424','\u0444','\u0425','\u0445','\u0426','\u0446','\u0427','\u0447','\u0428',
        '\u0448','\u0429','\u0449','\u042a','\u044a','\u042b','\u044b','\u042c','\u044c',
        '\u042d','\u044d','\u042e','\u044e','\u042f','\u044f');
        $arr_replace_cyr = array('«','»','—','А', 'а', 'Б', 'б', 'В', 'в', 'Г', 'г', 'Д', 'д', 'Е', 'е',
        'Ё', 'ё', 'Ж','ж','З','з','И','и','Й','й','К','к','Л','л','М','м','Н','н','О','о',
        'П','п','Р','р','С','с','Т','т','У','у','Ф','ф','Х','х','Ц','ц','Ч','ч','Ш','ш',
        'Щ','щ','Ъ','ъ','Ы','ы','Ь','ь','Э','э','Ю','ю','Я','я');
        $str2 = str_replace($arr_replace_utf,$arr_replace_cyr,$str);
        return $str2;
    }
    function checkEmailEx(){
        $book =R::count('user', 'email = ?', [$this->email]);
        if (!$book){
            return true;
        }
        else
            return false;
    }
    function create(){
        $user = R::dispense('user');
        $user->name = $this->name;
        $user->password = password_hash($this->password, PASSWORD_BCRYPT);
        $user->email = $this->email;
        $user->facts = "Расскажи что-нибудь о себе...";
        $user->photo = "base.png";
        $ans = R::store($user);
    }
    public function readOne($id){
        $bean = R::load('user', $id);
       if ($bean->id!=0)
            $this->ans_ex = true;
        else
            $this->ans_ex = false;
        $bean_item = array(
            'id'          =>   $bean->id,
            'name'        =>  "$bean->name",
            'facts'       =>  "$bean->facts",
            'password'    =>  "$bean->password",
            'email'       =>  "$bean->email",
            'photo'       =>  "$bean->photo"
        );
        $str_ = json_encode($bean_item);
        $ans = $this->jsonEncodeCyr($str_);
        return $ans;    
    }
    public function update(){
        $bean = R::findOne('user', 'id = ?', [$this->id]);
        if ($bean){
            if (!is_null($this->name))
                $bean->name = $this->name;
            if (!is_null($this->facts))
                $bean->facts = $this->facts;
            if (!is_null($this->password))
                $bean->password=  password_hash($this->password, PASSWORD_BCRYPT);
            if (!is_null($this->email))
                $bean->email = $this->email;
             if (!is_null($this->photo))
                $bean->photo = $this->photo;
            $ans = R::store($bean);
            return true;
        }
        else 
            return false;
    }
    function emailExists(){
        $book = R::findOne('user', 'email = ?', [$this->email]);
        if ($book){
            $this->password = $book->password;
            $this->name = $book->name;
            $this->id = $book->id;
            $this->photo = $book->photo;
            $this->facts = $book->facts;
            $_SESSION['logged_user'] = $book;
            return true;
        }
        else
            return false;
    }
    public function delete($id){
        $bean = R::load('user', $id);
        if ($bean->id!=0){
            R::trash($bean);
            return true;
        }
        else 
            return false;
    }
    function getNoteSerial($_si , $ok){
        $arr_note = UserEpisode::readAll($this->id);
        $episode_arr = array();
        $episode_arr += ['note'=>$ok];
        for ($row = 0; $row <count($arr_note); $row++) 
            {
                $bean = R::findOne('episode', 'id = ?', [$arr_note[$row]['episode_id']]);
                if ($bean->serial_id === $_si){
                    $episode_item = array(
                    'id'          =>   $arr_note[$row]['id'],
                    'name'        =>  "$bean->name",
                    'date'        =>  "$bean->date",
                    'season_num'  =>   $bean->season_num,
                    'episode_num' =>   $bean->episode_num,
                    'note'        =>   $arr_note[$row]['note']); 
                     array_push($episode_arr,  $episode_item);
                } 
            }
        $str_ = json_encode($episode_arr, JSON_FORCE_OBJECT);
        $ans = $this->jsonEncodeCyr($str_);
        if ($arr_note  && $bean)
            $this->ans_ex=true;
        else
            $this->ans_ex=false;
        return $ans;
    }
    function getUserSerialList(){
        $arr_note = UserSerials::readAll($this->id);
        $serial_arr = array();
        for ($row = 0; $row <count($arr_note); $row++) 
            {
                $bean = R::findOne('serial', 'id = ?', [$arr_note[$row]['serial_id']]);
                if ($bean->id != 0){
                $serial_item = array(
                'id'          =>   $bean->id,
                'name'        =>  "$bean->name",
                'rating'        =>  $bean->rating,
                'genre'        =>  "$bean->genre",
                'year'        =>  "$bean->year",
               	);
                 array_push($serial_arr,  $serial_item);
                 }
            }
        $str_ = json_encode($serial_arr,JSON_FORCE_OBJECT);
        $ans = $this->jsonEncodeCyr($str_);
        if ($arr_note  && $bean)
            $this->ans_ex=true;
        else
            $this->ans_ex=false;
        return $ans;
    }
    function getNote(){
        $arr_note = UserEpisode::readAll($this->id);
        $episode_arr = array();
        for ($row = 0; $row <count($arr_note); $row++) 
            {
                $bean = R::findOne('episode', 'id = ?', [$arr_note[$row]['episode_id']]);
                $bean_2 = R::findOne('serial', 'id = ?', [$bean->serial_id]);
                $episode_item = array(
                'id'          =>  $arr_note[$row]['id'],
                'name'        =>  "$bean->name",
                'date'        =>  "$bean->date",
                'serial_name'   => $bean_2->name,
                'season_num'  =>   $bean->season_num,
                'episode_num' =>   $bean->episode_num,
                'note'        =>   $arr_note[$row]['note']
             );
                 array_push($episode_arr,  $episode_item);
            }
        $str_ = json_encode($episode_arr,JSON_FORCE_OBJECT);
        $ans = $this->jsonEncodeCyr($str_);
        if ($arr_note  && $bean && $bean_2)
            $this->ans_ex=true;
        else
            $this->ans_ex=false;
        return $ans;
    }
    function getNotNote(){
        $arr_note = UserEpisode::readAll($this->id);
        $episode_arr = array();
        for ($row = 0; $row <count($arr_note); $row++) 
            {
                if ($arr_note[$row]['note']==0){
                    $bean = R::findOne('episode', 'id = ?', [$arr_note[$row]['episode_id']]);
                    $bean_2 = R::findOne('serial', 'id = ?', [$bean->serial_id]);
                    $episode_item = array(
                    'id'          =>   $arr_note[$row]['id'],
                    'name'        =>  "$bean->name",
                    'date'        =>  "$bean->date",
                    'serial_name' =>   $bean_2->name ,
                    'season_num'  =>   $bean->season_num,
                    'episode_num' =>   $bean->episode_num,
                    'note'        =>   $arr_note[$row]['note']); 
                    
                    array_push($episode_arr,  $episode_item);
                }   
            }
        $str_ = json_encode($episode_arr);
        $ans = $this->jsonEncodeCyr($str_);
         if ($arr_note  && $bean && $bean_2)
            $this->ans_ex=true;
        else
            $this->ans_ex=false;
        return $ans;
    }
    function Count($s_i){
        $arr_note = UserEpisode::readAll($this->id);
        $c = 0;
        for ($row = 0; $row <count($arr_note); $row++) 
            {
                if ($arr_note[$row]['note'] == 0 && Episode::readSerialId($arr_note[$row]['episode_id']) == $s_i){
                    $c++;
                }
        }
        return $c;
    }
    function updateNoteSerial($arr_note){
        $ok = true;
        for ($row = 0; $row <count($arr_note); $row++) 
            {
                $book = R::load('userepisode', $arr_note[$row]['name']);
                if($book->id === 0)
                    return false;
                $book->note = $arr_note[$row]['value'];
                R::store($book);
            }
        return $ok;
    }
    function getRatingSerial($id){
        $arr_note = UserSerials::read($this->id, $id);
        $bean = R::findOne('serial', 'id = ?', [$id]);
        if ($arr_note!=NULL){
        $serial_item = array(
                'id'          =>   $arr_note['id'],
                'serial_id'   =>   $bean->id,
                'name'        =>  "$bean->name",
                'year'        =>   $bean->year,
                'description' =>  "$bean->description",
                'fun_facts'   =>  "$bean->fun_facts",
                'country'     =>  "$bean->country",
                'photo'       =>  "$bean->photo",
                'genre'       =>  "$bean->genre",
                'rating'      =>  "$bean->rating",
                'ratingU'    =>    $arr_note['ratingU']
             );
        }
        else {
             $serial_item = array(
                
                'serial_id'   =>   $bean->id,
                'name'        =>  "$bean->name",
                'year'        =>   $bean->year,
                'description' =>  "$bean->description",
                'fun_facts'   =>  "$bean->fun_facts",
                'country'     =>  "$bean->country",
                'photo'       =>  "$bean->photo",
                'genre'       =>  "$bean->genre",
                'rating'      =>  "$bean->rating",
                
             );
        }
        $str_ = json_encode($serial_item);
        $ans = $this->jsonEncodeCyr($str_);
        if ($bean)
            $this->ans_ex=true;
        else
            $this->ans_ex=false;
        return $ans;
    }
    function UpdateRatingSerial($arr_note){
        $ok = true;
        $book = R::load('userserials', $arr_note['id']);
        if($book->id == 0 || $book->serial_id != $arr_note['serial_id']){
            return false;
        }
        $book->rating_user_id = $arr_note['ratingU'];
        R::store($book);
        $ans = $this->UpdateGeneralRatingSerial($arr_note);
        return $ans;
    }
    private function UpdateGeneralRatingSerial($arr_note){
        $books = R::findAll("userserials", "serial_id = ?", [$arr_note['serial_id']]);
        $count_u = 0;
        $sum_mark = 0; 
        foreach ($books as $bean) {
            $sum_mark+=$bean->rating_user_id;
            $count_u++;
        }
        if ($count_u == 0)
             return false;
        else{
        $new_mark =  intval($sum_mark/$count_u);
        $book = R::load('serial', $arr_note['serial_id']);
        $book->rating =  $new_mark;
        R::store($book);
        return true;
        }
        
    }
   
}
?>