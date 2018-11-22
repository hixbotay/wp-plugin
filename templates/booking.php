<?php 
HBImporter::model('period','country','airport','processing_time');
HBImporter::helper('math','date','currency');
HBHtml::add_datepicker_lib();
$config = HBFactory::getConfig();
$countries = (new HBModelCountry())->getList();
$periods = (new HBModelPeriod())->getList();
$airports = (new HBModelAirport())->getList();
$processing_times = (new HBModelProcessing_time())->getList();


// debug($products);
add_filter('pre_get_document_title',function(){return __('Booking');});

get_header();
?>
<div class="container">
<div class="tab-step clearfix">
	<h1 class="note">Vietnam Visa Application Form</h1>
	<ul class="style-step hidden-xs">
		<li class="active"><font class="number">1.</font> <?php echo ('Visa Options')?></li>
		<li><font class="number">2.</font> <?php echo __('Applicant Details')?></li>
		<li><font class="number">3.</font> <?php echo __('Review and Payment')?></li>
	</ul>
</div>
<div class="applyform">
		<form id="frmApply" class="form-horizontal" role="form" action="<?php echo site_url('booking-step2')?>" method="GET">
			<div class="row clearfix">
				<div class="col-md-7">
					<div class="panel-options">
						<div class="form-group row">
							<div class="col-md-4">
								<label class="control-label">Passport holder <span class="required">*</span></label>
							</div>
							<div class="col-md-8">
								<?php echo HBHtml::select($countries, 'country_code', 'class="form-control change-price group_size" required', 'country_code', 'country_name','','country_code',__('Please select'))?>
							
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-4">
								<label class="control-label">Number of visa <span class="required">*</span></label>
							</div>
							<div class="col-md-8">
								<select id="passenger_number" name="passenger_number" class="form-control change-price group_size">
								<?php for($i=1;$i<=$config->passenger_limit;$i++){?>
								<option value="<?php echo $i?>"><?php echo $i?> <?php echo $i>1?__('Applicants'): __('Applicant')?></option>
								<?php }?>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-4">
								<label class="control-label"><?php echo __('Type of visa')?> <span class="required">*</span></label>
							</div>
							<div class="col-md-8">
								<?php echo HBHtml::select($periods, 'period_id', 'required class="form-control change-price visa_type"', 'id', 'name',reset($periods)->id,'period_id')?>								
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-4">
								<label class="control-label">Purpose of visit <span class="required">*</span></label>
							</div>
							<div class="col-md-8">
								<select id="purpose_of_visit" name="purpose_of_visit" required class="form-control change-price visit_purpose">
									<option value="">Please select...</option>
									<option value="tour">For tourist</option>
									<option value="bus">For business</option></select>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-4">
								<label class="control-label">Arrival airport <span class="required">*</span></label>
							</div>
							<div class="col-md-8">
								<?php echo HBHtml::select($airports, 'airport_id', 'required class="form-control change-price arrival_port"', 'id', 'name','','airport_id',__('Please select'))?>
								
								<div class="processing-note">
									<?php echo __('The first port you arrive to Vietnam')?>.
								</div>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-4">
								<label class="control-label"><?php echo __('Arrival date')?> <span class="required">*</span></label>
							</div>
							<div class="col-md-8">
								<div class="">
									<?php echo HBHtml::calendar('','start', 'start', HBDateHelper::getConvertDateFormat('J'),'required class="form-control" readonly="true"',array('minDate'=>'+1'));?>
								</div>
								<div class="processing-note">
									When you arrive Vietnam?
								</div>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-4">
								<label class="control-label">Processing time <span class="required">*</span></label>
							</div>
							<div class="col-md-8">
								<?php foreach($processing_times as $i=>$pt){?>
								<div class="radio">
									<label>
										<input id="processing_time_<?php echo $pt->id?>" note-id="processing-time-normal-note" class="processing_time" type="radio" name="processing_time" value="<?php echo $pt->id?>">
										<strong><?php echo $pt->name?></strong>
									</label>
									<div id="processing-time-normal-note" class="processing-option none">
										<div class="processing-note">
											<?php echo $pt->description?>
										</div>
									</div>
								</div>
								<?php }?>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-12">
								<div class="div"></div>
							</div>
							<div class="col-md-4">
								<label class="control-label">Private/confidential letter</label>
								<p class="help-block red">(Recommended)</p>
							</div>
							<div class="col-md-8">
								<div class="checkbox">
									<label>
										<input type="checkbox" id="private_visa" name="private_later" class="private_visa" value="1">
										<strong>Show me in a private visa letter</strong>
									</label>
								</div>
								<div class="processing-note">
									Because of Vietnam Immigration Office policy, they list a number of people on the same visa letter, so we offer private/confidential visa letter is showing your name or your group in 1 letter without others name on your letter. But you have to pay extra <b>10USD</b>/letter for you or your group.
								</div>
							</div>
						</div>
						<div class="form-group full_package_group full_package_group_none" style="display: none;">
							<div class="col-md-12">
								<div class="div"></div>
							</div>
							<div class="col-md-4">
								<label class="control-label">Full package service</label>
								<p class="help-block red">(Recommended)</p>
							</div>
							<div class="col-md-8">
								<div class="checkbox">
									<label>
										<input type="checkbox" id="full_package" name="full_package" class="full_package" value="1">
										<strong>Full visa services at the airport</strong>
									</label>
									<div class="processing-note">
										<span class="glyphicon glyphicon-ok"></span> Including the Airport Fast-Track service.<br>
										<span class="glyphicon glyphicon-ok"></span> Including Visa stamping fee for Vietnam Government.<br>
										<span class="red">You don't need to pay any extra fee.</span><br>
										<span class="red hidden">Save more 10% for the visa service fee.</span>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-12">
								<div class="div"></div>
							</div>
							<div class="col-md-4">
								<label class="control-label">Upon arrival services</label>
							</div>
							<div class="col-md-8">
								<div class="checkbox cb_fast_checkin">
									<label>
										<input type="checkbox" id="fast_checkin" name="airport_fast_track" class="fast_checkin" value="1">
										Airport fast track
									</label>
									<div class="processing-note">
										To avoid wasting your time and get line for getting visa stamp, our staff will handle all procedure for you. You will check-in faster than the others.
									</div>
								</div>
								<div class="checkbox">
									<label>
										<input type="checkbox" id="car_pickup" name="car_pickup" class="car_pickup" value="1">
										Airport car pick-up
									</label>
									<div class="processing-note">
										Our friendly drivers standing outside with your name on the welcome sign. He will pick you up at the airport to your hotel.
									</div>
								</div>
								<div class="clearfix car-select" id="car-select" style="background-color: rgb(248, 248, 248); border: 1px solid rgb(221, 221, 221); padding: 10px; display: none;">
									<label class="control-label">Car type</label>
									<div class="">
										<select class="form-control car_type" name="car_type" id="car_type">
											<option value="Economic Car" selected="selected">Economic Car</option>
										</select>
									</div>
									<label class="control-label">Seats</label>
									<div class="">
										<select class="form-control change-price car_service" id="car_service">
											<option value="4" selected="selected">4 seats</option>
											<option value="7">7 seats</option>
											<option value="16">16 seats</option>
											<option value="24">24 seats</option>
										</select>
										<input type="hidden" name="car_service"/>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group" style="padding-top: 20px; padding-bottom: 20px;">
							<label class="col-md-4 control-label"></label>
							<div class="col-md-8">
								<button class="btn btn-danger btn-next" type="submit">NEXT <i class="icon-double-angle-right icon-large"></i></button>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-5">
					<div class="panel-fees">
						<ul>
							<li class="clearfix">
								<label>Passport holder:</label>
								<span class="passport_holder_t">Please select...</span>
							</li>
							<li class="clearfix">
								<label>Number of visa:</label>
								<span class="group_size_t">1 Applicant</span>
							</li>
							<li class="clearfix">
								<label>Type of visa:</label>
								<span class="visa_type_t"><?php echo reset($periods)->name?><br><?php echo reset($periods)->description?></span>
							</li>
							<li class="clearfix">
								<label>Purpose of visit:</label>
								<span class="visit_purpose_t">Please select...</span>
							</li>
							<li class="clearfix">
								<label>Arrival airport:</label>
								<span class="arrival_port_t">Please select...</span>
							</li>
							<li class="clearfix">
								<label>Arrival date:</label>
								<span class="arrival_date_t">Please select...</span>
							</li>
							<li class="clearfix">
								<label>Visa service fee:</label>
								<span class="total_visa_price price"><?php echo HBCurrencyHelper::displayPrice(reset($periods)->price_tour)?> x 1 applicant = <?php echo HBCurrencyHelper::displayPrice(reset($periods)->price_tour)?></span>
							</li>
							<li class="clearfix" id="processing_time_li" style="display: none">
								<label>Processing time:</label>
								<span class="processing_note_t">Normal (2 working days)</span>
								<div class="clr"></div>
								<span class="processing_t price"></span>
								<div class="clr"></div>
							</li>
							<li class="clearfix" id="private_visa_li" style="display: none">
								<label>Private letter:</label>
								<span class="private_visa_t price"></span>
							</li>
							<li class="clearfix" id="full_package_li" style="display: none">
								<label>Full package service:</label>
								<div class="full_package_services"></div>
							</li>
							<li class="clearfix" id="extra_service_li" style="display: none">
								<label>Extra services:</label>
								<div class="extra_services"></div>
							</li>
							<li class="clearfix" id="vipsave_li" style="display: none">
								<label>VIP discount:</label>
								<span class="vipsave_t price"></span>
							</li>
							<li class="clearfix" id="promotion_li" style="background-color: #F8F8F8">
								<div class="" id="promotion-box-input">
									<div class="row clearfix">
										<label class="col-md-5">Got a promotion code?</label>
										<div class="col-md-7">
											<div class="input-group">
												<input type="text" class="promotion-input form-control" id="promotion-input" name="promotion-input" value="">
												<span class="input-group-btn" style="float: none;">
													<button type="button" class="btn btn-danger btn-apply-code">APPLY</button>
												</span>
										    </div>
											<!-- <div class="promotion-error red none">Code invalid. Please try again!</div> -->
										</div>
									</div>
								</div>
								<div class="clearfix none" id="promotion-box-succed">
									<label class="left">Promotion discount:</label>
									<span class="promotion_t price"></span>
								</div>
							</li>
							<li class="total clearfix">
								<div class="clearfix">
									<label>TOTAL FEE:</label>
									<span class="total_price"><?php echo HBCurrencyHelper::displayPrice(reset($periods)->price_tour)?></span>
								</div>
								
							</li>
						</ul>
						<!-- 
						<div class="payment-methods">
							<img alt="" src="https://www.vietnam-immigration.net/template/images/payment-methods.jpg">
						</div>
						 -->
					</div>
				</div>
			</div>
			<input type="hidden" id="vip_discount" name="vip_discount" value="0">
		</form>
	</div>
</div>

<script>
	jQuery(document).ready(function($){
		$('.processing_time:first').attr('checked',true);
		$('.processing_time:first').parents('.radio').find('.processing-option').show();
		$('.processing_time').click(function(){
			$('.processing-option').hide();
			$(this).parents('.radio').find('.processing-option').show();
			$('#purpose_of_visit').trigger('change');
		});
		$('#airport_fast_track').click(function(){
			
			$('#purpose_of_visit').trigger('change');
		});
		$('#start').change(function(){
			$('.arrival_date_t').html($(this).val());
		});
		$('input[name="private_later"]').click(function(){
			$('#purpose_of_visit').trigger('change');
		});
		$('#fast_checkin').click(function(){
			$('#purpose_of_visit').trigger('change');
		});
		
		$('#car_pickup').click(function(){
			
			if($(this).attr('checked')){
				$('#car-select').show();
				$('input[name="car_service"]').val($('#car_service').val());
			}else{
				$('#car-select').hide();
				$('input[name="car_service"]').val('');
			}
			$('#purpose_of_visit').trigger('change');
		});
		$('.change-price').change(function(){
			var element_id = $(this).attr('id');
			if(element_id=='car_service'){
				$('input[name="car_service"]').val($(this).val());
			}			
			var post = {};
			post.country_code =  jQuery('#country_code').val();
			post.passenger_number =  jQuery('#passenger_number').val();
			post.period_id =  jQuery('#period_id').val();
			post.purpose_of_visit =  jQuery('#purpose_of_visit').val();
			post.airport_id =  jQuery('#airport_id').val();
			post.start =  jQuery('#start').val();
			post.processing_time =  jQuery('input[name="processing_time"]:checked').val();
			post.private_later =  jQuery('#private_visa:checked').val();
			post.car_service =  jQuery('input[name="car_service"]').val();
			post.airport_fast_track =  jQuery('#fast_checkin:checked').val();
			jQuery.ajax({
	           type: "POST",
	           url: 'index.php?hbaction=order&task=caculate_price',
	           dataType: 'json',
	           data: post, // serializes the form's elements.
	           beforeSend: function(){display_processing_form(1);},
	           success: function(result)
	           {       	 
	        	   display_processing_form(0);
	        	   $('.passport_holder_t').html(result.country);
	        	   $('.group_size_t').html(result.passenger_number);
	        	   $('.visa_type_t').html(result.period);
	        	   $('.visit_purpose_t').html(result.purpose_of_visit);
	        	   $('.arrival_port_t').html(result.airport_id);	        	   
	        	   $('.total_visa_price').html(result.visa_service_fee);
	        	   if(result.private_later!=''){
		        	   $('#private_visa_li').show();
	        		   $('.private_visa_t').html(result.private_later);
		        	}else{
		        		$('#private_visa_li').hide();		        		
			        }
			        
	        	   if(result.extra_service!=''){
		        	   $('#extra_service_li').show();
	        		   $('#extra_service_li .extra_services').html(result.extra_service);
		        	}else{
		        		$('#extra_service_li').hide();		        		
			        }
			        if(element_id=='country_code'){
				        if(result.country_notice){
					        jAlert(result.country_notice);
					    }
				        if(result.country_limit_period!=''){
				        	jQuery('#period_id').html(result.country_limit_period);
					    }
				    }
	        	   $('.total_price').html(result.total);
	           },
	           error: function (){
	        	   display_processing_form(0);
	        	   jAlert('<?php echo __('System error'); ?>');
		       }
	         });
		});
		
	});
</script>
<?php get_footer() ?>