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
      <a class="navbar-brand" href="dashboard.php"><i class="fa fa-home fa-lg" aria-hidden="true"> </i><?php echo lang('home_admin')." ";?></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse " id="nav1">
      <ul class="nav navbar-nav navbar-right">
       <li><a href="categories.php"><?php echo lang('CATEGORIES');?></a></li>
       <li><a href="items.php"><?php echo lang('ITEMS');?></a></li>
       <li><a href="members.php"><?php echo lang('MEMBERS');?></a></li>
       <li><a href="#"><?php echo lang('STATISTICS');?></a></li>
       <li><a href="Comments.php"><?php echo lang('COMMENTS');?></a></li>
       <li><a href="#"><?php echo lang('LOGS');?></a></li>
      
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['Dname']?><span class="caret"></span></a>
          <ul class="dropdown-menu">
          <li><a href="../index.php">Visit our Shop</a></li>
            <li><a href="members.php?do=Edit&userID=<?php echo $_SESSION['ID']?>"><?php echo lang('EditProfile');?></a></li>
            <li><a href="#"><?php echo lang('Setting');?></a></li>
            <li><a href="logout.php"><?php echo lang('Logout');?></a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>


