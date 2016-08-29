<?php include 'headerbarrenav.php'; ?>
<link rel="stylesheet" href="<?php echo base_url('/assets/style/general.css') ?>"/>


<html>
<head>
    <title>Upload Form</title>
</head>
<body>
 <div class="container">
   <div class="center-block">
   <?php echo form_open_multipart('index.php/controle/ajoutExcel');?>

   <input type="file" id="fichier_xl" name="fichier_xl" size="20" />
   <br /><br />
   <input type="submit" value="upload" />
   </form>
       <input type="text" id="resptext" name="resptext">
  </div>
 </div>
</body>
</html>