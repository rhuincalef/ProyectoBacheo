<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//TODO Comentar! Clase de firephp utilizada para la depuración.
require_once('FirePHP.class.php');

class Auth extends CI_Controller {
	# TODO: CREAR UN CONTROLADOR APARTE PARA ESTAS COSAS
	public function __construct() {
	    parent::__construct();
	    $this->load->library('ion_auth');
	    $this->load->library('form_validation');
	    $this->load->helper('url');

	    /* Se tiene en cuenta para los mensajes de la librería ion-auth*/
	    $this->lang->load('auth');
		$this->load->helper('language');

	}

	public function login_via_ajax() {
		$firephp = FirePHP::getInstance(True);
		$identity = $this->input->post('login_identity');
		$password = $this->input->post('login_password');
		// $remember = $this->input->post('remember_me');
		$firephp->log($identity);
	    $firephp->log($password);
	    # Usar si es necesario enviar mas info del usuario
	    // $user = $this->ion_auth->user()->row();
	    if ($this->ion_auth->logged_in())
		{
			$username = $this->ion_auth->user()->row()->username;
			echo json_encode(array('status' => 'OK','data' => array('login_identity' => $username, 'logged_in' => 'Ya se encuentra logeado.')));
		}
		else
		{
			if($this->ion_auth->login($identity, $password))
			{
				//if the login is successful
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				echo json_encode(array('status' => 'OK','data' => array('login_identity' => $identity)));
			}
			else
			{
				//if the login was un-successful
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				echo json_encode(array('status' => 'ERROR', 'data' => $this->ion_auth->errors()));
			}
		}
	}

	public function logout()
	{
		//log the user out
		$logout = $this->ion_auth->logout();

		//redirect them to the login page
		$this->session->set_flashdata('message', $this->ion_auth->messages());
		// redirect('auth/login', 'refresh');
	}

	public function registrarUsuario()
	{
		$data['logueado'] = $this->ion_auth->logged_in();
		if ($data['logueado']) {
			$data['usuario'] = $this->ion_auth->user()->row()->username;
		}
		$this->template->build_page("registrarUsuario",$data);
	}

	public function create_user()
	{
		$firephp = FirePHP::getInstance(True);

		// Set validation rules.
		// The custom rules 'identity_available' and 'validate_password' can be found in '../libaries/MY_Form_validation.php'.
		$validation_rules = array(
			array('field' => 'register_first_name', 'label' => 'First Name', 'rules' => 'required'),
			array('field' => 'register_last_name', 'label' => 'Last Name', 'rules' => 'required'),
			array('field' => 'register_phone_number', 'label' => 'Phone Number', 'rules' => 'xss_clean'),
			// array('field' => 'register_newsletter', 'label' => 'Newsletter', 'rules' => 'integer'),
			array('field' => 'register_email_address', 'label' => 'Email Address', 'rules' => 'required|valid_email|identity_available'),
			array('field' => 'register_username', 'label' => 'Username', 'rules' => 'required|min_length[4]|identity_available'),
			array('field' => 'register_password', 'label' => 'Password', 'rules' => 'required|validate_password'),
			array('field' => 'register_confirm_password', 'label' => 'Confirm Password', 'rules' => 'required|matches[register_password]')
		);
		$this->form_validation->set_rules($validation_rules);

		// Run the validation.
		if ($this->form_validation->run())
		{
			$firephp->log('Pasa la validacion.');
			// Get user login details from input.
			$username = $this->input->post('register_username');
			$password = $this->input->post('register_password');
			$email = $this->input->post('register_email_address');
			$additional_data = array(
									'first_name' => $this->input->post('register_first_name'),
									'last_name' => $this->input->post('register_last_name'),
									'phone' => $this->input->post('register_phone_number'),
									 'email' => $this->input->post('register_email_address')
									);
			$group = array('2'); // Sets user to public. No need for array('1', '2') as user is always set to member by default

			$firephp->log($username);
			$firephp->log($password);
			$firephp->log($email);
			$firephp->log($additional_data);
			$firephp->log($group);

			if ($this->ion_auth->register($username, $password, $email, $additional_data, $group))
			{
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				// $this->data['message'] = $this->ion_auth->errors();
				echo json_encode(array('status' => 'OK', 'message' => 'Your account has successfully been created.'));
			}
			else{
				$firephp->log('No se pudo registrar el usuario.');
				$this->session->flashdata('message');
				echo json_encode(array('status' => 'ERROR', 'message' => $this->ion_auth->errors()));
				// echo $this->ion_auth->errors();
			}			
		}
		else
		{
			$firephp->log('No pasa la validacion.');
			// echo validation_errors();
			echo json_encode(array('status' => 'ERROR', 'message' => validation_errors()));
		}
	}
}
?>