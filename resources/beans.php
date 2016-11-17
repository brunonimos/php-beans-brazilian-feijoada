<?php

$share=new share();

class share {

public function __construct(){
$beans=new beans();
$beans->chama("");
}

}

class prepare {

private $vetores=array();
private $objects=array();
private $managedbeans=array();
private $exclude=array();
private $attributes=array();
private $requires=array();
private $context=array();
private $notation=array();

public function getManagedBeans(){
return $this->managedbeans;
}

public function chama(prepare $prepare){
$prepare->loadDependency($prepare);
$prepare->loadContext($prepare);
$prepare->loadFile($prepare);
$prepare->loadClass($prepare);
$prepare->checkNotation($prepare);
$prepare->fetchNotation($prepare);
$prepare->objConstruct($prepare);
}

private function loadDependency(prepare $prepare){
$dir="../public/WEB-INF/";
$file="web.xml";
$dependency=file_get_contents($dir.$file);
$data=simplexml_load_string($dependency,"SimpleXMLElement",LIBXML_NOCDATA);
$json=json_encode($data);
$prepare->vetores=json_decode($json,TRUE);
}

private function loadContext(prepare $prepare){
$root=realpath($_SERVER["DOCUMENT_ROOT"]);
$currentdir=__DIR__.'/';
foreach($prepare->vetores['context'] as $key => $val){
if($val['@attributes']['local']!="this"){
$prepare->context[]="$root\\".$val['@attributes']['local'];
}else{
$prepare->context[]="";
}
}
}

private function loadFile(prepare $prepare){
foreach($prepare->vetores['requirement'] as $key => $val){
require_once $prepare->context[$key].'/'.$val['@attributes']['file'].'';
$prepare->requires[]=$val['@attributes']['file'];
}
}

private function loadClass(prepare $prepare){
foreach($prepare->vetores['classe'] as $key => $val){
$obj=new $val['@attributes']['classname']();
$prepare->objects[$val['@attributes']['classname']]=$obj;
$getter=get_object_vars($prepare->objects[$val['@attributes']['classname']]);
$prepare->objects[$val['@attributes']['classname']]=$getter;
}
}

private function checkNotation(prepare $prepare){
foreach($prepare->requires as $key => $val){
$prepare->notation[]=file_get_contents($prepare->context[$key].$prepare->requires[$key]);
$prepare->notation[$key]=str_replace("\n","",$prepare->notation[$key]);
$prepare->notation[$key]=str_replace("\r","",$prepare->notation[$key]);
$prepare->notation[$key]=str_replace(" ","",$prepare->notation[$key]);
$prepare->notation[$key]=preg_replace('/[ ]{2,}|[\t]/','',trim($prepare->notation[$key]));
}
}

private function fetchNotation(prepare $prepare){
foreach($prepare->objects as $key => $val){
$classes=$key;
foreach($prepare->objects[$key] as $key => $val){
$prepare->attributes[$classes][$key]=$key;
}
}
}

private function objConstruct(prepare $prepare){
$scope=$_POST['scope'];
$bean=new beans();
foreach($prepare->notation as $key => $val){
$notindex=$key;
foreach($prepare->attributes as $key => $val){
if(strpos($prepare->notation[$notindex],"class".$key) !== false){
$objindex=$key;
foreach($prepare->attributes[$key] as $key => $val){
if(strpos($prepare->notation[$notindex],"#ManagedBeanpublic$".$key) !== false){
$managedbean=$key;
foreach($prepare->objects[$objindex] as $key => $val){
if($key==$managedbean){
$prepare->managedbeans[$objindex][$managedbean]=$val;
}
}
}
}
}
}
}
}
}

class beans {

private $database;

private $connection;

private $statement;

private $table;

private $colluns=array();

private $keys;

private $bind;

private $managedbeans=array();

public $sql;

private function getDb_folder(){
return self::db_folder;
}

private function load(){
$prepare=new prepare();
$prepare->chama($prepare);
$this->managedbeans=$prepare->getManagedBeans();
}

public function chama(){
if($_POST['scope'] ?? die("Undefined Method")){
$scope=$_POST['scope'];
$this->$scope();
}
}

private function request(){
$this->load();
$json=json_encode($this->managedbeans);
print_r($json);
}

public function DAO($database){
$this->database=$database;
$classes=get_declared_classes();
end($classes);
$offset=key($classes);
$classe=$classes[$offset];
$this->load();
$this->table=$classe;
foreach($this->managedbeans[$classe] as $key => $value){
if(!is_array($value)){
$this->colluns[$key]=$value;
}else{
$dimensional=$value;
foreach($dimensional as $key => $value){
if(!is_array($value)){
$this->colluns[$key]=$value;
}else{
$bidimensional=$value;
foreach($bidimensional as $key => $value){
$this->colluns[$key]=$value;
}
}
}
}
}
$this->createDB();
}

private function createDB(){
$conn=new SQLite3($this->database);
$createtable="CREATE TABLE IF NOT EXISTS ".$this->table." (";
end($this->colluns);
$last=key($this->colluns);
foreach($this->colluns as $key => $value){
if($key!==$last){
$createtable.=$key." UNIQUE ON CONFLICT IGNORE,";
$this->keys.=$key.",";
$this->bind.=":".$key.",";
}else{
$createtable.=$key.")";
$this->keys.=$key;
$this->bind.=":".$key;
}
}
$conn->exec($createtable);
$conn->close();
$this->insertInDB();
}

private function insertInDB(){
if(file_exists($this->database) && is_file($this->database)){
try{
$this->connection = new PDO('sqlite:'.$this->database);
$this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
$this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
$this->connection->setAttribute(PDO::ATTR_ERRMODE,true);
$this->connection->setAttribute(PDO::ERRMODE_EXCEPTION,true);
}catch(PDOException $PDOexecption){
echo $PDOexecption->getMessage();
}
$this->sql="INSERT INTO ".$this->table." (".$this->keys.") VALUES (".$this->bind.")";
$this->commando($this->colluns);
}else{
die("File ".$this->database." not found");
}
}

public function commando(array $params){
$this->executa($this->sql,$params);
}

private function executa($sql,$params){
try{
$this->statement=$this->connection->prepare($sql);
if(is_object($this->statement)){
$this->statement->execute($params);
}
} catch(PDOException $PDOException){
print_r($PDOexecption->getMessage());
}
}

}

?>