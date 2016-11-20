jQuery("#menu-toggle").click(function(e) {
     e.preventDefault();
     jQuery(".wrapper").toggleClass("toggled");
 });

 jQuery('.sidebar-dropdown-toggle').on('click', function () {
   var toggle = jQuery(this);
  
   toggle.siblings('.sidebar-dropdown-menu').first().toggleClass('open');
 });
