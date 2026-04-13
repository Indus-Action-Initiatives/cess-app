<!DOCTYPE html>
<html lang="en">

   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,minimal-ui">
      <title>Be style</title>
      <!--<meta content="Admin Dashboard" name="description">
      <meta content="ThemeDesign" name="author">-->
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <?php echo $this->Html->meta('icon');?>
      <?Php echo $this->Html->css(array('/plugin/morris/morris.css','admin/bootstrap.min.css','admin/icons.css','admin/style.css'));?>
   </head>
   <body class="fixed-left">
      <!-- Loader -->
      <div id="preloader">
         <div id="status">
            <div class="spinner"></div>
         </div>
      </div>
      <!-- Begin page -->
      <div class="accountbg">
         <div class="content-center">
            <div class="content-desc-center">
               <div class="container">
                  <div class="row justify-content-center">
                     <div class="col-lg-5 col-md-8">
                        <div class="card">
                           <div class="card-body">
                              <h3 class="text-center mt-0 m-b-15">
                                    <?php echo $this->Html->link($this->Html->image('admin/logo-dark.png',array('alt'=>'logo','height'=>30)),'/admin/index',array('class'=>'logo logo-admin','escape'=>false));?>
                                </h3>
                              <h4 class="text-muted text-center font-18"><b>Reset Password</b></h4>
                              <div class="p-3">
                                    <?php echo $this->Form->create(null,array('url'=>'/admin/index/','novalidate','type' =>'post','class'=>"form-horizontal m-t-20")); ?>
                                    <div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Enter your <b>Email</b> and instructions will be sent to you!</div>
                                    <div class="form-group row">
                                       <div class="col-12"><input class="form-control" type="email" required="" placeholder="Email"></div>
                                    </div>
                                    <div class="form-group text-center row m-t-20">
                                       <div class="col-12"><button class="btn btn-primary btn-block waves-effect waves-light" type="submit">Send Email</button></div>
                                    </div>
                                    <?php echo $this->Form->end();?>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- end row -->
               </div>
            </div>
         </div>
      </div>
      <!-- jQuery  -->
      <?php echo $this->Html->script(array('jquery.min.js','bootstrap.bundle.min.js','modernizr.min.js','detect.js','fastclick.js','jquery.slimscroll.js','jquery.blockUI.js','waves.js','jquery.nicescroll.js','jquery.scrollTo.min.js','app.js'));?>
   </body>
   <!-- Mirrored from themesdesign.in/drixo/vertical/pages-recoverpw.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 15 May 2020 04:43:53 GMT -->
</html>