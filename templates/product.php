<?php 
HBImporter::model('productcategory','product');
HBImporter::helper('math');
$model = new HBModelProductCategory();

$url = HBHelper::get_url_path();
if($url[1]){
	$product_id =end(explode('-', $url[1]));
}else{
	wp_redirect(site_url('404.php'));
}
$category = $model->getItem($product_id);

$product = (new HBModelProduct())->getItem($product_id);

$src = reset(wp_get_attachment_image_src($product->product_icon,'large',true));
// debug($products);
add_filter('pre_get_document_title',function() use ($product){
	return $product->type.' '.$product->name;
});
get_header();
?>
<div class="container">
		<h1 class="title"><?php echo $product->name ?></h1>
	
	<div class="row">
		<div class="col-md-9">
			<div  class="relative image-banner">
				<img class="wp-post-image" src="<?php echo $src?>" />
			</div>
		</div>
		<div class="col-md-3">
			<center>
				<a href="#demo" id="view_demo" class="btn btn-primary zeno5">Xem Demo</a>
				<a href="javascript:void(0)" class="btn btn-primary zeno5" onclick="window.location.href= document.referrer;">Quay lại</a>
			</center>
		</div>
	</div>
	<div class="content"><?php echo apply_filters('the_content', $product->description);?></div>
	
	
	<div id="demo"></div>
	<?php if($product->type=='video'){?>
			<script>
				jQuery(document).ready(function($){
					$('#view_demo').click(function(){
						jAlert('<center><?php echo trim(apply_filters('the_content', '[embed]'.$product->product_link.'[/embed]'))?></center>');
					});
				});
			</script>
			
		<?php } else if($product->type=="website"){?>
			<script>
				jQuery(document).ready(function($){
					$('#view_demo').click(function(){
						$('#demo_content').show();
					});
				});
			</script>
			<div id="demo_content" style="display:none;">
				<div class="navbar-fixed-top" style="line-height:30px;padding-left:20px;z-index:9999999;width:100%;background: white;
	box-shadow: 0 4px 10px -6px #222;"><a href="#" onclick="jQuery('#demo_content').hide()"><< Đóng lại</a></div>
				<iframe style="width:100%;height:100%;position:fixed;z-index:99999;top:30px;left:0" src="<?php echo $product->product_link?>"></iframe>
			</div>
		<?php }?>
	
</div>
<?php get_footer() ?>