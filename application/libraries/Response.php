<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Response {
    public function createResponse($controller, $data, $html, $statusCode, $message) {
		$output = array(
			'statusCode' => $statusCode,
			'message' => $message
		);
		if(!empty($data)) {
			$output['data'] = $data;
		}
		if(!empty($html)) {
			$output['html'] = $html;
		}
        return $controller->output
		->set_content_type('application/json')
		->set_status_header($statusCode)
		->set_output(json_encode($output));
    }
}