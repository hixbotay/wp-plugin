<?php 
HBImporter::model('orders');
HBImporter::helper('currency','date');
$input = HBFactory::getInput();
$order = (new HBModelOrders())->getComplexItem($input->getInt('order_id'));
// debug($order);
add_filter('pre_get_document_title',function(){return __('Payment');});
wp_enqueue_style( 'bootstrap', site_url(). '/wp-content/plugins/visa-fvn/assets/css/bootstrap.css', '', '1.0.0' );
wp_enqueue_script( 'bootstrap', site_url(). '/wp-content/plugins/visa-fvn/assets/js/bootstrap.min.js', array('jquery'), '1.0.0' );
wp_enqueue_style( 'visa', site_url(). '/wp-content/plugins/visa-fvn/assets/css/visa.css', '', '1.0.0' );
?>
<?php get_header();?>
<div class="applyform step3">
	<form id="frontForm" name="frontForm" action="index.php" method="POST">
		<h3>Please review your visa application details !</h3>
		<?php echo HBHelper::renderLayout('email_order_info',$order)?>
		<br>
		<h3>Passport details</h3>
		<?php echo HBHelper::renderLayout('email_passenger',$order)?>
		<br>
		<h3>Service fees</h3>
		<?php echo HBHelper::renderLayout('email_summary',$order)?>
	<br>
	<h3><?php echo __('Choose a payment method')?></h3>
	<p>Please select one of below payment method to proceed the visa application.</p>
	 
                    <div id="payment-area">
                        <p><input type="radio" name="pay_method" value="paypal" checked="checked"/><img style="width:200px" src="https://www.paypalobjects.com/webstatic/mktg/logo-center/PP_Acceptance_Marks_for_LogoCenter_266x142.png?01AD=39-fyRS8I-n5xFc-JIzcXqDql2n6M9wGCEszIwFf3ZXFEuPKp6ena6A&01RI=4E1BBBDDE2B7CDD&01NA=na"/>
                      <a target="_blank" href="https://www.onepay.vn/"><img style="width:200px" src="<?php echo site_url()?>/wp-content/plugins/visa-fvn/assets/images/logo-onepay.png"/></a>
                      </p>                     
                        
                    </div>
<input type="hidden" name="order_id" value="<?php echo $input->getInt('order_id')?>"/>
<input type="hidden" name="hbaction" value="payment"/>
<input type="hidden" name="task" value="process"/>

	<div class="form-group" style="padding-top: 20px; padding-bottom: 20px;">
		<div class="text-center">
			<!-- <button class="btn btn-danger btn_back" type="button" onclick="window.location='https://www.vietnam-immigration.net/apply-visa/step2.html'"><i class="icon-double-angle-left icon-large"></i> BACK</button> -->
				<button class="btn btn-danger btn_next" type="submit" >NEXT <i class="icon-double-angle-right icon-large"></i></button>
			</div>
		</div>
	</form>
</div>
<script>
function submitForm(){
	var form= jQuery("#frontForm");
	//var validator = form.validate();
	if(1){//form.valid()){
		if(jQuery("input[name='pay_method']").is(":checked")==false)
		{
			alert("<?php echo __('Please choose a payment method') ?>");
			return false;
		}
		
		//form.submit();
		displayProcessingForm(1);
		jQuery.ajax({
	           type: "POST",
	           url: '<?php echo site_url()?>/?hbaction=tour&task=book&hb_meta_nonce=<?php echo wp_create_nonce( 'hb_meta_nonce' );?>',
	           dataType: 'json',
	           data: form.serialize(), // serializes the form's elements.
	           success: function(result)
	           {
	        	 
	        	   jQuery('#order_id').val(result.order_id);
				   if(result.hasOwnProperty("status")){
					   if(result.status==1){
							window.location = result.url;
						}else{
							displayProcessingForm(0);
							alert(result.error.msg);
							return false;
						}
				   }else{
					   displayProcessingForm(0);
					   alert('<?php echo __('System error warn'); ?>');
				   }
	           },
	           error: function (){
	        	   displayProcessingForm(0);
	        	   alert('<?php echo __('System error warn'); ?>');
		       }
	         });
	}else{
		//validator.focusInvalid();
	}
	return false;
}
function displayProcessingForm(enable){
	if(enable){
		jQuery('button').prop( "disabled", true );
		jQuery('body').css( "opacity", '0.5' );
		jQuery('body').append('<img id="loading"  style="position: fixed;top:50%;left: 50%;width:100px;z-index:999;" src="<?php echo site_url()?>/wp-content/plugins/hbpro/assets/images/loading.gif"/>');
// 		jQuery('#loading').show();
	}else{
		jQuery('button').prop( "disabled", false );
		jQuery('body').css( "opacity", '1' );
		jQuery('#loading').remove();
	}
}
</script>
<?php get_footer(); ?>


