<?php
$mail_option = get_option('fvn_mail_customer');
$mail_option = json_decode($mail_option);
$mail_admin_option = get_option('fvn_mail_admin');
$mail_admin_option = json_decode($mail_admin_option);

$mail_payment_option = get_option('fvn_mail_payment');
$mail_payment_option = json_decode($mail_payment_option);
?>
<form action="<?php echo admin_url('admin-post.php?action=hbaction')?>"
	method="post" name="adminForm" id="adminForm" class="form-validate adminForm">
	<!-- CONFIG -->
	<table style="width:100%">
		<tr>
			<td><?php echo __('Customer mail from name')?></td>
			<td><?php echo FvnHtml::text('data[fvn_mail_customer][from_name]','',$mail_option->from_name)?></td>
		</tr>
		<tr>
			<td><?php echo __('Customer mail from email')?></td>
			<td><?php echo FvnHtml::mail('data[fvn_mail_customer][from_email]','',$mail_option->from_email)?></td>
		</tr>
		<tr>
			<td><?php echo __('Customer mail title')?></td>
			<td><?php echo FvnHtml::text('data[fvn_mail_customer][title]','',$mail_option->title)?></td>
		</tr>
		<tr>
			<td><?php echo __('Customer mail description')?></td>
			<td><?php echo FvnHtml::editor('data[fvn_mail_customer][description]',[],$mail_option->description,'fvn_mail_description')?></td>
		</tr>
		
		<tr>
			<td><?php echo __('Payment mail title')?></td>
			<td><?php echo FvnHtml::text('data[fvn_mail_payment][title]','',$mail_payment_option->title)?></td>
		</tr>
		<tr>
			<td><?php echo __('Payment mail description')?></td>
			<td><?php echo FvnHtml::editor('data[fvn_mail_payment][description]',[],$mail_payment_option->description,'fvn_mail_payment_description')?></td>
		</tr>
		
		<tr>
			<td><?php echo __('Admin mail from name')?></td>
			<td><?php echo FvnHtml::text('data[fvn_mail_admin][from_name]','',$mail_admin_option->from_name)?></td>
		</tr>
		<tr>
			<td><?php echo __('Admin mail from mail')?></td>
			<td><?php echo FvnHtml::mail('data[fvn_mail_admin][from_email]','',$mail_admin_option->from_email)?></td>
		</tr>
		<tr>
			<td><?php echo __('Admin mail title')?></td>
			<td><?php echo FvnHtml::text('data[fvn_mail_admin][title]','',$mail_admin_option->title)?></td>
		</tr>
		<tr>
			<td><?php echo __('Admin mail description')?></td>
			<td><?php echo FvnHtml::editor('data[fvn_mail_admin][description]',[],$mail_admin_option->description,'fvn_mail_admin')?></td>
		</tr>
		
		
		
	</table>
	
	<?php wp_nonce_field( 'hb_action', 'hb_meta_nonce' );?>
	<input type="hidden" name="hbaction" value="setting" />
	<input type="hidden" id="task" name="task" value="saveMail" />
	<?php  submit_button()?>
</form>