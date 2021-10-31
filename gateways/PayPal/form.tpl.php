<?php
/*
 * Created on Sun Oct 31 2021 1:47:15 PM
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
<?php $url = ($this->gateway->live) ? 'www.paypal.com' : 'www.sandbox.paypal.com';?>
<form action="https://<?php echo $url;?>/cgi-bin/webscr" method="post" id="pp_form" name="pp_form" class="center aligned">
<input type="image" src="<?php echo SITEURL;?>/gateways/paypal/logo_large.png" style="width:150px" name="submit" title="Pay With Paypal" alt="" onclick="document.pp_form.submit();">
  <?php if($this->row->recurring == 1):?>
  <input type="hidden" name="cmd" value="_xclick-subscriptions">
  <input type="hidden" name="a3" value="<?php echo $this->cart->totalprice;?>">
  <input type="hidden" name="p3" value="<?php echo $this->row->days;?>">
  <input type="hidden" name="t3" value="<?php echo $this->row->period;?>">
  <input type="hidden" name="src" value="1">
  <input type="hidden" name="sr1" value="1">
  <?php else:?>
  <input type="hidden" name="cmd" value="_xclick">
  <input type="hidden" name="amount" value="<?php echo $this->cart->totalprice;?>">
  <?php endif;?>
  <input type="hidden" name="business" value="<?php echo $this->gateway->extra;?>">
  <input type="hidden" name="item_name" value="<?php echo $this->row->title;?>">
  <input type="hidden" name="item_number" value="<?php echo $this->row->id . '_' . App::Auth()->uid;?>">
  <input type="hidden" name="return" value="<?php echo Url::url("/dashboard");?>">
  <input type="hidden" name="rm" value="2">
  <input type="hidden" name="notify_url" value="<?php echo SITEURL . '/gateways/'. $this->gateway->dir;?>/ipn.php">
  <input type="hidden" name="cancel_return" value="<?php echo Url::url("/dashboard");?>">
  <input type="hidden" name="no_note" value="1">
  <input type="hidden" name="currency_code" value="<?php echo ($this->gateway->extra2) ? $this->gateway->extra2 : App::Core()->currency;?>">
</form>