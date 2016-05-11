<link rel="stylesheet" href="<?php echo base_url('/assets/bootstrap/css/bootstrap.css') ?>"/>
<link rel="stylesheet" href="<?php echo base_url('/assets/styles/login.css') ?>"/>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="#"> CQO </a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="active">
                    <a href="#">Lien1</a>
                </li>
                <li>
                    <a href='../controle/create'>Lien2</a>
                </li>
                <li>
                    <a href='../controle'>Liste Controle</a>
                </li>
                <li>
                    <a href='../controle'>Statistiques</a>
                </li>
                <li>
                    <a href='../controle'>Moulinette</a>
                </li>

                <li class="dropdown">
                    <a class="dropdown-toggle" aria-expanded="true" aria-haspopup="true" role="button" data-toggle="dropdown" href="#">
                        Dropdown exemple
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li> <a href='../controle/create'>Lien2</a></li>
                    </ul>
                </li>
        </div>
    </div>
</nav>