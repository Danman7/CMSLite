	<footer class="navbar navbar-default navbar-fixed-bottom <?php if ($layout_context == "public") {echo "navbar-inverse";}?>">
	<div class="container">
        <p class="navbar-text"><?php if ($layout_context == "admin") {echo "CMSLite courtesy <a href=\"http://www.linkedin.com/profile/view?id=189813882&authType=NAME_SEARCH&authToken=m_Ez&locale=en_US&srchid=1898138821383137384706&srchindex=1&srchtotal=6&trk=vsrp_people_res_name&trkInfo=VSRPsearchId%3A1898138821383137384706%2CVSRPtargetId%3A189813882%2CVSRPcmpt%3Aprimary\">Dan Atanasov</a>. This software is free for use and modification by anyone.";} else {echo "Public Footer Area";} ?></p>
    </div>
    </footer>
</body>
</html>
<?php
  // Close database connection
	if (isset($connection)) {
	  mysqli_close($connection);
	}
?>