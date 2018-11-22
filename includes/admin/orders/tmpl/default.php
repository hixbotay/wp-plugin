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
global $wpdb;
$total = $this->pagination->total;
$paid_count = $wpdb->get_var("SELECT count(1) FROM {$wpdb->prefix}fvn_orders WHERE pay_status = 'SUCCESS'");
$unpaid_count = $total-$paid_count;
HBHtml::add_datepicker_lib();
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

<div class="tablenav top">

    <ul class="subsubsub">
        <li class="all"><a href="admin.php?page=orders" aria-current="page">Tất cả <span class="count">(<?php echo $total ?>)</span></a> |</li>
        
        <li class="active"><a href="admin.php?page=orders&pay=success" <?php echo $paid_active ?>>Đã thanh toán <span class="count">(<?php echo $paid_count ?>)</span></a> |</li>
        <li class="active"><a href="admin.php?page=orders&pay=pending" <?php echo $unpaid_active ?>>Chưa thanh toán <span class="count">(<?php echo $unpaid_count ?>)</span></a> |</li>
    </ul>

    <br>
    <br>

	<div class="alignleft actions bulkactions">
        <label for="bulk-action-selector-top" class="screen-reader-text"><?php echo __('Bulk process')?></label>
        <select name="action" id="bulk-action-selector-top">
            <option>Tác vụ</option>
            <option value="edit" class="hide-if-no-js"><?php echo __('Edit')?></option>
            <option value="trash"><?php echo __('Delete')?></option>
        </select>
        <input id="doaction" class="button action" value="Áp dụng" type="submit" onclick="deletes()">
    </div>
    <div class="alignleft actions">
			<label for="filter-by-date" class="screen-reader-text"><?php echo __('Fitler by date')?></label>
            <?php
                $date = $this->input->get('date');
            ?>
        <?php echo HBHtml::calendar($date, 'filter[date]','date','yy-mm-dd','class="input-medium required name" required placeholder="'.__('Pick date').'"',array('changeMonth'=>true,'changeYear'=>true,'maxDate'=>"(new Date()).getDate()"))?>
            <Button class="button action" onclick="return filterDate()">Lọc</Button>

        <input type="text" id="info_custom" placeholder="<?php echo __('Order number, name, email, mobile')?>" value="<?php if ($this->input->get('information')) echo $this->input->get('information') ?>" >
        <span><Button class="button action" onclick="return filterInfo()"><?php echo __('Find')?></Button></span>
        <span><Button class="button action" onclick="window.location='admin.php?page=orders'">X</Button></span>

    </div>


    <div class="tablenav-pages one-page"><span class="displaying-num"><?php echo count($this->items); ?> mục</span>
	<span class="pagination-links"><span class="tablenav-pages-navspan" aria-hidden="true">«</span>
	<span class="tablenav-pages-navspan" aria-hidden="true">‹</span>
	<span class="paging-input"><label for="current-page-selector" class="screen-reader-text">Trang hiện tại</label><input class="current-page" id="current-page-selector" name="paged" value="1" size="1" aria-describedby="table-paging" type="text"><span class="tablenav-paging-text"> trên <span class="total-pages">1</span></span></span>
	<span class="tablenav-pages-navspan" aria-hidden="true">›</span>
	<span class="tablenav-pages-navspan" aria-hidden="true">»</span></span></div>
		<br class="clear">
</div>


<div>
	<form id="mainform" method="POST" action="<?php echo admin_url('admin-post.php?action=hbaction')?>">
		<table class="wp-list-table widefat fixed striped posts">
			<thead>
				<tr>
                    <th id="cb" class="column-cb check-column">
                        <input id="cb-select-all-1" type="checkbox" onclick="toggle(this)">
                    </th>
					<th><?php echo __('Order number')?></th>
					<th><?php echo __('Full name')?></th>
                    <th><?php echo __('Order status')?></th>
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
								<span class="view"><a target="_blank" href="admin.php?page=orders&layout=edit&id=<?php echo $item->id; ?>">Sửa</a></span>
								<span class="view"> | <a target="_blank" href="<?php echo HBHelper::get_order_link($item)?>">Xem</a></span>
                                <span class="trash"> | <a href="#" class="submitdelete" onclick="deleteItem(<?php echo $item->id ?>)">Xóa</a></span>
                            </div>
						</td>
                        
						<td><?php echo $item->fullname;?></td>
                        <td <?php echo $order_color; ?> >
                            <?php echo $item->order_status;?>
                            <?php if ($item->order_status == 'PENDING'): ?>
                            <div class="clearfix"></div>
                            <div class="row-actions">
                                <span class="view"><a target="_blank" href="admin.php?page=orders&layout=edit&id=<?php echo $item->id; ?>" title="Đánh dấu: 'đã xử lý'"><span style="font-size: 16px">✓</span></a></span>
                            </div>
                            <?php endif; ?>
                        </td>
						<td><a href="tel:<?php echo $item->mobile;?>"><?php echo $item->mobile;?></a></td>
						<td><?php echo $item->created;?></td>
					</tr>
				<?php }?>
			</tbody>
		</table>

        <?php wp_nonce_field( 'hb_action', 'hb_meta_nonce' );?>
        <input type="hidden" name="hbaction" value="orders" />
        <input type="hidden" id="task" name="task" value="deleteitem" />
        <input type="hidden" id="itemID" name="itemID" value="">

	</form>
</div>


<style>
    #cb-select-all-1{
        margin-top: 15px;
    }
</style>