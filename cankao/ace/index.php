<?php
// $dsn = "mysql:host=localhost;dbname=test";
// $db = new PDO($dsn, 'root', '111111');
// $db->setAttribute(PDO::ATTR_CASE, PDO::CASE_UPPER);
// // $count = $db->exec("INSERT INTO foo SET name = 'heiyeluren',gender='男',time=NOW()");
// // echo $count;

// // foreach($db->query("SELECT * FROM foo") as $row){
// //     print_r($row);
// // }

// // 

// $rs = $db->query("SELECT * FROM foo");
// while($row = $rs->fetch()){
//     print_r($row);
// }



abstract  class A
{
	public static $xx=123;
	public function __construct()
	{
		 
	}
	public  function t()
	{
		// echo static::$xx;
		static::test();
	}


	public static function  test()
	{
		echo "ptest\n";
		echo "parents";
	}
}

class B extends A{
	 
public static $xx=1223;
	public static function test()
	{
		echo "construct\n";
		echo "child";
	}

	public function getName()
	{
		return "xxx";
	}

	function __get($property)
	{
		$method="get$property";
		if(method_exists($this, $method))
			return $this->$method();
	}

	function xxxx($xxx)
	{
		echo "xxxx";
		var_dump($xxx);
	}
}


class C
{
	public $part;
	function __call($method,$args)
	{
		if(method_exists($this->part, $method))
			return $this->part->$method($args);
	}

	function __construct($x)
	{
		$this->part=$x;
	}

	public $xxx;
	function __clone()
	{
		$this->xxx="123";
	}
}
$b=new B();
$c =new C($b);
$c->xxx="321";
$d=clone $c;
var_dump($d);
var_dump($c);
die();



$cc=$c;

$cc->part=new B();

var_dump($c);
var_dump($cc);


function &test()
{
	static $b=0;//申明一个静态变量
	$b=$b+1;
	echo $b;
	return $b;
}

$a=test();//这条语句会输出　$b的值　为１
$a=5;
$a=test();//这条语句会输出　$b的值　为2

$a=&test();//这条语句会输出　$b的值　为3
$a=5;
$a=test();//这条语句会输出　$b的值　为6