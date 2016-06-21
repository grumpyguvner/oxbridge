<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h1><?php echo $heading_title; ?></h1>
      <?php echo $text_message; ?>
      <div class="buttons">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
      </div>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>

            <script>
            // Send transaction data with a pageview if available
            // when the page loads. Otherwise, use an event when the transaction
            // data becomes available.
<?php if (isset($orderDetails)) { ?>
            dataLayer.push({
              'ecommerce': {
                'purchase': {
                  'actionField': {
                    'id': '<?php echo $orderDetails['order_id']; ?>',                         // Transaction ID. Required for purchases and refunds.
                    'affiliation': '<?php echo addslashes($orderDetails['store_name']); ?>',
                    'revenue': '<?php echo round($orderDetails['total'], 2); ?>',                     // Total transaction value (incl. tax and shipping)
                    'tax':'<?php echo round($orderDetails['order_tax'], 2); ?>',
                    'shipping': '<?php echo $orderDetails['shipping_total']; ?>'
                  },
                  'products': [
<?php if(isset($orderProduct)) { ?>
<?php for($i=0, $ii=count($orderProduct); $i<$ii; $i++) {  $product = $orderProduct[$i]; ?>
                   {
                    'name': <?php echo json_encode(html_entity_decode($product['name'], ENT_QUOTES, 'UTF-8')); ?>,
                    'id': <?php if(isset($product['sku'])) { ?><?php echo json_encode(html_entity_decode($product['sku'],ENT_QUOTES, 'UTF-8')); ?><?php } else { ?><?php echo json_encode(html_entity_decode($product['model'],ENT_QUOTES, 'UTF-8')); ?><?php } ?>,
                    'price': '<?php echo round($product['price'], 2); ?>',
                    'category': <?php echo json_encode(html_entity_decode($product['category_name'], ENT_QUOTES, 'UTF-8')); ?>,
                    'quantity': <?php echo $product['quantity']; ?>
                    }
<?php if (isset($orderProduct[$i+1]) || (isset($orderProductOptions) && count($orderProductOptions))) {?>
                    ,
<?php } ?>
<?php } ?>
<?php } ?>
<?php if(isset($orderProductOptions)) { ?>
<?php for($i=0, $ii=count($orderProductOptions); $i<$ii; $i++) {  $product = $orderProductOptions[$i]; ?>
                    {
                    'name': <?php echo json_encode(html_entity_decode($product['name'], ENT_QUOTES, 'UTF-8')); ?>,
                    'id': <?php if(isset($product['sku'])) { ?><?php echo json_encode(html_entity_decode($product['sku'],ENT_QUOTES, 'UTF-8')); ?><?php } else { ?><?php echo json_encode(html_entity_decode($product['model'],ENT_QUOTES, 'UTF-8')); ?><?php } ?>,
                    'price': '<?php echo round($product['price'], 2); ?>',
                    'category': <?php echo json_encode(html_entity_decode($product['category_name'], ENT_QUOTES, 'UTF-8')); ?>,
                    'variant': <?php echo json_encode(html_entity_decode($product['options_data'],ENT_QUOTES, 'UTF-8')); ?>,
                    'quantity': <?php echo $product['quantity']; ?>
                    }
<?php if (isset($orderProductOptions[$i+1])) {?>
                    ,
<?php } ?>
<?php } ?>
<?php } ?>
                   ]
                }
              }
            });
<?php } ?>
            </script>
            
<?php echo $footer; ?>