      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>

      <?php if ( $_SESSION['passwd'] == '9876' ) { ?>
			　<?php if ( $_SESSION['sidemenu'] == 'rstudent_list' || $_SESSION['sidemenu'] == 'rstudent_class' ) { ?><li class="treeview active"><?php } else { ?><li class="treeview"><?php } ?>
				  <a href="rstudent_list.php">
					<i class="fa fa-user"></i> <span>受講生管理</span>
					<span class="pull-right-container">
						  <i class="fa fa-angle-left pull-right"></i>
						</span>
				  </a>
				  <ul class="treeview-menu">
					<?php if ( $_SESSION['sidemenu'] == 'rstudent_list' ) { ?><li class="active"><?php } else { ?><li><?php } ?><a href=rstudent_list.php><i class="fa fa-circle-o"></i>受講生一覧</a></li>
			    </ul>
			  </li>
      <?php } ?>
			  <?php if ( $_SESSION['sidemenu'] == 'kishitsu_diag' ) { ?>
          <li class="treeview active">
        <?php } else { ?>
          <li class="treeview active">
        <?php } ?>
				  <a href="kishitsu_diag.php">
					<i class="fa fa-home"></i> <span>氣質</span>
					<span class="pull-right-container">
						  <i class="fa fa-angle-left pull-right"></i>
						</span>
				  </a>
				  <ul class="treeview-menu">
					<?php if ( $_SESSION['sidemenu'] == 'kishitsu_diag11' ) { ?>
            <li class="treeview active">
              <a href=kishitsu_diag11.php><i class="fa fa-circle-o"></i>氣質情報</a>
            </li>
          <?php } ?>
				  </ul>
			  </li>
      </ul>
