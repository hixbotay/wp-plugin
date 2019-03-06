
<section id="site-main">
<div class="container">
    <h3><?php echo __('Chi tiết khách sạn')?></h3>
<?php if(!$order){ ?>
<?php echo __('Đơn đặt hàng không tồn tại'); ?>

<form style="margin-top: 20px">

    <div class="form-group">
        <input type="text"  name="order_number" required class="form-control" placeholder="<?php echo __('Mã'); ?>" />
    </div>
    <div class="form-group">
        <input type="email"  name="email" class="form-control" required placeholder="<?php echo __('Email'); ?>"  />
    </div>
     <div class="form-group">
        <input type="submit"  value="Kiểm tra" class="btn btn-primary submit-oderdetail pull-left"/>
     </div>

</form>

<?php }else{?>
<?php $tour = ThemexTour::get_hotel($order->tour_id, true);?>

        <div class="row table">
            <div class="col-md-4"><p><?php echo __('Mã')?></p></div>
            <div class="col-md-8"><?php echo $order->order_number?></div>
        </div>
        <div class="row table">
            <div class="col-md-4"><p><?php echo __('Tên khách sạn')?></p></div>
            <div class="col-md-8">
                <?php
                if ($tour['title']){
                    echo $tour['title'];
                }else{
                    echo get_the_title($order->tour_id);
                }
                ?>
            </div>
        </div>
        <div class="row table">
            <div class="col-md-4"><p><?php echo __('Checkin')?></p></div>
            <div class="col-md-8"><?php echo (new DateTime($order->checkin))->format('d/m/Y')?></div>
        </div>

<?php }?>
</div>
</section>