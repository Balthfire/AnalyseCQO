<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Controle extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Controle_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'controle/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'controle/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'controle/index.html';
            $config['first_url'] = base_url() . 'controle/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Controle_model->total_rows($q);
        $controle = $this->Controle_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'controle_data' => $controle,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('controle_list', $data);
    }
    public function viewAjoutExcel()
    {
        $this->load->view('ajoutExcel');
    }
    public function viewGrapheTest()
    {
        $this->load->view('grapheTest');
    }

    public function ajoutExcel()
    {
        var_dump(APPPATH);

        $resp ="chips1";
        $this->load->model("Controle_model");
        $controle = new Controle_model();
        $c = $controle->get_by_id(1);
        $config['upload_path'] = './temp/';
        $config['allowed_types'] = 'xlsx';
        $config['max_size']    = '400000000';
        $config['encrypt_name'] = false;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        //var_dump($config['upload_path']);
        //exit;
        if ( ! $this->upload->do_upload('fichier_xl')) {
            $this->session->set_flashdata('status', '<div class="alert alert-danger">'.$this->upload->display_errors().'</div>');
            //redirect('index.php/Cconnexion/viewAjoutExcel');
            redirect('index.php/Cconnexion/index');
            $resp = "chips2";
        } else {
            $this->load->library('excel');
            $objReader = PHPExcel_IOFactory::createReader("Excel2007");
            $objReader->setReadDataOnly(true);
            $data = $this->upload->data();
            $objPHPExcel = $objReader->load($data['full_path']);
            $objWorksheet = $objPHPExcel->getSheet(1);
            $row = intval($objWorksheet->getHighestDataRow());
            $stringCol = $objWorksheet->getHighestDataColumn();
            $indexCol = PHPExcel_Cell::columnIndexFromString($stringCol);

            // TODO : Modifier le intval -> internet
            $this->load->model("Feuille_model");
            $this->load->model("Cellule_model");

            $feuille = new Feuille_model();
            // TODO : gérer le numpage et l'id_controle dynamiquement
            // TODO : gérer le htaccess (danscache)
            $datafeuille =  array(
                'nb_ligne' => $row,
                'nb_colonne' => $indexCol,
                'num_page' => 1,
                'id_Controle' => 1
            );
            $idFeuille = $feuille->insert($datafeuille);
            $cellule = new Cellule_model();
            // x = colonne  y = ligne
            for ($x = 1; $x < $indexCol; $x++) {
                for ($y = 1; $y < $row; $y++) {
                    $colString = PHPExcel_Cell::stringFromColumnIndex($x);
                    //TODO : check la fonction PhpExcel GetCalculatedValue
                    $cellvalue = $objPHPExcel->setActiveSheetIndex(1)->getCell($colString . $y)->getValue();
                    $name = $objPHPExcel->getSheetNames();
                    var_dump($name);

                    if ($cellvalue != NULL)
                    {
                        $datacellule = array(
                            'pos_x' => $x,
                            'pos_y' => $y,
                            'valeur' => $cellvalue,
                            'id_feuille' => $idFeuille
                        );
                        $cellule->insert($datacellule);
                    }
                }
            }
            $resp = "chips3";
            redirect('index.php/controle/viewAjoutExcel');
        }
        echo($resp);
    }

    public function ajoutControleParAjoutExcel()
    {


    }

    public function read($id) 
    {
        $row = $this->Controle_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_Controle' => $row->id_Controle,
		'designation' => $row->designation,
		'description' => $row->description,
		'num_vague' => $row->num_vague,
		'date_debut' => $row->date_debut,
		'date_fin' => $row->date_fin,
		'note' => $row->note,
		'Niveau_Qualite' => $row->Niveau_Qualite,
		'fichier_excell' => $row->fichier_excell,
		'extension_fichier' => $row->extension_fichier,
		'id_Type_Controle' => $row->id_Type_Controle,
		'NNI' => $row->NNI,
	    );
            $this->load->view('controle_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('controle'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('controle/create_action'),
	    'id_Controle' => set_value('id_Controle'),
	    'designation' => set_value('designation'),
	    'description' => set_value('description'),
	    'num_vague' => set_value('num_vague'),
	    'date_debut' => set_value('date_debut'),
	    'date_fin' => set_value('date_fin'),
	    'note' => set_value('note'),
	    'Niveau_Qualite' => set_value('Niveau_Qualite'),
	    'fichier_excell' => set_value('fichier_excell'),
	    'extension_fichier' => set_value('extension_fichier'),
	    'id_Type_Controle' => set_value('id_Type_Controle'),
	    'NNI' => set_value('NNI'),
	);
        $this->load->view('controle_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'designation' => $this->input->post('designation',TRUE),
		'description' => $this->input->post('description',TRUE),
		'num_vague' => $this->input->post('num_vague',TRUE),
		'date_debut' => $this->input->post('date_debut',TRUE),
		'date_fin' => $this->input->post('date_fin',TRUE),
		'note' => $this->input->post('note',TRUE),
		'Niveau_Qualite' => $this->input->post('Niveau_Qualite',TRUE),
		'fichier_excell' => $this->input->post('fichier_excell',TRUE),
		'extension_fichier' => $this->input->post('extension_fichier',TRUE),
		'id_Type_Controle' => $this->input->post('id_Type_Controle',TRUE),
		'NNI' => $this->input->post('NNI',TRUE),
	    );

            $this->Controle_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('controle'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Controle_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('controle/update_action'),
		'id_Controle' => set_value('id_Controle', $row->id_Controle),
		'designation' => set_value('designation', $row->designation),
		'description' => set_value('description', $row->description),
		'num_vague' => set_value('num_vague', $row->num_vague),
		'date_debut' => set_value('date_debut', $row->date_debut),
		'date_fin' => set_value('date_fin', $row->date_fin),
		'note' => set_value('note', $row->note),
		'Niveau_Qualite' => set_value('Niveau_Qualite', $row->Niveau_Qualite),
		'fichier_excell' => set_value('fichier_excell', $row->fichier_excell),
		'extension_fichier' => set_value('extension_fichier', $row->extension_fichier),
		'id_Type_Controle' => set_value('id_Type_Controle', $row->id_Type_Controle),
		'NNI' => set_value('NNI', $row->NNI),
	    );
            $this->load->view('controle_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('controle'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_Controle', TRUE));
        } else {
            $data = array(
		'designation' => $this->input->post('designation',TRUE),
		'description' => $this->input->post('description',TRUE),
		'num_vague' => $this->input->post('num_vague',TRUE),
		'date_debut' => $this->input->post('date_debut',TRUE),
		'date_fin' => $this->input->post('date_fin',TRUE),
		'note' => $this->input->post('note',TRUE),
		'Niveau_Qualite' => $this->input->post('Niveau_Qualite',TRUE),
		'fichier_excell' => $this->input->post('fichier_excell',TRUE),
		'extension_fichier' => $this->input->post('extension_fichier',TRUE),
		'id_Type_Controle' => $this->input->post('id_Type_Controle',TRUE),
		'NNI' => $this->input->post('NNI',TRUE),
	    );

            $this->Controle_model->update($this->input->post('id_Controle', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('controle'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Controle_model->get_by_id($id);

        if ($row) {
            $this->Controle_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('controle'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('controle'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('designation', 'designation', 'trim|required');
	$this->form_validation->set_rules('description', 'description', 'trim|required');
	$this->form_validation->set_rules('num_vague', 'num vague', 'trim|required');
	$this->form_validation->set_rules('date_debut', 'date debut', 'trim|required');
	$this->form_validation->set_rules('date_fin', 'date fin', 'trim|required');
	$this->form_validation->set_rules('note', 'note', 'trim|required|numeric');
	$this->form_validation->set_rules('Niveau_Qualite', 'niveau qualite', 'trim|required');
	$this->form_validation->set_rules('fichier_excell', 'fichier excell', 'trim|required');
	$this->form_validation->set_rules('extension_fichier', 'extension fichier', 'trim|required');
	$this->form_validation->set_rules('id_Type_Controle', 'id type controle', 'trim|required');
	$this->form_validation->set_rules('NNI', 'nni', 'trim|required');

	$this->form_validation->set_rules('id_Controle', 'id_Controle', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Controle.php */
/* Location: ./application/controllers/Controle.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2016-06-03 09:09:44 */
/* http://harviacode.com */