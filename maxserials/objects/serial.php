<?php
class Serial{
    private $table_name = "serial";
    public $id;
    public $name;
    public $year;
    public $description;
    public $fun_facts;
  	public $country;
    public $photo;
    public $genre;
    public $rating;
    private $conn;
    public $ans_ex=false;
    public function __construct($connection){
        $this->conn = $connection;
    }
    function __destruct()
    {
       R::close();
    }
    private function jsonEncodeCyr($str) {
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
    public function readAll(){
        $books = R::findAll('serial');
        if ($books)
            $this->ans_ex = true;
        else
            $this->ans_ex = false;
        $serials_arr=array();
        foreach ($books as $bean) {
            $serials_item = array(
                'id'          =>   $bean->id,
                'name'        =>  "$bean->name",
                'year'        =>   $bean->year,
                'description' =>  "$bean->description",
                'fun_facts'   =>  "$bean->fun_facts",
                'country'     =>  "$bean->country",
                'photo'       =>  "$bean->photo",
                'genre'       =>  "$bean->genre",
                'rating'      =>  "$bean->rating"
                
            );
            array_push($serials_arr,  $serials_item);
        }
        $str_ = json_encode($serials_arr);
        $ans = $this->jsonEncodeCyr($str_);
        return $ans;
    }
    public function readOne($id){
        $bean = R::load('serial', $id);
        if ($bean->id!=0)
            $this->ans_ex = true;
        else
            $this->ans_ex = false;
        $serials_item = array(
            'id'          =>   $bean->id,
            'name'        =>  "$bean->name",
            'year'        =>   $bean->year,
            'description' =>  "$bean->description",
            'fun_facts'   =>  "$bean->fun_facts",
            'country'     =>  "$bean->country",
            'photo'       =>  "$bean->photo",
            'genre'       =>  "$bean->genre",
            'rating'      =>  "$bean->rating"
        );
        $str_ = json_encode($serials_item);
        $ans = $this->jsonEncodeCyr($str_);
        return $ans;    
    }
        public function search($key){
        $books = R::find('serial', 'name LIKE ?', ["%$key%"]);
        if ($books)
            $this->ans_ex = true;
        else
            $this->ans_ex = false;
        $serials_arr = array();
        foreach ($books as $bean) {
            $serials_item = array(
                'id'          =>   $bean->id,
                'name'        =>  "$bean->name",
                'year'        =>   $bean->year,
                'description' =>  "$bean->description",
                'fun_facts'   =>  "$bean->fun_facts",
                'country'     =>  "$bean->country",
                'photo'       =>  "$bean->photo",
                'genre'       =>  "$bean->genre",
                'rating'      =>  "$bean->rating"
                
            );
            array_push($serials_arr,  $serials_item);
        }
        $str_ = json_encode($serials_arr);
        $ans = $this->jsonEncodeCyr($str_);
        return $ans;
    }
}
?>