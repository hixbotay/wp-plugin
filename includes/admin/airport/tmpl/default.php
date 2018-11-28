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
defined ( 'ABSPATH' ) or die ( 'Restricted access' );
?>
<form action="admin.php" action="GET" id="adminForm" name="adminForm">
<div class="wrap">
	<h1><?php echo __("airport")?><a
			href="<?php echo admin_url('admin.php?page=airport&layout=edit')?>"
			class="page-title-action"><?php echo __("Add")?></a>
	</h1>

	<div class="tablenav top">
		
		<div class="alignleft actions">
			<?php echo FvnHtml::text('filter_title', '',$this->input->get('filter_title'))?>
			<input name="filter_action" id="post-query-submit"
				class="button" value="Lọc" type="submit">
		</div>

		<br class="clear">
	</div>


	<div>
		
			<table class="wp-list-table widefat fixed striped posts">
				<thead>
					<tr>
						<th><?php echo __('airport name')?></th>
						<th>Thao tác</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($this->items as $item){?>
						<tr>
						<td><?php echo $item->name;?></td>
						<td><a
							href="admin.php?page=airport&layout=edit&id=<?php echo $item->id?>"><?php echo __('Edit')?></a>
							<a href="javascript:void(0)" class="fvn-function" data-ask="1" data-href="<?php echo admin_url('admin.php?hbaction=airport&task=delete&id='.$item->id)?>"><?php echo __('Delete')?></a></td>
					</tr>
					<?php }?>
				</tbody>
			</table>
			<input type="hidden" name="page" value="<?php echo $this->input->get('page')?>"/>
			<?php echo $this->pagination->getListFooter()?>
			
		
	</div>
</div>
</form>