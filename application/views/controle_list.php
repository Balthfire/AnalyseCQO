<?php include 'headerbarrenav.php'; ?>

<!doctype html>
<html>
    <head>
        <style>
            body{
                padding: 15px;
            }
        </style>
    </head>
    <body>
        <h2 style="margin-top:0px">Controle List</h2>
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php echo anchor(site_url('index.php/controle/create'),'Create', 'class="btn btn-primary"'); ?>
            </div>
            <div class="col-md-4 text-center">
                <div style="margin-top: 8px" id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-1 text-right">
            </div>
            <div class="col-md-3 text-right">
                <form action="<?php echo site_url('controle/index'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php 
                                if ($q <> '')
                                {
                                    ?>
                                    <a href="<?php echo site_url('controle'); ?>" class="btn btn-default">Reset</a>
                                    <?php
                                }
                            ?>
                          <button class="btn btn-primary" type="submit">Search</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
        <table class="table table-bordered" style="margin-bottom: 10px">
            <tr>
		<th>Action</th>
		<th>Nom</th>
		<th>NNI</th>
            </tr><?php
            foreach ($controle_data as $controle)
            {
                ?>
        <tr>
            <td style="text-align:center" width="200px">
                <?php
                echo anchor(site_url('index.php/controle/read/'.$controle->id_Controle),'Read');
                echo ' | ';
                echo anchor(site_url('index.php/controle/update/'.$controle->id_Controle),'Update');
                echo ' | ';
                echo anchor(site_url('index.php/controle/delete/'.$controle->id_Controle),'Delete','onclick="javasciprt: return confirm(\'Are You Sure ?\')"');
                echo ' | ';
                echo anchor(site_url('index.php/controle/viewUploadExcel?idctrl='.$controle->id_Controle),'Excel');
                ?>
            </td>
			<td><?php echo $controle->nom ?></td>
			<td><?php echo $controle->NNI ?></td>
		</tr>
                <?php
            }
            ?>
        </table>
        <div class="row">
            <div class="col-md-6">
                <a href="#" class="btn btn-primary">Total Record : <?php echo $total_rows ?></a>
	    </div>
            <div class="col-md-6 text-right">
                <?php echo $pagination ?>
            </div>
        </div>
    </body>
</html>