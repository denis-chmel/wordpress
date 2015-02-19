<?php

require("config.php");
// header('Access-Control-Allow-Origin: *');

//ini_set('display_errors', 1);
//error_reporting(-1);
if (empty($_POST['request_id'])) {
	die("Error: non-empty request_id is expected to be in POST");
}

$pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
$pdo->exec("SET CHARACTER SET utf8");

$parts = @$_POST['parts'] ?: [];
$wrong_parts = [];
$unfinished_count = 0;
foreach ($parts as $part) {
  if (!isset($part['correct'])) {
    $unfinished_count++;
    continue;
  }
  if ('y' !== $part['correct']) {
    unset($part['correct']);
    $wrong_parts[] = $part;
  }
}

$decomposition = @$_POST['decomposition'] == 'y' ? 'y' : 'n';
$finished_at = 'n' == $decomposition || 0 == $unfinished_count ? 'NOW()' : 'NULL';

$q = $pdo->prepare("REPLACE INTO euphoria_reports (request_id, query, decomposition, parts, wrong_parts, ip, url, raw_response, finished_at) VALUES (:request_id, :query, :decomposition, :parts, :wrong_parts, :ip, :url, :raw_response, $finished_at)");
$result = $q->execute(array(
    ':request_id' => $_POST['request_id'],
    ':query' => @$_POST['query'],
    ':decomposition' => $decomposition,
    ':parts' => json_encode($parts, JSON_PRETTY_PRINT),
    ':wrong_parts' => json_encode($wrong_parts, JSON_PRETTY_PRINT),
    ':ip' => @$_SERVER['REMOTE_ADDR'],
    ':url' => @$_POST['url'],
    ':raw_response' => @$_POST['raw_response'],
));
if (!$result) {
  var_dump($q->errorInfo());
}

/*
DROP TABLE IF EXISTS `euphoria_reports`;
CREATE TABLE `euphoria_reports` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `request_id` varchar(255) NOT NULL,
  `query` text NOT NULL,
  `decomposition` enum('y', 'n'),
  `parts` text,
  `wrong_parts` text,
  `ip` varchar(255) NULL,
  `url` TEXT NULL,
  `raw_response` TEXT NULL,
  `finished_at` timestamp NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE (request_id),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB default CHARSET=utf8;
*/
