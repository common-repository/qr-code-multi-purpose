<?php
/*
Plugin Name: QR Code Multi Purpose
Description: QR Code Multi Purpose Widget to display QR code with your details on your sidebar and configure
Plugin URI: http://www.iteamweb.com/
Version: 1.0
Author: Suresh Baskaran
License: GPL
*/
 
 include("BarcodeQR.php");
 
class qrcodebusinesscard extends WP_Widget
{
  function qrcodebusinesscard()
  {
    $widget_ops = array('classname' => 'qrcodemultipurpose', 'description' => 'Displays Multiple forms of QR data' );
    $this->WP_Widget('qrcodemultipurpose', 'QR Code Multi Purpose', $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'w_title' => '','category' => '' ,'title' => '' ,'url' => '' ,'name' => '' ,'address' => '' ,'phone' => '' ,'email' => '' ) );
    $w_title = $instance['w_title'];
	$category = $instance['category'];
	$title = $instance['title'];
	$url = $instance['url'];
	$name = $instance['name'];
	$address = $instance['address'];
	$phone = $instance['phone'];
	$email = $instance['email'];

?>
  
  <p><label for="<?php echo $this->get_field_id('w_title'); ?>">Widget title: <input class="widefat" id="<?php echo $this->get_field_id('w_title'); ?>" name="<?php echo $this->get_field_name('w_title'); ?>" type="text" value="<?php echo attribute_escape($w_title); ?>" /></label></p>

<p>
	<label for="<?php echo $this->get_field_id('category'); ?>">
		<?php _e('Choose QR code method:'); ?>
	</label>
	<select id="<?php echo $this->get_field_id('category'); ?>" class="widefat" name="<?php echo $this->get_field_name('category'); ?>">
		<option value=1 <?php if($category==1) echo "selected"; ?>>Bookmark</option>
		<option value=2 <?php if($category==2) echo "selected"; ?>>Business card</option>
		<option value=3 <?php if($category==3) echo "selected"; ?>>Call us</option>
		<option value=4 <?php if($category==4) echo "selected"; ?>>Open URL in mobile</option>
	</select>
</p>

  <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>

  <p><label for="<?php echo $this->get_field_id('url'); ?>">URL: <input class="widefat" id="<?php echo $this->get_field_id('url'); ?>" name="<?php echo $this->get_field_name('url'); ?>" type="text" value="<?php echo attribute_escape($url); ?>" /></label></p>

  <p><label for="<?php echo $this->get_field_id('name'); ?>">Name: <input class="widefat" id="<?php echo $this->get_field_id('name'); ?>" name="<?php echo $this->get_field_name('name'); ?>" type="text" value="<?php echo attribute_escape($name); ?>" /></label></p>

  <p><label for="<?php echo $this->get_field_id('address'); ?>">Address: <input class="widefat" id="<?php echo $this->get_field_id('address'); ?>" name="<?php echo $this->get_field_name('address'); ?>" type="text" value="<?php echo attribute_escape($address); ?>" /></label></p>
  <p><label for="<?php echo $this->get_field_id('phone'); ?>">Phone: <input class="widefat" id="<?php echo $this->get_field_id('phone'); ?>" name="<?php echo $this->get_field_name('phone'); ?>" type="text" value="<?php echo attribute_escape($phone); ?>" /></label></p>
  <p><label for="<?php echo $this->get_field_id('email'); ?>">Email: <input class="widefat" id="<?php echo $this->get_field_id('email'); ?>" name="<?php echo $this->get_field_name('email'); ?>" type="text" value="<?php echo attribute_escape($email); ?>" /></label></p>





  <?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['w_title'] = $new_instance['w_title'];
	$instance['category'] = $new_instance['category'];
	$instance['title'] = $new_instance['title'];
	$instance['url'] = $new_instance['url'];
	$instance['name'] = $new_instance['name'];
	$instance['address'] = $new_instance['address'];
	$instance['phone'] = $new_instance['phone'];
	$instance['email'] = $new_instance['email'];

    return $instance;
  }
 
  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);
 
    echo $before_widget;
    $w_title = empty($instance['w_title']) ? ' ' : apply_filters('widget_title', $instance['w_title']);
	$category = $instance['category'];
	$title = $instance['title'];
	$url = $instance['url'];
	$name = $instance['name'];
	$address = $instance['address'];
	$phone = $instance['phone'];
	$email = $instance['email'];

//    $cat_id = $instance['cat_id'];
 
    if (!empty($w_title))
      echo $before_title . $w_title . $after_title;;
 
	// set BarcodeQR object 
$qr = new BarcodeQR(); 

// create URL QR code 
if($category==1)
	$qr->bookmark($title,$url);
elseif($category==2)
	$qr->contact($name, $address, $phone, $email);
elseif($category==3)
	$qr->phone($phone);
elseif($category==4)
	$qr->url($url);
// display new QR code image 
$qr->draw(150, "tmp/qr-code.png");

 echo "<img src=./tmp/qr-code.png>";
    echo $after_widget;
  }
 
}
add_action( 'widgets_init', create_function('', 'return register_widget("qrcodebusinesscard");') );?>