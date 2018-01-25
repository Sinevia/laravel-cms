
<!-- START: Message Area -->
<div class="container" style="padding-top: 20px;">
    <div  id="alert-area" class="" style="margin-left: 0px;">
        
        <?php if (isset($error) AND $error != '') { ?>
            <div class="alert alert-danger">
                <a class="close" data-dismiss='alert'>×</a>
                <span class="fa fa-ban"></span>
                <?php echo $error; ?>
            </div>
        <?php } ?>
        
        <?php if (isset($info) AND $info != '') { ?>
            <div class="alert alert-info">
                <a class="close" data-dismiss='alert'>×</a>
                <span class="fa fa-info"></span>
                <?php echo $info; ?>
            </div>
        <?php } ?>

        <?php if (isset($success) AND $success != '') { ?>
            <div class="alert alert-success">
                <a class="close" data-dismiss='alert'>×</a>
                <span class="fa fa-check-circle"></span>
                <?php echo $success; ?>
            </div>
        <?php } ?>

        <?php if (isset($warning) AND $warning != '') { ?>
            <div class="alert alert-warning">
                <a class="close" data-dismiss='alert'>×</a>
                <span class="fa fa-exclamation-circle"></span>
                <?php echo $warning; ?>
            </div>
        <?php } ?>
        
        <?php if (Session::get('error')) { ?>
            <div class="alert alert-danger">
                <a class="close" data-dismiss='alert'>×</a>
                <span class="fa fa-ban"></span>
                {{ Session::get('error') }}
            </div>
        <?php } ?>
        
        <?php if (Session::get('info')) { ?>
            <div class="alert alert-info">
                <a class="close" data-dismiss='alert'>×</a>
                <span class="fa fa-info"></span>
                {{ Session::get('info') }}
            </div>
        <?php } ?>

        <?php if (Session::get('success')) { ?>
            <div class="alert alert-success">
                <a class="close" data-dismiss='alert'>×</a>
                <span class="fa fa-check-circle"></span>
                {{ Session::get('success') }}
            </div>
        <?php } ?>
        
        <?php if (Session::get('warning')) { ?>
            <div class="alert alert-warning">
                <a class="close" data-dismiss='alert'>×</a>
                <span class="fa fa-exclamation-circle"></span>
                {{ Session::get('warning') }}
            </div>
        <?php } ?>

        <?php if (count($errors)) { ?>
            <div class="alert alert-danger">
                <a class="close" data-dismiss='alert'>×</a>
                <?php foreach ($errors->all() as $error) { ?>
                    {!! $error !!}
                    <br />     
                <?php } ?>
            </div>
        <?php } ?>
    </div>

    <script>
        $(function () {
            setTimeout(function () {
                $('#alert-area').hide();
            }, 15000);
        });
    </script>
</div>
<!-- END: Message Area -->
