<?php

//ini_set('display_errors', 1);
//error_reporting(-1);
if (empty($_POST)) {
	die("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vel porta ligula, sed imperdiet massa. Curabitur in molestie orci, ac tincidunt lorem. Donec nisl ipsum, ultrices a leo id, sodales dignissim justo. Suspendisse nec augue ac risus tincidunt sodales sed in arcu. Fusce maximus quam ac dui bibendum faucibus quis a diam. Proin dapibus ultrices ipsum. Proin vitae efficitur mi. Praesent semper nisl libero, in placerat lorem mollis eu. Vivamus luctus elementum ipsum, at hendrerit arcu semper molestie. Donec facilisis mauris enim, a rhoncus lectus vestibulum nec. Ut scelerisque augue eget porta imperdiet. Suspendisse efficitur at turpis imperdiet efficitur. Nunc in mi sem. Duis sed diam id quam feugiat ultricies sed et quam. Aenean porttitor, nibh et pretium viverra, odio metus facilisis ante, vitae efficitur sapien mauris quis ligula. Fusce nec est sit amet neque rutrum facilisis vel interdum ligula.");
}

$pdo = new PDO('mysql:host=127.0.0.1;dbname=bask_blog', 'bask_blog', 'Ahmichai4');
$pdo->exec("SET CHARACTER SET utf8");

$q = $pdo->prepare('INSERT INTO landing_subscribtions (email, page_title, page_url, ip, created_at) VALUES (:email, :page_title, :page_url, :ip, NOW())');
$result = $q->execute(array(
	':email' => @$_POST['email'],
	':page_title' => @$_POST['page_title'],
	':page_url' => @$_POST['page_url'],
	':ip' => @$_SERVER['REMOTE_ADDR'],
));
//var_dump($result, $q->errorInfo());

/*
DROP TABLE IF EXISTS `landing_subscribtions`;
CREATE TABLE `landing_subscribtions` (
`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NULL,
  `page_title` varchar(255) COLLATE utf8_unicode_ci NULL,
  `page_url` text COLLATE utf8_unicode_ci NULL,
  `ip` varchar(255) NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB default CHARSET=utf8;
*/
