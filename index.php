<?php
include 'inc/header.php';
$page = "index";
include 'inc/inclogin.php';
echo "test";
?>

<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
	<div class="container">
		<h1>Welcome to Big event for us!</h1>
		<p>This site is dedicated to a group of awesome people gathering together for different activities.  We simply hang out together and do awesome stuff.</p>
	</div>
</div>

<div class="container">
	<div class="col-md-12">
  	<h2>Next Big event</h2>
  	<p>The next Big event will be a go-Kart race at Insert place here on that day.</p>
  	<p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
  	<div class="pull-right form-inline">
    	<div class="btn-group">
    		<button class="btn btn-primary" data-calendar-nav="prev">&lt; Prev</button>
    		<button class="btn" data-calendar-nav="today">Today</button>
    		<button class="btn btn-primary" data-calendar-nav="next">Next &gt;</button>
    	</div>
    	<div class="btn-group">
    		<button class="btn btn-warning" data-calendar-view="year">Year</button>
    		<button class="btn btn-warning active" data-calendar-view="month">Month</button>
    		<button class="btn btn-warning" data-calendar-view="week">Week</button>
    		<button class="btn btn-warning" data-calendar-view="day">Day</button>
    	</div>
    </div>
  </div>

  <div class="col-md-12">
  	<div id="calendar"></div>
  </div>
  <div class="span3">
  	<h4>Events</h4>
  	<small>This list is populated with events dynamically</small>
  	<ul id="eventlist" class="nav nav-list"></ul>
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

<?php echo "test"; ?>


<?php include 'inc/footer.php'; ?>