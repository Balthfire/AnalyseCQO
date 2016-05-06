<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Changemet_statut extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Changemet_statut_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'changemet_statut/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'changemet_statut/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'changemet_statut/index.html';
            $config['first_url'] = base_url() . 'changemet_statut/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Changemet_statut_model->total_rows($q);
        $changemet_statut = $this->Changemet_statut_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'changemet_statut_data' => $changemet_statut,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('changemet_statut_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Changemet_statut_model->get_by_id($id);
        if ($row) {
            $data = array(
		'Date_changement' => $row->Date_changement,
		'id_Statut' => $row->id_Statut,
		'NNI' => $row->NNI,
		'id_Controle' => $row->id_Controle,
	    );
            $this->load->view('changemet_statut_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('changemet_statut'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('changemet_statut/create_action'),
	    'Date_changement' => set_value('Date_changement'),
	    'id_Statut' => set_value('id_Statut'),
	    'NNI' => set_value('NNI'),
	    'id_Controle' => set_value('id_Controle'),
	);
        $this->load->view('changemet_statut_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'Date_changement' => $this->input->post('Date_changement',TRUE),
	    );

            $this->Changemet_statut_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('changemet_statut'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Changemet_statut_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('changemet_statut/update_action'),
		'Date_changement' => set_value('Date_changement', $row->Date_changement),
		'id_Statut' => set_value('id_Statut', $row->id_Statut),
		'NNI' => set_value('NNI', $row->NNI),
		'id_Controle' => set_value('id_Controle', $row->id_Controle),
	    );
            $this->load->view('changemet_statut_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('changemet_statut'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_Statut', TRUE));
        } else {
            $data = array(
		'Date_changement' => $this->input->post('Date_changement',TRUE),
	    );

            $this->Changemet_statut_model->update($this->input->post('id_Statut', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('changemet_statut'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Changemet_statut_model->get_by_id($id);

        if ($row) {
            $this->Changemet_statut_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('changemet_statut'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('changemet_statut'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('Date_changement', 'date changement', 'trim|required');

	$this->form_validation->set_rules('id_Statut', 'id_Statut', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Changemet_statut.php */
/* Location: ./application/controllers/Changemet_statut.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2016-05-06 08:00:37 */
/* http://harviacode.com */