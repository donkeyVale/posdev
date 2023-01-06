<?php

class Conexion{

	static public function conectar(){

		$link = new PDO("mysql:host=147.182.174.137;dbname=pospruebas_db",
			            "root",
			            "d1sast3R");

		$link->exec("set names utf8");

		return $link;

	}

}
