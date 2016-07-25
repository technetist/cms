<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>

<?php 

    if (isset($_POST['submit'])) {
        $to = "Adrien.Maranville@gmail.com";
        $subject = escape($_POST['subject']);
        $body = escape($_POST['message']);
    } 
    

?>


<!-- Navigation -->

<?php  include "includes/nav.php"; ?>

 
<!-- Page Content -->
<div class="container">
    <section id="login">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="form-wrap">
                        <h1>Contact</h1>
                        <form role="form" action="" method="post" id="message-form" autocomplete="off">
                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <label for="subject" class="sr-only">Subject</label>
                                <input type="text" name="subject" id="subject" class="form-control" placeholder="Subject">
                            </div>
                            <div class="form-group">
                                <label for="message" class="sr-only">Message</label>
                                <textarea rows="8" name="message" id="message" class="form-control"></textarea>
                            </div>         
                            <input type="submit" name="submit" id="message-submit" class="btn btn-custom btn-lg btn-block" value="Submit">
                        </form>
                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>


<hr>



<?php include "includes/footer.php";?>
