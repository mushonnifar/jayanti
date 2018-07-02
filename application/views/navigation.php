<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> <span>
                        <img alt="image" class="img-circle" src="<?php echo base_url(); ?>assets/inspinia/img/profile_small.jpg" />
                    </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?php echo $this->session->userdata('nama'); ?></strong>
                            </span> <span class="text-muted text-xs block"><?php echo $this->session->userdata('jabatan_name'); ?> <b class="caret"></b></span> </span> </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url('Logout'); ?>">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    IN+
                </div>
            </li>
            <li class="<?php echo ($this->session->userdata('menu') == 'Home') ? 'active' : ''; ?>">
                <a href="<?php echo base_url('admin'); ?>"><i class="fa fa-home"></i> <span class="nav-label">Home</span></a>
            </li>
            <?php foreach ($menu as $value) { ?>
                <li class="<?php echo ($this->session->userdata('menu') == $value['name']) ? 'active' : ''; ?>">
                    <a href="<?= base_url() . $value['link']; ?>"><i class="<?= $value['icon']; ?>"></i> <span class="nav-label"><?= $value['name']; ?></span> <?php if (count($value['child']) > 0) { ?><span class="fa arrow"></span><?php } ?></a>
                    <?php if (count($value['child']) > 0) { ?>
                        <ul class="nav nav-second-level">
                            <?php foreach ($value['child'] as $v) { ?>
                                <li class="<?php echo ($this->session->userdata('sub_menu') == $v['name']) ? 'active' : ''; ?>"><a href="<?= base_url() . $v['link']; ?>"><i class="<?= $v['icon']; ?>"></i> <?= $v['name']; ?></a></li>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                </li>
            <?php } ?>            
        </ul>
    </div>
</nav>
<div id="page-wrapper" class="gray-bg dashbard-1">
    <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>                
                <a href="<?php echo base_url(); ?>" class="navbar-brand">SISTEM INFORMASI</a>
            </div>            
            <ul class="nav navbar-top-links navbar-right">                
                <li>
                    <a href="<?php echo base_url('Logout'); ?>">
                        <i class="fa fa-sign-out"></i> Log out
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="wrapper wrapper-content">