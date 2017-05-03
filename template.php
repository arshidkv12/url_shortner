<!DOCTYPE html>
<html>
<head>
    <title>url shortner</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
 <div class="wrap">
    <div class="short-url"><?php echo isset($short_url)?$short_url:'';?></div> 
     <form method="post">
         <input type="url" class="form-control" name="url" placeholder="url" required>
         <input type="submit" class="btn btn-primary" value="Shorten" >
     </form>
 </div>
</body>
</html>