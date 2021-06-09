<?php 
interface ClubStorage {
	
	public function read($id);
	public function readAll();
	public function readAllValide();
	public function valideclub($id);
	public function search($club);
	public function create(Club $a);
	public function delete($id);
}
 ?>