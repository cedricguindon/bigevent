  		<hr>

  		<footer>
  			<p>&copy; Big event for us 2014</p>
  			<?php
  			if(!ini_get('date.timezone') )
			{
			    date_default_timezone_set('EST');
			}
  			$start1 = date('Y-m-d h:i:s', 1394427600000 / 1000);
			echo $start1;
			$end1 = date('Y-m-d h:i:s', 1414427600000 / 1000);
			echo $end1;
  			?>
  		</footer>
  	</div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="dist/underscore.min.js"></script>
    <script type="text/javascript" src="dist/bootstrap-calendar-master/js/calendar.min.js"></script>
    <script type="text/javascript" src="js/calinit.js"></script>
    
</body>
</html>