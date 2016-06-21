<ul class="nav nav-pills filter" role="tablist">
  <li role="presentation" <?php echo ($forFilter=='default') ? 'class="active"' : ''; ?>><a href="<?php echo $filterURL; ?>&notified=0"><i class="fa fa-circle-o"></i>&nbsp;<strong>Default (not notified)</strong></a></li>
  <li role="presentation" <?php echo ($forFilter=='notified') ? 'class="active"' : ''; ?>><a href="<?php echo $filterURL; ?>&notified=1"><i class="fa fa-circle"></i>&nbsp;<strong>Already notified (at least once)</strong></a></li>
  <li role="presentation" <?php echo ($forFilter=='ordered') ? 'class="active"' : ''; ?>><a href="<?php echo $filterURL; ?>&ordered=1"><i class="fa fa-check"></i>&nbsp;<strong>Ordered</strong></a></li>
</ul>
<br />
<table id="abandonedCartsWrapper<?php echo $store_id; ?>" class="table table-bordered table-hover AbCartsTable" width="100%">
      <thead>
        <tr class="table-header">
          <td class="left" width="5%"><strong class="btn-send" data-toggle="tooltip" data-placement="left" title="Every record has unique ID number.">ID</strong></td>
          <td class="left" width="20%"><strong class="btn-send" data-toggle="tooltip" title="This column shows you information about the customers with abandoned carts.">Customer Info</strong></td>
          <td class="left" width="25%"><strong class="btn-send" data-toggle="tooltip" title="This column displays the contents of the abandoned carts from your customers.">Shopping Cart</strong></td>
          <td class="left" width="15%"><strong class="btn-send" data-toggle="tooltip" title="When the customers visited your store and how long they've browsed it.">Date & Time</strong></td>
          <td class="left" width="15%" style="white-space: normal;" ><strong class="btn-send" data-toggle="tooltip" title="From here you can see on which pages the customers are leaving your store.">Last Visited Page</strong></td>
          <td class="left" width="10%"><strong class="btn-send" data-toggle="tooltip" title="Here we collect the IP addresses of the customers.">IP</strong></td>
          <td class="left" width="10%"><strong class="btn-send" data-toggle="tooltip" title="You can send messages to the customers or delete the records.">Status & Actons</strong></td>
        </tr>
      </thead>
	<?php if (!empty($sources)) { ?>
		<?php $i=0; foreach ($sources as $ab) { ?>
              <tbody>
				<tr>
				  <td class="left">
                  	<?php echo $ab['id']; ?>
                  </td>
                  <td>
                 	 <?php $ab['customer_info'] = json_decode($ab['customer_info'], true); ?>
                     <table class="table table-bordered">
                     	<?php if (empty($ab['customer_info'])) { ?>
                        <tr><td class="name"><i class="fa fa-user"></i> (not provided)</td></tr>
						<tr><td class="email"><i class="fa fa-envelope-o"></i> (not provided)</td></tr>
						<tr><td class="telephone"><i class="fa fa-phone"></i> (not provided)</td></tr>
                        <tr><td class="language"><i class="fa fa-flag"></i> (not provided)</td></tr>
                        <tr><td class="language"><i class="fa fa-book"></i> Guest</td></tr>
                       	<?php } else { ?>
						<tr><td class="name"><i class="fa fa-user"></i>
                            <?php if (isset($ab['customer_info']['firstname']) && isset($ab['customer_info']['lastname'])) {
                                echo $ab['customer_info']['firstname'].' '.$ab['customer_info']['lastname'];
                            } else if (!isset($ab['customer_info']['firstname']) && !isset($ab['customer_info']['lastname'])) {
                                echo '(not provided)';
                            } else if (isset($ab['customer_info']['firstname']) && !isset($ab['customer_info']['lastname'])) {
                                echo $ab['customer_info']['firstname'];
                            } else if (!isset($ab['customer_info']['firstname']) && isset($ab['customer_info']['lastname'])) {
                                echo $ab['customer_info']['lastname'];
                            } ?>
                        </td></tr>
						<tr><td class="email"><i class="fa fa-envelope-o"></i> <?php echo (isset($ab['customer_info']['email']) ? $ab['customer_info']['email'] : '(not provided)'); ?></td></tr>
						<tr><td class="telephone"><i class="fa fa-phone"></i> <?php echo (isset($ab['customer_info']['telephone']) ? $ab['customer_info']['telephone'] : '(not provided)'); ?></td></tr>
                        <tr><td class="language"><i class="fa fa-flag"></i> Language: <?php echo isset($ab['customer_info']['language']) ? $ab['customer_info']['language'] : '(not provided)'; ?><?php echo (isset($ab['customer_info']['lang_image'])) ? '<div class="btn btn-xs btn-default" style="float:right;"><img src="'.$ab['customer_info']['lang_image'].'" style="margin-top:-2px;" /></div>' : ''; ?></td></tr>
                        <tr><td class="language"><i class="fa fa-book"></i> <?php if (isset($ab['customer_info']['email'])) { $customerCheck = $data['this->model_sale_customer']->getCustomerByEmail($ab['customer_info']['email']); } else { $customerCheck=''; } if (!empty($customerCheck)) echo "Existing customer <a href='index.php?route=sale/customer/edit&token=".$token."&customer_id=".$customerCheck['customer_id']."' target='_blank' class='btn btn-xs btn-default' data-toggle='tooltip' title='Click to more about the customer' style='float:right;'><i class='fa fa-eye'></i> More</a>"; else echo "Guest customer"; ?></td></tr>
                        <?php } ?>
                     </table>
                  </td>
                  <td>
                	 <?php $ab['cart'] = json_decode($ab['cart'], true); ?>
                      <table class="table table-bordered">
                         <?php if (is_array($ab['cart'])) { ?>
                           <?php foreach ($ab['cart'] as $product) { ?>
                            <?php if ($product['image']) {
                                    $image_thumb = $data['this->model_tool_image']->resize($product['image'], 30, 30);
                                    $image = $data['this->model_tool_image']->resize($product['image'], 125, 125);
                                } else {
                                    $image_thumb = false;
                                    $image = false;
                                }
                            ?>
                            <tr>
                        <script>
                        $( "#picture<?php echo $i; ?>" ).mouseleave(function() {
                           $("#picture-hover<?php echo $i; ?>").fadeOut( 200 );
                        });
                        $( "#picture<?php echo $i; ?>" ).mouseenter(function() {
                           $("#picture-hover<?php echo $i; ?>").fadeIn( 200 );
                        });
                        </script>
                              <td width="70%" class="name"><div id="picture<?php echo $i; ?>" style="float:left;padding-right:3px;"><a href="<?php echo '../index.php?route=product/product&product_id='. $product['product_id']; ?>" target="_blank"><div id="picture-hover<?php echo $i; ?>" style="position:absolute;z-index:99999;padding-top:18px;display:none;"><img src="<?php echo $image; ?>" class="img-polaroid img-hover" /></div><img src="<?php echo $image_thumb; ?>" /></a></div> <a href="<?php echo HTTP_CATALOG.'index.php?route=product/product&product_id='. $product['product_id']; ?>" target="_blank"><?php echo $product['name']; ?></a>
                                <div>
                                  <?php foreach ($product['option'] as $option) { ?>
                                  - <small><?php echo $option['name']; ?> <?php echo $option['value']; ?></small><br />
                                  <?php } ?>
                                </div></td>
                              <td width="15%" class="quantity">x&nbsp;<?php echo $product['quantity']; ?></td>
                              <td width="15%" class="price"><?php $price = $data['this->currency']->format($product['price']); echo $price; ?></td>
                            </tr>
                            <?php $i++; } ?>
                          <?php } ?>
                      </table>
                  </td>
                  <td>
                  	First visit:<br /><?php echo $ab['date_created'] ?><br /><br />
                    Last visit:<br /><?php echo $ab['date_modified'] ?><br /><br />
                	Total time spent:<br /><?php $time = strtotime($ab['date_modified']) - strtotime($ab['date_created']); echo gmdate("H:i:s", $time) ?>
                  </td>
                  <td> 
					  <?php $link = "...".substr($ab['last_page'], -30); ?>
                	  <a href="..<?php echo $ab['last_page']; ?>" target="_blank"><?php echo $link; ?></a> 
                  </td>
                  <td> 
                	  <?php echo $ab['ip']; ?> 
                      <br /><br />
                      <a class="btn btn-xs btn-default btn-send" href="http://www.checkip.com/ip/<?php echo $ab['ip']; ?>" data-toggle="tooltip" title="Click here to learn more about customer's location" target="_blank"><i class="fa fa-search"></i> Check IP</a>
                  </td>
                  <td>
					  <?php if (!empty($ab['customer_info']['email'])) { ?>
					   
                        <div class="btn-group">
                          <button type="button" <?php if ($ab['ordered']==1) { echo "disabled='disabled'"; } ?> class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-envelope-square"></i>&nbsp;Send reminder <span class="caret"></span>
                          </button>
                          <ul class="dropdown-menu" role="menu">
                          	<?php foreach ($usable_templates as $id => $template) { ?>
                            	<?php if ($id == 0) { ?>
                                	<li class="disabled"><a><?php echo $template; ?></a></li>
                                <?php } else { ?>
                            		<li><a data-event-id="<?php echo $ab['id']; ?>" style="cursor:pointer;" onClick="sendReminder('<?php echo $ab['id']; ?>', '<?php echo $id; ?>');"><?php echo $template; ?></a></li>
                                <?php } ?>
                            <?php } ?> 
                          </ul>
                        </div>
					  <?php } else { ?>
					  <a class="btn btn-sm btn-default disabled btn-send" data-toggle="tooltip" title="You cannot send message to a customer with no email or already ordered." disabled="disabled"><i class="fa fa-envelope-square"></i> Send reminder</a>
					  <?php } ?>
					  <br /> <br />
                      <a onclick="removeItem('<?php echo $ab['id']; ?>')" class="btn btn-sm btn-danger"><i class="fa fa-times"></i> Remove</a>
                      <br /> <br />
                     <strong> Status:</strong> <br />
                      Notified -> <?php if ($ab['notified'] == 0) { echo "No"; } else { echo "Yes (". $ab['notified'] .")"; } ?> <br />
                      Ordered -><?php if ($ab['ordered'] == 0) { echo "No"; } else { echo "Yes"; } ?>
                  </td>
                </tr>
              </tbody>
        <?php } ?>
	<?php } else { ?>
    	<tr><td colspan="10"><div class="center">There are no records yet.</div></td></tr>
    <?php } ?>
    <tfoot><tr><td colspan="10">
    	<div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
       </td></tr></tfoot>
</table>
<div style="float:right;padding: 5px;">
	<a onclick="removeAllEmpty()" class="btn btn-sm btn-warning"><i class="fa fa-file-o"></i>&nbsp;&nbsp;Remove all empty records</a>&nbsp;<a onclick="removeAll()" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i>&nbsp;&nbsp;Remove all</a> 
</div>
<script>
	$(function () {
		$('.btn-send').tooltip({
			animation: true,
			placement: "bottom"
		});
	});
	$(document).ready(function(){
		$('#abandonedCartsWrapper<?php echo $store_id; ?> .pagination a').on('click', (function(e){
			e.preventDefault();
			$.ajax({
				url: this.href,
				type: 'get',
				dataType: 'html',
				success: function(data) {				
					$("#abandonedCartsWrapper<?php echo $store_id; ?>").html(data);
				}
			});
		}));	
		
		$('.filter a').on('click', (function(e){
			e.preventDefault();
			$.ajax({
				url: this.href,
				type: 'get',
				dataType: 'html',
				success: function(data) {				
					$("#abandonedCartsWrapper<?php echo $store_id; ?>").html(data);
				}
			});
		}));	 
	});
   function removeAll() {      
		var r=confirm("Are you sure that you want to remove all records from this store?");
		if (r==true) {
			$.ajax({
				url: 'index.php?route=module/abandonedcarts/removeallrecords&store=<?php echo $store_id; ?>&token=<?php echo $token; ?>',
				type: 'post',
				data: {'remove': r, 'store' : <?php echo $store_id; ?> },
				success: function(response) {
					location.reload();
			}
		});
	 }
	}
   function removeAllEmpty() {      
		var r=confirm("Are you sure that you want to remove all empty records (with no emails) from this store?");
		if (r==true) {
			$.ajax({
				url: 'index.php?route=module/abandonedcarts/removeallemptyrecords&store=<?php echo $store_id; ?>&token=<?php echo $token; ?>',
				type: 'post',
				data: {'remove': r, 'store' : <?php echo $store_id; ?> },
				success: function(response) {
					location.reload();
			}
		});
	 }
	}
</script>