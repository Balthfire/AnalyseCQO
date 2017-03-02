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

    public function read($id) 
    {
        $row = $this->Controle_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_Controle' => $row->id_Controle,
		'nom' => $row->nom,
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
            'action' => site_url('index.php/controle/create_action'),
	    'id_Controle' => set_value('id_Controle'),
	    'nom' => set_value('nom'),
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
		'nom' => $this->input->post('nom',TRUE),
		'NNI' => $this->input->post('NNI',TRUE),
	    );

            $this->Controle_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('index.php/controle'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Controle_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('index.php/controle/update_action'),
                'id_Controle' => set_value('id_Controle', $row->id_Controle),
                'nom' => set_value('nom', $row->nom),
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
		'nom' => $this->input->post('nom',TRUE),
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
	$this->form_validation->set_rules('nom', 'nom', 'trim|required');
	$this->form_validation->set_rules('NNI', 'nni', 'trim|required');

	$this->form_validation->set_rules('id_Controle', 'id_Controle', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function viewUploadExcel()
    {
        $this->load->view('ajoutExcel');
    }

    public function viewUploadExcel2()
    {
        $this->load->view('viewUploadExcel');
    }

    public function viewUploadCCS()
    {
        $this->load->view('viewUploadCCS');
    }

    public function viewResultProcess($data)
    {
        $this->load->view('viewResultProcess', $data);
    }

    public function viewProcessExcelCCS(Fichier_model $fichier)
    {
        $this->load->model('Fichier_model');
        $data = array(
            "lastinsert" => $fichier->get_last_id(),
            'arrayNomFeuille' => $this->getNomFeuilleExcel($fichier->get_last_id())
        );
        $this->load->view('viewAjoutCCS',$data);
    }

    public function ProcessCCS()
    {
        $this->load->library('excel');
        $this->load->model("Fichier_model");
        $this->load->model("Agence_model");

        $fichier = new Fichier_model;
        $fichier = $fichier->get_by_id($this->input->post('lastinsert'));
        $objReader = PHPExcel_IOFactory::createReader("Excel2007");
        $objReader->setReadDataOnly(true);
        $objPHPExcel = $objReader->load($fichier->upload_path);
        $arraynomfeuille = $objPHPExcel->getSheetNames();

        //Nombre de champs ajoutés via le script js
        $nbtotalchamp = $this->input->post('nb_champ',TRUE);
        $inputnomfeuille = $this->input->post('nom_feuille',TRUE);

        $generalArray = array();
        $arrayFeuille = array();
        foreach ($arraynomfeuille as $nomfeuille) {
            //TODO : Amélioration du système pour gérer plusieurs feuilles automatiquement
            if($nomfeuille == $inputnomfeuille)
            {
                $objPHPExcel->setActiveSheetIndexByName($nomfeuille);
                $objWorksheet = $objPHPExcel->getActiveSheet();
                $datastart = $this->input->post('datastart',TRUE);
                $nbechant = $this->input->post('nbechant',TRUE)-1; //Plus pratique

                $arrayColonne= array();
                for($i=1;$i<=$nbtotalchamp;$i++)
                {
                    $header = $this->input->post('nom_champ_'.$i,TRUE);
                    $colonnelettre = $this->input->post('value_'.$i,TRUE);
                    $arrayLigne = array();
                    for($z=0;$z <= $nbechant;$z++)
                    {
                        $arrayData = array();
                        $numligne = $z + $datastart;
                        $valeur = $objWorksheet->getCell($colonnelettre . $numligne)->getCalculatedValue();
                        $Strvaleur = strval($valeur);
                        if (!is_null($valeur) AND strlen($Strvaleur)>0)
                        {
                            $arrayData[$header] = $valeur;
                            $arrayLigne[$numligne] = $arrayData;
                        }
                        else
                        {
                            $arrayData[$header] = 0;
                            $arrayLigne[$numligne] = $arrayData;
                        }
                    }

                    $arrayColonne[$colonnelettre] = $arrayLigne;
                }
                $arrayFeuille[$nomfeuille] = $arrayColonne;
            }
        }
        $generalArray[$this->input->post('lastinsert')] = $arrayFeuille;


        $Agencemodel = new Agence_model();
        foreach($generalArray as $idfichier => $Array)
        {
            foreach($Array as $feuille => $Array2)
            {
                $ColonneA = $Array2['A'];
                $ColonneD = $Array2['D'];
                $ColonneE = $Array2['E'];
                $ColonneF = $Array2['F'];
                for($i=$datastart;$i<=750+$datastart;$i++)
                {
                    $insertdata = array(
                        'CCS' => $ColonneA[$i]['CCS'],
                        'DUM' => $ColonneD[$i]['Service'],
                        'SDUM' => $ColonneE[$i]['Service2'],
                        'nom' => $ColonneF[$i]['Agence'],
                    );

                    $Agencemodel->insert($insertdata);
                }
            }
        }
    }

    public function viewProcessExcel(Fichier_model $fichier)
    {
        $this->load->model('Fichier_model');
        $data = array(
            "lastinsert" => $fichier->get_last_id(),
            'arrayNomFeuille' => $this->getNomFeuilleExcel($fichier->get_last_id())
        );
        $this->load->view('viewStartProcessExcel',$data);
    }

    public function viewProcessExcel2(Fichier_model $fichier)
    {
        $this->load->model('Fichier_model');
        $data = array(
            "lastinsert" => $fichier->get_last_id(),
            'arrayNomFeuille' => $this->getNomFeuilleExcel($fichier->get_last_id())
        );
        $this->load->view('viewSelectColonne',$data);
    }

    public function viewCalculExcelToSql($ArrayLinkedDatas)
    {
        $this->load->model('Operateur_model');
        $operateur = new Operateur_model();

        $data = array(
            'ArrayLinkedDatas' => $ArrayLinkedDatas,
            'ArrayOperateurs' => $operateur->get_all()
        );
        $this->load->view('viewCreationCalcul',$data);
    }

    //Process suivit lors de l'upload d'un fichier excel
    public function ProcessExcel()
    {
        set_time_limit(0);
        $ArrayInfoIndicateur = $this->getPageInfoIndicateur();
        $StructIdArray = $this->getDataProcess($this->input->post('lastinsert'),$ArrayInfoIndicateur);
        $SortedCCS = $this->TriCCS($StructIdArray);
        $this->CalculSommeParCCS($SortedCCS);
    }

    public function ProcessExcel2()
    {
        set_time_limit(0);
        $timestamp_debut = microtime(true);
        $ArrayInfoIndicateur = $this->getAllDataFromView();
        $timestamp_fin = microtime(true);
        var_dump($timestamp_fin-$timestamp_debut);
        $timestamp_debut = microtime(true);
        $CleanedForStruct = $this->StructureCleaning($ArrayInfoIndicateur);
        $timestamp_fin = microtime(true);
        var_dump($timestamp_fin-$timestamp_debut);
        $timestamp_debut = microtime(true);
        $AllDataArray = $this->getDataProcess2($this->input->post('lastinsert'),$CleanedForStruct);
        $timestamp_fin = microtime(true);
        var_dump($timestamp_fin-$timestamp_debut);
        $timestamp_debut = microtime(true);
        $StructIdArray = $this->createStructure2($AllDataArray);
        $timestamp_fin = microtime(true);
        var_dump($timestamp_fin-$timestamp_debut);
        $timestamp_debut = microtime(true);
        $ArrayLinkedDatas = $this->linkStructureToIndicateur($StructIdArray,$ArrayInfoIndicateur);
        $timestamp_fin = microtime(true);
        var_dump($timestamp_fin-$timestamp_debut);

        $this->viewCalculExcelToSql($ArrayLinkedDatas);
        /*
        $SortedCCS = $this->TriCCS($StructIdArray);
        $this->CalculSommeParCCS($SortedCCS);*/
    }

    public function getPageInfoIndicateur()
    {
        $nbIndicateur = $this->input->post('nb_indic',TRUE);
        $ArrayInfoIndicateur = array();

        for ($i=1;$i<=$nbIndicateur;$i++)
        {
            $nomIndicateur = $this->input->post('indicateur_'.$i,TRUE);
            $datastart = $this->input->post('datastart_'.$i,TRUE);
            $dataend = $this->input->post('dataend_'.$i,TRUE);
            $nbChamp = $this->input->post('nb_champ_'.$i,TRUE);
            $nomfeuille = $this->input->post('nom_feuille_'.$i,TRUE);
            $ArraySelectionColonne = array();

            for($c=1;$c<=$nbChamp;$c++)
            {
                $ArraySelectionColonne[$nomfeuille][$this->input->post('nom_champ_'.$i.'_'.$c,TRUE)] = $this->input->post('value_'.$i.'_'.$c,TRUE);
            }
            $ArrayInfoIndicateur[$nomIndicateur]['start'] = $datastart;
            $ArrayInfoIndicateur[$nomIndicateur]['end'] = $dataend;
            $ArrayInfoIndicateur[$nomIndicateur]['feuille'] = $ArraySelectionColonne;
        }
        return($ArrayInfoIndicateur);
    }

    public function getAllDataFromView()
    {
        $nbIndicateur = $this->input->post('nb_indic',TRUE);
        $ArrayInfoIndicateur = array();
        for ($i=1;$i<=$nbIndicateur;$i++)
        {
            $ArraySelectionFeuille = array();
            $nomIndicateur = $this->input->post('indicateur_'.$i,TRUE);
            $nbFeuille = $this->input->post('nb_feuille_'.$i,TRUE);

            for ($f=1;$f<=$nbFeuille;$f++)
            {
                $datastart = $this->input->post('datastart_'.$i.'_'.$f,TRUE);
                $dataend = $this->input->post('dataend_'.$i.'_'.$f,TRUE);
                $nbColonne = $this->input->post('nb_colonne_'.$i.'_'.$f,TRUE);
                $nomfeuille = $this->input->post('txt_nom_feuille_'.$i.'_'.$f,TRUE);
                $ArraySelectionColonne = array();

                for($c=1;$c<=$nbColonne;$c++)
                {
                    $typeColonne = $this->input->post('type_colonne_'.$i.'_'.$f.'_'.$c,TRUE);
                    $lettreColonne = $this->input->post('value_'.$i.'_'.$f.'_'.$c,TRUE);
                    $ArraySelectionColonne[$typeColonne] = $lettreColonne;
                }
                $ArraySelectionFeuille[$nomfeuille]['colonnes'] = $ArraySelectionColonne;
                $ArraySelectionFeuille[$nomfeuille]['start'] = $datastart;
                $ArraySelectionFeuille[$nomfeuille]['end'] = $dataend;
            }
            $ArrayInfoIndicateur[$nomIndicateur] = $ArraySelectionFeuille;
        }
        return($ArrayInfoIndicateur);
    }

    //Retourne un Array contenant les feuilles et les colonnes à entrer dans la table structure, sans doublons.
    public function StructureCleaning($ArrayInfoIndicateur)
    {
        $TempArray = array();
        $MergedArrays = array();
        $TempMergedArrays = array();
        //Merge les arrays, si les Feuilles sont déjà présentes,les colonnes de chaque indicateur sont combinées dans un même tableau.
        foreach($ArrayInfoIndicateur as $nomIndic => $ArrayFeuilles)
        {
            $MergedArrays = array_merge_recursive($ArrayFeuilles,$TempArray);
            $MergedArrays = array_merge_recursive($MergedArrays,$TempMergedArrays);
            $TempArray = $ArrayFeuilles;
            $TempMergedArrays = $MergedArrays;
        }
        $CleanedArray = array();
        $ItemArray = array();

        foreach($MergedArrays as $nomfeuille => $ArrayItems)
        {
            foreach($ArrayItems as $item => $value)
            {
                $Arraycolonnes = array();

                if(is_array($value))
                {
                    if($item == 'start')
                        $ItemArray['start'] = $value[0];
                    if($item == 'end')
                        $ItemArray['end'] = $value[0];
                }
                else
                {
                    if ($item == 'start')
                        $ItemArray['start'] = $value;
                    if ($item == 'end')
                        $ItemArray['end'] = $value;
                }

                if($item == 'colonnes')
                {
                    foreach($value as $typecolone => $lettrecolonne)
                    {
                        if(is_array($lettrecolonne))
                            $Arraycolonnes[$typecolone] = $lettrecolonne[0];
                        else
                            $Arraycolonnes[$typecolone] = $lettrecolonne;
                    }
                    $ItemArray['colonnes'] = $Arraycolonnes;
                }
            }
            $CleanedArray[$nomfeuille] = $ItemArray;
        }
        return($CleanedArray);
    }

    //Récupère les données contenu dans le fichier excel en fonction des paramètres donnés par l'utilisateur
    //Envoi un Array contenant toute les données à intégré à la BDD à la fonction createstructure
    //@param : lastid - Dernier id de fichier entré en base de donné par la fonction StoreExcel()
    public function getDataProcess($lastid,$ArrayInfoIndicateur)
    {
        $this->load->library('excel');
        $this->load->model("Fichier_model");
        $fichier = new Fichier_model;
        $fichier = $fichier->get_by_id($lastid);

        $objReader = PHPExcel_IOFactory::createReader("Excel2007");
        $objReader->setReadDataOnly(true);
        $objPHPExcel = $objReader->load($fichier->upload_path);

        $generalArray = array();
        $arrayFeuille = array();
        $ArrayUsedSheets = array();
        foreach($ArrayInfoIndicateur as $NomIndicateur => $Infos){

            $FeuillesExcel = $Infos['feuille'];
            $datastart = $Infos['start'];
            $dataend = $Infos['end'];

            foreach($FeuillesExcel as $SheetName => $ColumnArray)
            {
            //TODO : Vérifier la récupération d'une même colonne plusieurs fois (colonneCCS x nbIndicateur)
                $objPHPExcel->setActiveSheetIndexByName($SheetName);
                $objWorksheet = $objPHPExcel->getActiveSheet();
                $nbechant = $dataend - $datastart;
                $arrayColonne = array();
                foreach($ColumnArray as $header => $lettrecolonne)
                {
                    $arrayLigne = array();
                    for($z=0;$z <= $nbechant;$z++)
                    {
                        $arrayData = array();
                        $numligne = $z + $datastart;
                        $valeur = $objWorksheet->getCell($lettrecolonne . $numligne)->getCalculatedValue();
                        $Strvaleur = strval($valeur);
                        if (!is_null($valeur) AND strlen($Strvaleur)>0)
                        {
                            $arrayData[$header] = $valeur;
                            $arrayLigne[$numligne] = $arrayData;
                        }
                        else
                        {
                            $arrayData[$header] = 0;
                            $arrayLigne[$numligne] = $arrayData;
                        }
                    }
                    $arrayColonne[$lettrecolonne] = $arrayLigne;
                }
                $arrayFeuille[$SheetName] = $arrayColonne;
            }
        }
        $generalArray[$lastid] = $arrayFeuille;
        return $this->createStructure($generalArray);
    }

    public function getDataProcess2($lastid,$ArrayInfoIndicateur)
    {
        $this->load->library('excel');
        $this->load->model("Fichier_model");
        $fichier = new Fichier_model;
        $fichier = $fichier->get_by_id($lastid);

        $objReader = PHPExcel_IOFactory::createReader("Excel2007");
        $objReader->setReadDataOnly(true);
        $objPHPExcel = $objReader->load($fichier->upload_path);

        $generalArray = array();
        //$arrayFeuille = array();

        foreach ($ArrayInfoIndicateur as $nomFeuille => $ArrayInfos)
        {
            $colonnesExcel = $ArrayInfos['colonnes'];
            $datastart = $ArrayInfos['start'];
            $dataend = $ArrayInfos['end'];

            $objPHPExcel->setActiveSheetIndexByName($nomFeuille);
            $objWorksheet = $objPHPExcel->getActiveSheet();
            $nbechant = $dataend - $datastart;
            //$arrayColonne = array();

            foreach ($colonnesExcel as $TypeColonne => $lettrecolonne)
            {
                //$arrayLigne = array();
                for ($z = 0; $z <= $nbechant; $z++)
                {
                    //$arrayData = array();
                    $numligne = $z + $datastart;
                    $valeur = $objWorksheet->getCell($lettrecolonne . $numligne)->getCalculatedValue();
                    $Strvaleur = strval($valeur);
                    if (!is_null($valeur) AND strlen($Strvaleur) > 0)
                    {
                        //$arrayData[$TypeColonne] = $valeur;
                        //$arrayLigne[$numligne] = $arrayData;
                        $generalArray[$lastid][$nomFeuille][$lettrecolonne][$numligne][$TypeColonne] = $valeur;

                    } else {
                        //$arrayData[$TypeColonne] = 0;
                        //$arrayLigne[$numligne] = $arrayData;
                        $generalArray[$lastid][$nomFeuille][$lettrecolonne][$numligne][$TypeColonne] = 0;
                    }
                }
                //$arrayColonne[$lettrecolonne] = $arrayLigne;
            }
            unset($objWorksheet);
            //$arrayFeuille[$nomFeuille] = $arrayColonne;
        }
        //$generalArray[$lastid] = $arrayFeuille;
        unset($objPHPExcel);
        return($generalArray);
    }

    //Insère les données passées en paramètre dans la BDD et retourne un Array des ID structures créés.
    //@param : arrayGeneral - Contient les données extraite du fichier Excel
    public function createStructure($arrayGeneral)
    {
        $this->load->library('excel');
        $this->load->model("Fichier_model");
        $this->load->model("Feuille_model");
        $this->load->model("Colonne_model");
        $this->load->model("Structure_model");
        $this->load->model("Data_model");

        $struct = new Structure_model();
        $feuille = new Feuille_model();
        $col = new Colonne_model();
        $datamodel = new Data_model();
        $previousColonne = "";
        $StructIdArray = array();
        $ArrayUsedSheets= array();

        foreach($arrayGeneral as $idfichier => $arrayFeuille)
        {
            foreach($arrayFeuille as $nomfeuille => $arrayColonne)
            {
                if(!in_array($nomfeuille,$ArrayUsedSheets))
                {
                    $insert_data = array(
                        "nom" => $nomfeuille,
                    );
                    $feuille->insert($insert_data);
                    $idFeuille = $feuille->get_last_id();
                }
                else
                {
                    $idFeuille = $struct->getidFeuilleByidFichier($idfichier,$nomfeuille);
                }

                foreach($arrayColonne as $lettreColonne => $arrayLigne)
                {
                    foreach($arrayLigne as $numligne => $arrayData)
                    {
                        foreach($arrayData as $header => $valeur)
                        {
                            if($previousColonne != $lettreColonne)
                            {
                                //TODO : mieux gérer la mise en place du type colonne
                                switch ($header)
                                {
                                    case "CCS":
                                        $insert_data = array(
                                            "header"=>$header,
                                            "lettre_excel"=>$lettreColonne,
                                            "id_type_colonne"=>1);
                                        break;
                                    case "Montant":
                                        $insert_data = array(
                                            "header"=>$header,
                                            "lettre_excel"=>$lettreColonne,
                                            "id_type_colonne"=>2);
                                        break;
                                    case "Champ KO":
                                        $insert_data = array(
                                            "header"=>$header,
                                            "lettre_excel"=>$lettreColonne,
                                            "id_type_colonne"=>3);
                                        break;
                                }

                                $col->insert($insert_data);
                                $idCol = $col->get_last_id();

                                $insert_data = array(
                                    "id_Fichier"=>$idfichier,
                                    "id_Feuille"=>$idFeuille,
                                    "id_Colonne"=>$idCol
                                );
                                $struct->insert($insert_data);
                                $idStruct = $struct->get_last_id();
                                $StructIdArray[] = $idStruct;
                            }

                            $insert_data = array(
                                "data" => $valeur,
                                "num_ligne_excel" => $numligne,
                                "id_Structure" => $idStruct
                            );
                            $datamodel->insert($insert_data);
                            $idData = $datamodel->get_last_id();
                            $previousColonne = $lettreColonne;
                        }
                    }
                }
                $ArrayUsedSheets[] = $nomfeuille;
            }
        }
        return($StructIdArray);
    }

    public function createStructure2($arrayGeneral)
    {
        $this->load->library('excel');
        $this->load->model("Fichier_model");
        $this->load->model("Feuille_model");
        $this->load->model("Colonne_model");
        $this->load->model("Structure_model");
        $this->load->model("Data_model");

        $struct = new Structure_model();
        $feuille = new Feuille_model();
        $col = new Colonne_model();
        $datamodel = new Data_model();
        $StructIdArray = array();
        $previousColonne = "";

        foreach($arrayGeneral as $idfichier => $arrayFeuille)
        {
            foreach($arrayFeuille as $nomfeuille => $arrayColonne)
            {
                $insert_data = array(
                    "nom" => $nomfeuille,
                );
                $feuille->insert($insert_data);
                $idFeuille = $feuille->get_last_id();

                foreach($arrayColonne as $lettreColonne => $arrayLigne)
                {
                    foreach($arrayLigne as $numligne => $arrayData)
                    {
                        foreach($arrayData as $header => $valeur)
                        {
                            //TODO : mieux gérer la mise en place du type colonne
                            if($lettreColonne != $previousColonne)
                            {
                                switch ($header) {
                                    case "CCS":
                                        $insert_data = array(
                                            "header" => $header,
                                            "lettre_excel" => $lettreColonne,
                                            "id_type_colonne" => 1);
                                        break;
                                    case "Montant":
                                        $insert_data = array(
                                            "header" => $header,
                                            "lettre_excel" => $lettreColonne,
                                            "id_type_colonne" => 2);
                                        break;
                                    case "Champ KO":
                                        $insert_data = array(
                                            "header" => $header,
                                            "lettre_excel" => $lettreColonne,
                                            "id_type_colonne" => 3);
                                        break;
                                }
                                $col->insert($insert_data);
                                $idCol = $col->get_last_id();

                                $insert_data = array(
                                    "id_Fichier"=>$idfichier,
                                    "id_Feuille"=>$idFeuille,
                                    "id_Colonne"=>$idCol
                                );
                                $struct->insert($insert_data);
                                $idStruct = $struct->get_last_id();
                                $StructIdArray[] = $idStruct;
                            }
                            $insert_data = array(
                                "data" => $valeur,
                                "num_ligne_excel" => $numligne,
                                "id_Structure" => $idStruct
                            );
                            $datamodel->insert($insert_data);
                            $previousColonne = $lettreColonne;
                        }
                    }
                }
            }
        }
        return($StructIdArray);
    }

    public function linkStructureToIndicateur($ArrayStruct,$ArrayIndicateur)
    {
        $this->load->model("Structure_model");
        $struct = new Structure_model();
        $ResultArray = array();

        $LinkArray = $struct->getLinkingInfos($ArrayStruct);

        foreach($ArrayIndicateur as $nomIndicateur => $Arrayfeuille)
        {
            foreach($Arrayfeuille as $nomfeuille => $ArrayInfos)
            {
                foreach($ArrayInfos['colonnes'] as $TypeColonnne => $lettre)
                {
                    for($i=0;$i<=count($LinkArray)-1;$i++)
                    {
                        if($LinkArray[$i]['nom'] == $nomfeuille AND $LinkArray[$i]['lettre_excel'] == $lettre)
                        {
                            $ResultArray[$nomIndicateur][$nomfeuille]['colonnes'][$TypeColonnne] = $LinkArray[$i]['id_structure'];
                        }
                    }
                }
            }
        }
        return($ResultArray);
    }

    public function StoreFormula()
    {
        $ObjectFormula = json_decode($this->input->post('HiddenFormula',TRUE));
        $ArrayFormula = array();
        foreach($ObjectFormula as $nomIndic => $ArrayDenoNum)
        {
            foreach($ArrayDenoNum as $numerateur => $ArrayIdStruct)
            {
                foreach($ArrayIdStruct as $idStruct => $ArrayOperateur)
                {
                    foreach($ArrayOperateur as $key => $idOperateur)
                    {
                        $ArrayFormula[$nomIndic][$numerateur][$idStruct][$key] = $idOperateur;
                    }
                }
            }
        }
        var_dump($ArrayFormula);

    }
    //Parcour des différentes données colonnes identifiantes (Actuellement, en fonction du CCS -> Colonne/TypeColonne non géré dynamiquement)
    //et création d'un Array contenant chaque identifiant distinct.
    //@param : StructIdArray - Array de clé structure
    //DEPRECATED
    public function TriCCS($StructIdArray)
    {
        $this->load->model("Type_colonne_model");
        $typecolmodel = new Type_colonne_model();
        $datamodel = new Data_model();
        $structmodel = new Structure_model();
        $colonnemodel = new Colonne_model();

        $ArrayNumLigne = array();
        $ArrayDetails = array();
        $CCSDistinct = array();
        foreach($StructIdArray as $idStruct)
        {
            $struct = $structmodel->get_by_id($idStruct);
            $idFichier = $struct->id_Fichier;
            $idFeuille = $struct->id_Feuille;
            $idColonne = $struct->id_Colonne;
            $col = $colonnemodel->get_by_id($struct->id_Colonne);

            $ArrayColonne = $datamodel->get_colonne($idFichier,$idFeuille,$idColonne);
            $TypeCol = $typecolmodel->get_by_id($col->id_Type_Colonne);

            //TODO : mieux gérer les types colonne
            if(!is_null($TypeCol))
            {
                if ($TypeCol->nom == "identifiant")
                {
                    foreach ($ArrayColonne as $col)
                    {
                        $ArrayNumLigne[] = $col['num_ligne_excel'];
                        $ArrayNumLigne[] = $col['data'];

                        if(!array_key_exists($col['data'],$CCSDistinct))
                            $CCSDistinct[$col['data']] = $ArrayDetails;
                    }

                    foreach($CCSDistinct as $CCS => $dataCCS)
                    {
                        $ArrayLigne = array();
                        for($i=1;$i<=count($ArrayNumLigne);$i++)
                        {
                            if(($i%2)==1)
                            {
                                if($CCS == $ArrayNumLigne[$i])
                                {
                                    $ArrayLigne[] = $ArrayNumLigne[$i-1];
                                    $CCSDistinct[$CCS]['ligne'] = $ArrayLigne;
                                }
                            }
                        }
                    }
                }
            }
        }
        return($this->getDataParCCS($CCSDistinct,$idFeuille,$idFichier));
    }

    //Retourne un array contenant les données de chaque ligne pour chaque CCS
    public function getDataParCCS($CCSArray,$idFeuille,$idFichier)
    {
        $typecolmodel = new Type_colonne_model();
        $colmodel = new Colonne_model();
        $structmodel = new Structure_model();
        $datamodel = new Data_model();

        $ArrayIdTotalColonne = $structmodel->get_other_columns($idFichier,$idFeuille);
        $ArrayIdTriColonne = array();
        foreach($ArrayIdTotalColonne as $ArrayColonne)
        {
            $col = $colmodel->get_by_id($ArrayColonne['id_Colonne']);
            $typecol = $typecolmodel->get_by_id($col->id_Type_Colonne);
            //TODO Gérér dynamiquement les colonnes et leur nom --> NE marche pas pour le moment
            if($typecol->nom != "CCS")
            {
                $ArrayIdTriColonne[] = $ArrayColonne['id_Colonne'];
            }
        }
        $DataArray = array();
        foreach($CCSArray as $CCS => $ArrayLigne)
        {
            $LineArray = array();
            for($i=0;$i<=count($ArrayLigne['ligne'])-1;$i++)
            {
                $Data =array();
                foreach($ArrayIdTriColonne as $indice => $idColonne)
                {
                    $col = $colmodel->get_by_id($idColonne);
                    $ArrayNumLigne = $ArrayLigne['ligne'];
                    $numligne = $ArrayNumLigne[$i];
                    $Data[$col->header] = $datamodel->get_specific_data($numligne,$idFeuille,$idFichier,$idColonne);
                    $LineArray[$numligne] = $Data;
                }
            }
            $DataArray[$CCS] = $LineArray;
        }
        return($DataArray);
    }

    //Retourne un array contenant les sommes de chacune des colonnes organisé par CCS
    //Ajoute un array contenant les noms d'agence correspondant au CCS
    public function CalculSommeParCCS($SortedCCS)
    {
        $this->load->model("Agence_model");
        $AgenceModel = new Agence_model();
        $ArrayResult = array();
        $MontantParCCS = array();
        $KOParCCS = array();
        $CCSparName = array();
        $NbLigneParCCS = array();

        foreach ($SortedCCS as $CCS => $ArrayLigne)
        {
            $Agence = $AgenceModel->get_by_id($CCS);
            $CCSparName[$Agence->nom][] = $CCS;
            $NbLigneParCCS[$CCS]= count($ArrayLigne);

            foreach ($ArrayLigne as $numligne => $ArrayColonne)
            {
                foreach($ArrayColonne as $header => $ArrayMedium)
                {
                    switch($header) {
                            case 'Montant':
                            foreach ($ArrayMedium as $indice => $ArrayData)
                            {
                                if (array_key_exists($CCS,$MontantParCCS))
                                    $MontantParCCS[$CCS] = $MontantParCCS[$CCS] + abs(floatval($ArrayData['data']));
                                else
                                    $MontantParCCS[$CCS] = abs(floatval($ArrayData['data']));
                            }
                            break;
                        case 'Champ KO':
                            foreach ($ArrayMedium as $indice => $ArrayData)
                            {
                                if (array_key_exists($CCS,$KOParCCS))
                                    $KOParCCS[$CCS] = $KOParCCS[$CCS] + abs(floatval($ArrayData['data']));
                                else
                                    $KOParCCS[$CCS] = abs(floatval($ArrayData['data']));
                            }
                            break;
                    }
                }
            }
        }
        $ArrayResult['NbLigneParCCS']= $NbLigneParCCS;
        $ArrayResult['MontantParCCS'] = $MontantParCCS;
        $ArrayResult['KOParCCS'] = $KOParCCS;
        $ArrayResult['CCSparName'] = $CCSparName;
        $ArrayResult['MT'] = array_sum($MontantParCCS);
        $ArrayResult['AT'] = array_sum($KOParCCS);

        $this->load->view('viewResultProcess', $ArrayResult);

        //return($ArrayResult);
    }

    public function storeExcel()
    {
        set_time_limit(0);
        $this->load->library('excel');
        $this->load->model("Fichier_model");
        $fichier = new Fichier_model();

        $input = 'fichier_xl';
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'xlsx';
        $config['max_size'] = '400000000000000000000';
        $config['encrypt_name'] = false;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!$this->upload->do_upload($input))
        {
            $this->session->set_flashdata('status', '<div class="alert alert-danger">' . $this->upload->display_errors() . '</div>');
            $this->session->set_flashdata('message', 'Nope');
            //$this->session->set_flashdata('message', $this->input->post($input));
            redirect(site_url('index.php/controle'));
        }
        else
        {
            $data = $this->upload->data();
            $uploadpath = $data['full_path'];
            $name = $_FILES['fichier_xl']['name'];
            $date = date('Y-n');
            $insert_data = array(
                "nom"=>$name,
                "extension"=>$config['allowed_types'],
                "upload_path"=>$uploadpath,
                "annee"=>$date,
            );
            $fichier->insert($insert_data);

            $this->session->set_flashdata('message', 'le fichier excel a bien été uploadé');
            $this->viewProcessExcel($fichier);

            // Transforme un excel en html
            /*
            $inputFileType = 'Excel2007';
            $inputFileName = $uploadpath;
            $outputFileType = 'HTML';
            $outputFileName = './uploads/test.html';
            $objPHPExcelReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objPHPExcelReader->load($inputFileName);
            $objPHPExcelWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,$outputFileType);
            $objPHPExcel = $objPHPExcelWriter->save($outputFileName);*/

        }

    }

    public function storeExcel2()
    {
        set_time_limit(0);
        $this->load->library('excel');
        $this->load->model("Fichier_model");
        $fichier = new Fichier_model();

        $input = 'fichier_xl';
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'xlsx';
        $config['max_size'] = '400000000000000000000';
        $config['encrypt_name'] = false;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!$this->upload->do_upload($input))
        {
            $this->session->set_flashdata('status', '<div class="alert alert-danger">' . $this->upload->display_errors() . '</div>');
            $this->session->set_flashdata('message', 'Nope');
            //$this->session->set_flashdata('message', $this->input->post($input));
            redirect(site_url('index.php/controle'));
        }
        else
        {
            $data = $this->upload->data();
            $uploadpath = $data['full_path'];
            $name = $_FILES['fichier_xl']['name'];
            $date = date('Y-n');
            $insert_data = array(
                "nom"=>$name,
                "extension"=>$config['allowed_types'],
                "upload_path"=>$uploadpath,
                "annee"=>$date,
            );
            $fichier->insert($insert_data);

            $this->session->set_flashdata('message', 'le fichier excel a bien été uploadé');
            $this->viewProcessExcel2($fichier);

            // Transforme un excel en html
            /*
            $inputFileType = 'Excel2007';
            $inputFileName = $uploadpath;
            $outputFileType = 'HTML';
            $outputFileName = './uploads/test.html';
            $objPHPExcelReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objPHPExcelReader->load($inputFileName);
            $objPHPExcelWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,$outputFileType);
            $objPHPExcel = $objPHPExcelWriter->save($outputFileName);*/

        }

    }

    public function storeExcelCCS()
    {
        set_time_limit(0);
        $this->load->library('excel');
        $this->load->model("Fichier_model");
        $fichier = new Fichier_model();

        $input = 'fichier_xl';
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'xlsx';
        $config['max_size'] = '400000000000000000000';
        $config['encrypt_name'] = false;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!$this->upload->do_upload($input))
        {
            $this->session->set_flashdata('status', '<div class="alert alert-danger">' . $this->upload->display_errors() . '</div>');
            $this->session->set_flashdata('message', 'Nope');
            //$this->session->set_flashdata('message', $this->input->post($input));
            redirect(site_url('index.php/controle'));
        }
        else
        {
            $data = $this->upload->data();
            $uploadpath = $data['full_path'];
            $name = $_FILES['fichier_xl']['name'];
            $date = date('Y-n');
            $insert_data = array(
                "nom"=>$name,
                "extension"=>$config['allowed_types'],
                "upload_path"=>$uploadpath,
                "annee"=>$date,
            );
            $fichier->insert($insert_data);

            $this->session->set_flashdata('message', 'le fichier excel a bien été uploadé');
            $this->viewProcessExcelCCS($fichier);

            // Transforme un excel en html
            /*
            $inputFileType = 'Excel2007';
            $inputFileName = $uploadpath;
            $outputFileType = 'HTML';
            $outputFileName = './uploads/test.html';
            $objPHPExcelReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objPHPExcelReader->load($inputFileName);
            $objPHPExcelWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,$outputFileType);
            $objPHPExcel = $objPHPExcelWriter->save($outputFileName);*/
        }
    }

    public function getNomFeuilleExcel($idfichier)
    {
        $this->load->library('excel');
        $this->load->model("Fichier_model");

        $fichier = new Fichier_model();
        $fichier = $fichier->get_by_id($idfichier);

        $objReader = PHPExcel_IOFactory::createReader("Excel2007");
        $objReader->setReadDataOnly(true);
        $objPHPExcel = $objReader->load($fichier->upload_path);

        $name = $objPHPExcel->getSheetNames();
        unset($objPHPExcel);
        return $name;
    }

    public function getHeaderColonne($datastart)
    {

    }

    /**
    public function ajoutExcel()
    {
        $this->load->model("Controle_model");
        $controle = new Controle_model();
        $c = $controle->get_by_id('id_Controle');
        $config['upload_path'] = './temp/';
        $config['allowed_types'] = 'xlsx';
        $config['max_size'] = '400000000000000000';
        $config['encrypt_name'] = false;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('fichier_xl')) {
            $this->session->set_flashdata('status', '<div class="alert alert-danger">' . $this->upload->display_errors() . '</div>');
            redirect('index.php/Cconnexion/index');
        } else {
            $this->load->library('excel');
            $objReader = PHPExcel_IOFactory::createReader("Excel2007");
            $objReader->setReadDataOnly(true);
            $data = $this->upload->data();
            $objPHPExcel = $objReader->load($data['full_path']);

            // TODO : Modifier le intval -> internet
            $this->load->model("Fichier_model");
            $this->load->model("Feuille_model");
            $this->load->model("Cellule_model");

            $fichier = new Fichier_model();
            $datafichier = array(
                'libelle' => "lib1",
                'id_Controle' => $this->input->post('id_Controle',TRUE)
            );
            $idfichier = $fichier->insertReturn($datafichier);

            $name = $objPHPExcel->getSheetNames();
            $nombrefeuille = count($name);


            for ($nbF = 0; $nbF < $nombrefeuille; $nbF++) {
            $objWorksheet = $objPHPExcel->getSheet($nbF);
            $row = intval($objWorksheet->getHighestDataRow());
            $stringCol = $objWorksheet->getHighestDataColumn();
            $indexCol = PHPExcel_Cell::columnIndexFromString($stringCol);
            $feuille = new Feuille_model();
            // TODO : gérer le numpage et l'id_controle dynamiquement
            // TODO : gérer le htaccess (danscache)
            $datafeuille = array(
            'nb_ligne' => $row,
            'nb_colonne' => $indexCol,
            'num_page' => $nbF,
            'id_Fichier' => $idfichier
            );
            $idFeuille = $feuille->insertReturn($datafeuille);
            $cellule = new Cellule_model();

            // x = colonne  y = ligne
            for ($x = 0; $x < $indexCol; $x++) {
            for ($y = 0; $y < $row; $y++) {
            $colString = PHPExcel_Cell::stringFromColumnIndex($x);
            //TODO : Fonction getCalculatedValue : bug lors de sélection de colonne complète (D:D) pour calcul

            //$cellvalue = $objPHPExcel->setActiveSheetIndex($nbF)->getCell($colString . $y)->getCalculatedValue();

            // Gestion de l'erreur cité ci-dessus
            $indiceCheck = 0;
            foreach ($name as $nomfeuille) {
            $cellValueFinal = "";
            $cellValueOrigin = $objPHPExcel->setActiveSheetIndex($nbF)->getCell($colString . $y)->getValue();
            $nbSpaceFeuille = substr_count($nomfeuille," ");

            if ($nbSpaceFeuille > 0)
            $strSearch = "'" . $nomfeuille . "'!";
            else
            $strSearch = $nomfeuille . "!";

            $nbOccurence = substr_count($cellValueOrigin, $strSearch);
            if ($nbOccurence > 0) {
            $lenStrSearch = strlen($strSearch);
            $lenOriginal = strlen($cellValueOrigin);
            $chrSearch = ":";
            $posChrSearch = strpos($cellValueOrigin, $chrSearch);
            $lastPosChrSearch = strrpos($cellValueOrigin, $chrSearch);

            $posStart = 0;
            $var = "";


            $posOccurence = 1;
            for ($z = 0; $z <= $nbOccurence; $z++) {

            $searchChr = ":";
            $posSearch = strpos($cellValueOrigin, $searchChr, $posOccurence);
            $posNomFeuille = strpos($cellValueOrigin, $nomfeuille, $posOccurence);

            if ($indiceCheck >= 1) {
            for ($num = 1; $num < $indiceCheck; $num++) {
            $posOccurence = $posSearch + 1;
            $posSearch = strpos($cellValueOrigin, $searchChr, $posOccurence);
            }
            }
            $posSearch = strpos($cellValueOrigin, $searchChr, $posOccurence);

            $chrAvant = substr($cellValueOrigin, $posSearch - 1, 1);
            $chrApres = substr($cellValueOrigin, $posSearch + 1, 1);

            if ($chrApres == $chrAvant AND $chrApres != " ") {
            $strPosToEnd = substr($cellValueOrigin, $posSearch + 2);
            $lengthStrAfterPos = strlen($strPosToEnd);
            $originalLength = strlen($cellValueOrigin);
            $lengthStrBefPos = $originalLength - $lengthStrAfterPos - 4;
            $strStartToPos = substr($cellValueOrigin, 0, $lengthStrBefPos);

            $objWorksheet = $objPHPExcel->getSheetByName($nomfeuille);
            $nbLigneFeuilleMin = 1;
            $nbLigneFeuilleMax = intval($objWorksheet->getHighestDataRow());

            $cellValueFinal = $strStartToPos . "!" . $chrAvant . $nbLigneFeuilleMin . $searchChr . $chrApres . $nbLigneFeuilleMax . $strPosToEnd;
            $indiceCheck++;
            $chips = array($colString . $y => $cellValueFinal);

            var_dump($chips);

            }
            $posOccurence = $posSearch + 1;
            $objPHPExcel->setActiveSheetIndex($nbF)->getCell($colString . $y)->setValue($cellValueFinal);
            }
            }
            }

            $cellvalue = $objPHPExcel->setActiveSheetIndex($nbF)->getCell($colString . $y)->getCalculatedValue();

            if ($cellvalue != NULL) {
            $datacellule = array(
            'pos_x' => $x,
            'pos_y' => $y,
            'valeur' => $cellvalue,
            'id_Feuille' => $idFeuille,

            );
            $cellule->insert($datacellule);
            }
            }
            }
            }
            var_dump($data['full_path']);

            redirect('index.php/controle/viewAjoutExcel');
        }
    }*/
}

/* End of file Controle.php */
/* Location: ./application/controllers/Controle.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2016-10-28 15:16:08 */
/* http://harviacode.com */