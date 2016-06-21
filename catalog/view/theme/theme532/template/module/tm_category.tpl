<div class="box category">
	<div class="box-heading"><h3><i class="flaticon-show5"></i><?php echo $heading_title; ?></h3></div>
	<div class="box-content">
		<div class="box-category">
		<?php if ($categories) {  echo $categories; } ?>
		</div>
	</div>
</div>
<script>
jQuery(document).ready(function(){
jQuery('.box-category .menu').find('li>ul').before('<i class="fa fa-angle-right"></i>');
  jQuery('.box-category .menu li i').on("click", function(){
   if (jQuery(this).hasClass('fa-angle-down')) { jQuery(this).removeClass('fa-angle-down').parent('li').find('> ul').slideToggle(); }
    else {
     jQuery(this).addClass('fa-angle-down').parent('li').find('> ul').slideToggle();
    }
  });
});
</script>
