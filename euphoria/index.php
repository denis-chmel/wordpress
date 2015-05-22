<?php

header('Content-Type: text/html; charset=utf-8');

$request_id = uniqid();
$url = 'http://0.0.0.0:5555/api/v0.1/parse';

$raw_response = '';
$beautified_response = '';
$error = '';
$is_one_word = false;

$query = isset($_REQUEST['query']) ? $_REQUEST['query'] : '';

$decomposition = '';
$report_parts = [];

if ($query) {
	$data = array('query' => $query);
	$is_one_word = preg_match('#\W#', $query) == 0;

	$options = array(
		'http' => array(
			'header'  => "Content-type: application/json",
			'method'  => 'POST',
			'content' => json_encode($data),
		),
	);
	$context  = stream_context_create($options);
	$error = 'No response from request parser, something is wrong.';
	$raw_response = @file_get_contents($url, false, $context);
	if ($raw_response) {
		$error = false;
		$json = json_decode($raw_response, JSON_OBJECT_AS_ARRAY);
		$beautified_response = json_encode($json, JSON_PRETTY_PRINT);

		$decomposition = str_replace(',', ' ', $query);
		$decomposition = str_replace('  ', ' ', $decomposition);
		$decomposition = strtolower($decomposition);

		$report_parts = $parts = [];
		$types = [
			'exact' => 'dish name',
		];

		$parts_count = 0;
		foreach ($json['classifications'][0] as $item) {
			$parts_count++;

			foreach ($report_parts as $part) {
				if ($part['query'] == $item['query']) {
					// same entity second time
					continue 2;
				}
			}

			$type = $item['type'];
			if (isset($types[$type])) {
				$type = $types[$type];
			}

			$html = '<span class="part"><i><em>' . $type . '<span class="question-sign">?</span></em></i>' . htmlspecialchars($item['query']) . '</span> ';
			$decomposition = str_replace($item['query'], $html, $decomposition);

			$report_parts[] = [
				'query' => $item['query'],
				'type' => $item['type'],
			];

			$parts[] = [
				'raw_type' => $item['type'],
				'type' => $type,
				'html' => $html,
			];
		}
	}
}

$examples = [
	// From Sergey
	'dessert',
	'ham, egg and cheese',
	'black bean soup',
	'fish soup',
	// From BAS-604:
	'bagel and cream cheese',
	'cheeseburger with bacon and onions',
	'turkey and salami sandwich on 7 grain bread, with pepperjack cheese, lettuce, tomato, mayo and mustard',
	'ham and cheese',
	'pepperoni pizze',
	'pizza with sausage, pepper and onions',
	'Roast Beef sandwich and coke',
	'roasted chicken, onion soup and sparkling water',
	'spicy curry and indian beer',
	'fish and chips and a coke',
	'Hot pastrami on rye and a Dr. Brown\'s cream soda',
	'sushi and snapple or coke',
	'chicken parm hero with french fries and a coke',
	'cheddar cheese burger, nothing else on the burger, french fries and a vanilla shake',
	'2 sicilian slices and an order of mozzeralla sticks',
	'hearts of lettuce, french dressing and nothing else in the salad',
	'chicken tenders, with honey mustard only and a root beer',
	'cheddar cheese omelette, wheat toast, apple juice, large coffee with whole milk and 3 sweet n lows on the side',
];
$examples = array_filter($examples, function($value) use ($query) {
	return $value !== $query;
});
shuffle($examples);

$questions = [
	'exact' => 'We believe this is a <i>dish name</i>. Correct?',
	'category' => 'We believe this is a <i>category</i>. Correct?',
	'keyword' => 'This is neither a dish name, nor a category. Correct?',
]

?>
<html>
<head>
	<title>BaskPredict Demo</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script type="text/javascript" src="//code.jquery.com/jquery-1.11.1.min.js"></script>
	<link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
	<style type="text/css">
		body{margin: 10px}
		h4{margin-top:25px}
		h1{font-size:0;margin-bottom:5px}
		h1:before{content:"Euphoria Query Parser";display:block;padding-left:135px;width:210px;height:35px;line-height:1.2;font-size:12px;color:#AAA;background:url(https://www.gobask.com/release/img/logo-white.png) no-repeat}
		#request,#response{font:12px monospace;white-space:pre;padding:5px;height:18em;overflow-y:scroll}
		#response{height:auto;overflow-y:hidden;min-height:18em;background:transparent}
		#request{width:100%;border:1px solid silver;border-radius:4px;resize:vertical}
		#dishes{font: 12px monospace; overflow:hidden;overflow-y:auto;height:600px;border-radius:6px;margin-top: 15px;}
		#dish_template,#li_template,#persona_template{display:none}
		.dish{margin-bottom:15px;padding:10px;border:2px solid #DDD;border-radius:6px}
		.dish .restaurant{padding:5px 0;border-left:1px dotted silver;text-align:center}
		.dish *{line-height:1.3}
		.dish .description{min-height:50px}
		.dish h5{font-size:16px;margin-top:0}
		.dish a{text-decoration:underline;font-size:13px}
		.dish .restaurant-image{height:60px;width:60px;border-radius:50%;padding:6px;margin:0 10px 5px 0;background:#FFF}
		.dish .btn-light{background:#EEE}
		body:after{-webkit-transition:all 500ms;-moz-transition:all 500ms;-o-transition:all 500ms;transition:all 500ms;content:"The request was updated, see new recommendations.";color:#FFF;padding-top:20px;text-align:center;display:block;position:fixed;height:65px;left:0;right:0;top:-100%;font-size:18px;background:#5cb85c;z-index:100;opacity:.8}
		body.success:after{top:0;opacity:1}
		.help{color:#AAA}
		.error{color:red}
		label{font-weight:400}
		.nowrap{white-space:nowrap}
		.dish button{margin-top:5px}
		.dish .restaurant-name{font-size:12px}
		.dish .restaurant,.dish .restaurant a{color:#999}
		.dish .price{padding-left:5px;color:#6f9235}
		.dish .dish-id{float: right; color: #CCC; font-size: 11px}
		.technical {padding: 0 30px 15px; margin: 40px auto}
		.personas .glyphicon {font-size: 18px; display: block; padding: 5px;}
		#user-input a {color: #CCC;text-decoration: none;padding: 9px;margin: -7px -10px 0 0}
		#user-input .section {padding: 3px; border-radius: 2px}
		#user-input .ordered .section {color: #fff;background: #337ab7}
		.list-group-item{padding:5px 10px}
		@media (max-width: 767px) {
			.technical {max-height: 385px;overflow: hidden; overflow-y:auto; }
		}
		.decomposition, .query-input {
			font-size: 16px;
		}
		.decomposition {
			display: block;
			color: #AAA;
			min-height: 30px;
			margin-bottom: 20px;
		}
		.decomposition.type {
			margin-bottom: 35px;
		}
		.decomposition .part {
			color: #333;
			border-bottom: 1px solid #00b200;
			border-radius: 5px;
			padding: 5px;
			position: relative;
			/*white-space: nowrap;*/
		}
		.decomposition.unchecked .part {
			border-bottom: 1px solid #BBB;
		}
		.decomposition .part i {
			position: absolute;
			font-size: 12px;
			bottom: -18px;
			margin-left: 50%;
			line-height: 1;
			color: green;
		}
		.wrong .decomposition .part i {
			color: red;
		}
		.question-sign,
		.wrong .question-sign,
		.correct .question-sign {
			display: none;
		}
		.decomposition .part .part {
			border: none;
		}
		#decomposition .decomposition .part i {
			display: none !important;
		}
		.decomposition .part.gray {
			border-bottom: 1px solid #BBB;
		}
		.wrong .decomposition .part {
			border-bottom: 1px solid red;
		}
		.decomposition .part.gray i {
			color: #999;
		}

		.decomposition {
			line-height: 30px;
		}

		#types .decomposition {
			min-height: 50px;
			margin-top: -5px;
			margin-bottom: 10px;
		}

		.decomposition .part i em {
			display: inline-block;
			white-space: nowrap;
			margin-left: -50%;
		}
		.decomposition .part.gray em {
			border-top-color: #999;
		}
		.wrong .decomposition .part em {
			border-top-color: red;
			text-decoration: line-through;
		}
		#example {
			border-bottom: 1px dotted;
		}
		.question {
			margin-top: 15px;
			font-size: 15px;
		}
		.info-link {
			cursor: help;
		}
		.yes-no {
			margin-bottom: 20px;
		}
		#thank-you {
			margin-bottom: 50px;
		}
		.debug {
			display: none;
		}
		.ajax-circle {
			display: block;
			position: absolute;
			margin-left: -25px;
			margin-top: 10px;
			width: 16px;
			height: 16px;
			background: url(https://www.gobask.com/release/img/ajax-circle.gif) no-repeat;
		}
	</style>
</head>
<body>

<div class="container">

	<h1>Bask</h1>

	<div class="row">
		<div class="col-sm-6 left">

			<h4 id="top">What would you like to order?</h4>

			<form action="<?php echo $_SERVER['REQUEST_URI'] ?>" class="input-group">

				<input type="text" class="form-control query-input" size="40" name="query" value="<?php echo htmlspecialchars($query) ?>" />
				<span class="input-group-btn">
					<button class="btn btn-success" type="submit">Interpret</button>
				</span>
			</form>

			<?php if ($error): ?>
				<p class="error"><?php echo $error ?></p>
				<!-- ssh -f -L 5555:localhost:5555 -N denis@devdb01.gobask.com -->
			<?php endif ?>

			<p class="debug">e.g. <a id="example" href="#">dessert</a></p>

			<div id="decomposition" class="<?php echo $query && !$error ? '' : 'hidden' ?>">
				<h4>Results</h4>

				<?php if ($is_one_word): ?>

					<p style="margin-bottom: 20px">
						You have definitely asked for one dish only.<br>
						<span class="help">(but you may request several at once, just use "and", commas, or semicolons)</span>
					</p>

				<?php else: ?>
					<div class="well">
						First, we are trying to figure out how many dishes you've asked for.
					</div>

					<div class="question-block" for="decomposition">
						<label class="decomposition">
							<?php echo $decomposition ?>
						</label>

						<p class="question">We believe you have asked for <?php echo sprintf(ngettext('%d dish', '%d dishes', $parts_count), $parts_count) ?>. Correct?</p>
						<p><span class="ajax-circle hidden"></span><button class="btn btn-default yes-no">Yes</button>&nbsp;<button class="btn btn-default yes-no">No</button></p>
					</div>
				<?php endif ?>
			</div>

			<div id="types" class="<?php echo $is_one_word ? '' : 'hidden' ?>">

				<div class="well">
					<p>Next, we need to figure out what type of query you've made, the
						options are:</p>
					<ul style="list-style-type: none; padding-left: 15px">
						<li>dish name<span class="help">&nbsp;&mdash; This is an actual dish name</span></li>
						<li>category<span class="help">&nbsp;&mdash; This is a category of dishes</span></li>
						<li>keyword<span class="help">&nbsp;&mdash; Neither exact dish nor category, you are just looking for a dish similar to this.</span></li>
					</ul>
				</div>

				<?php foreach ($parts as $i => $part): ?>
					<div class="question-block <?php echo $is_one_word ? '' : 'hidden' ?>" for="<?php echo $i ?>">
						<p class="question"><?php echo $questions[$part['raw_type']] ?></p>
						<label class="decomposition type">
							<?php echo $part['html'] ?>
						</label>
						<p><span class="ajax-circle hidden"></span><button class="btn btn-default yes-no">Yes</button>&nbsp;<button class="btn btn-default yes-no">No</button></p>
					</div>
				<?php endforeach ?>

			</div>

			<div class="question-block hidden" id="thank-you">
				<h4>Thank you!</h4>
				<p>Please try another query.</p>
				<button class="btn btn-default try-again">Try another query</button>
			</div>

		</div>
		<div class="col-sm-6 hidden-xs">

			<div class="technical well">

				<h4>Raw Results</h4>

				<pre id="dishes"><?php echo $beautified_response ?></pre>

			</div>

		</div>
	</div>

	<li id="li_template" class="list-group-item">
		<a href="#" class="glyphicon glyphicon-remove pull-right"></a>
		<span class="section glyphicon"></span>
		<span class="dish-name"></span>
	</li>

	<button id="persona_template" type="button" class="btn btn-default">
		<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
		<span class="name"></span>
	</button>

	<div id="dish_template" class="dish card">
		<div class="row">
			<div class="col-xs-8">
				<h5>
					<span class="dish-name">Test name</span>
					<span class="price">$1</span>
					<span class="dish-id"></span>
				</h5>
				<p class="description">Test descriptions</p>
				<button class="btn btn-primary" update-section="ordered">
					<span class="glyphicon glyphicon-shopping-cart"></span>
					Order
				</button>
				<button class="btn btn-light" update-section="favorited" title="Add to favorites">
					<span class="glyphicon glyphicon-heart" aria-hidden="true"></span>
				</button>
				<span class="nowrap">
					<button class="btn btn-light" update-section="liked" title="Like">
						<span class="glyphicon glyphicon-thumbs-up"></span>
					</button>
					<button class="btn btn-light" update-section="disliked" title="Dislike">
						<span class="glyphicon glyphicon-thumbs-down"></span>
					</button>
				</span>
			</div>
			<div class="col-xs-4 restaurant">
				<p class="restaurant-name"></p>
				<img class="restaurant-image" src="" title="" /><br>
				<div class="enter-restaurant">
					<a href="#">See full menu</a>
				</div>
				<div class="leave-restaurant">
					<a href="#">Leave restaurant</a>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		$(function(){

			var examples = <?php echo json_encode($examples) ?>;
			var example_index = 0;
			var data = <?php echo json_encode([
				'request_id' => $request_id,
				'query' => $query,
				'parts' => $report_parts,
			]); ?>;
			data.url = window.location.href;
			data.raw_response = <?php echo json_encode($raw_response) ?>;
			<?php if ($is_one_word): ?>
			data.decomposition = 'y'; // cannot be failure if 1 word only
			<?php endif ?>

			function rotateExample()
			{
				var example_query = examples[example_index++];
				if (!example_query) {
					example_index = 0;
					example_query = examples[example_index++];
				}
				$('#example').html(example_query);
			}

			$("#example").click(function(e){
				$("input[name=query]").val($(this).text());
				$("form").submit();

				return false;
			});

			$("button.yes-no").click(function(){

				var $container = $(this).closest('p');
				$container.find('.yes-no').removeClass("btn-default1 btn-success btn-danger active");
				var is_yes = $(this).text() == 'Yes';
				$(this).addClass('active').addClass(is_yes ? "btn-success" : "btn-danger");
				var block = $(this).closest(".question-block");
				block.toggleClass('correct', is_yes).toggleClass('wrong', !is_yes);
				if (block.attr('for') == 'decomposition') {
					data.decomposition = is_yes ? 'y' : 'n';
					$("#types").toggleClass('hidden', !is_yes);
					$("#types .question-block:first").toggleClass('hidden', !is_yes);
					$("#thank-you").toggleClass('hidden', is_yes);
				} else {
					data.parts[parseInt(block.attr('for'))].correct = is_yes ? 'y' : 'n';
					var next_block = $(block).next('.question-block');
					next_block.removeClass('hidden');
					if (next_block.length == 0) {
						$("#thank-you").removeClass('hidden');
					}
				}

				var $ajax = $container.find('.ajax-circle');
				$ajax.removeClass('hidden');
				setTimeout(function(){
					$ajax.addClass('hidden');
				}, 500);

				$.post(
					'http://www.gobask.com/blog/euphoria/report.php',
					data
				).done(function(response){
						if (response) alert('Warning: ' + response);
					}).error(function(response){
						if ($(".debug:visible").length == 0) {
							alert('Error: ' + (response.responseText || 'unknown error'));
						}
					});

				$('body').stop().animate({scrollTop: 1000}, 1000);
			});

			$(".try-again").click(function(){
				$('body').stop().animate({scrollTop: 0}, 100, function(){
					$('.query-input').focus().select();
				});
			});

			<?php if (!$query):?>
			$(".try-again").click();
			<?php endif ?>

			rotateExample();

		});
	</script>

</div>
</body>
