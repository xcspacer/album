<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("Login_model");
	}
	public function index()
	{
		$data["title"] = "Login";
		$this->load->view('home/login', $data);
	}
	public function access()
	{
		$email = $_POST["email"];
		$password = md5($_POST["password"]);
		$user = $this->Login_model->access($email, $password);
		if ($user) {
			$this->session->set_userdata("logged_user", $user);
			$user = array(
				"user" => $_SESSION["logged_user"]["id"],
				"ip" => $_SERVER["REMOTE_ADDR"],
				"hostname" => gethostbyaddr($_SERVER['REMOTE_ADDR']),
			);
			$this->Login_model->userAccess($user);
			redirect(base_url());
		} else {
			$user = array(
				"email" => $email,
				"password" =>  $password,
				"ip" => $_SERVER["REMOTE_ADDR"],
				"hostname" => gethostbyaddr($_SERVER['REMOTE_ADDR']),
			);
			$this->Login_model->userRefused($user);
			$this->session->set_flashdata('msg', '<div class="alert alert-danger">Dados inválidos!</div>');
			redirect(base_url('login'));
		}
	}
	public function logout()
	{
		$this->session->unset_userdata("logged_user");
		redirect(base_url());
	}
	public function passwordForgot()
	{
		$data["title"] = "Recuperar Senha";
		$this->load->view('home/passwordForgot', $data);
	}
	public function forward()
	{
		$email = $this->input->post('email');
		$login = $this->Login_model->checkEmail($email);
		if ($login == null) {
			echo "<div class='divmsg alert alert-danger'>E-mail não cadastrado!</div>";
		} else {
			$hash = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789', 5)), 10, 8);
			$this->Login_model->newHash($email, $hash);
			$this->sendEmail($email, $hash);
			echo "<div class='divmsg alert alert-success'>Instruções enviadas, verique seu e-mail.</div>";
		}
	}
	public function sendEmail($email, $hash)
	{
		$data['email'] = $email;
		$data['hash'] = $hash;
		$this->load->library('email');
		$config['charset'] = 'UTF-8';
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'html';
		$config['protocol'] = 'smtp';
		$config['smtp_crypto'] = 'ssl';
		$config['smtp_host'] = '';
		$config['smtp_user'] = '';
		$config['smtp_pass'] = '';
		$config['smtp_port'] = 465;
		$this->email->initialize($config);
		$this->email->from('mail@mail.com', '');
		$this->email->to($email);
		$this->email->subject('Recuperar Senha');
		$this->email->message($this->load->view('emails/password', $data, TRUE));
		if ($this->email->send() === TRUE) {
			return true;
		} else {
			return false;
		}
	}
	public function passwordRedefine($hash = NULL)
	{
		$data["title"] = "Redefinir Senha";
		$data['flash'] = $this->session->flashdata();
		$data['admin'] = $this->Login_model->getHash($hash);
		if ($data['admin'] == null) {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger">Link inválido ou expirado!</div>');
			redirect(base_url('login'));
		}
		$this->load->view('home/passwordRedefine', $data);
	}
	public function newPassword($hash = NULL)
	{
		$hash = $this->input->post('hash');
		$password = md5($this->input->post('password'));
		$confirmPassword = md5($this->input->post('confirmPassword'));
		$admin = $this->Login_model->getHash($hash);
		if ($admin == null) {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger">Link inválido!</div>');
			redirect(base_url('login'));
		}
		if ($this->input->post('password') !== $this->input->post('confirmPassword')) {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger">Senhas digitadas não conferem!</div>');
			redirect(base_url('login/passwordRedefine/' . $hash));
		}
		$this->Login_model->newPassword($admin[0]->id, $password);
		$this->Login_model->deleteHash($admin[0]->id);
		$this->session->set_flashdata('msg', '<div class="alert alert-success">Senha alterada!</div>');
		redirect(base_url('login'));
	}
}