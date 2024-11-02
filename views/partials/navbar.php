<?php

echo <<<_END
	<nav class="navbar navbar-default">
	  <div class="container">
		<div class="navbar-header">
		   <a class="navbar-brand" href="#myPage"><span class="glyphicon glyphicon-book"></span></a>
		</div>
		<div class="collapse navbar-collapse" id="myNavbar">
		  <ul class="nav navbar-nav navbar-right">
		  	<li><a href="Library-staff-only.html">Staff Access</a></li>
		  	<li><a href="Update-account.html">Update Account</a></li>			
			<li><a href="">Initiate Return</a></li>
			<li><a href="Library-login.html">Logout</a></li>
			<li><a href="Library-search.html">Search Library</a></li>
		  </ul>
		</div>
	  </div>
	</nav>
_END;