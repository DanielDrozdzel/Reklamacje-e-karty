<?php


abstract class DatabaseCon extends PHPUnit_Extensions_Database_TestCase
{
	static protected $pdo = null;
	
	private $conn = null;
	
	protected $mocked;
	
    public function getConnection() {	
		if($this->conn === null) {
			if(self::$pdo === null) {
				self::$pdo = new PDO('sqlite:reklamacja.sqlite');
				self::$pdo->exec("create table if not exists reklamacje(id INTEGER PRIMARY KEY, data TEXT, imie VARCHAR(50), 
							nazwisko VARCHAR(100), karta VARCHAR(11), kwota VARCHAR(6), stan VARCHAR (10), miejsce VARCHAR(4), ekstra TEXT)");
			}
		$this->conn = $this->createDefaultDBConnection(self::$pdo, ':reklamacja:');
		}
		return $this->conn;
	}
	
	public function getDataSet() {
		return $this->createXMLDataSet('rek_xml.xml');
	}
	
	public function setUp()
    {
       $mocked_controller = $this->getMockBuilder("\app\controller\Controller")->setMethods(array("getAll", "findDestination", "setWynikModel"))->getMock();
	   
	   $map = array("id"=>null, "data"=>"01-05-2015", "imie"=>"daniel", "nazwisko"=>"danielewicz", "karta"=>"00000000001", "kwota"=>"8,00","stan"=>null, "miejsce"=>"Mps", "extra"=>null);
	   
	   $mocked_controller->method("getAll")->willReturn($map);
	   $mocked_controller->method("findDestination")->willReturn("zapisz");
	   
	   $this->mocked = $mocked_controller;
    }
	
	public function tearDown() {
		self::$pdo->exec("delete from reklamacje");
	}
   
   public function buildMocked($return, array $tablica) {
	   $mocked_controller2 = $this->getMockBuilder("\app\controller\Controller")->setMethods(array("getAll", "findDestination", "setWynikModel"))->getMock();
	   
	   $mocked_controller2->method("getAll")->willReturn($tablica);
	   $mocked_controller2->method("findDestination")->willReturn($return);
	   
	   $this->mocked_actual = $mocked_controller2;
   }
   
   public function met_controller($controller, array $wynik){
	 $controller->expects($this->once())->method("getAll");
	 $controller->expects($this->once())->method("findDestination");
	 $controller->expects($this->once())->method("setWynikModel")->with($this->equalTo($wynik));
   }
   
}

?>