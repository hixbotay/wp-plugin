<?php
HBImporter::model('productcategory','product');
HBImporter::helper('math');
$model = new HBModelProductCategory();
$categories = $model->get_root_items();

$url = HBHelper::get_url_path();
if($url[1]){
	$cat_id =end(explode('-', $url[1]));
}else{
	$cat_id = $categories[0]->id;
}
$category = $model->getItem($cat_id);

$child_categories = $model->get_child_item($category->id);

$product_model = new HBModelProduct();
$product_model->set_state('list.limit',4);
//$products = (new HBModelProduct())->get_product_by_cat($cat_id);

$src = reset(wp_get_attachment_image_src($category->category_icon,'large',true));
// debug($products);

add_filter('pre_get_document_title',function() use ($category){
	return $category->name;
});
get_header();
?>
<div class="container">
	
	<div id="list-cat">
		<ul class="">
			<?php foreach($categories as $cat){?>
				<li class="<?php echo $cat_id==$cat->id ? 'active' : ''?>"><a href="<?php echo $cat_id==$cat->id ? '#' : site_url('/products/'.HBHelper::clean_string($cat->name).'-'.$cat->id)?>"><?php echo $cat->name?></a></li>
			<?php }?>
		</ul>
	</div>
	
	<div>
		<?php foreach($child_categories as $child_cat){
		$cat_product = $product_model->get_product_by_cat($child_cat->id);
		?>
		<?php if(count($cat_product)>0){?>
		<div class="slide-cat relative">
			<div class="cat-brand"><?php echo $child_cat->name?></div>	
			<div class="row">
				<?php foreach($cat_product as $p){
				$src = reset(wp_get_attachment_image_src($p->product_icon,'medium',true));
				?>
				<div class="item-product col-xs-3">
					<div class="relative">
						<div class="item-product-name"><?php echo $p->name?></div>
						<div class="item-product-view">
							<a href="<?php echo  site_url('/product/'.$p->alias.'-'.$p->id)?>" class="zeno5 btn btn-primary">Xem chi tiết</a>
						</div>
						<img class="wp-post-image" src="<?php echo $src?>"/>
					</div>
					
				</div>
				<?php }?>
			</div>
		</div>
		<?php }?>
		<?php }?>
	</div>
</div>
<?php get_footer() ?>