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

  <form class= "form" action = "search.php" method ="POST" >
        <select name="selectedValue">
            <option value="Set-id">Set-id</option>
            
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
            print("<img src= $imagesrc  id='$setid1' onclick='inspectSet(this.id)'>");  // Hans fixar det
    
    
    
            //Checks format of image
    
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
        print("<img src= $imagesrc  id='$setid1' onclick='inspectSet(this.id)'>");  // Hans fixar det

        //Checks format of image
}
        // do Something for Alphabetical

    break;
    default:
        // Something went wrong or form has been tampered.
    }


?>