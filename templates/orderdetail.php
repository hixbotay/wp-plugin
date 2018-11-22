
<?php get_header();?>
<?php 
HBImporter::helper('currency');
$order_number = $_GET['order_number'];
$email = $_GET['email'];
global $wpdb;
$query = "select * from #__fvn_orders where email LIKE \"{$email}\" AND order_number LIKE \"{$order_number}\";";
// debug('');
// debug($query);
$query = str_replace('#__', $wpdb->prefix, $query);
$order = $wpdb->get_row($query);

?>

<section id="site-main">
<div class="container">
    <h3><?php echo __('Booking detail')?></h3>
<?php if(!$order){ ?>
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

<?php }else{?>

        <div class="row table">
            <div class="col-md-4"><p><?php echo __('Order number')?></p></div>
            <div class="col-md-8"><?php echo $order->order_number?></div>
        </div>
        <div class="row table">
            <div class="col-md-4"><p><?php echo __('Info detail')?></p></div>
            <div class="col-md-8"><?php echo $order->email?></div>
        </div>
        <div class="row table">
       
        <div class="row table">
            <div class="col-md-4"><p><?php echo __('Payment status')?></p></div>
            <div class="col-md-8">
                <?php echo HBCurrencyHelper::paymentStatus($order->pay_method, $order->pay_status); ?>
            </div>
        </div>
        <div class="row table">
            <div class="col-md-4"><p><?php echo __('total')?></p></div>
            <div class="col-md-8"><?php echo HBCurrencyHelper::displayPrice($order->total,$order->currency)?></div>
        </div>

<?php }?>
</div>
</section>

<?php get_footer(); ?>


