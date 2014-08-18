<?php

function __autoload($class_name) {
    include '/class/' . $class_name . '.php';
}

include 'inc/header.php';
$page = "event";
include 'inc/inclogin.php';

if(isset($_GET['id'])){
	$eventid = $_GET['id'];

	$ds = new DataSource();
    $event = $ds->getEvent($eventid);

}


?>

<div class="jumbotron">
	<div class="container">
		<h1><?php echo $event->title ?></h1>
	</div>
</div>

<div class="container">

	<div class="row">
		<div class="col-md-4">
			<h2>Event organizer</h2>
			<a href="member.php?mem=<?php echo $event->owner ?>"><img src="img/member/<?php echo $event->owner ?>.jpg" alt="<?php echo $event->owner ?>" title="<?php echo $event->owner ?>"></a>
		</div>
		<div class="col-md-8">
			<h2>Details</h2>
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Description</h3>
				</div>
				<div class="panel-body"><?php echo $event->desc ?></div>
			</div>
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Start date</h3>
				</div>
				<div class="panel-body"><?php echo $event->start ?></div>
			</div>
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">End date</h3>
				</div>
				<div class="panel-body"><?php echo $event->end ?></div>
			</div>
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Member's going</h3>
				</div>
				<div class="panel-body"></div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6">
			<h2>About us</h2>
			<p>We are simply a group that enjoys different activities</p>
			<p><a class="btn btn-default" href="#" role="button">View members &raquo;</a></p>
		</div>
		<div class="col-md-6">
			<h2>Contact</h2>
			<p>Fee free to contact us for more info or to join our group.</p>
			<p><a class="btn btn-default" href="#" role="button">Contact us &raquo;</a></p>
		</div>
	</div>

<?php include 'inc/footer.php'; ?>