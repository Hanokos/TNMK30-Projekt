<html>
    <head>
    <meta charset="utf-8">
      
        <link rel="stylesheet" href="style.css">
        <script src="effect.js" defer></script>
    </head>
    <body>
    <section id="header">
    <div class="header container">
      <div class="nav-bar">
        <div class="brand">
          <a href="index.html"><img src="lego logo 4.0.png" alt="Logo"></a>
        </div>
        <div class="nav-list">
          <div class="hamburger"><div class="bar"></div></div>
          <ul>
            <li><a href="index.html" data-after="Home">Home</a></li>
            <li><a href="about.html" data-after="Service">About</a></li>
            <li><a href="search.php" data-after="Contact">Search</a></li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  </section>

</html>

<?php


$connection = mysqli_connect("mysql.itn.liu.se", "lego", "", "lego");

 

if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);

}



$SetID = $_GET['set'];

$query = "SELECT * FROM sets WHERE SetID = '$SetID'";

$result = mysqli_query($connection,  $query);



$info = "SELECT inventory.Quantity, inventory.SetID , inventory.ItemID, parts.Partname, images.ItemID, images.ItemtypeID,images.ColorID,
images.has_gif, images.has_jpg, images.has_largegif, images.has_largejpg, colors.Colorname FROM inventory, parts, colors, images WHERE
inventory.SetID =  '$SetID' AND parts.PartID = inventory.ItemID AND colors.ColorID = inventory.ColorID AND images.ItemID = inventory.ItemID
AND colors.ColorID = images.ColorID ORDER BY inventory.Quantity DESC";



$result = mysqli_query($connection, $info);

if(1 == 1){
  echo("
  <h3 class='mycss'> parts included in set $SetID ($setname):</h3>
<table>
   <tr>
     <td>Image </td>
     <td> part name </td>
     <td> Color </td>
     <td> Quantity </td>
   </tr>
</table>"

);}

while   ($row =  mysqli_fetch_array($result)){



$invpart = $row['Partname'];

$invqual = $row['Quantity'];

$colorsname = $row['Colorname'];

$itemid = $row['ItemID'];

$itemtype = $row['ItemtypeID'];

$colorid = $row['ColorID'];

$gif = $row['has_gif'];

$jpg = $row['has_jpg'];

$imagesrc = "";





if ($jpg){

    $imagesrc = "http://www.itn.liu.se/~stegu76/img.bricklink.com/$itemtype/$colorid/$itemid.jpg";

    


}

else if ($gif){

    $imagesrc = "http://www.itn.liu.se/~stegu76/img.bricklink.com/$itemtype/$colorid/$itemid.gif";


}





print (

 "<table class = 'sheesh' >
     <tr>
        <td> <img src= $imagesrc> </td>
        <td> $invpart </td>
        <td> $colorsname </td>
        <td> $invqual </td>
       
     </tr>
    <table>"

) ;

}


