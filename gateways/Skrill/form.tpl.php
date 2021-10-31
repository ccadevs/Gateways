<?php
 /*
 * Created on Sun Oct 31 2021 1:55:58 PM
 *
 * Author     : Mile S.
 * Contact    : info@ccwebspot.com
 * Website    : https://ccwebspot.com/
 * Copyright (c) 2021 CC.Webspot
 *
 */

  if (!defined("CCApp"))
      die('Direct access to this location is not allowed.');
?>
<?php $url = ($this->gateway->live) ? 'www.skrill.com/app/payment.pl' : 'www.skrill.com/app/test_payment.pl';?>
<form action="https://<?php echo $url;?>" method="post" id="mb_form" name="mb_form" class="center aligned">
<input type="image" src="<?php echo SITEURL;?>/gateways/skrill/logo_large.png" style="width:150px" name="submit" title="Pay With Skrill" alt="" onclick="document.mb_form.submit();">
  <input type="hidden" name="pay_to_email" value="<?php echo $this->gateway->extra;?>">
  <input type="hidden" name="return_url" value="<?php echo Url::url("/dashboard");?>">
  <input type="hidden" name="cancel_url" value="<?php echo Url::url("/dashboard");?>">
  <input type="hidden" name="status_url" value="<?php echo SITEURL.'/gateways/' . $this->gateway->dir;?>/ipn.php" />
  <input type="hidden" name="merchant_fields" value="session_id, item, custom" />
  <input type="hidden" name="item" value="<?php echo $this->row->title;?>" />
  <input type="hidden" name="session_id" value="<?php echo md5(time())?>" />
  <input type="hidden" name="custom" value="<?php echo $this->row->id . '_' . App::Auth()->uid;?>" />
  <?php if($this->row->recurring == 1):?>
  <input type="hidden" name="rec_amount" value="<?php echo $this->cart->totalprice;?>" />
  <input type="hidden" name="rec_period" value="<?php echo Membership::calculateDays($this->row->id);?>" />
  <input type="hidden" name="rec_cycle" value="day" />
  <?php else: ?>
  <input type="hidden" name="amount" value="<?php echo $this->cart->totalprice;?>" />
  <?php endif; ?>
  <input type="hidden" name="currency" value="<?php echo ($this->gateway->extra2) ? $this->gateway->extra2 : App::Core()->currency;?>" />
  <input type="hidden" name="detail1_description" value="<?php echo $this->row->title;?>" />
  <input type="hidden" name="detail1_text" value="<?php echo $this->row->description;?>" />
</form>