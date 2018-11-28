<?php
/**
 * @package 	FVN-extension
 * @author 		Vuong Anh Duong
 * @link 		http://freelancerviet.net
 * @copyright 	Copyright (C) 2011 - 2012 Vuong Anh Duong
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id$
 **/
// die('ddfdf');
defined('ABSPATH') or die('Restricted access');
HBImporter::helper('currency','date','orderstatus','paystatus','params');
global $wpdb;
$total = $this->pagination->total;
$paid_count = $wpdb->get_var("SELECT count(1) FROM {$wpdb->prefix}fvn_orders WHERE pay_status = 'SUCCESS'");
$unpaid_count = $total-$paid_count;
FvnHtml::add_datepicker_lib();
$paid_active = null;
$unpaid_active = null;

if ($this->input->get('pay') == 'success'){
    $paid_active = 'class="current"';
}
if ($this->input->get('pay') == 'pending'){
    $unpaid_active = 'class="current"';
}


?>
<h1><?php echo __('Booking')?></h1>
<form id="adminForm" method="GET" action="<?php echo admin_url('admin.php?page=orders')?>">
<div class="tablenav top">
	<ul class=" clearfix">
        <li ><a href="javascript:void(0)" class="btn btn-primary" onclick="hb_submit_form('exportCsv')" aria-current="page"><?php echo __("Export to csv")?> <span class="count"></span></a></li>       
        
    </ul>
    
    <ul class="subsubsub">
        <li class="all"><a href="admin.php?page=orders" aria-current="page">Tất cả <span class="count">(<?php echo $total ?>)</span></a> |</li>
        
        <li class="active"><a href="admin.php?page=orders&pay=success" <?php echo $paid_active ?>>Đã thanh toán <span class="count">(<?php echo $paid_count ?>)</span></a> |</li>
        <li class="active"><a href="admin.php?page=orders&pay=pending" <?php echo $unpaid_active ?>>Chưa thanh toán <span class="count">(<?php echo $unpaid_count ?>)</span></a> |</li>
        
    </ul>

    <br>
    <br>

    <div class="alignleft actions">			
        <?php echo FvnHtml::calendar($this->input->get('filter_date'), 'filter_date','date','yy-mm-dd','readonly="true" class="input-medium required name" required placeholder="'.__('Arrival date').'"',array('changeMonth'=>true,'changeYear'=>true,'maxDate'=>"(new Date()).getDate()"))?>
        
        <input type="text" id="info_custom" placeholder="<?php echo __('Order number, name, email, mobile')?>" value="<?php if ($this->input->get('information')) echo $this->input->get('information') ?>" >
        <?php echo OrderStatus::getHtmlList('filter_order_status', '', $this->input->get('filter_order_status'), '',__('Select Order status'))?>
        <?php echo PayStatus::getHtmlList('filter_pay_status', '', $this->input->get('filter_pay_status'), '',__('Select Pay status'))?>
        <button class="button" type="button" onclick="hb_submit_form('')" ><?php echo __('Find')?></button>
        <span><Button class="button action" onclick="window.location='admin.php?page=orders'">X</Button></span>

    </div>


    <div class="tablenav-pages one-page"><span class="displaying-num"><?php echo $this->pagination->total; ?> mục</span>
	<span class="pagination-links"><span class="tablenav-pages-navspan" aria-hidden="true">«</span>
	<span class="tablenav-pages-navspan" aria-hidden="true">‹</span>
	<span class="paging-input"><label for="current-page-selector" class="screen-reader-text">Trang hiện tại</label><input class="current-page" id="current-page-selector" name="paged" value="1" size="1" aria-describedby="table-paging" type="text"><span class="tablenav-paging-text"> trên <span class="total-pages">1</span></span></span>
	<span class="tablenav-pages-navspan" aria-hidden="true">›</span>
	<span class="tablenav-pages-navspan" aria-hidden="true">»</span></span></div>
		<br class="clear">
</div>


<div>
	
		<table class="wp-list-table widefat fixed striped posts">
			<thead>
				<tr>
                    <th id="cb" class="column-cb check-column">
                        <input id="cb-select-all-1" type="checkbox" onclick="toggle(this)">
                    </th>
					<th><?php echo __('Order number')?></th>
					<th><?php echo __('Full name')?></th>
					<th><?php echo __('Arrival date')?></th>
					<th><?php echo __('Pay status')?></th>
                    <th><?php echo __('Order status')?></th>
                    <th><?php echo __('Total')?></th>
					<th><?php echo __('Mobile')?></th>
					<th><?php echo __('Created')?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($this->items as $item){?>
                    <?php
                        $color  = '';
                        if ($item->pay_status == 'PENDING'){
                            $color = 'style="color: #F0AD4E"';
                        }
                        if ($item->pay_status == 'SUCCESS'){
                            $color = 'style="color: #5CB85C"';
                        }

                        $order_color = '';
                        if ($item->order_status == 'PENDING'){
                            $order_color = 'style="color: #F0AD4E"';

                        }
                        if ($item->order_status == "CONFIRMED"){
                            $order_color = 'style="color: #5CB85C"';
                        }


                        ?>
					<tr>
                        <td>
                            <input id="cb-select-<?php echo $item->id; ?>" type="checkbox" name="id[]" value="<?php echo $item->id; ?>"></td>
						<td>
							<a target="_blank" href="<?php echo HBHelper::get_order_link($item)?>"><?php echo $item->order_number;?></a>
							<div class="clearfix"></div>
							<div class="row-actions">
								<span class="view"><a target="_blank" href="admin.php?page=orders&layout=edit&id=<?php echo $item->id; ?>"><?php echo __('Edit')?></a></span>
								<span class="view"> | <a target="_blank" href="<?php echo HBHelper::get_order_link($item)?>"><?php echo __('View')?></a></span>
                                <span class="trash"> | <a href="javascript:void(0)" class="fvn-function" data-ask="1" data-href="<?php echo admin_url('admin.php?hbaction=orders&task=delete&id='.$item->id)?>"><?php echo __('Delete')?></a></span>
                            </div>
						</td>
                        
						<td><?php echo $item->fullname;?></td>
						<td><?php echo HBDateHelper::display($item->start).' '.$item->start_time?></td>
						<td><span <?php echo $color?>><?php echo $item->pay_status?></span></td>
                        <td <?php echo $order_color; ?> >
                            <?php echo $item->order_status;?>
                            <?php if ($item->order_status == 'PENDING'): ?>
                            <div class="clearfix"></div>
                            <div class="row-actions">
                                <span class="view"><a target="_blank" href="admin.php?page=orders&layout=edit&id=<?php echo $item->id; ?>" title="Đánh dấu: 'đã xử lý'"><span style="font-size: 16px">✓</span></a></span>
                            </div>
                            <?php endif; ?>
                        </td>
                        <td><?php echo HBCurrencyHelper::displayPrice($item->total)?></td>
						<td><a href="tel:<?php echo $item->mobile;?>"><?php echo $item->mobile;?></a></td>
						<td><?php echo $item->created;?></td>
					</tr>
				<?php }?>
			</tbody>
		</table>

        <?php wp_nonce_field( 'hb_action', 'hb_meta_nonce' );?>
        <input type="hidden" name="hbaction" value="orders" />
        <input type="hidden" id="task" name="task" value="" />
        <input type="hidden"  name="page" value="orders" />
	
</div>
</form>

<style>
    #cb-select-all-1{
        margin-top: 15px;
    }
</style>