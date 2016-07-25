<?php include "includes/adminHeader.php" ?>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include "includes/adminNav.php" ?>
        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to your Admin Panel
                            <small>Author</small>
                        </h1>

                        <?php
                            if (isset($_GET['source'])) {
                                $source = escape($_GET['source']);
                            }
                            else {
                                $source = '';
                            }
                            switch($source){
                                case 'add_post';
                                include "includes/add_post.php";
                                break;

                                case 'edit_post';
                                include "includes/edit_post.php";
                                break;

                                default: include "includes/view_comments.php";
                                break;
                            }
                        ?>

                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

<?php include "includes/adminFooter.php" ?>