<?php 
HBImporter::model('orders');
HBImporter::helper('currency','date');
$input = HBFactory::getInput();

// debug($order);
add_filter('pre_get_document_title',function(){return __('Order detail');});
wp_enqueue_style( 'bootstrap', site_url(). '/wp-content/plugins/visa-fvn/assets/css/bootstrap.css', '', '1.0.0' );
//wp_enqueue_script( 'bootstrap', site_url(). '/wp-content/plugins/visa-fvn/assets/js/bootstrap.min.js', array('jquery'), '1.0.0' );
wp_enqueue_style( 'visa', site_url(). '/wp-content/plugins/visa-fvn/assets/css/visa.css', '', '1.0.0' );
?>
<?php get_header();?>
<?php 
$email = $input->get('email');
$order_number = $input->get('order_number');
global $wpdb;
$query = "select * from #__fvn_orders where email LIKE \"{$email}\" AND order_number LIKE \"{$order_number}\";";
// debug('');
// debug($query);
$query = str_replace('#__', $wpdb->prefix, $query);
$order = $wpdb->get_row($query);
$order_complex = (new HBModelOrders())->getComplexItem($order->id);
//debug($order_complex);
?>

<section id="site-main">
<div class="container">
    <h3><?php echo __('Booking detail')?></h3>
	<hr>
<?php if(!$order->id){ ?>
<?php echo __('Order number is invalid'); ?>

<form style="margin-top: 20px">

    <div class="form-group">
        <input type="text"  name="order_number" required class="form-control" placeholder="<?php echo __('Code'); ?>" />
    </div>
    <div class="form-group">
        <input type="email"  name="email" class="form-control" required placeholder="<?php echo __('Email'); ?>"  />
    </div>
     <div class="form-group">
        <input type="submit"  value="<?php echo __('Check')?>" class="btn btn-primary submit-oderdetail pull-left"/>
     </div>

</form>

<?php }else{
	?>
		
		<div class="row">
            <div class="col-md-4"><h3><?php echo __('Order number')?></h3></div>
            <div class="col-md-8"><?php echo $order->order_number?></div>
        </div>       
        <div class="row table">
            <div class="col-md-4"><h3><?php echo __('Payment status')?></h3></div>
            <div class="col-md-8">
                <?php echo HBCurrencyHelper::paymentStatus($order->pay_method, $order->pay_status); ?>
            </div>
        </div>
		<hr>
       <h3><?php echo __('Order info')?></h3>
		<?php echo HBHelper::renderLayout('email_order_info',$order_complex)?>
		<br>
		<h3><?php echo __('Passenger detail')?></h3>
		<?php echo HBHelper::renderLayout('email_passenger',$order_complex)?>
		<br>
		<h3><?php echo __('Service fee')?></h3>
		<?php echo HBHelper::renderLayout('email_summary',$order_complex)?>
		<?php if($order_complex->order->params['image_result']){?>
		<h3><?php echo __('Download scan visa')?></h3>
		<?php foreach($order_complex->order->params['image_result'] as $s){
			$src = wp_get_attachment_image_src($s,'orignal',true)[0];
			?>
			<a href="<?php echo $src?>" target="_blank"><img class='image-preview' src='<?php echo $src?>' style='width: 300px;'></a>
		<?php }?>
		<?php }?>

<?php }?>
</div>
</section>

<?php get_footer(); ?>


