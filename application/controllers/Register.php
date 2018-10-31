<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
        $this->load->library(array('ion_auth','form_validation'));
        $this->load->helper(array('url','language'));

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
	}
	public function index()
	{
    	$this->data['title'] = $this->lang->line('create_user_heading');
        $this->data['m_description']='Kerjakerja, Berdikari';
        $this->data['m_keyword']='Berita Terkini, Info Grafis - Register';
        $this->template->display('members/register',$this->data);
	}
    public function create_account()
    {
        $this->data['title'] = $this->lang->line('create_user_heading');
        $tables = $this->config->item('tables','ion_auth');
        $identity_column = $this->config->item('identity','ion_auth');
        $this->data['identity_column'] = $identity_column;

        $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'required');
        $this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'required');
        $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email|is_unique[' . $tables['users'] . '.email]');
        $this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'trim');
        $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

        if ($this->form_validation->run()===TRUE)
        {
            $email    = strtolower($this->input->post('email'));
            $identity = ($identity_column==='email') ? $email : $this->input->post('identity');
            $password = $this->input->post('password');

            $additional_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name'  => $this->input->post('last_name'),
                'phone'      => $this->input->post('phone'),
            );

            $this->ion_auth->register($identity, $password, $email, $additional_data);
            $info['success']=TRUE;
            $info['message']='Successfully';
        }else{
            $info['success']=FALSE;
            $info['errors']=validation_errors();
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($info));
    }
}

/* End of file Register.php */
/* Location: ./application/controllers/Register.php */