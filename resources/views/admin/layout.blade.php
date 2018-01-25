<!DOCTYPE html>
<html>
    <head>
        <title>@yield('webpage_title') - CMS Admin</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Sinevia Ltd">
        <link rel="shortcut icon" type="image/vnd.microsoft.icon" href="favicon.ico" />
        <link rel="icon" type="image/png" href="favicon.png" />
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="//maxcdn.bootstrapcdn.com/bootswatch/3.3.5/sandstone/bootstrap.min.css" rel="stylesheet" media="screen">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    </head>
    <body>
        <!-- START: Main Content -->
        <?php $shared_errors = isset($shared_errors) ? $shared_errors : true; ?>
        <?php if ($shared_errors) { ?>
            @include('cms::admin.shared-alerts')
        <?php } ?>
            
        <div class="container">
            @yield('webpage_header')
        </div>

        <div class="container">
            @yield('webpage_content')
        </div>
        <!-- END: Main Content -->
    </body>
</html>
