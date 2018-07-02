<!DOCTYPE html>
<html>

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>INSPINIA | Login</title>

        <link href="<?= base_url(); ?>assets/inspinia/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?= base_url(); ?>assets/inspinia/font-awesome/css/font-awesome.css" rel="stylesheet">

        <link href="<?= base_url(); ?>assets/inspinia/css/animate.css" rel="stylesheet">
        <link href="<?= base_url(); ?>assets/inspinia/css/style.css" rel="stylesheet">

    </head>

    <body class="gray-bg">

        <div class="middle-box text-center loginscreen animated fadeInDown">
            <div>
                <p>Login in. To see it in action.</p>
                <form class="m-t" role="form" method="post" action="<?php echo base_url();?>Login/do_login">
                    <div class="form-group">
                        <input name="username" type="text" class="form-control" placeholder="Username" required="">
                    </div>
                    <div class="form-group">
                        <input name="password" type="password" class="form-control" placeholder="Password" required="">
                    </div>
                    <button type="submit" class="btn btn-primary block full-width m-b">Login</button>
                </form>
                <span style="color:#d32132"><?php echo isset($message) ? $message:'';?></span>
            </div>
        </div>

        <!-- Mainly scripts -->
        <script src="<?= base_url(); ?>assets/inspinia/js/jquery-2.1.1.js"></script>
        <script src="<?= base_url(); ?>assets/inspinia/js/bootstrap.min.js"></script>

    </body>

</html>
