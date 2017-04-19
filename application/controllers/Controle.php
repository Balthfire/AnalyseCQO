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
                'annee' => $row->annee,
                'vague' => $row->vague,
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
            'nom' => set_value('nom'),
            'annee' => set_value('annee'),
            'vague' => set_value('vague'),
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
                'annee' => $this->input->post('annee',TRUE),
                'vague' => $this->input->post('vague',TRUE),
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
                'nom' => set_value('nom', $row->nom),
                'annee' => set_value('annee', $row->annee),
                'vague' => set_value('vague', $row->vague),
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
                'annee' => $this->input->post('annee',TRUE),
                'vague' => $this->input->post('vague',TRUE),
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
        $this->form_validation->set_rules('annee', 'annee', 'trim|required');
        $this->form_validation->set_rules('vague', 'vague', 'trim|required');
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

    public function viewProcessExcel2(Fichier_model $fichier,$idctrl)
    {
        $this->load->model('Fichier_model');
        $this->load->model('Type_Colonne_Model');
        $TC = new Type_colonne_model();
        $data = array(
            'idControle'=> $idctrl,
            "lastinsert" => $fichier->get_last_id(),
            'arrayNomFeuille' => $this->getNomFeuilleExcel($fichier->get_last_id()),
            'arrayTypeColonne' => $TC->get_all()
        );
        $this->load->view('viewSelectColonne',$data);
    }

    public function viewCalculExcelToSql($ArrayLinkedDatas,$idCtrl)
    {
        $this->load->model('Operateur_model');
        $operateur = new Operateur_model();
        $data = array(
            'idControle' => $idCtrl,
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
        $idCtrl = $this->input->post('idControle',TRUE);
        $ArrayInfoIndicateur = $this->getAllDataFromView();
        $CleanedForStruct = $this->StructureCleaning($ArrayInfoIndicateur);
        $AllDataArray = $this->getDataProcess2($this->input->post('lastinsert'),$CleanedForStruct);
        $StructIdArray = $this->createStructure2($AllDataArray);
        $ArrayLinkedDatas = $this->linkStructureToIndicateur($StructIdArray,$ArrayInfoIndicateur);
        $this->viewCalculExcelToSql($ArrayLinkedDatas,$idCtrl);
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
            $nomIndicateur = $this->input->post('indicateur_'.$i,TRUE);
            $nbFeuille = $this->input->post('nb_feuille_'.$i,TRUE);

            for ($f=1;$f<=$nbFeuille;$f++)
            {
                $datastart = $this->input->post('datastart_'.$i.'_'.$f,TRUE);
                $dataend = $this->input->post('dataend_'.$i.'_'.$f,TRUE);
                $nbColonne = $this->input->post('nb_colonne_'.$i.'_'.$f,TRUE);
                $nomfeuille = $this->input->post('txt_nom_feuille_'.$i.'_'.$f,TRUE);

                for($c=1;$c<=$nbColonne;$c++)
                {
                    $typeColonne = $this->input->post('type_colonne_'.$i.'_'.$f.'_'.$c,TRUE);
                    $lettreColonne = $this->input->post('value_'.$i.'_'.$f.'_'.$c,TRUE);
                    $ArrayInfoIndicateur[$nomIndicateur][$nomfeuille]['colonnes'][$typeColonne][] = $lettreColonne;
                }
                $ArrayInfoIndicateur[$nomIndicateur][$nomfeuille]['start'] = $datastart;
                $ArrayInfoIndicateur[$nomIndicateur][$nomfeuille]['end'] = $dataend;
            }
        }
        return($ArrayInfoIndicateur);
    }

    //Retourne un Array contenant les feuilles et les colonnes à entrer dans la table structure, sans doublons.
    public function StructureCleaning($ArrayInfoIndicateur)
    {
        $TempArray = array();
        $TempMergedArrays = array();
        $MergedArrays = array();
        //Merge les arrays, si les Feuilles sont déjà présentes,les colonnes de chaque indicateur sont combinées dans un même tableau.
        foreach($ArrayInfoIndicateur as $nomIndic => $ArrayFeuilles)
        {
            $MergedArrays = array_merge_recursive($ArrayFeuilles,$TempArray);
            $MergedArrays = array_merge_recursive($MergedArrays,$TempMergedArrays);
            $TempArray = $ArrayFeuilles;
            $TempMergedArrays = $MergedArrays;
        }
        $CleanedArray = array();
        foreach($MergedArrays as $nomfeuille => $ArrayItems)
        {
            foreach($ArrayItems as $item => $value)
            {
                if(is_array($value)) {
                    if($item == 'start')
                        $CleanedArray[$nomfeuille]['start'] = $value[0];
                    if($item == 'end')
                        $CleanedArray[$nomfeuille]['end'] = $value[0];
                } else {
                    if ($item == 'start') {
                        $CleanedArray[$nomfeuille]['start'] = $value;
                    }
                    if ($item == 'end') {
                        $CleanedArray[$nomfeuille]['end'] = $value;
                    }
                }

                if($item == 'colonnes') {
                    foreach($value as $typecolonne => $ArrayLettreColonne)
                    {
                        foreach($ArrayLettreColonne as $key => $lettrecolonne )
                        {
                            if(isset($CleanedArray[$nomfeuille]['colonnes'][$typecolonne])){
                                if(!in_array($lettrecolonne,$CleanedArray[$nomfeuille]['colonnes'][$typecolonne])) {
                                    $CleanedArray[$nomfeuille]['colonnes'][$typecolonne][] = $lettrecolonne;
                                }
                            }else{
                                $CleanedArray[$nomfeuille]['colonnes'][$typecolonne][] = $lettrecolonne;
                            }
                        }
                    }
                }
            }
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
                        if (!is_null($valeur) AND strlen($Strvaleur)>0) {
                            $arrayData[$header] = $valeur;
                            $arrayLigne[$numligne] = $arrayData;
                        } else {
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

        foreach ($ArrayInfoIndicateur as $nomFeuille => $ArrayInfos)
        {
            $colonnesExcel = $ArrayInfos['colonnes'];
            $datastart = $ArrayInfos['start'];
            $dataend = $ArrayInfos['end'];

            $objPHPExcel->setActiveSheetIndexByName($nomFeuille);
            $objWorksheet = $objPHPExcel->getActiveSheet();
            $nbechant = $dataend - $datastart;
            foreach ($colonnesExcel as $TypeColonne => $ArrayLettreColonne)
            {
                foreach($ArrayLettreColonne as $key => $lettrecolonne)
                {
                    for ($z = 0; $z <= $nbechant; $z++)
                    {
                        $numligne = $z + $datastart;
                        $valeur = $objWorksheet->getCell($lettrecolonne . $numligne)->getCalculatedValue();
                        $Strvaleur = strval($valeur);
                        if (!is_null($valeur) AND strlen($Strvaleur) > 0) {
                            $generalArray[$lastid][$nomFeuille][$lettrecolonne][$numligne][$TypeColonne] = $valeur;
                        } else {
                            $generalArray[$lastid][$nomFeuille][$lettrecolonne][$numligne][$TypeColonne] = 0;
                        }
                    }
                }
            }
            unset($objWorksheet);
        }
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
                if(!in_array($nomfeuille,$ArrayUsedSheets)) {
                    $insert_data = array(
                        "nom" => $nomfeuille,
                    );
                    $feuille->insert($insert_data);
                    $idFeuille = $feuille->get_last_id();
                }
                else {
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
        $this->load->model("Type_Colonne_model");
        $this->load->model("Structure_model");
        $this->load->model("Data_model");

        $struct = new Structure_model();
        $feuille = new Feuille_model();
        $col = new Colonne_model();
        $datamodel = new Data_model();
        $typecolonne = new Type_colonne_model();
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
                            if($lettreColonne != $previousColonne)
                            {
                                $TC = $typecolonne->get_by_nom($header);
                                $insert_data = array(
                                    "header" => $header,
                                    "lettre_excel" => $lettreColonne,
                                    "id_type_colonne" => $TC->id_Type_Colonne
                                );
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
                foreach($ArrayInfos['colonnes'] as $TypeColonnne => $ArrayLettre)
                {
                    foreach($ArrayLettre as $key => $lettre)
                    {
                        for($i=0;$i<=count($LinkArray)-1;$i++)
                        {
                            if($LinkArray[$i]['nom'] == $nomfeuille AND $LinkArray[$i]['lettre_excel'] == $lettre)
                            {
                                $ResultArray[$nomIndicateur][$nomfeuille]['colonnes'][$TypeColonnne][$lettre] = $LinkArray[$i]['id_structure'];
                            }
                        }
                    }
                }
            }
        }
        return($ResultArray);
    }

    public function ProcessCalcul()
    {
        $ArrayIndicEtape = $this->GenerateEtape();
        //$this->GenerateQuery2($ArrayIndicEtape);
        $this->GenerateQuery($ArrayIndicEtape);
    }

    public function GenerateEtape()
    {
        $this->load->model("Etape_model");
        $this->load->model("Indicateur_model");
        $this->load->model("Type_Indicateur_model");
        $this->load->model("Structure_model");

        $Etape = new Etape_model();
        $Indicateur = new Indicateur_model();
        $Type_Indicateur = new Type_indicateur_model();
        $ordre = 1;

        $idCtrl = $this->input->post('idControle');
        $ObjectFormula = json_decode($this->input->post('HiddenFormula',TRUE));
        $MagicArray = array();
        foreach($ObjectFormula as $nomIndic => $ArrayDenoNum)
        {
            $nomtype = $nomIndic."_".date("Y");
            $RespArray = $Type_Indicateur->getIdByNom($nomtype);

            if(count($RespArray)<=0){
                $insert_data = array(
                    "nom" => $nomtype
                );
                $Type_Indicateur->insert($insert_data);
                $idTypeIndic = $Type_Indicateur->get_last_id();
            } else {
                $idTypeIndic = $RespArray[0]['id_Type_Indicateur'];
            }

            $insert_data = array(
                "nom"=>$nomIndic,
                "id_Controle"=>$idCtrl,
                "id_Type_Indicateur"=>$idTypeIndic
            );

            $Indicateur->insert($insert_data);
            $idIndicateur = $Indicateur->get_last_id();

            foreach($ArrayDenoNum as $numerateur => $ArrayIdStruct)
            {
                foreach($ArrayIdStruct as $idStruct => $ArrayOperateur)
                {
                    foreach($ArrayOperateur as $key => $idOperateur)
                    {
                        $insert_data = array(
                            "ordre" => $ordre,
                            "id_Type_Indicateur"=>$idTypeIndic,
                            "id_Structure"=>$idStruct,
                            "id_Operateur"=>$idOperateur
                        );

                        $Etape->insert($insert_data);
                        $idEtape = $Etape->get_last_id();
                        $MagicArray[$idIndicateur]['nomIndic'] = $nomIndic;
                        $MagicArray[$idIndicateur]['arrayEtapes'][] = $idEtape;
                        $ordre++;
                    }
                }
            }
        }
        return($MagicArray);
    }

    public function GenerateQuery($ArrayIndicEtape)
    {
        $this->load->model("Etape_model");
        $this->load->model("Indicateur_model");
        $this->load->model("Structure_model");
        $this->load->model("Colonne_model");
        $this->load->model("Type_Colonne_model");
        $this->load->model("Operateur_model");
        $this->load->model("Agence_model");

        $Indicateur = new Indicateur_model();
        $ArrayResult = array();

        $ArrayFeuilleStructOperateur = array();
        foreach ($ArrayIndicEtape as $idIndic => $ArrayInfo) {
            $ArrayFeuille = $this->GetIdStructsFromEtape($ArrayInfo);
/*
            foreach ($ArrayFeuille as $idFeuille => $ArrayTypeCol) {
                $IdStructs = "";
                foreach ($ArrayTypeCol as $nomTypeCol => $ArrayConteneur) {
                    foreach ($ArrayConteneur as $conteneur => $ArrayInfos) {
                        foreach ($ArrayInfos as $indice => $info) {
                            if ($conteneur == "IdStructs") {
                                $IdStructs = $IdStructs . "," . $info;
                            }
                        }
                    }
                }
                $IdStructs = substr($IdStructs, 1);
*/
            foreach ($ArrayFeuille as $idFeuille => $ArrayTypeCol) {
                $ArrayQueries = array();
                $IdStructs = "";
                foreach ($ArrayTypeCol as $nomTypeCol => $ArrayIdStruct) {
                    foreach ($ArrayIdStruct as $idStruct => $ArrayOperateur) {
                        $IdStructs = $IdStructs . "," . $idStruct;
                        foreach ($ArrayOperateur as $indice => $operateur) {
                            $ArrayFeuilleStructOperateur[$idIndic][$idFeuille][$idStruct][] = $operateur;
                        }
                    }
                }
                $IdStructs = substr($IdStructs, 1);
                var_dump($IdStructs);


                $ArrayQueries[] = "DROP TEMPORARY TABLE IF EXISTS TMP_data;";
                $ArrayQueries[] = "CREATE TEMPORARY TABLE TMP_data AS(Select * FROM data WHERE id_Structure IN($IdStructs));";
                //TODO : penser à une meilleure intégration (ces requêtes seront toujours utilisées par le processus)
                $ArrayQueries[] = "ALTER TABLE TMP_data ADD Nom_Type_Colonne varchar(25);";
                $ArrayQueries[] = "ALTER TABLE TMP_data ADD id_feuille INTEGER(25);";
                $ArrayQueries[] = "DROP TEMPORARY TABLE IF EXISTS TMP_struct;";
                $ArrayQueries[] = "CREATE TEMPORARY TABLE TMP_struct AS(SELECT TMP_data.id_Structure,id_Colonne,structure.id_feuille FROM structure INNER JOIN TMP_data ON TMP_data.id_Structure = structure.id_Structure);";
                $ArrayQueries[] = "DROP TEMPORARY TABLE IF EXISTS TMP_colonne;";
                $ArrayQueries[] = "CREATE TEMPORARY TABLE TMP_colonne AS(SELECT TMP_struct.id_Colonne,id_Type_Colonne FROM colonne INNER JOIN TMP_struct ON TMP_struct.id_Colonne = colonne.id_Colonne);";
                $ArrayQueries[] = "DROP TEMPORARY TABLE IF EXISTS TMP_Type_Colonne;";
                $ArrayQueries[] = "CREATE TEMPORARY TABLE TMP_Type_Colonne AS(SELECT type_colonne.* FROM type_colonne INNER JOIN TMP_colonne ON TMP_colonne.id_Type_Colonne = type_colonne.id_Type_Colonne);";

                $Results = $this->GenerateUpdateQueries($ArrayTypeCol);
                $ArrayQueries = array_merge($ArrayQueries, $Results['Queries']);
                /* $TempTables = $Results['TempTables'];
                 $ArrayQueries[] = "DROP TEMPORARY TABLE IF EXISTS TMP_Sorted;";
                 $ArrayQueries[] = $this->GenerateJoinQuery($TempTables);
                 $ArrayQueries[] = "DROP TEMPORARY TABLE IF EXISTS TMP_Sorted2;";
                 $ArrayQueries[] = "CREATE TEMPORARY TABLE TMP_Sorted2 as (SELECT * FROM TMP_Sorted);";
                 $ArrayQueries['select'] = $this->GenerateSelectQuery($ArrayTypeCol);
                */
                $ArrayQueries['select'] = "SELECT * FROM TMP_data";
                $indic = $Indicateur->get_by_id($idIndic);
                $result = $Indicateur->execute_super_query($ArrayQueries);
                $megaquery = $result['megaquery'];
                unset($result['megaquery']);
                $ArrayResult[$idIndic][$idFeuille] = $result;
            }
        }

        $FinalResult = array();
        foreach ($ArrayResult as $IdIndic => $arrayfeuille) {
            foreach ($arrayfeuille as $idFeuille => $ArrayDatas) {
                foreach ($ArrayDatas as $indice => $ArrayDataResult) {
                    $FinalResult[$IdIndic][$idFeuille][$ArrayDataResult['num_ligne_excel']][$ArrayDataResult['id_Structure']] = [$ArrayDataResult['data']];
                }
            }
        }

        $this->load->model("Feuille_model");
        $feuilleModel = new Feuille_model();
        $structModel = new Structure_model();
        $colonneModel = new Colonne_model();
        $TypeColModel = new Type_colonne_model();
        $agenceModel = new Agence_model();
        $indicateurModel = new Indicateur_model();
        $operateurModel = new Operateur_model();


        $ArrayFinalResult = array();
        // Création d'un Array permettant d'identifier les identifiants et de noter les lignes du fichier leur correspondant
        foreach ($FinalResult as $IdIndic => $ArrayIdFeuille) {
            $GroupArray = array();
            foreach ($ArrayIdFeuille as $IdFeuille => $ArrayNumLigne) {
                foreach ($ArrayNumLigne as $numligne => $ArrayIdStructure) {
                    foreach ($ArrayIdStructure as $idStructure => $ArrayData) {
                        $structure = $structModel->get_by_id($idStructure);
                        $colonne = $colonneModel->get_by_id($structure->id_Colonne);
                        $typecolonne = $TypeColModel->get_by_id($colonne->id_Type_Colonne);
                        if ($typecolonne->isIdentifiant) {
                            $GroupArray[$ArrayData[0]][$IdFeuille][] = $numligne;
                        }
                    }
                }
            }

            // Remplacement des lignes par les données réelles afin de pouvoir appliquer les opérateurs
            $CCSArray = array();
            foreach($GroupArray as $Identifiant => $ArrayFeuille){
                if(strlen($Identifiant) > 1) {
                    $Agence = $agenceModel->get_by_id($Identifiant);
                    foreach ($ArrayFeuille as $IdFeuille => $ArrayNumLigne) {
                        foreach ($ArrayNumLigne as $indice => $numligne) {
                            foreach ($ArrayIdFeuille[$IdFeuille][$numligne] as $idStructure => $ArrayData) {
                                $structure = $structModel->get_by_id($idStructure);
                                $colonne = $colonneModel->get_by_id($structure->id_Colonne);
                                $typecolonne = $TypeColModel->get_by_id($colonne->id_Type_Colonne);
                                if (!($typecolonne->isIdentifiant)) {
                                    $CCSArray[$Agence->nom][$idStructure][] = abs($ArrayData[0]);
                                }
                            }
                        }
                    }
                }
            }

            $ArrayFinalResult[$IdIndic]['total'] = array();
            foreach($CCSArray as $NomAgence => $ArrayIdStructure){
                $ArrayFinalResult[$IdIndic][$NomAgence] = array();
                foreach($ArrayIdStructure as $idStruct => $ArrayData){
                    $struct = $structModel->get_by_id($idStruct);
                    $col = $colonneModel->get_by_id($struct->id_Colonne);
                    $TypeCol = $TypeColModel->get_by_id($col->id_Type_Colonne);
                    $ArrayOperateur = $ArrayFeuilleStructOperateur[$IdIndic][$struct->id_feuille][$idStruct];
                    foreach($ArrayOperateur as $indice => $idOperateur) {
                        $operateur = $operateurModel->get_by_id($idOperateur);
                        switch($operateur->valeur){
                            case "NBVAL":
                                if(array_key_exists($TypeCol->nom,$ArrayFinalResult[$IdIndic][$NomAgence])){
                                    $ArrayFinalResult[$IdIndic][$NomAgence][$TypeCol->nom] += count($ArrayData);
                                } else {
                                    $ArrayFinalResult[$IdIndic][$NomAgence][$TypeCol->nom] = count($ArrayData);
                                }

                                if(array_key_exists($TypeCol->nom,$ArrayFinalResult[$IdIndic]['total'])){
                                    $ArrayFinalResult[$IdIndic]['total'][$TypeCol->nom] += count($ArrayData);
                                } else {
                                    $ArrayFinalResult[$IdIndic]['total'][$TypeCol->nom] = count($ArrayData);
                                }
                                break;
                            case "SOMME":
                                if(array_key_exists($TypeCol->nom,$ArrayFinalResult[$IdIndic][$NomAgence])){
                                    $ArrayFinalResult[$IdIndic][$NomAgence][$TypeCol->nom] += array_sum($ArrayData);
                                } else {
                                    $ArrayFinalResult[$IdIndic][$NomAgence][$TypeCol->nom] = array_sum($ArrayData);
                                }

                                if(array_key_exists($TypeCol->nom,$ArrayFinalResult[$IdIndic]['total'])){
                                    $ArrayFinalResult[$IdIndic]['total'][$TypeCol->nom] += array_sum($ArrayData);
                                } else {
                                    $ArrayFinalResult[$IdIndic]['total'][$TypeCol->nom] = array_sum($ArrayData);
                                }
                                break;
                        }
                    }
                }
            }
        }

        foreach($ArrayFinalResult as $id => $array)
        {
            $indic = $Indicateur->get_by_id($id);
            var_dump($indic->nom);
            var_dump($array);
        }

        //le nombre de totalcount n'est pas bon

    }

    function GetIdStructsFromEtape($ArrayInfo)
    {
        $Etape = new Etape_model();
        $Structure = new Structure_model();
        $Colonne = new Colonne_model();
        $Type_Colonne = new Type_colonne_model();
        $ArrayIdStruct = array();
        $ArrayFeuille = array();

        foreach($ArrayInfo['arrayEtapes'] as $key => $idEtape)
        {
            $varEtape = $Etape->get_by_id($idEtape);
            $varStruct = $Structure->get_by_id($varEtape->id_Structure);
            $varFeuille = $varStruct->id_feuille;
            $varColonne = $Colonne->get_by_id($varStruct->id_Colonne);
            $varTypeColonne = $Type_Colonne->get_by_id($varColonne->id_Type_Colonne);

            $Resp = $Structure->get_column_identifiant($varStruct->id_Fichier,$varFeuille);
            $structIdent = $Resp[0]['id_Colonne'];

            if(!isset($ArrayFeuille[$varFeuille]['Identifiant'][$structIdent])){
                $ArrayFeuille[$varFeuille]['Identifiant'][$structIdent][] = null ;
            }
            $ArrayFeuille[$varFeuille][$varTypeColonne->nom][$varStruct->id_Structure][] = $varEtape->id_Operateur;;

            /*
            if(!isset($ArrayFeuille[$varFeuille]['Identifiant']['IdStructs'])){
                $ArrayFeuille[$varFeuille]['Identifiant']['IdStructs'][] = $structIdent;
                $ArrayFeuille[$varFeuille]['Identifiant']['Operateurs'][] = null;
            }
            $ArrayFeuille[$varFeuille][$varTypeColonne->nom]['IdStructs'][] = $varStruct->id_Structure;
            $ArrayFeuille[$varFeuille][$varTypeColonne->nom]['Operateurs'][] = $varEtape->id_Operateur;
            */
        }

        return($ArrayFeuille);
    }
    /*
    function GetIdStructsFromEtape($ArrayInfo)
    {
        $Etape = new Etape_model();
        $Structure = new Structure_model();
        $Colonne = new Colonne_model();
        $Type_Colonne = new Type_colonne_model();
        $ArrayIdStruct = array();
        $IdStructs="";

        foreach($ArrayInfo['arrayEtapes'] as $key => $idEtape)
        {
            $varEtape = $Etape->get_by_id($idEtape);
            $varStruct = $Structure->get_by_id($varEtape->id_Structure);
            $varColonne = $Colonne->get_by_id($varStruct->id_Colonne);
            $varTypeColonne = $Type_Colonne->get_by_id($varColonne->id_Type_Colonne);

            $Resp = $Structure->get_column_identifiant($varStruct->id_Fichier,$varStruct->id_feuille);
            $structIdent = $Resp[0]['id_Colonne'];
            if(isset($ArrayIdStruct['Identifiant']['idStruct'])){
                if(!in_array($structIdent,$ArrayIdStruct['Identifiant']['idStruct'])) {
                    $ArrayIdStruct['Identifiant']['idStruct'][] = $structIdent;
                    $ArrayIdStruct['Identifiant']['Operateurs'][] = null;
                    $IdStructs = $IdStructs.','.$structIdent;
                }
            } else {
                $ArrayIdStruct['Identifiant']['idStruct'][] = $structIdent;
                $ArrayIdStruct['Identifiant']['Operateurs'][] = null;
                $IdStructs = $IdStructs.','.$structIdent;
            }
            $IdStructs = $IdStructs.','.$varEtape->id_Structure;
            $ArrayIdStruct[$varTypeColonne->nom]['idStruct'][] = $varEtape->id_Structure;
            $ArrayIdStruct[$varTypeColonne->nom]['Operateurs'][] = $varEtape->id_Operateur;
        }
        $IdStructs = substr($IdStructs, 1);
        $ArrayIdStruct['IdStructs'] = $IdStructs;
        return($ArrayIdStruct);
    }

    function GenerateUpdateQueries($ArrayIdStruct)
    {
        $ArrayCreateTempTables = array();
        $ArrayQueries = array();
        $ArrayTempTable = array();
        foreach($ArrayIdStruct as $nomtype => $KeyStruct)
        {
            $KeyStruct = $ArrayIdStruct[$nomtype]['IdStructs'];
            $nomtable = "TMP_data_$nomtype";
            $ArrayTempTable[$nomtype] = $nomtable;
            for($s=0;$s<=count($KeyStruct)-1;$s++)
            {
                $ArrayQueries[] = "UPDATE TMP_data SET Nom_Type_Colonne =(SELECT DISTINCT nom FROM TMP_Type_Colonne,TMP_Colonne,TMP_struct WHERE TMP_Type_Colonne.id_Type_Colonne = TMP_Colonne.id_Type_Colonne AND TMP_Colonne.id_Colonne = TMP_struct.id_Colonne AND id_structure = $KeyStruct[$s]) WHERE id_Structure = $KeyStruct[$s];";
                $ArrayQueries[] = "UPDATE TMP_data SET id_feuille =(SELECT DISTINCT id_feuille FROM TMP_struct WHERE id_structure = $KeyStruct[$s]) WHERE id_Structure = $KeyStruct[$s];";
                $ArrayCreateTempTables[] = "DROP TEMPORARY TABLE IF EXISTS $nomtable;";
                $ArrayCreateTempTables[] = "CREATE TEMPORARY TABLE $nomtable AS (SELECT id_data as id_data_$nomtype,num_ligne_excel as num_ligne_excel_$nomtype,data as data_$nomtype FROM TMP_data WHERE Nom_Type_Colonne = '$nomtype');";
            }
        }
        $ArrayQueries = array_merge($ArrayQueries,$ArrayCreateTempTables);
        $ArrayResult['Queries'] = $ArrayQueries;
        $ArrayResult['TempTables'] = $ArrayTempTable;
        return($ArrayResult);
    }
*/
    function GenerateUpdateQueries($ArrayTypeColonne)
    {
        $ArrayQueries = array();
        foreach($ArrayTypeColonne as $nomTypeColonne => $ArrayIdStruct) {
            foreach($ArrayIdStruct as $idStruct => $ArrayOperateur){
                $ArrayQueries[] = "UPDATE TMP_data SET Nom_Type_Colonne =(SELECT DISTINCT nom FROM TMP_Type_Colonne,TMP_Colonne,TMP_struct WHERE TMP_Type_Colonne.id_Type_Colonne = TMP_Colonne.id_Type_Colonne AND TMP_Colonne.id_Colonne = TMP_struct.id_Colonne AND id_structure = $idStruct) WHERE id_Structure = $idStruct;";
                $ArrayQueries[] = "UPDATE TMP_data SET id_feuille =(SELECT DISTINCT id_feuille FROM TMP_struct WHERE id_structure = $idStruct) WHERE id_Structure = $idStruct;";
            }
        }
        $ArrayResult['Queries'] = $ArrayQueries;
        return($ArrayResult);
    }

    function GenerateJoinQuery($TempTables)
    {
        $JoinQuery = "CREATE TEMPORARY TABLE TMP_Sorted AS(SELECT * FROM ";
        $TempTables2 = $TempTables;
        next($TempTables2);
        $first = true;
        foreach($TempTables as $nomtype => $nomtable) {
            $nomtype2 = key($TempTables2);
            $nomtable2 = $TempTables2[$nomtype2];
            if ($first) {
                $JoinQuery = $JoinQuery . "$nomtable INNER JOIN $nomtable2 ON $nomtable.num_ligne_excel_$nomtype=$nomtable2.num_ligne_excel_$nomtype2 ";
                $first = false;
            } else {
                $JoinQuery = $JoinQuery . "INNER JOIN $nomtable2 ON $nomtable.num_ligne_excel_$nomtype=$nomtable2.num_ligne_excel_$nomtype2 ";
            }
            if ($this->has_next($TempTables2)) {
                next($TempTables2);
            } else {
                break;
            }
        }
        $JoinQuery = $JoinQuery .");";
        return($JoinQuery);
    }

    function has_next($array) {
        if (is_array($array)) {
            if (next($array) === false) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    function GenerateSelectQuery($ArrayIdStruct)
    {
        $this->load->model("Operateur_model");
        $this->load->model("Type_Colonne_model");
        $OperateurModel = new Operateur_model();
        $TypeColModel = new Type_colonne_model();
        $SelectQuery = "SELECT ";
        $varSelect = "";
        $FromQuery = " FROM TMP_Sorted";
        $varFrom = "";
        $WhereQuery = "";
        $varWhere = "";
        $GroupQuery = "GROUP BY ";
        $varGroup = "";
        $i=0;
        $lastnomtype="";
        foreach($ArrayIdStruct as $nomtype => $value) {
            if($nomtype != $lastnomtype){
                $i=0;
            }
            $typecol = $TypeColModel->get_by_nom($nomtype);
            $ArrayOperateurs = $ArrayIdStruct[$nomtype]['Operateurs'];
            $count = count($ArrayOperateurs);
            $idOp = $ArrayOperateurs[$i];
            $operateur = $OperateurModel->get_by_id($idOp);
            if($typecol->isIdentifiant){
                //A remplacer par CCS
                switch($typecol->nom){
                    case "Identifiant":
                        $varSelect = $varSelect . ",nom as Agence";
                        $varFrom = $varFrom.",agence ";
                        $varWhere = $varWhere." WHERE TMP_Sorted.data_Identifiant=agence.CCS ";
                        $varGroup = $varGroup.",nom";
                        break;
                    case "DMR":
                        $varSelect = $varSelect . ",COUNT(DISTINCT(data_DMR)) AS NbDMR";
                        break;
                    default:
                        $varSelect = $varSelect . ",data_$typecol->nom AS $typecol->nom";
                        $varGroup = $varGroup.",data_$typecol->nom";
                        break;
                }
            } else {
                if($typecol->nom == "Montant" || $typecol->nom == "Nombre")
                {
                    $varSelect = $varSelect . ",ROUND((($operateur->valeursql(ABS(data_$typecol->nom)))/2),2) as $typecol->nom";
                } else {
                    $varSelect = $varSelect . ",ROUND(($operateur->valeursql(ABS(data_$typecol->nom))),2) as $typecol->nom";
                }
            }
            if($i<$count) {
                $i++;
            }
            $lastnomtype = $nomtype;
        }

        if(key_exists("Anomalie",$ArrayIdStruct) && key_exists("Montant",$ArrayIdStruct)){
            $varSelect = $varSelect . ",ROUND((SUM(ABS(data_Anomalie))/((SUM(ABS(data_Montant)))/2)*100),2) as 'Anomalie/Montant'";
            $varSelect = $varSelect . ",ROUND(((SUM(ABS(data_Anomalie)))/((SELECT((SUM(ABS(data_Montant)))/2) FROM TMP_Sorted2)))*100 ,2) as 'Anomalie/MontantTotal'";
        }
        if(key_exists("NbAnomalie",$ArrayIdStruct) && key_exists("Nombre",$ArrayIdStruct)){
            $varSelect = $varSelect . ",ROUND((SUM(ABS(data_NbAnomalie))/((COUNT(ABS(data_Nombre)))/2)*100),2) as 'NbAnomalie/NbAgence'";
            $varSelect = $varSelect . ",ROUND((SUM(ABS(data_NbAnomalie))/((SELECT((COUNT(ABS(data_Nombre)))/2)  FROM TMP_Sorted2)))*100,2) as 'NbAnomalie/NbTotal'";
        }

        $varSelect = $this->CheckComma($varSelect);
        $varGroup = $this->CheckComma($varGroup);
        $varWhere = $this->CheckComma($varWhere);

        $SelectQuery = $SelectQuery . $varSelect;
        $FromQuery = $FromQuery . $varFrom;
        $WhereQuery = $WhereQuery . $varWhere;
        $GroupQuery = $GroupQuery . $varGroup;
        return($SelectQuery.$FromQuery.$WhereQuery.$GroupQuery);
    }

    function CheckComma($var){
        if((strpos($var,",")) == 0) {
            $var = substr($var,1);
        }
        return($var);
    }

    public function GenerateQuery2($ArrayIndicEtape){

        $this->load->model("Etape_model");
        $this->load->model("Indicateur_model");
        $this->load->model("Structure_model");
        $this->load->model("Colonne_model");
        $this->load->model("Type_Colonne_model");

        $Etape = new Etape_model();
        $Indicateur = new Indicateur_model();
        $Structure = new Structure_model();
        $Colonne = new Colonne_model();
        $Type_Colonne = new Type_colonne_model();

        foreach($ArrayIndicEtape as $idIndic => $ArrayInfo)
        {
            $ArrayIdStruct = array();
            $IdStructs ="";
            $SuperQuery ="";
            foreach($ArrayInfo['arrayEtapes'] as $key => $idEtape)
            {
                $varEtape = $Etape->get_by_id($idEtape);
                $varStruct = $Structure->get_by_id($varEtape->id_Structure);
                $varColonne = $Colonne->get_by_id($varStruct->id_Colonne);
                $varTypeColonne = $Type_Colonne->get_by_id($varColonne->id_Type_Colonne);

                $Resp = $Structure->get_column_identifiant($varStruct->id_Fichier,$varStruct->id_feuille);
                $structIdent = $Resp[0]['id_Colonne'];
                if(isset($ArrayIdStruct['Identifiant']['idStruct'])){
                    if(!in_array($structIdent,$ArrayIdStruct['Identifiant']['idStruct'])) {
                        $ArrayIdStruct['Identifiant']['idStruct'][] = $structIdent;
                        $ArrayIdStruct['Identifiant']['Operateurs'][] = null;
                        $IdStructs = $IdStructs.','.$structIdent;
                    }
                } else {
                    $ArrayIdStruct['Identifiant']['idStruct'][] = $structIdent;
                    $ArrayIdStruct['Identifiant']['Operateurs'][] = null;
                    $IdStructs = $IdStructs.','.$structIdent;
                }
                $IdStructs = $IdStructs.','.$varEtape->id_Structure;
                $ArrayIdStruct[$varTypeColonne->nom]['idStruct'][] = $varEtape->id_Structure;
                $ArrayIdStruct[$varTypeColonne->nom]['Operateurs'][] = $varEtape->id_Operateur;
            }
            $IdStructs = substr($IdStructs, 1);

            $SuperQuery = "CREATE TEMPORARY TABLE TMP_data AS(Select * FROM data WHERE id_Structure IN($IdStructs));";
            $SuperQuery = $SuperQuery." ALTER TABLE TMP_data ADD Nom_Type_Colonne varchar(25); CREATE TEMPORARY TABLE TMP_struct AS(SELECT TMP_data.id_Structure,id_Colonne FROM structure INNER JOIN TMP_data ON TMP_data.id_Structure = structure.id_Structure); CREATE TEMPORARY TABLE TMP_colonne AS(SELECT TMP_struct.id_Colonne,id_Type_Colonne FROM colonne INNER JOIN TMP_struct ON TMP_struct.id_Colonne = colonne.id_Colonne); CREATE TEMPORARY TABLE TMP_Type_Colonne AS(SELECT type_colonne.* FROM type_colonne INNER JOIN TMP_colonne ON TMP_colonne.id_Type_Colonne = type_colonne.id_Type_Colonne);";
            $UpdateQuery = "";
            $TempTableQuery = "";
            var_dump($idIndic);
            var_dump($ArrayIdStruct);
            foreach($ArrayIdStruct as $nomtype => $KeyStruct)
            {
                $KeyStruct = $ArrayIdStruct[$nomtype]['idStruct'];
                for($s=0;$s<=count($KeyStruct)-1;$s++)
                {
                    $UpdateQuery = $UpdateQuery."UPDATE TMP_data
SET Nom_Type_Colonne =(SELECT DISTINCT nom FROM TMP_Type_Colonne,TMP_Colonne,TMP_struct WHERE TMP_Type_Colonne.id_Type_Colonne = TMP_Colonne.id_Type_Colonne AND TMP_Colonne.id_Colonne = TMP_struct.id_Colonne AND id_structure = $KeyStruct[$s])
WHERE id_Structure = $KeyStruct[$s];";
                    $TempTableQuery = $TempTableQuery."CREATE TEMPORARY TABLE TMP_data_$nomtype AS (SELECT id_data as id_data_$nomtype,num_ligne_excel as num_ligne_excel_$nomtype,data as data_$nomtype FROM TMP_data WHERE Nom_Type_Colonne = '$nomtype');";
                }
            }
            $SuperQuery = $SuperQuery.$UpdateQuery.$TempTableQuery;
            $LastQuery = "CREATE TEMPORARY TABLE TMP_Sorted AS(SELECT * FROM ";
            $TempArrayIdStruct1 = $ArrayIdStruct;
            $TempArrayIdStruct2 = $ArrayIdStruct;
            next($TempArrayIdStruct2);
            for($i=1;$i<=count($ArrayIdStruct)-1;$i++)
            {
                if($this->has_next($TempArrayIdStruct2)) {
                    $nomtype = key($TempArrayIdStruct1);
                    $nomtype2 = key($TempArrayIdStruct2);
                    if ($i == 1) {
                        $LastQuery = $LastQuery . "TMP_data_$nomtype INNER JOIN TMP_data_$nomtype2 ON TMP_data_$nomtype.num_ligne_excel_$nomtype=TMP_data_$nomtype2.num_ligne_excel_$nomtype2 ";
                    } else {
                        $LastQuery = $LastQuery . "INNER JOIN TMP_data_$nomtype2 ON TMP_data_$nomtype.num_ligne_excel_$nomtype=TMP_data_$nomtype2.num_ligne_excel_$nomtype2 ";
                    }
                    next($TempArrayIdStruct1);
                    next($TempArrayIdStruct2);
                }
                else{
                    $nomtype = key($TempArrayIdStruct1);
                    $nomtype2 = key($TempArrayIdStruct2);
                    $LastQuery = $LastQuery . "INNER JOIN TMP_data_$nomtype2 ON TMP_data_$nomtype.num_ligne_excel_$nomtype=TMP_data_$nomtype2.num_ligne_excel_$nomtype2 ";
                }
            }
            $LastQuery = $LastQuery .");";
            $SuperQuery = $SuperQuery . $LastQuery;

            $CalcQuery = "SELECT data_Identifiant";
            foreach($ArrayIdStruct as $nomtype => $value)
            {
                $ArrayOperateurs = $ArrayIdStruct[$nomtype]['Operateurs'];
                foreach($ArrayOperateurs as $key => $idOp)
                {
                    //TODO : Ajouter "valeursql dans la BDD pour mieux gérer les opérateurs"
                    if($nomtype != "Identifiant") {
                        if($nomtype == "Montant" || $nomtype == "Anomalie")
                        {
                            $valeursql = "SUM(ABS(";
                            $CalcQuery = $CalcQuery . "," . $valeursql . "data_" . $nomtype . "))";
                        }
                    }
                }
            }
            $CalcQuery = $CalcQuery . "FROM TMP_Sorted GROUP BY data_Identifiant;";
            $SuperQuery = $SuperQuery . $CalcQuery;
            var_dump($Indicateur->execute_super_query($SuperQuery));
        }

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
        $config['allowed_types'] = 'xlsx|xlsm';
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

        $idctrl = $this->input->post('id_Controle',TRUE);
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
            $this->viewProcessExcel2($fichier,$idctrl);

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

    redirect('index.php/controle/viewAjoutExcel');
    }
    }*/
}

/* End of file Controle.php */
/* Location: ./application/controllers/Controle.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2016-10-28 15:16:08 */
/* http://harviacode.com */