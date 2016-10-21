<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Data_indicateur extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Data_indicateur_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'data_indicateur/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'data_indicateur/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'data_indicateur/index.html';
            $config['first_url'] = base_url() . 'data_indicateur/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Data_indicateur_model->total_rows($q);
        $data_indicateur = $this->Data_indicateur_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'data_indicateur_data' => $data_indicateur,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('data_indicateur_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Data_indicateur_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_data_indicateur' => $row->id_data_indicateur,
		'methode_calcul' => $row->methode_calcul,
		'resultat' => $row->resultat,
		'id_Indicateur' => $row->id_Indicateur,
		'CCS' => $row->CCS,
	    );
            $this->load->view('data_indicateur_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('data_indicateur'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('data_indicateur/create_action'),
	    'id_data_indicateur' => set_value('id_data_indicateur'),
	    'methode_calcul' => set_value('methode_calcul'),
	    'resultat' => set_value('resultat'),
	    'id_Indicateur' => set_value('id_Indicateur'),
	    'CCS' => set_value('CCS'),
	);
        $this->load->view('data_indicateur_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'methode_calcul' => $this->input->post('methode_calcul',TRUE),
		'resultat' => $this->input->post('resultat',TRUE),
		'id_Indicateur' => $this->input->post('id_Indicateur',TRUE),
		'CCS' => $this->input->post('CCS',TRUE),
	    );

            $this->Data_indicateur_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('data_indicateur'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Data_indicateur_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('data_indicateur/update_action'),
		'id_data_indicateur' => set_value('id_data_indicateur', $row->id_data_indicateur),
		'methode_calcul' => set_value('methode_calcul', $row->methode_calcul),
		'resultat' => set_value('resultat', $row->resultat),
		'id_Indicateur' => set_value('id_Indicateur', $row->id_Indicateur),
		'CCS' => set_value('CCS', $row->CCS),
	    );
            $this->load->view('data_indicateur_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('data_indicateur'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_data_indicateur', TRUE));
        } else {
            $data = array(
		'methode_calcul' => $this->input->post('methode_calcul',TRUE),
		'resultat' => $this->input->post('resultat',TRUE),
		'id_Indicateur' => $this->input->post('id_Indicateur',TRUE),
		'CCS' => $this->input->post('CCS',TRUE),
	    );

            $this->Data_indicateur_model->update($this->input->post('id_data_indicateur', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('data_indicateur'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Data_indicateur_model->get_by_id($id);

        if ($row) {
            $this->Data_indicateur_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('data_indicateur'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('data_indicateur'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('methode_calcul', 'methode calcul', 'trim|required');
	$this->form_validation->set_rules('resultat', 'resultat', 'trim|required|numeric');
	$this->form_validation->set_rules('id_Indicateur', 'id indicateur', 'trim|required');
	$this->form_validation->set_rules('CCS', 'ccs', 'trim|required');

	$this->form_validation->set_rules('id_data_indicateur', 'id_data_indicateur', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Data_indicateur.php */
/* Location: ./application/controllers/Data_indicateur.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2016-10-21 12:59:51 */
/* http://harviacode.com */