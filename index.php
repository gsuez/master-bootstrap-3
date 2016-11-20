<?php
/*------------------------------------------------------------------------
# author Gonzalo Suez
# copyright Copyright © 2013 gsuez.cl. All rights reserved.
# @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Website http://www.gsuez.cl
-------------------------------------------------------------------------*/	// no direct access
defined('_JEXEC') or die;

include 'includes/unseting.php';

include 'includes/params.php';

?>
<!DOCTYPE html>
<html lang="en">
<?php
 include 'includes/head.php'; ?>
<body>
  <div id="wrapper" class="wrapper">
    <?php include 'blocks/sidenav.php'; ?>

    <div id="page-content-wrapper">
      <?php include 'blocks/header.php'; ?>

      <!-- wrapper for the main, unique content for each page -->
      <main class="container"> 
	      <jdoc:include type="component" /> <!-- main content -->

	      <jdoc:include type="modules" name="editorsChoise" /> <!--replace with our own-->
	      <jdoc:include type="modules" name="mostVisitedArticle" /> <!--replace with our own-->
	  </main>

    </div>
  </div>



<jdoc:include type="modules" name="debug" />
</section>
<!-- page -->
<!-- JS -->
<script type="text/javascript" src="<?php echo $tpath; ?>/js/template.min.js"></script>
<!-- JS -->
</body>
</html>
