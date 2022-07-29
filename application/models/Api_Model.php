<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_Model extends CI_Model {
    public function register($param){
		if($this->db->insert('users', $param)){
			return true;
		}else{
			return false;
		}
	}

	public function login($param){
		if($this->db->get_where('users', $param)->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function logout($id, $status, $lastSeen){
		$this->db->set(array('status' => $status, 'lastSeen' => $lastSeen));
        $this->db->where('userId', $id);
        $this->db->update('users');
	}

	public function isExistingUser($param){
		if($this->db->get_where('users', $param)->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function getUser($param){
		return $this->db->get_where('users', $param)->result_array();
	}

	public function addFriend($param){
		if($this->db->insert('user_friends', $param)){
			return true;
		}else{
			return false;
		}
	}

	public function confirmFriend($param){
		$this->db->set(array('status' => 'Accepted'));
        $this->db->where($param);
        $this->db->update('user_friends');
	}

	public function getAllFriends(){
		$query = "SELECT users.* FROM users LEFT JOIN user_friends ON users.userId = user_friends.senderId OR users.userId = user_friends.receiverId WHERE user_friends.id IS NOT NULL AND user_friends.status = 'Accepted' AND ((user_friends.senderId = '" . $this->session->userdata('userId') . "' AND user_friends.receiverId = users.userId) OR (user_friends.receiverId = '" . $this->session->userdata('userId') . "' AND user_friends.senderId = users.userId));";

		return $this->db->query($query)->result_array();
	}

	public function getFriendRequests(){
		$query = "SELECT users.* FROM users LEFT JOIN user_friends ON users.userId = user_friends.senderId WHERE user_friends.receiverId = '" . $this->session->userdata('userId') . "' AND user_friends.id IS NOT NULL AND user_friends.status = 'Pending';";

		return $this->db->query($query)->result_array();
	}

	public function getNotFriends() {
		$query = "SELECT * FROM users WHERE users.userId != '" . $this->session->userdata('userId') . "' AND users.userId NOT IN (SELECT users.userId FROM users LEFT JOIN user_friends ON users.userId = user_friends.senderId OR users.userId = user_friends.receiverId WHERE user_friends.id IS NOT NULL AND (user_friends.status = 'Accepted' OR user_friends.status = 'Pending') AND ((user_friends.senderId = '" . $this->session->userdata('userId') . "' AND user_friends.receiverId = users.userId) OR (user_friends.receiverId = '" . $this->session->userdata('userId') . "' AND user_friends.senderId = users.userId)));";

		return $this->db->query($query)->result_array();
	}

	public function getConversations($getConversationsParam = ''){
		if(!empty($getConversationsParam)) {
			$query = "SELECT * FROM conversations WHERE (senderId = '" . $this->session->userdata('userId') . "' AND receiverId = '" . $getConversationsParam . "') OR (senderId = '" . $getConversationsParam . "' AND receiverId = '" . $this->session->userdata('userId') . "')";

			return $this->db->query($query)->result_array();
		}
		$query = "SELECT * FROM conversations WHERE senderId = '" . $this->session->userdata('userId') . "' OR receiverId = '" . $this->session->userdata('userId') . "'";

		return $this->db->query($query)->result_array();
	}

	public function getRecentMessage($param){
		$query = "SELECT * FROM messages WHERE conversationId = '" . $param . "' ORDER BY id DESC LIMIT 1";

		return $this->db->query($query)->result_array();
	}

	public function getMessages($param){
        $query = "SELECT * FROM messages WHERE conversationId = '" . $param . "'";

		return $this->db->query($query)->result_array();
    }

	public function sendMessage($param){
		if($this->db->insert('messages', $param)){
			return true;
		}else{
			return false;
		}
	}

	public function createConvo($param){
        $data = array(
            'conversationId' => $param['conversationId'],
            'senderId' => $param['senderId'],
            'receiverId' => $param['receiverId']
        );
		if($this->db->insert('conversations', $data)){
			return true;
		}else{
			return false;
		}
	}

	public function getPosts() {
		$query = "SELECT posts.postId, posts.content, posts.image, posts.video, posts.createdAt, users.firstName, users.lastName, users.profilePicture FROM posts LEFT JOIN users ON posts.userId = users.userId WHERE posts.userId = '" . $this->session->userdata('userId') . "' OR posts.userId IN (SELECT users.userId FROM users LEFT JOIN user_friends ON users.userId = user_friends.senderId OR users.userId = user_friends.receiverId WHERE user_friends.id IS NOT NULL AND user_friends.status = 'Accepted' AND ((user_friends.senderId = '" . $this->session->userdata('userId') . "' AND user_friends.receiverId = users.userId) OR (user_friends.receiverId = '" . $this->session->userdata('userId') . "' AND user_friends.senderId = users.userId))) ORDER BY posts.createdAt DESC;";

		return $this->db->query($query)->result_array();
	}

	public function insertPost($param){
		if($this->db->insert('posts', $param)){
			return true;
		}else{
			return false;
		}
	}
}
