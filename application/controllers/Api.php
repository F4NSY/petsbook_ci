<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {
    public function login()
	{
		if($this->input->method() != 'post') {
            return $this->response->createResponse($this, '', '', 405, '');
        }
		$credentials = array('email' => $this->input->post('email') , 'password' => md5($this->input->post('password')));
		if(!$this->Api_Model->login($credentials)){
			return $this->response->createResponse($this, '', '', 400, 'invalid-credentials');
		}
		$user = $this->Api_Model->getUser(array('email' => $credentials['email']))[0];
		$sessionArray = array(
			'name' => $user['firstName'] . ' ' . $user['lastName'],
			'userId' => $user['userId'],
			'profilePicture' => $user['profilePicture'],
			'isLoggedIn' => TRUE
		);
		$this->session->set_userdata($sessionArray);
		return $this->response->createResponse($this, '', '', 200, 'ok');
	}

	public function register()
	{	
		if($this->input->method() != 'post') {
            return $this->response->createResponse($this, '', '', 405, '');
        }
		if($this->Api_Model->isExistingUser(array('email' => $this->input->post('emailRegister')))){
			return $this->response->createResponse($this, '', '', 400, 'duplicate-email');
		}
		$userId = substr(md5(microtime()), rand(0,25), 6);
		$data = array(
			'userId' => $userId,
			'firstName' => $this->input->post('firstNameRegister'),
			'lastName' => $this->input->post('lastNameRegister'),
			'email' => $this->input->post('emailRegister'),
			'password' => md5($this->input->post('passwordRegister')),
			'birthday' => $this->input->post('birthdayRegister'),
			'gender' => $this->input->post('genderRegister'),
			'profilePicture' => base_url() . 'assets/images/default_profile.jpg'
		);
		if($this->Api_Model->register($data)){
			return $this->response->createResponse($this, '', '', 201, 'created');
		}
		return $this->response->createResponse($this, '', '', 500, 'unexpected-error');
	}

	public function logout() {
		$this->session->sess_destroy();
		redirect('');
	}

    public function getFriends()
	{
        if($this->input->method() != 'get') {
            return $this->response->createResponse($this, '', '', 405, '');
        }

        if($this->input->get('query') == '' || $this->input->get('query') == 'lists') {
            $friends = $this->Api_Model->getAllFriends();
            $cardButton = '<a href="#!" class="btn btn-primary">View</a>';
        }
        if($this->input->get('query') == 'requests') {
            $friends = $this->Api_Model->getFriendRequests();
            $cardButton = '
				<a href="#!" class="btn btn-primary">Confirm</a>
				<a href="#!" class="btn">Delete</a>
			';
        }
        if($this->input->get('query') == 'suggestions') {
            $friends = $this->Api_Model->getNotFriends();
            $cardButton = '
				<a href="#!" class="btn btn-primary">Add Friend</a>
				<a href="#!" class="btn">Remove</a>
			';
        }
        
        $response = '';

        for($i = 0; $i < count($friends); $i++) {
            $cardImage = base_url() . 'assets/images/default_profile.jpg';
            $cardContent = '
				<div class="card-title txt-overflow fw-bold">
					' . $friends[$i]['firstName'] . ' ' . $friends[$i]['lastName'] . '
				</div>
				<p class="card-text txt-overflow">
					23 mutual friends
				</p>
				<div class="d-grid gap-2">
					' . $cardButton . '
				</div>
			';
            $response .= '<div class="d-flex justify-content-center col-xl-3 col-lg-4 col-md-6 mb-3" >';

            ob_start();
            include APPPATH . 'views/user/components/card-component.php';
            $response .=  ob_get_clean();
            $response .= '</div>';
        }

        return $this->response->createResponse($this, '', $response, 200, 'ok');
	}
	public function getConversations() {
		$response = '';
		$conversations = $this->Api_Model->getConversations();
		if(count($conversations) == 0) {
			$response .= '
				<div class="text-center fs-4 text-danger">
					No Conversations found!
				</div>
			';
			return $this->response->createResponse($this, '', $response, 200, 'ok');
		}
		foreach($conversations as $conversation) {
			$recentMessage = $this->Api_Model->getRecentMessage($conversation['conversationId'])[0];
			$userId['userId'] = $conversation['senderId'];
			if($userId['userId'] == $this->session->userdata('userId')) {
				$userId['userId'] = $conversation['receiverId'];
			}
			$user = $this->Api_Model->getUser($userId)[0];
			$response .= '
				<a href="" class="link-dark" onclick="openConversation(event, \'' . $conversation['conversationId'] . '\')">
					<div class="mb-4 d-flex align-items-center pe-3">
						<img
							src="' . $user['profilePicture'] . '"
							class="rounded-circle me-3"
							height="50"
							width="50"
							style="object-fit: cover;"
						/>
						<div class="flex-grow-1">
							<div>
								' . $user['firstName'] . ' ' . $user['lastName'] . '
							</div>
							<div>
								' . $recentMessage['content'] . '
							</div>
						</div>
						<div>
							<div class="status-dot"><i class="fas fa-circle"></i></div>
						</div>
					</div>
				</a>
			';
		}
		return $this->response->createResponse($this, '', $response, 200, 'ok');
	}

	public function getMessages() {
		$response = '';
		$messages = $this->Api_Model->getMessages($this->input->get('conversationId'));
		if(count($messages) == 0) {
			$response .= '
				<div class="text-center fs-4 text-danger">
					No Messages found!
				</div>
			';
			return $this->response->createResponse($this, '', $response, 200, 'ok');
		}
		$userId['userId'] = $messages[0]['senderId'];
		if($userId['userId'] == $this->session->userdata('userId')) {
			$userId['userId'] = $messages[0]['receiverId'];
		}
		$user = $this->Api_Model->getUser($userId)[0];
		foreach($messages as $message) {
			if($message['senderId'] == $this->session->userdata('userId')){
				$response .= '
					<div class="chat outgoing d-flex">
						<div class="details align-self-center">
							' . ($message['content'] != '' ? '<p class="m-0">' . $message['content'] . '</p>' : '') . '
							' .($message['image'] != '' ? '<img class="mt-2 border" style="cursor: pointer;" onclick="viewChatImage(\'' . $message['image'] .'\')" src="' . base_url() . 'uploads/messages/' . $message['image'] . '">' : '') . '
						</div>
					</div>
				';
				continue;
			}
			$response .= '
				<div class="chat incoming d-flex">
					<img src="' . $user['profilePicture'] . '" class="user align-self-end me-2">
					<div class="details align-self-center">
						' . ($message['content'] != '' ? '<p class="m-0">' . $message['content'] . '</p>' : '') . '
						' .($message['image'] != '' ? '<img class="mt-2 border" style="cursor: pointer;" onclick="viewChatImage(\'' . $message['image'] .'\')" src="' . base_url() . 'uploads/messages/' . $message['image'] . '">' : '') . '
					</div>
				</div>
			';
		}
		return $this->response->createResponse($this, '', $response, 200, 'ok');
	}

	public function sendMessage() {
        $sendMessageParam = array(
            'senderId' => $this->session->userdata('userId'),
            'receiverId' => $this->input->post('receiverId'),
            'content' => $this->input->post('chatContent'),
        );
		$conversation = $this->Api_Model->getConversations($sendMessageParam['receiverId']);
		if(count($conversation) == 0) {
			$sendMessageParam['conversationId'] = substr(md5(microtime()), rand(0,25), 6);
			$sendMessageParam['image'] = $this->uploadFiles($_FILES, 'chatImage', $sendMessageParam['conversationId'], 'messages');
			array_filter($sendMessageParam);
			$this->Api_Model->createConvo($sendMessageParam);
			$this->Api_Model->sendMessage($sendMessageParam);

			return $this->response->createResponse($this, '', '', 200, 'ok');
		}
		$sendMessageParam['conversationId'] = $conversation[0]['conversationId'];
		$sendMessageParam['image'] = $this->uploadFiles($_FILES, 'chatImage', $sendMessageParam['conversationId'], 'messages');
		array_filter($sendMessageParam);
		$this->Api_Model->sendMessage($sendMessageParam);

		return $this->response->createResponse($this, '', '', 200, 'ok');
	}

	public function getUser() {
		$users = $this->Api_Model->getMessages($this->input->get('getUserParam'));
		$getUserParam['userId'] = $users[0]['senderId'];
		if($getUserParam['userId'] == $this->session->userdata('userId')) {
			$getUserParam['userId'] = $users[0]['receiverId'];
		}
		$user = $this->Api_Model->getUser($getUserParam)[0];

		return $this->response->createResponse($this, $user, '', 200, 'ok');
	}

	public function uploadFiles($files, $elementName, $subStringFileName, $fileUploadPath) {
		$fileName = $files[$elementName]['name'];
		$fileTmpName = $files[$elementName]['tmp_name'];
		$extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
		$fileNewName = $subStringFileName . '-' . substr(md5(microtime()), rand(0,25), 8);
		$fileUploadName = $fileNewName . '.' . $extension;
		if(!empty($fileName)){
			move_uploaded_file($fileTmpName, './uploads/' . $fileUploadPath . '/' . $fileUploadName);

			return $fileUploadName;
		}

		return '';
	}
}