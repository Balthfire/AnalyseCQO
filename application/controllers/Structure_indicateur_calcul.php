<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Structure_indicateur_calcul extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Structure_indicateur_calcul_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'structure_indicateur_calcul/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'structure_indicateur_calcul/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'structure_indicateur_calcul/index.html';
            $config['first_url'] = base_url() . 'structure_indicateur_calcul/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Structure_indicateur_calcul_model->total_rows($q);
        $structure_indicateur_calcul = $this->Structure_indicateur_calcul_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'structure_indicateur_calcul_data' => $structure_indicateur_calcul,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('structure_indicateur_calcul_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Structure_indicateur_calcul_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_SIC' => $row->id_SIC,
		'id_Structure' => $row->id_Structure,
		'id_Indicateur' => $row->id_Indicateur,
		'id_Methode_Calcul' => $row->id_Methode_Calcul,
	    );
            $this->load->view('structure_indicateur_calcul_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('structure_indicateur_calcul'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('structure_indicateur_calcul/create_action'),
	    'id_SIC' => set_value('id_SIC'),
	    'id_Structure' => set_value('id_Structure'),
	    'id_Indicateur' => set_value('id_Indicateur'),
	    'id_Methode_Calcul' => set_value('id_Methode_Calcul'),
	);
        $this->load->view('structure_indicateur_calcul_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'id_Structure' => $this->input->post('id_Structure',TRUE),
		'id_Indicateur' => $this->input->post('id_Indicateur',TRUE),
		'id_Methode_Calcul' => $this->input->post('id_Methode_Calcul',TRUE),
	    );

            $this->Structure_indicateur_calcul_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('structure_indicateur_calcul'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Structure_indicateur_calcul_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('structure_indicateur_calcul/update_action'),
		'id_SIC' => set_value('id_SIC', $row->id_SIC),
		'id_Structure' => set_value('id_Structure', $row->id_Structure),
		'id_Indicateur' => set_value('id_Indicateur', $row->id_Indicateur),
		'id_Methode_Calcul' => set_value('id_Methode_Calcul', $row->id_Methode_Calcul),
	    );
            $this->load->view('structure_indicateur_calcul_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('structure_indicateur_calcul'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_SIC', TRUE));
        } else {
            $data = array(
		'id_Structure' => $this->input->post('id_Structure',TRUE),
		'id_Indicateur' => $this->input->post('id_Indicateur',TRUE),
		'id_Methode_Calcul' => $this->input->post('id_Methode_Calcul',TRUE),
	    );

            $this->Structure_indicateur_calcul_model->update($this->input->post('id_SIC', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('structure_indicateur_calcul'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Structure_indicateur_calcul_model->get_by_id($id);

        if ($row) {
            $this->Structure_indicateur_calcul_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('structure_indicateur_calcul'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('structure_indicateur_calcul'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('id_Structure', 'id structure', 'trim|required');
	$this->form_validation->set_rules('id_Indicateur', 'id indicateur', 'trim|required');
	$this->form_validation->set_rules('id_Methode_Calcul', 'id methode calcul', 'trim|required');

	$this->form_validation->set_rules('id_SIC', 'id_SIC', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Structure_indicateur_calcul.php */
/* Location: ./application/controllers/Structure_indicateur_calcul.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2016-10-28 15:16:09 */
/* http://harviacode.com */