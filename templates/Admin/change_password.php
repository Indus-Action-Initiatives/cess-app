<?php  $class = 'required'; ?>
<?= $this->Flash->render() ?>
<!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <div class="headerbar-item">
              <a class="btn btn-danger btn-sm" href="<?php echo webURL?>admin/dashboard">
                <i class="fa fa-backward"></i> Back to list </a>
            </div>
            <br>
            <h1>Reset Password</h1>
            
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo webURL ?>admin/dashboard">Home</a></li>
              <li class="breadcrumb-item active">Center</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
        <div class="card card-primary">
            <!-- /.panel-heading -->
            <div class="card-body">
            <?php echo $this->Form->create(null,array('url'=>webURL.'admin/changePassword','type' =>'post','id'=>"resetpass")); ?>
                <div class="row">
                    <div class="col-6">

                            <div class="form-group">
                                <label>New Password<span class="required">*</span></label>
                                 <?php echo $this->Form->input('password',array('type'=>'password','class'=>'form-control '.$class,'div'=>false,'label'=>false,'id'=>'password')); ?>

                            </div>

                            <div class="form-group">
                                <label>Retype New Password<span class="required">*</span></label>
                                 <?php echo $this->Form->input('confirmpassword',array('type'=>'password','class'=>'form-control '.$class,'div'=>false,'label'=>false,'equalTo'=>'#password')); ?>
                            </div>

                        </div>
                            <div class="col-lg-12">

                            <?php echo $this->Form->button('Submit',array('type'=>'submit','class'=>'btn btn-success','id'=>'submitUserlogin')); ?>
                            <?php echo $this->Form->end(); ?>
                            </div>

                            

                    <!-- /.col-lg-6 (nested) -->

                </div>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
