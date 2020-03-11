<?php
	/**
	 * Синглтон подключение к БД
	 */
	class singlePDO{
		private static $construct_data;
		//private $host, $name_bd, $user_name, $user_password;
		private function __construct()
		{

		}

		public static function GetInst($host, $name_bd, $user_name, $user_password){

			if(self::$construct_data != null){
				$construct_temp['host'] = $host;
				$construct_temp['name_bd'] = $name_bd;
				$construct_temp['user_name'] = $user_name;
				$construct_temp['user_password'] = $user_password;
				foreach (self::$construct_data as $key => $value) {
					var_dump($value); echo "<br>";
					var_dump($construct_temp); echo "<br>";
					if ($value['host'] === $construct_temp['host']
					and $value['name_bd'] === $construct_temp['name_bd']
					and $value['user_name'] === $construct_temp['user_name']
					and $value['user_password'] === $construct_temp['user_password'])
					{
						return self::$construct_data[$key]['singlePDO'];
					}
				}
				$singlePDO = new singlePDO();
				$pdo = new PDO('mysql:host=' .$host. ';dbname=' .$name_bd. '', $user_name, $user_password);
				$key = count(self::$construct_data)+1;
				self::$construct_data[$key] = ['singlePDO'=>$singlePDO, 'pdo' => $pdo, 'host' => $host, 'name_bd' => $name_bd, 'user_name' => $user_name, 'user_password' => $user_password];
				return self::$construct_data[$key]['singlePDO'];
			}
			else{
					$singlePDO = new singlePDO();
					$pdo = new PDO('mysql:host=' .$host. ';dbname=' .$name_bd. '', $user_name, $user_password);
					self::$construct_data[0] = ['singlePDO'=>$singlePDO, 'pdo' => $pdo, 'host' => $host, 'name_bd' => $name_bd, 'user_name' => $user_name, 'user_password' => $user_password];
					return self::$construct_data[0]['singlePDO'];
			}
		}

		public static function printConnectAll(){
			if(self::$construct_data != null){
				foreach (self::$construct_data as $key => $value) {
						var_dump(self::$construct_data[$key]['singlePDO']); echo "<br>";
						var_dump(self::$construct_data[$key]['pdo']); echo "<br>";
						echo "Host - ". self::$construct_data[$key]['host']."<br>";
						echo "Name Data Base - ". self::$construct_data[$key]['name_bd']."<br>";
						echo "User Name - ". self::$construct_data[$key]['user_name']."<br><br>";
				}
			}
			else{
				echo "printConnectAll - Нет активных соединений.<br>";
			}
		}

		private function GetPDO(){
			$key = array_search($this, array_column(self::$construct_data, 'singlePDO'));
			return self::$construct_data[$key]['pdo'];
		}

		public function GetInfoConnect(){
			$key = array_search($this, array_column(self::$construct_data, 'singlePDO'));
			return self::$construct_data[$key];
		}

		public function prepare($insertQuery){
			$pdo = $this->GetPDO();
			return $pdo->prepare($insertQuery);
		}

		public function quote($str){
			$pdo = $this->GetPDO();
			return $pdo->quote($str);
		}

		public function query($selectQuery){
			$pdo = $this->GetPDO();
			return $pdo->query($selectQuery);
		}

		public function lastInsertId(){
			$pdo = $this->GetPDO();
			return $pdo->lastInsertId();
		}
	}
