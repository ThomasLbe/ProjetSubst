<?php 

interface CompteStorage {

	public function checkAuth($login, $pass);
	public function create(Compte $a);
	public function readAll();
	public function delete($id);
	public function prom($id);
}

 ?>