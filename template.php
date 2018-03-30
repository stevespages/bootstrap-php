<?php

return 

'
<!DOCTYPE html>
<html lang="en">
<head>
  <title>'.$title.'</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container-fluid">
<div>'.$navigation.'
<div class="steve-nav-bar"></div>
<h1>'.$main_heading.'</h1>
<div class="row">
  <div class="col-sm"><h3>'.$sub_heading.'</h3>'.$content[0].'</div>
  <div class="col-sm">'.$content[1].'</div>
  <div class="col-sm">'.$content[2].'</div>
</div>

<div class="row">
  <div class="col-sm"></div>
</div>

</div>

</body>
</html>
'
;