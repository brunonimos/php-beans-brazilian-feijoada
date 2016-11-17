<?php

require_once __DIR__.'/beans.php';

test1::aaa();

class test1 {

public function __construct(){
$this->att1['user']['login']="bbb";
$this->att1['user']['senha']="aaa";
$this->att2['aaa']="134545";
}

public static function aaa(){
$beans=new beans();
$beans->DAO("mydb.sql");
}

#ManagedBean
public $att1=array();

#ManagedBean
public $att2=array();

#ManagedBean
public $att3=4.56;

public $att4=false;

private $not1="not share";

}

?>