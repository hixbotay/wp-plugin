<?php
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id$
 **/
// die('ddfdf');
defined('ABSPATH') or die('Restricted access');
?>
<h1>Đơn đặt hàng</h1>

<div class="tablenav top">
	<div class="alignleft actions bulkactions">
				<label for="bulk-action-selector-top" class="screen-reader-text">Lựa chọn thao tác hàng loạt</label><select name="action" id="bulk-action-selector-top">
	<option value="-1">Tác vụ</option>
		<option value="edit" class="hide-if-no-js">Chỉnh sửa</option>
		<option value="trash">Bỏ vào thùng rác</option>
	</select>
	<input id="doaction" class="button action" value="Áp dụng" type="submit">
			</div>
					<div class="alignleft actions">
			<label for="filter-by-date" class="screen-reader-text">Lọc theo ngày</label>
			<select name="m" id="filter-by-date">
				<option selected="selected" value="0">Tất cả các ngày</option>
	<option value="201609">Tháng Chín 2016</option>
			</select>
	
	<input name="filter_action" id="post-query-submit" class="button" value="Lọc" type="submit">		</div>
	<div class="tablenav-pages one-page"><span class="displaying-num">5 mục</span>
	<span class="pagination-links"><span class="tablenav-pages-navspan" aria-hidden="true">«</span>
	<span class="tablenav-pages-navspan" aria-hidden="true">‹</span>
	<span class="paging-input"><label for="current-page-selector" class="screen-reader-text">Trang hiện tại</label><input class="current-page" id="current-page-selector" name="paged" value="1" size="1" aria-describedby="table-paging" type="text"><span class="tablenav-paging-text"> trên <span class="total-pages">1</span></span></span>
	<span class="tablenav-pages-navspan" aria-hidden="true">›</span>
	<span class="tablenav-pages-navspan" aria-hidden="true">»</span></span></div>
		<br class="clear">
</div>
	
	
<div>
	<form>
		<table class="wp-list-table widefat fixed striped posts">
			<thead>
				<tr>
					<th>Số đơn đặt hàng</th>
					<th>Tour</th>
					<th>Họ tên</th>
					<th>Pay status</th>
					<th>Order status</th>					
					<th>Số điện thoại</th>
					<th>Email</th>
					<th>Địa chỉ</th>
					<th>Ngày đăng kí</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($this->items as $item){?>
					<tr>
						<td>
							<a target="_blank" href="<?php echo HBHelper::get_order_link($item)?>"><?php echo $item->order_number;?></a>
							<div class="clearfix"></div>
							<div class="row-actions">
								<span class="edit"><a href="#">Chỉnh sửa</a> | </span>
								<span class="inline hide-if-no-js"><a href="#" class="editinline">Sửa nhanh</a> | </span>
								<span class="trash"><a href="#" class="submitdelete">Xóa tạm</a> | </span>
								<span class="view"><a href="#" >Xem</a></span>
							</div>
						</td>
						<td><?php echo $item->tour_name;?></td>
						<td><?php echo $item->fullname;?></td>
						<td><?php echo $item->pay_status;?></td>
						<td><?php echo $item->order_status;?></td>
						<td><?php echo $item->mobile;?></td>
						<td><?php echo $item->email;?></td>
						<td><?php echo $item->address;?></td>
						<td><?php echo $item->created;?></td>
					</tr>
				<?php }?>
			</tbody>
		</table>
	</form>
</div>