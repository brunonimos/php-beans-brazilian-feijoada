<?php

test2::aaa();

class test2 {
			
public $att5="Text";

#ManagedBean
public $att6=169454;

#ManagedBean
public $att7=40.96;

public $att8=true;

#ManagedBean
public $attx="AAA";

private $not2="not share";

public static function aaa(){
$beans=new beans();
$beans->DAO("mydb.sql");
}

}

?>