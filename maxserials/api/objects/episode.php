<?php
class Episode{
    private $table_name = "episode";
    public $id;
    public $name;
    public $serial_id;
    public $season_num;
    public $episode_num;
  	public $date;
    public $ans_ex=false;
    public $conn;
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
    public function create(){
        $episode = R::dispense('episode');
        $episode->name = $this->name;
        $episode->serial_id = $this->serial_id;
        $episode->season_num = $this->season_num;
        $episode->episode_num = $this->episode_num;
        $episode->date = $this->date;
        $ans = R::store($episode);
    }
    public function readOne($id){
        $bean = R::load('episode', $id);
        if ($bean->id!=0)
            $this->ans_ex = true;
        else
            $this->ans_ex = false;
        $episode_item = array(
            'id'          =>   $bean->id,
            'name'        =>   "$bean->name",
            'serial_id'   =>   $bean->serial_id,
            'season_num'  =>   $bean->season_num,
            'episode_num' =>   $bean->episode_num,
            'date'        =>   "$bean->date",
        );
        $str_ = json_encode($episode_item);
        $ans = $this->jsonEncodeCyr($str_);
        return $ans;    
    }
     public static function readSerialId($id){
        $bean = R::load('episode', $id);
        if ($bean->id!=0)
            return $bean->serial_id;
        else
            return NULL;
    }
    public function readAll($id){
        $books = R::findAll('episode', 'serial_id = ?', [$id]);
        if ($books)
            $this->ans_ex = true;
        else
            $this->ans_ex = false;
        $episode_arr = array();
        foreach ($books as $bean) {
             $episode_item = array(
            'id'          =>   $bean->id,
            'serial_id'   =>   $bean->serial_id
        );
            array_push($episode_arr,  $episode_item);
        }
        
        return $episode_arr;    
    }
    public function readP($id){
        $books = R::findAll('episode', 'serial_id = ?', [$id]);
        if ($books)
            $this->ans_ex = true;
        else
            $this->ans_ex = false;
        $episode_arr = array();
        foreach ($books as $bean) {
             $episode_item = array(
             'id'          =>   $bean->id,
            'name'        =>   "$bean->name",
            'serial_id'   =>   $bean->serial_id,
            'season_num'  =>   $bean->season_num,
            'episode_num' =>   $bean->episode_num,
            'date'        =>   "$bean->date"
        );
            array_push($episode_arr,  $episode_item);
        }
        $str_ = json_encode($episode_arr);
        $ans = $this->jsonEncodeCyr($str_);
        return $ans;     
    }
    public function Count($id){
        $c = R::Count('episode', 'serial_id = ?', [$id]);
        if (!$c)
            return 0;
        else
            return $c;    
    }
    public function update($id){
        $episode = R::load('episode', $id);
        if ($episode->id!=0){
            $episode->name = $this->name;
            $episode->serial_id = $this->serial_id;
            $episode->season_num = $this->season_num;
            $episode->episode_num = $this->episode_num;
            $episode->date = $this->date;
            $ans = R::store($episode);
            return true;
        }
        else 
            return false;
    }
    public function delete($id){
        $bean = R::load('episode', $id);
        if ($bean->id!=0){
            R::trash($bean);
            return true;
        }
        else 
            return false;
    }
}
?>