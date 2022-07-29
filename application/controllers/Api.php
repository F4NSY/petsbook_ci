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
		$this->Api_Model->logout($sessionArray['userId'], 'Active', '');
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
		$this->Api_Model->logout($this->session->userdata('userId'), 'Inactive', date("n/j/Y, g:i:s A"));
		$this->session->sess_destroy();
		redirect('');
	}

	public function addFriend() {
        $addFriendParam = array(
            'senderId' => $this->session->userdata('userId'),
            'receiverId' => $this->input->post('receiverId'),
        );
		$this->Api_Model->addFriend($addFriendParam);

		return $this->response->createResponse($this, '', '', 200, 'ok');
	}

	public function confirmFriend() {
        $addFriendParam = array(
            'senderId' => $this->input->post('senderId'),
            'receiverId' => $this->session->userdata('userId'),
        );
		$this->Api_Model->confirmFriend($addFriendParam);

		return $this->response->createResponse($this, '', '', 200, 'ok');
	}

    public function getFriends()
	{
        if($this->input->method() != 'get') {
            return $this->response->createResponse($this, '', '', 405, '');
        }

		$responseIfEmpty = '';

        if($this->input->get('query') == '' || $this->input->get('query') == 'lists') {
            $friends = $this->Api_Model->getAllFriends();
			$responseIfEmpty .= '
				<div class="text-center fs-4 text-danger">
					Please browse for people in the suggestions to obtain friends.
				</div>
			';
        }
        if($this->input->get('query') == 'requests') {
            $friends = $this->Api_Model->getFriendRequests();
			$responseIfEmpty .= '
				<div class="text-center fs-4 text-danger">
					No friend requests found!
				</div>
			';
        }
        if($this->input->get('query') == 'suggestions') {
            $friends = $this->Api_Model->getNotFriends();
			$responseIfEmpty .= '
				<div class="text-center fs-4 text-danger">
					No friends suggestions as of the moment.
				</div>
			';
        }
        
        $response = '';
		if(count($friends) == 0) {
			$response .= $responseIfEmpty;
			return $this->response->createResponse($this, '', $response, 200, 'ok');
		}
        for($i = 0; $i < count($friends); $i++) {
			if($this->input->get('query') == '' || $this->input->get('query') == 'lists') {
				$cardButton = '<a href="' . base_url() . 'profile/' . $friends[$i]['userId'] . '" class="btn btn-primary">View</a>';
			}
			if($this->input->get('query') == 'requests') {
				$cardButton = '
					<button type="button" class="btn btn-primary" onclick="confirmFriend(\'' . $friends[$i]['userId'] . '\', \'requests\')">Confirm</button>
					<button type="button" class="btn">Delete</button>
				';
			}
			if($this->input->get('query') == 'suggestions') {
				$cardButton = '
					<button type="button" class="btn btn-primary" onclick="addFriend(\'' . $friends[$i]['userId'] . '\', \'suggestions\')">Add Friend</button>
				';
			}
			$pictureUrl = base_url() . 'profile/' . $friends[$i]['userId'];
            $cardImage = $friends[$i]['profilePicture'];
            $cardContent = '
				<a href="' . base_url() . 'profile/' . $friends[$i]['userId'] . '">
					<div class="card-title text-dark txt-overflow fw-bold">
						' . $friends[$i]['firstName'] . ' ' . $friends[$i]['lastName'] . '
					</div>
				</a>
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
				<a href="" class="link-dark" onclick="openConversation(event, \'' .  $user['userId'] . '\')">
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
		$conversation = $this->Api_Model->getConversations($this->input->get('userId'));
		if(count($conversation) == 0) {
			$response .= '
				<div class="text-center fs-4 text-danger">
					No Messages found!
				</div>
			';
			return $this->response->createResponse($this, '', $response, 200, 'ok');
		}
		$messages = $this->Api_Model->getMessages($conversation[0]['conversationId']);
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
		$user = $this->Api_Model->getUser(array('userId' => $this->input->get('userId')));

		return $this->response->createResponse($this, $user, '', 200, 'ok');
	}

	public function getPosts() {
		$response = '';
		$posts = $this->Api_Model->getPosts();
		if(count($posts) == 0) {
			$response .= '
				<div class="text-center fs-4 text-danger">
					No Posts found!
				</div>
			';
			return $this->response->createResponse($this, '', $response, 200, 'ok');
		}
		foreach($posts as $post) {
			$response .= '
				<div class="bg-light my-3 p-3 rounded-6">
					<div class="py-2">
						<div class="d-flex align-items-center">
							<img
								src="' . $post['profilePicture'] . '"
								class="rounded-circle me-3"
								height="45"
								width="45"
								style="object-fit: cover;"
							/>
							<div class="fs-7">
								<div class="fw-bold">
									' . $post['firstName'] . ' ' . $post['lastName'] . '
								</div>
								<div class="post-time" data-post-time="' . $post['createdAt'] . '">
								</div>
							</div>
						</div>
					</div>
					<div class="py-2">
						' . $post['content'] . '
					</div>'
					. ($post['image'] != '' || $post['video'] != '' ? '<div class="row" style="padding: 12px 12px 0px 12px;">
						<div class="container mb-4 p-0">
							<div class="swiper">
							<div class="swiper-wrapper">'
								. ($post['image'] != '' ? '<div class="swiper-slide px-1 d-flex justify-content-center align-items-center">
									<img class="swiperImg" src="' . base_url() . 'uploads/posts/images/' . $post['image'] . '">
								</div>' : '') .
								($post['video'] != '' ? '<div class="swiper-slide px-1 d-flex justify-content-center align-items-center">
									<iframe width="100%" height="300px" src="' . base_url() . 'uploads/posts/videos/' . $post['video'] . '" title="YouTube video" allowfullscreen></iframe>
								</div>' : '') .
							'</div>

							<!-- <div class="swiper-button-prev"></div> -->
							<!-- <div class="swiper-button-next"></div> -->

							</div>
						</div>
					</div>' : '') .
					'<div class="py-2 border-bottom border-top">
						<div class="row text-center">
							<div class="col cursor-pointer like-post" data-like-post="' . $post['postId'] . '"><i class="fas fa-thumbs-up me-2"></i>Like</div>
							<div class="col cursor-pointer" onclick="comment(\'' . $post['postId'] . '\')"><i class="fas fa-comment-alt me-2"></i>Comment</div>
						</div>
					</div>
					<div class="py-2">
						<div class="d-flex align-items-center">
							<img
								src="' . $this->session->userdata('profilePicture') . '"
								class="rounded-circle me-3"
								height="35"
								width="35"
								style="object-fit: cover;"
							/>
							<form class="d-flex flex-grow-1 fs-7">
								<input type="text" name="comment" id="comment-' . $post['postId'] . '" class="form-control form-control input-content" placeholder="Write a comment...">
								<button class="submit bg-primary" type="submit"><i class="fab fa-telegram-plane"></i></button>
							</form>
						</div>
					</div>
				</div>
			';
		}
		return $this->response->createResponse($this, '', $response, 200, 'ok');
	}

	public function insertPost() {
        $insertPostParam = array(
            'postId' => substr(md5(microtime()), rand(0,25), 6),
            'userId' => $this->session->userdata('userId'),
            'content' => $this->input->post('postContent'),
        );
		$insertPostParam['image'] = $this->uploadFiles($_FILES, 'postImage', $insertPostParam['postId'], 'posts/images');
		$insertPostParam['video'] = $this->uploadFiles($_FILES, 'postVideo', $insertPostParam['postId'], 'posts/videos');
		array_filter($insertPostParam);
		$this->Api_Model->insertPost($insertPostParam);

		return $this->response->createResponse($this, '', '', 200, 'ok');
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