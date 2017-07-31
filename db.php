<?php
trait Singleton{
    private static $instance=NULL;
    public static function instance(){
        if(self::$instance==NULL) self::$instance = new self();
        return self::$instance;
    }
}


class Database{
    private $config=[
        "host"=>"127.0.0.1",
        "db"=>"hotels",
        "user"=>"root",
        "pass"=>"",
        "charset"=>"utf8",
        "port"=>3306
    ];
    private $DBH,$tables,$table=NULL;
    use Singleton;
    private function __construct(){
        $cfg = $this->config;
        $this->DBH = new PDO("mysql:host={$cfg["host"]};port={$cfg["port"]};dbname={$cfg["db"]}",
            $cfg["user"],
            $cfg["pass"]
            /*[
                PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]*/
        );
        $sth = $this->DBH->query("SHOW TABLES");
        $this->tables = $sth->fetchAll(PDO::FETCH_COLUMN);
    }

    public function __get($name){
        if(!in_array($name,$this->tables)) throw new Exception("Table Not Found",3001);
        $this->table = "`".$name."`";
        return $this;
    }
    public function getAll($where=1,$params=[]){
        if(!$this->table) throw new Exception("Table Not Selected",3002);
        $sth = $this->DBH->prepare("SELECT * FROM {$this->table} WHERE {$where}");
        $sth->execute($params);
        $this->table=NULL;
        return $sth->fetchAll();
    }
    public function getColumns(array $collist,$where=1,$params=[]){
        $columns = implode(",",$collist);
        if(!$this->table) throw new Exception("Table Not Selected",3002);
        $sth = $this->DBH->prepare("SELECT {$columns} FROM {$this->table} WHERE {$where}");
        $sth->execute($params);
        $this->table=NULL;
        return $sth->fetchAll();
    }

    public function insert($data){
        if(!$this->table) throw new Exception("Table Not Selected",3002);
        //INSERT INTO {table} (`name`,`text`) VALUES (:name)
        $keys = array_keys($data);
        $q = "INSERT INTO {$this->table} (`".implode("`,`",$keys)."`) VALUES (:".implode(",:",$keys).")";
        $sth = $this->DBH->prepare($q);
        $sth->execute($data);
        $this->table=NULL;
        return $this->DBH->lastInsertId();
    }
    public function delete($id){
        if(!$this->table) throw new Exception("Table Not Selected",3002);
        $sth = $this->DBH->prepare("DELETE FROM {$this->table} WHERE `id`=?");
        $sth->bindValue(1,$id,PDO::PARAM_INT);
        $sth->execute();
        $this->table=NULL;
    }
    public function join($table,$firstfield,$secondfield,$type="INNER"){
        if(!in_array($table,$this->tables)) throw new Exception("Table Not Foond",3001);
        if(!$this->table) throw new Exception("Table Not Selected",3002);
        $this->table.=" {$type} JOIN `{$table}` ON ({$this->table}.`{$firstfield}` = `{$table}`.`{$secondfield}`) ";
        return $this;
    }

}
