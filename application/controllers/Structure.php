<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Structure extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Structure_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'structure/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'structure/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'structure/index.html';
            $config['first_url'] = base_url() . 'structure/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Structure_model->total_rows($q);
        $structure = $this->Structure_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'structure_data' => $structure,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('structure_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Structure_model->get_by_id($id);
        if ($row) {
            $data = array(
		'annee_utilisation' => $row->annee_utilisation,
		'id_Type_Controle' => $row->id_Type_Controle,
		'id_Type_Indicateur' => $row->id_Type_Indicateur,
	    );
            $this->load->view('structure_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('structure'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('structure/create_action'),
	    'annee_utilisation' => set_value('annee_utilisation'),
	    'id_Type_Controle' => set_value('id_Type_Controle'),
	    'id_Type_Indicateur' => set_value('id_Type_Indicateur'),
	);
        $this->load->view('structure_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'annee_utilisation' => $this->input->post('annee_utilisation',TRUE),
	    );

            $this->Structure_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('structure'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Structure_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('structure/update_action'),
		'annee_utilisation' => set_value('annee_utilisation', $row->annee_utilisation),
		'id_Type_Controle' => set_value('id_Type_Controle', $row->id_Type_Controle),
		'id_Type_Indicateur' => set_value('id_Type_Indicateur', $row->id_Type_Indicateur),
	    );
            $this->load->view('structure_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('structure'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_Type_Controle', TRUE));
        } else {
            $data = array(
		'annee_utilisation' => $this->input->post('annee_utilisation',TRUE),
	    );

            $this->Structure_model->update($this->input->post('id_Type_Controle', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('structure'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Structure_model->get_by_id($id);

        if ($row) {
            $this->Structure_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('structure'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('structure'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('annee_utilisation', 'annee utilisation', 'trim|required');

	$this->form_validation->set_rules('id_Type_Controle', 'id_Type_Controle', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Structure.php */
/* Location: ./application/controllers/Structure.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2016-10-21 12:59:52 */
/* http://harviacode.com */