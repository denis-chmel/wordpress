<?php
/**
 * This file adds the Landing template to the Agency Pro Theme.
 *
 * @author StudioPress
 * @package Agency Pro
 * @subpackage Customizations
 */

/*
Template Name: Landing2
*/
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8"/>
    <title>Bask Business</title>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="stylesheet" href="http://portal.bask.local/vendor/bootstrap/dist/css/bootstrap.min.css" type="text/css" media="all"/>
    <script type="text/javascript" src="http://portal.bask.local/vendor/jquery/dist/jquery.min.js"></script>
    <link rel="stylesheet" href="http://portal.bask.local/css/main.css" type="text/css" media="all"/>
</head>
<body class="guest_home">

<div class="layout-wrapper">
    <div class="layout-row">
        <main class="layout">

            <div class="navbar navbar-inverse" role="navigation">

                <div class="page-progressbar"></div>

                <div class="top-message">
                </div>

                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#"><img src="http://portal.bask.local/img/bask-business.png"></a>
                    </div>

                    <div class="collapse navbar-collapse">
                    </div>
                </div>
            </div>

            <div class="page-inner">



<?php

the_post();
do_action( 'genesis_post_content' );


?>
            </div>

        </main>
    </div>
    <div class="layout-row">

        <footer class="layout">
            <div class="container">

                <div class="pull-right text-right">

                    <div class="social-icons">
                        <a href="https://twitter.com/GoBask"><img src="http://gobask.com/release/img/social/twitter.png" alt="twitter"></a>&nbsp;&nbsp;
                        <a href="https://www.facebook.com/gobask"><img src="http://gobask.com/release/img/social/facebook.png" alt="facebook"></a>&nbsp;&nbsp;
                        <a href="http://instagram.com/gobask/"><img src="http://gobask.com/release/img/social/insta.png" alt="instagram"></a>&nbsp;&nbsp;
                        <a href="http://www.pinterest.com/GoBask/"><img src="http://gobask.com/release/img/social/pinterest.png" alt="pinterest"></a>
                    </div>

                </div>

                <p class="links">
                    <a href="#">What's bask</a>
                    <a href="#">Blog</a>
                    <a href="#">Jobs</a>
                    <a href="#">Terms</a>
                    <a href="#">Privacy</a>
                </p>

                <div id="logo-gobask">
                    <h1>Bask</h1>

                    <h2>© 2014 Bask Labs Inc.</h2>
                </div>

            </div>

        </footer>

    </div>
</div>

<script type="text/javascript" src="http://portal.bask.local/vendor/bootstrap/dist/js/bootstrap.min.js"></script>

</body>
</html>

