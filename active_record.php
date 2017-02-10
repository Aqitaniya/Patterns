<?php
//http://www.devshed.com/c/a/php/using-the-active-record-pattern-with-php-and-mysql/
class User{
    private $db;
    private $firstName;
    private $lastName;
    private $email;
    private $table='users';
    public function __construct(){
        $this->db = new MySQL('localhost','rav','cRv_2543','rav_test_active_record');
    }
    public function setFirstName($firstName){
        $this->firstName="'".$firstName."'";
    }
    public function setLastName($lastName){
        $this->lastName="'".$lastName."'";
    }
    public function setEmail($email){
        $this->email="'".$email."'";
    }
    public function fetch($id){
        if(!$row=mysql_query("SELECT * FROM $this->table WHERE id='$id'")){
            throw new Exception('Error fetching row');
        }
        return $row;
    }
    public function insert(){
        if(!mysql_query("INSERT INTO $this->table (firstName,lastName,email) VALUES ($this->firstName,$this->lastName,$this->email)")){
            throw new Exception('Error inserting row');
        }
    }
    public function update($id){
        if(!mysql_query("UPDATE $this->table SET firstName=$this->firstName, lastName=$this->lastName,email=$this->email WHERE id=$id")){
            throw new Exception('Error updating row');
        }
    }
    public function delete($id){
        if(!mysql_query("DELETE FROM $this->table WHERE id=$id")){
            throw new Exception('Error deleting row');
        }
    }
}

try{
    $user = new User();

    $user->setFirstName('Alejandro');
    $user->setLastName('Gervasio');
    $user->setEmail('alejandro@domain.com');

    $user->insert();


    $user->setFirstName('Alejandro');
    $user->setLastName('Gervasio');
    $user->setEmail('alex@domain.com');

    $user->update(1);

    $user->delete(1);

}

catch(Exception $e){
    echo $e->getMessage();
    exit();
}



class MySQL{
    private $result;
    private $table = "users";
    public function __construct($host='localhost',$user='user',$password='password',$database='database'){
        if(!$conId=mysql_connect($host,$user,$password)){
            throw new Exception('Error connecting to the server');
        }
        if(!mysql_select_db($database,$conId)){
            throw new Exception('Error selecting database');
        }
    }
    public function query($query){
        if(!$this->result=mysql_query($query)){
            throw new Exception('Error performing query '.$query);
        }
    }
    public function fetchRow(){
        while($row=mysql_fetch_array($this->result)){
            return $row;
        }
        return false;
    }
    public function fetchAll($table='users'){
        $this->query('SELECT * FROM '.$table);
        $rows=array();
        while($row=$this->fetchRow()){
            $rows[]=$row;
        }
        return $rows;
    }
    public function insert($params=array(),$table='users'){
        $sql='INSERT INTO '.$table.' ('.implode(',',array_keys($params)).') VALUES ("'.implode('","',array_values($params)).'")';
        $this->query($sql);
    }
}

try{
    $db=new MySQL('localhost','rav','cRv_2543','rav_test_active_record');
    $result=$db->fetchAll('users');
    foreach($result as $row){
        echo $row['firstName'].' '.$row['lastName'].' '.$row['email'].'<br />';
    }
    /* displays the following

    Alejandro Gervasio alejandro@domain.com
    John Doe john@domain.com
    Susan Norton susan@domain.com
    Marian Wilson marian@domain.com
    Mary Smith mary@domain.com
    Amanda Bears amanda@domain.com
    Jodie Foster jodie@domain.com
    Laura Linney laura@domain.com
    Alice Dern alice@domain.com
    Jennifer Aniston jennifer@domain.com
    */
}
catch(Exception $e){
    echo $e->getMessage();
    exit();
}

try{
    $db=new MySQL('localhost','rav','cRv_2543','rav_test_active_record');
    $db->insert(array('firstName'=>'Kate','lastName'=>'Johanson','email'=>'kate@domain.com'),'users');
}
catch(Exception $e){
    echo $e->getMessage();
    exit();
}
