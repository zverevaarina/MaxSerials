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
   
}
?>