<?php
/*
 * Created on Sun Oct 31 2021 5:28:47 PM
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
<?php $url = ($this->gateway->live) ? 'www.payfast.co.za' : 'sandbox.payfast.co.za';?>
  <form action="https://<?php echo $url;?>/eng/process" class="center aligned" method="post" id="pf_form" name="pf_form">
    <input type="image" src="<?php echo SITEURL.'/gateways/payfast/logo_large.png';?>" style="width:150px" class="ccapp basic primary button" name="submit" title="Pay With PayFast" alt="" onclick="document.pf_form.submit();"/>
	<?php
      $html = '';
      $string = '';
      $data  = array(
          'merchant_id' => $this->gateway->extra,
          'merchant_key' => $this->gateway->extra2,
          'return_url' => Url::url("/dashboard"),
          'cancel_url' => Url::url("/dashboard"),
          'notify_url' => SITEURL . '/gateways/' . $this->gateway->dir . '/ipn.php',
		  'name_first' => Auth::$userdata->fname,
		  'name_last' => Auth::$userdata->lname,
          'email_address' => Auth::$userdata->email,
          'm_payment_id' => $this->row->id,
          'amount' => $this->cart->totalprice,
          'item_name' => $this->row->title,
          //'item_description' => $this->row->description,
          'custom_int1' => App::Auth()->uid,
          );
      if($this->row->recurring) {
		  $data ['subscription_type'] = 1;
		  $data ['frequency'] = $this->row->period == "D" ? 3 : 6;
		  $data ['cycles'] = 0;
	  }

	  foreach( $data as $key => $val){
		  if(!empty($val)) {
			  $string .= $key .'='. urlencode(trim($val)) .'&';
		   }
	  }
	  $getString = substr( $string, 0, -1 );

	  $getString .= '&passphrase='. urlencode(trim($this->gateway->extra3));  
	  $data['signature'] = md5($getString);
	  
	  foreach($data as $name=> $value)
	  { 
		  $html .= '<input name="'.$name.'" type="hidden" value="'.$value.'" />'; 
	  } 
      print $html;
    ?>
  </form>