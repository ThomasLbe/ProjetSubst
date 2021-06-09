<?php 
interface FollowStorage {
	
	public function read($id);
	public function readAll();
	public function suivre($id,$user);
	public function unfollow($id,$user);
	public function delete($id);
	public function update($id, Follow $c);
}
 ?>