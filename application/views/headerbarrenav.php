
<link rel="stylesheet" href="<?php echo base_url('/assets/bootstrap/css/bootstrap.css') ?>"/>
<link rel="stylesheet" href="<?php echo base_url('/assets/styles/general.css') ?>"/>

<!--
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
-->

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="#"> CQO </a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="active">
                    <a href="#">Statistiques</a>
                </li>
                <li>
                    <a href='<?php echo base_url('index.php/controle/create')?>'>Ajouter un Controle</a>
                </li>
                <li>
                    <a href='<?php echo base_url('index.php/controle')?>'>Liste Controle</a>
                </li>
                <li>
                    <a href='<?php echo base_url('index.php/controle/viewUploadCCS')?>'>Ajout CCS</a>
                </li>
                <li>
                    <a href='<?php echo base_url('index.php/controle/viewGrapheTest')?>'>AjoutGraph</a>
                </li>
                <li>
                    <a href='<?php echo base_url('index.php/controle/viewIframeTest')?>'>TestIframe</a>
                </li>

                <li class="dropdown">
                    <a class="dropdown-toggle" aria-expanded="true" aria-haspopup="true" role="button" data-toggle="dropdown" href="">
                        Dropdown exemple
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li> <a href='../controle/create'>Lien2</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>