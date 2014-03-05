<?php  
	/*------------------------------------------------------------------------
# author    Gonzalo Suez
# copyright Copyright © 2013 gsuez.cl. All rights reserved.
# @license  http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Website   http://www.gsuez.cl
-------------------------------------------------------------------------*/
// no direct access
defined('_JEXEC') or die;

include 'includes/params.php';
?>
<!doctype html>
<html lang="en" >

<?php
include 'includes/head.php';
?>

<body>
<!--top-->
<?php  if($this->countModules('top')) : ?>
<div id="top">
<div class="container">
<div class="row">
<jdoc:include type="modules" name="top" style="none" />	
</div>
</div>
</div>
<?php  endif; ?>
<!--top-->
<div id="wrap">
<!--Navigation-->
 <div id="navigation">
      <div class="container">
        <div class="navbar navbar-default" role="navigation">
            <div class="navbar-header">
               <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
		<div id="brand">
				<a href="<?php  echo $this->params->get('logo_link')  ?>">
					   <img style="width:<?php  echo $this->params->get('logo_width')  ?>px; height:<?php  echo $this->params->get('logo_height')  ?>px; " src="<?php  echo $this->params->get('logo_file')  ?>" alt="Logo" />
					</a>
			</div>
            </div>
            <div class="navbar-collapse collapse">
<?php  if ($this->countModules('navigation')) : ?>
			<nav class="navigation" role="navigation">
				<jdoc:include type="modules" name="navigation" style="none" />
			</nav>
			<?php  endif; ?>
            </div>
          </div>
        </div>
      </div>
<!--Navigation-->
<!--fullwidth-->
<?php  if($this->countModules('fullwidth')) : ?>
<div id="fullwidth">
<div class="row">
<jdoc:include type="modules" name="fullwidth" style="block"/>
</div>
</div>
<?php  endif; ?>
<!--fullwidth-->
<!--Showcase-->
<?php  if($this->countModules('showcase')) : ?>
<div id="showcase">
<div class="container">
<div class="row">
<jdoc:include type="modules" name="showcase" style="block"/>
</div>
</div>
</div>
<?php  endif; ?>
<!--Showcase-->
<!--Feature-->
<?php  if($this->countModules('feature')) : ?>
<div id="feature">
<div class="container">
<div class="row">
<jdoc:include type="modules" name="feature" style="block" />	
</div>
</div>
</div>
<?php  endif; ?>
<!--Feature-->
<!-- Content -->
<div class="container">
<?php  if($this->countModules('breadcrumbs')) : ?>
<div id="breadcrumbs">	

<div class="row">
<jdoc:include type="modules" name="breadcrumbs" style="block" />
</div>

</div>
<?php endif; ?>
<div id="main" class="row show-grid">
<!-- Left -->
<?php if($this->countModules('left')) : ?>
<div id="sidebar" class="col-sm-<?php echo $leftcolgrid; ?>">
<jdoc:include type="modules" name="left" style="xhtml" />
</div>
<?php endif; ?>
<!-- Component -->
<div id="container" class="col-sm-<?php echo (12-$leftcolgrid-$rightcolgrid); ?>">
<!-- Content-top Module Position -->	
<?php if($this->countModules('content-top')) : ?>
<div id="content-top">
<div class="row">
<jdoc:include type="modules" name="content-top" style="block" />	
</div>
</div>
<?php endif; ?>
<div class="main-box">
<jdoc:include type="component" />
<jdoc:include type="message" />	
</div>
<!-- Below Content Module Position -->	
<?php if($this->countModules('content-bottom')) : ?>
<div id="content-bottom">
<div class="row">
<jdoc:include type="modules" name="content-bottom" style="block" />	
</div>
</div>
<?php endif; ?>
</div>
<!-- Right -->
<?php if($this->countModules('right')) : ?>
<div id="sidebar-2" class="col-sm-<?php echo $rightcolgrid; ?>">
<jdoc:include type="modules" name="right" style="xhtml" />
</div>
<?php endif; ?>
</div>
</div>
<!-- Content -->
<!-- bottom -->
<?php  if($this->countModules('bottom')) : ?>
<div id="bottom">
<div class="container">
<div class="row">
<jdoc:include type="modules" name="bottom" style="block" />
</div>
</div>
</div>
<?php  endif; ?>
<div id="push"></div>
<!-- bottom -->
</div>
<!-- footer -->
<?php  if($this->countModules('footer')) : ?>
<div id="footer">
<div class="container">
<div class="row">
<jdoc:include type="modules" name="footer" style="block" />
</div>
</div>
</div>
<?php  endif; ?>
<!-- footer -->

<jdoc:include type="modules" name="debug" />	
<!-- page -->	
<!-- JS -->
<script src="<?php  echo $this->baseurl  ?>/templates/<?php  echo $this->template; ?>/js/bootstrap.min.js"></script>
<script type="text/javascript">
  (function($){   
    $(document).ready(function(){
      // dropdown
      $('.parent').addClass('dropdown');
      $('.parent > a').addClass('dropdown-toggle');
      $('.parent > a').attr('data-toggle', 'dropdown');
      $('.parent > a').append('<b class="caret"></b>');
      $('.parent > ul').addClass('dropdown-menu');
    });
  })(jQuery);
</script> 
<script type="text/javascript">
$('.dropdown input').click(function(e) {
        e.stopPropagation();
    });
</script> 
<!-- JS -->
</body>
</html>
