<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Unite extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Unite_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'unite/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'unite/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'unite/index.html';
            $config['first_url'] = base_url() . 'unite/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Unite_model->total_rows($q);
        $unite = $this->Unite_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'unite_data' => $unite,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('unite_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Unite_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_Unite' => $row->id_Unite,
		'libelle' => $row->libelle,
		'SDUM' => $row->SDUM,
		'Valeur' => $row->Valeur,
	    );
            $this->load->view('unite_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('unite'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('unite/create_action'),
	    'id_Unite' => set_value('id_Unite'),
	    'libelle' => set_value('libelle'),
	    'SDUM' => set_value('SDUM'),
	    'Valeur' => set_value('Valeur'),
	);
        $this->load->view('unite_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'libelle' => $this->input->post('libelle',TRUE),
		'SDUM' => $this->input->post('SDUM',TRUE),
		'Valeur' => $this->input->post('Valeur',TRUE),
	    );

            $this->Unite_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('unite'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Unite_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('unite/update_action'),
		'id_Unite' => set_value('id_Unite', $row->id_Unite),
		'libelle' => set_value('libelle', $row->libelle),
		'SDUM' => set_value('SDUM', $row->SDUM),
		'Valeur' => set_value('Valeur', $row->Valeur),
	    );
            $this->load->view('unite_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('unite'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_Unite', TRUE));
        } else {
            $data = array(
		'libelle' => $this->input->post('libelle',TRUE),
		'SDUM' => $this->input->post('SDUM',TRUE),
		'Valeur' => $this->input->post('Valeur',TRUE),
	    );

            $this->Unite_model->update($this->input->post('id_Unite', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('unite'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Unite_model->get_by_id($id);

        if ($row) {
            $this->Unite_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('unite'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('unite'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('libelle', 'libelle', 'trim|required');
	$this->form_validation->set_rules('SDUM', 'sdum', 'trim|required');
	$this->form_validation->set_rules('Valeur', 'valeur', 'trim|required');

	$this->form_validation->set_rules('id_Unite', 'id_Unite', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Unite.php */
/* Location: ./application/controllers/Unite.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2016-10-21 12:59:52 */
/* http://harviacode.com */