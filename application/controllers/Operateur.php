<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Operateur extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Operateur_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'operateur/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'operateur/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'operateur/index.html';
            $config['first_url'] = base_url() . 'operateur/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Operateur_model->total_rows($q);
        $operateur = $this->Operateur_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'operateur_data' => $operateur,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('operateur_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Operateur_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_Operateur' => $row->id_Operateur,
		'valeur' => $row->valeur,
		'NeedParameter' => $row->NeedParameter,
	    );
            $this->load->view('operateur_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('operateur'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('operateur/create_action'),
	    'id_Operateur' => set_value('id_Operateur'),
	    'valeur' => set_value('valeur'),
	    'NeedParameter' => set_value('NeedParameter'),
	);
        $this->load->view('operateur_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'valeur' => $this->input->post('valeur',TRUE),
		'NeedParameter' => $this->input->post('NeedParameter',TRUE),
	    );

            $this->Operateur_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('operateur'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Operateur_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('operateur/update_action'),
		'id_Operateur' => set_value('id_Operateur', $row->id_Operateur),
		'valeur' => set_value('valeur', $row->valeur),
		'NeedParameter' => set_value('NeedParameter', $row->NeedParameter),
	    );
            $this->load->view('operateur_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('operateur'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_Operateur', TRUE));
        } else {
            $data = array(
		'valeur' => $this->input->post('valeur',TRUE),
		'NeedParameter' => $this->input->post('NeedParameter',TRUE),
	    );

            $this->Operateur_model->update($this->input->post('id_Operateur', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('operateur'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Operateur_model->get_by_id($id);

        if ($row) {
            $this->Operateur_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('operateur'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('operateur'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('valeur', 'valeur', 'trim|required');
	$this->form_validation->set_rules('NeedParameter', 'needparameter', 'trim|required');

	$this->form_validation->set_rules('id_Operateur', 'id_Operateur', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Operateur.php */
/* Location: ./application/controllers/Operateur.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-05-22 14:15:32 */
/* http://harviacode.com */