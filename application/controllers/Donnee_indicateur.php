<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Donnee_indicateur extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Donnee_indicateur_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'donnee_indicateur/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'donnee_indicateur/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'donnee_indicateur/index.html';
            $config['first_url'] = base_url() . 'donnee_indicateur/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Donnee_indicateur_model->total_rows($q);
        $donnee_indicateur = $this->Donnee_indicateur_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'donnee_indicateur_data' => $donnee_indicateur,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('donnee_indicateur_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Donnee_indicateur_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_Donnee' => $row->id_Donnee,
		'libelle' => $row->libelle,
		'valeur' => $row->valeur,
		'Requete_Calcul' => $row->Requete_Calcul,
		'id_Indicateur' => $row->id_Indicateur,
		'id_Modele_Donnees_Indicateur' => $row->id_Modele_Donnees_Indicateur,
	    );
            $this->load->view('donnee_indicateur_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('donnee_indicateur'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('donnee_indicateur/create_action'),
	    'id_Donnee' => set_value('id_Donnee'),
	    'libelle' => set_value('libelle'),
	    'valeur' => set_value('valeur'),
	    'Requete_Calcul' => set_value('Requete_Calcul'),
	    'id_Indicateur' => set_value('id_Indicateur'),
	    'id_Modele_Donnees_Indicateur' => set_value('id_Modele_Donnees_Indicateur'),
	);
        $this->load->view('donnee_indicateur_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'libelle' => $this->input->post('libelle',TRUE),
		'valeur' => $this->input->post('valeur',TRUE),
		'Requete_Calcul' => $this->input->post('Requete_Calcul',TRUE),
		'id_Indicateur' => $this->input->post('id_Indicateur',TRUE),
		'id_Modele_Donnees_Indicateur' => $this->input->post('id_Modele_Donnees_Indicateur',TRUE),
	    );

            $this->Donnee_indicateur_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('donnee_indicateur'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Donnee_indicateur_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('donnee_indicateur/update_action'),
		'id_Donnee' => set_value('id_Donnee', $row->id_Donnee),
		'libelle' => set_value('libelle', $row->libelle),
		'valeur' => set_value('valeur', $row->valeur),
		'Requete_Calcul' => set_value('Requete_Calcul', $row->Requete_Calcul),
		'id_Indicateur' => set_value('id_Indicateur', $row->id_Indicateur),
		'id_Modele_Donnees_Indicateur' => set_value('id_Modele_Donnees_Indicateur', $row->id_Modele_Donnees_Indicateur),
	    );
            $this->load->view('donnee_indicateur_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('donnee_indicateur'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_Donnee', TRUE));
        } else {
            $data = array(
		'libelle' => $this->input->post('libelle',TRUE),
		'valeur' => $this->input->post('valeur',TRUE),
		'Requete_Calcul' => $this->input->post('Requete_Calcul',TRUE),
		'id_Indicateur' => $this->input->post('id_Indicateur',TRUE),
		'id_Modele_Donnees_Indicateur' => $this->input->post('id_Modele_Donnees_Indicateur',TRUE),
	    );

            $this->Donnee_indicateur_model->update($this->input->post('id_Donnee', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('donnee_indicateur'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Donnee_indicateur_model->get_by_id($id);

        if ($row) {
            $this->Donnee_indicateur_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('donnee_indicateur'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('donnee_indicateur'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('libelle', 'libelle', 'trim|required');
	$this->form_validation->set_rules('valeur', 'valeur', 'trim|required|numeric');
	$this->form_validation->set_rules('Requete_Calcul', 'requete calcul', 'trim|required');
	$this->form_validation->set_rules('id_Indicateur', 'id indicateur', 'trim|required');
	$this->form_validation->set_rules('id_Modele_Donnees_Indicateur', 'id modele donnees indicateur', 'trim|required');

	$this->form_validation->set_rules('id_Donnee', 'id_Donnee', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Donnee_indicateur.php */
/* Location: ./application/controllers/Donnee_indicateur.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2016-05-06 08:00:38 */
/* http://harviacode.com */