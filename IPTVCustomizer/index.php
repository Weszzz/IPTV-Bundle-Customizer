<?php
/**
 * Created by PhpStorm.
 * User: Wes
 * Date: 8-4-2017
 * Time: 22:59
 */

?>

<html>

<head>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

</head>

<body>

<div class="container">
    <div class="row">
        <div class="sm-12">
            <h1>IPTV.bundle Customizer</h1>
            <hr>

            <form action="update_package.php" method="POST">
                <div class="form-group">
                    <label for="bundlename">Fill in some name for your bundle</label>
                    <input class="form-control" name="bundlename" id="bundlename" type="text" placeholder="Blablabla" autocomplete="off">
                </div>

                <div class="form-group">
                    <label for="playlist">Fill in some name for your bundle</label>
                    <textarea class="form-control" style="height: 250px;" name="playlist" id="playlist" placeholder="#EXTM3U" autocomplete="off"></textarea>
                </div>

                <div class="form-group">
                    <button id="bundlename" class="btn btn-info"><span class="glyphicon glyphicon-fire"></span> Click here to let the magic happen!</button>
                </div>
            </form>
        </div>
    </div>

</div>

</body>

</html>
