<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Type_indicateur extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Type_indicateur_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'type_indicateur/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'type_indicateur/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'type_indicateur/index.html';
            $config['first_url'] = base_url() . 'type_indicateur/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Type_indicateur_model->total_rows($q);
        $type_indicateur = $this->Type_indicateur_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'type_indicateur_data' => $type_indicateur,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('type_indicateur_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Type_indicateur_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_Type_Indicateur' => $row->id_Type_Indicateur,
		'libelle' => $row->libelle,
		'methode_calcul' => $row->methode_calcul,
	    );
            $this->load->view('type_indicateur_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('type_indicateur'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('type_indicateur/create_action'),
	    'id_Type_Indicateur' => set_value('id_Type_Indicateur'),
	    'libelle' => set_value('libelle'),
	    'methode_calcul' => set_value('methode_calcul'),
	);
        $this->load->view('type_indicateur_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'libelle' => $this->input->post('libelle',TRUE),
		'methode_calcul' => $this->input->post('methode_calcul',TRUE),
	    );

            $this->Type_indicateur_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('type_indicateur'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Type_indicateur_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('type_indicateur/update_action'),
		'id_Type_Indicateur' => set_value('id_Type_Indicateur', $row->id_Type_Indicateur),
		'libelle' => set_value('libelle', $row->libelle),
		'methode_calcul' => set_value('methode_calcul', $row->methode_calcul),
	    );
            $this->load->view('type_indicateur_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('type_indicateur'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_Type_Indicateur', TRUE));
        } else {
            $data = array(
		'libelle' => $this->input->post('libelle',TRUE),
		'methode_calcul' => $this->input->post('methode_calcul',TRUE),
	    );

            $this->Type_indicateur_model->update($this->input->post('id_Type_Indicateur', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('type_indicateur'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Type_indicateur_model->get_by_id($id);

        if ($row) {
            $this->Type_indicateur_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('type_indicateur'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('type_indicateur'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('libelle', 'libelle', 'trim|required');
	$this->form_validation->set_rules('methode_calcul', 'methode calcul', 'trim|required');

	$this->form_validation->set_rules('id_Type_Indicateur', 'id_Type_Indicateur', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Type_indicateur.php */
/* Location: ./application/controllers/Type_indicateur.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2016-06-03 09:09:44 */
/* http://harviacode.com */