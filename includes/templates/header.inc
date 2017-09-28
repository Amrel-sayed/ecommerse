<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="icon" href="<?php echo $img; ?>/EC_Logo.png">
    
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php gettitle(); ?></title>
        <!--[if lt IE 9]>
                <script src="js/html5shiv.js"></script>
                <script src="js/respond.min.js"></script>
        <![endif]-->
        <link rel="stylesheet" href="<?php echo $css; ?>/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo $css; ?>/font-awesome.min.css">
         <link rel="stylesheet" href="<?php echo $css; ?>/jquery-ui.min.css">
         <link rel="stylesheet" href="<?php echo $css; ?>/jquery.selectBoxIt.css">
         <link rel="stylesheet" href="<?php echo $js; ?>/jquery/jRating.jquery.css">
         <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo $css; ?>/jquery.tagit.css"> 
        <link rel="stylesheet" href="<?php echo $css; ?>/style.css"> 
        <link rel="stylesheet" href="<?php echo $css; ?>/front.css">
  
       </head>
    <body>
    <nav class="navbar navbar-default navbar-inverse">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#nav1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php"><img class="logo" src="<?php echo $img; ?>/EC_Logo.png">ommer<span>C</span>e</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse " id="nav1">
      <ul class="nav navbar-nav navbar-right">

       <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Departments<span class="caret"></span></a>
          <ul class="dropdown-menu">
               <?php 
              
                      $stmt=$con->prepare("SELECT * from categories where  Parent=0 ");
                      $stmt->EXECUTE();
                      $cats=$stmt->fetchAll();
                      foreach ($cats as $cat ){

                     
                     // *******  STR_REplace ****** to change any litter to any another litter

                      $stmt2=$con->prepare("SELECT * from categories where Parent=? ");
                      $stmt2->EXECUTE(array($cat['ID']));
                      $data2=$stmt2->fetchAll();
                      if($stmt2->rowCount()>0){
                           echo "<li class='dropdown-submenu'>";
                            echo "<a class='dropdown-toggle'  href='Departments.php?catid=".$cat['ID']."&catname=".str_replace(' & ','_',$cat['Name'])."'>".$cat['Name']."</a>";
                            echo'  <ul class="dropdown-menu">';
                             foreach ($data2 as $data ){
                             echo"<li><a href='Departments.php?catid=".$data['ID']."&catname=".str_replace(' & ','_',$data['Name'])."'>".$data['Name']."</a></li>";}
                        echo " </ul>
                               </li>";
                      }else{

                        echo "<li><a href='Departments.php?catid=".$cat['ID']."&catname=".str_replace(' & ','_',$cat['Name'])."'>".$cat['Name']."</a></li>";
                      }

                  }
            
            ?>
          </ul>
        </li>
      <!--  <li><a href="categories.php"><?php echo lang('CATEGORIES');?></a></li>
       <li><a href="items.php"><?php echo lang('ITEMS');?></a></li>
       <li><a href="members.php"><?php echo lang('MEMBERS');?></a></li>
       <li><a href="#"><?php echo lang('STATISTICS');?></a></li>
       <li><a href="Comments.php"><?php echo lang('COMMENTS');?></a></li>
       <li><a href="#"><?php echo lang('LOGS');?></a></li> -->
      <?php
      if(isset($_SESSION['fuser'])){
          $stmt5=$con->prepare("SELECT * from item_log where User_ID=? ");
          $stmt5->EXECUTE(array($_SESSION['ID']));
          $data5=$stmt5->fetchAll();
          $cartnum=$stmt5->rowCount();
         echo'<li class="dropdown">
         <a href="#" class="dropdown-toggle signed" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Welcome 

           '.$_SESSION['Dname'].'<img class="header-img" src="'.$_SESSION['img'].' "> <span class="caret"></span></a>';
          echo '<ul class="dropdown-menu">
            <li><a href="profile.php">'.lang('ViewProfile').'</a></li>
            <li><a href="newitem.php">'.lang('newitem').'</a></li>
            <li><a href="admin/members.php?do=Edit&userID='.$_SESSION['ID'].'">'.lang('Setting').'</a></li>
            <li><a href="logout.php">'.lang('Logout').'</a></li>
          </ul>
        </li>';
        echo ' <li><a href="selecteditems.php" class="cartbar sign"><img class="cartimg" src="layout\images\empty_cart-512.png"/><span id="cartcount">'.$cartnum.'</span></a></li>';
          }else{ echo '<li><a href="login.php?logst=signin" class="sign">'.lang('sign').'</a></li>';
                 echo '<li><a href="login.php?logst=signup" class="sign">'.lang('reg').'</a></li>';


           }?>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

