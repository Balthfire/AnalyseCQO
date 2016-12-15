<?php include 'headerbarrenav.php'; ?>
<link rel="stylesheet" href="<?php echo base_url('/assets/style/general.css') ?>"/>

<html>
<head>
    <title>Upload Form</title>
</head>
<body>
 <div class="container">
   <div class="center-block">
   <?php echo form_open_multipart('index.php/controle/storeExcel');?>

   <input type="file" id="fichier_xl" name="fichier_xl" class="btn btn-primary" />
   <input type="hidden" name="id_Controle" value="<?php $_GET['idctrl'] ?>" />

   <br /><br />
   <input type="submit" value="Upload" class="btn btn-primary" />
   </form>
  </div>
 </div>
</body>
</html>