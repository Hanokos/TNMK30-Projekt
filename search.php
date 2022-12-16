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
        <a href="index.html"><h1><span></span>block<span> browse</span></h1></a>
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

  <form class= "form" action = "search.php" method ="POST" >
        <select name="selectedValue">
            <option value="Set-id">Set-id</option>
            <option value="brick">Brick</option>
            <option value="Set-name">Set-name</option>
        </select>
            <label for="text"> Set id</label> <br>
            <input type="text" name = "text" id = "text" required>
        </div>
        <input type="submit" value = "input">
     </form> 
</html>

<?php

switch($_POST['selectedValue']){
    case 'Set-id':
     
        $connection = mysqli_connect("mysql.itn.liu.se", "lego", "", "lego");
 
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    
    
        $SetID = $_POST['text'];
    
        $query = "SELECT * FROM sets WHERE SetID = '$SetID'";
    
    
    $searchid = mysqli_query($connection, "SELECT sets.SetID, images.has_largejpg, images.has_largegif, images.has_jpg, images.has_gif FROM sets, images
    WHERE sets.SetID = '$SetID' AND images.ItemtypeID = 'S' AND images.ItemID = sets.SetID");
    
        while($row = mysqli_fetch_array($searchid)){
             
          
            $set_name = $row['Setname'];
            $setid1 = $row['SetID'];
            $itemid = $row['ItemID'];
            $gif = $row['has_gif'];
            $jpg = $row['has_jpg'];
            $gifL = $row['has_largegif'];
            $jpgL = $row['has_largejpg'];
    
          
        
             
            
    $gifL = $row['has_largegif'];
            if ($jpgL){
                $imagesrc = "http://www.itn.liu.se/~stegu76/img.bricklink.com/SL/$setid1.jpg";
            }
    
            else if  ($jpg){
                $imagesrc = "http://www.itn.liu.se/~stegu76/img.bricklink.com/SL/$setid1.gif";   
            }
            else {
                $imagesrc = "https://weber.itn.liu.se/~stegu76/img.bricklink.com/SL/375-2.jpg"; 
    
            }
            
            print("<p>$itemid </p>"); 
            print("<p>$set_name</p>");
            print("<p>$setid1</p>");
            print("<img src= $imagesrc>") ;
    
    
    
            //Checks format of image
    
}
    break;
    case 'brick':
         
    $connection = mysqli_connect("mysql.itn.liu.se", "lego", "", "lego");
 
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    $setname = $_POST['text'];
    $query = "SELECT * FROM sets WHERE Setname = '$setname'";
    $result = mysqli_query($connection,  $query);


    if ($row   =  mysqli_fetch_array($result)){
        $SetID = $row['SetID'];

        print("
        <h3> parts included in set $SetID ($setname):</h3>
        <table>
           <tr>
             <td> Quantity </td>
             <td> Color </td>
             <td> part name </td>
             <td>Image </td>
           </tr>
        </table>"
    );
}  

$query = "SELECT inventory.Quantity, inventory.SetID, inventory.ItemID, parts.Partname, images.ItemID, images.ItemtypeID,images.ColorID,
images.has_gif, images.has_jpg, images.has_largegif, images.has_largejpg, colors.Colorname , sets.SetID,  sets.Setname FROM sets, inventory, parts, colors, images WHERE 
sets.Setname like '$setname' AND parts.PartID = inventory.ItemID AND colors.ColorID = inventory.ColorID AND images.ItemID = inventory.ItemID
AND colors.ColorID = images.ColorID AND sets.SetID = inventory.SetID  ORDER BY inventory.Quantity DESC";

$result = mysqli_query($connection, $query);


while   ($row =  mysqli_fetch_array($result)){
    $setid1 = $row['SetID'];
    $invpart = $row['Partname'];
    $invqual = $row['Quantity'];
    $colorsname = $row['Colorname'];
    $itemid = $row['ItemID'];
    $itemtype = $row['ItemtypeID'];
    $colorid = $row['ColorID'];
    $gif = $row['has_gif'];
    $jpg = $row['has_jpg'];
    $imagesrc = "";
    $file = "";

    if ($jpg){
        $imagesrc = "http://www.itn.liu.se/~stegu76/img.bricklink.com/$itemtype/$colorid/$itemid.jpg";
        $file = "$itemtype/$colorid/$itemid.jpg";
    }

    else if ($gif){
        $imagesrc = "http://www.itn.liu.se/~stegu76/img.bricklink.com/$itemtype/$colorid/$itemid.gif";
        $file = "$itemtype/$colorid/$itemid.gif";
    }

    print (
     "<table >
         <tr>
        
            <td> $invqual </td>
            <td> $colorsname </td>
            <td> $invpart </td>
            <td> <img src= $imagesrc> </td>
          
         </tr>
        <table>"
    ) ;
}

break;
    case 'Set-name':

         
    $connection = mysqli_connect("mysql.itn.liu.se", "lego", "", "lego");
 
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    $setname = $_POST['text'];

    $query = "SELECT * FROM sets WHERE Setname = '$setname'";

    $result = mysqli_query($connection,  $query);

$searchname = mysqli_query($connection, "SELECT sets.SetID, sets.Setname, images.has_largejpg, images.has_largegif, images.has_jpg, images.has_gif FROM sets, images
WHERE sets.Setname LIKE '%$setname%' AND images.ItemtypeID = 'S' AND images.ItemID = sets.SetID ORDER BY CASE
WHEN sets.Setname LIKE '$setname%' THEN 1
WHEN sets.Setname LIKE '%$setname' THEN 2
ELSE 3
END");



    while($row = mysqli_fetch_array($searchname)){
         
        $set_name = $row['Setname'];
        $setid1 = $row['SetID'];
        $itemid = $row['ItemID'];
        $gif = $row['has_gif'];
        $jpg = $row['has_jpg'];
        $gifL = $row['has_largegif'];
        $jpgL = $row['has_largejpg'];

      
    
         
        
$gifL = $row['has_largegif'];
        if ($jpgL){
            $imagesrc = "http://www.itn.liu.se/~stegu76/img.bricklink.com/SL/$setid1.jpg";
        }

        else if  ($jpg){
            $imagesrc = "http://www.itn.liu.se/~stegu76/img.bricklink.com/SL/$setid1.gif";   
        }
        else {
            $imagesrc = "https://weber.itn.liu.se/~stegu76/img.bricklink.com/SL/375-2.jpg"; 

        }
        
        print("<p>$itemid </p>"); 
        print("<p>$set_name</p>");
        print("<p>$setid1</p>");
        print("<img src= $imagesrc  onclick='myFunction($setid1)'>"); 


        //Checks format of image
}
        // do Something for Alphabetical

    break;
    default:
        // Something went wrong or form has been tampered.
    }


?>