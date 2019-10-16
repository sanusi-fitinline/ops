<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Push extends CI_Controller {

	public function index()
	{
		$this->load->view('coba_push');
	}

	public function push1()
	{
		$this->load->view('coba_push1');
	}

	public function push2()
	{
		$this->load->view('coba_push2');
	}

	public function push3()
	{
		$this->load->view('coba_push3');
	}

	public function process() {
		require_once(APPPATH.'third_party/pusher/vendor/autoload.php');
		$options = array(
			'cluster' => 'ap1',
			'useTLS' => true
		);
		$pusher = new Pusher\Pusher(
			'3de920bf0bfb448a7809',
			'0799716e5d66b96f5b61',
			'845132',
			$options
		);

		$data['message'] = "Hello World , I'm Realtime Notification";
		$pusher->trigger('push-notif', 'my-event', $data);
	}
}
