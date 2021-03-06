<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {
	public function index($page = 'login')
	{
        if(!file_exists(APPPATH . 'views/user/' . $page . '.php')) {
            show_404();
        }
        $data['page'] = ucfirst($page) . 'aa';
        $this->load->view('user/template/header', $data);
        if($page != 'login' && $page != 'register') {
            $this->load->view('user/template/navbar');
        }
		$this->load->view('user/' . $page, $data);
        $this->load->view('user/template/footer');
	}

    public function friends($param = '')
    {
        $friendsUrl = array('lists', 'requests', 'suggestions');
        if(!empty($param) && (!in_array($param, $friendsUrl))) {
            show_404();
        }
        $data['page'] = 'Friends';
        $data['currentPath'] = $param;
        $this->load->view('user/template/header', $data);
        $this->load->view('user/template/navbar');
		$this->load->view('user/friends', $data);
        $this->load->view('user/template/footer');
    }

    public function profile($param = '')
    {
        $isExistingUser = $this->Api_Model->isExistingUser(array('userId' => $param));
        if(empty($param) || !$isExistingUser) {
            show_404();
        }
        $data['page'] = 'Profile';
        $data['user'] = $this->Api_Model->getUser(array('userId' => $param))[0];
        $this->load->view('user/template/header', $data);
        $this->load->view('user/template/navbar');
		$this->load->view('user/profile', $data);
        $this->load->view('user/template/footer');
    }

    public function chat($param = '')
    {
        $isExistingUser = $this->Api_Model->isExistingUser(array('userId' => $param));
        if(!empty($param) && !$isExistingUser) {
            show_404();
        }
        $data['page'] = 'Chat';
        $data['user'] = $this->Api_Model->getUser(array('userId' => $param));
        $this->load->view('user/template/header', $data);
        $this->load->view('user/template/navbar');
		$this->load->view('user/chat', $data);
        $this->load->view('user/template/footer');
    }
}
