<html>
    <head>
    <meta charset="utf-8">
      
        <link rel="stylesheet" href="style.css"> <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="effect.js" defer></script>
    </head>
    <body>
  <section id="header">
    <div class="header container">
      <div class="nav-bar">
        <div class="brand">
          <a href="index.html"><img src="bilder/lego logo 4.0.png" alt="Logo" id ="logo"></a>
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
  <h1>SEARCH</h1>
        <select name="selectedValue">
            <option value="Set-id">Set-id</option>
            
            <option value="Set-name">Set-name</option>
        </select>
            <label for="text"> [Options]</label> <br>
         
            <input type="text" name = "text" placeholder = "Write the input here" id = "text" required>
        </div>
        
        <input type="submit" value = "Submit">
        
     </form> 
     <div class="card">
        
        <span class = "info"><i class="fa fa-info-circle"></i></span>
        <h1 id ="textbox">Block Broswe</h1>
        <p> Du är två val möjligheter. Antigen söker på set-id med ett lego sets set ID för hitta ett specifik set. Eller söker på andra valet Set-namn med ett set namn</p>
        </div>
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
         print(
         "<div class='setidWrapper'>
            <div >
             <img src= $imagesrc class = 'idimg' onclick='inspectSet(this.id)'  id='$setid1' >
             <p>$itemid </p>
             <p>$set_name</p>
             <h1>Set ID: $setid1</h1>
            </div>
         </div>"); 
 
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
        
              
print(
"<div class='setWrapper'>
 <div ><img src= $imagesrc class = 'nameimg' onclick='inspectSet(this.id)'  id='$setid1' >
 <p>$itemid </p>
 <p>$set_name</p>
 <p>Set ID: $setid1</p>
 </div>
 </div>"); 
}
    break;
    default:
        // Something went wrong or form has been tampered.
     }


?>