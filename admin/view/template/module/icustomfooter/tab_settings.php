<div class="columns_left_menu">
    <ul class="nav nav-stacked nav-tabs column_tabs">
        <?php foreach($settings_columns as $index_3 => $column) : ?>
        <li<?php echo $index_3 == 0 ? ' class="active"' : ''; ?> <?php if (!empty($extraColumnAttributes[$column['var']])) echo $extraColumnAttributes[$column['var']]; ?>><a data-target="#column_settings_<?php echo $index_3; ?>"><?php echo $$column['var']; ?><i class="icon-chevron-right<?php echo $index_3 == 0 ? ' icon-white' : ''; ?>"></i></a></li>
        <?php endforeach; ?>
    </ul>
</div>
<div class="columns_content">
    <div class="tab-content column_content">
        <?php foreach($settings_columns as $index_3 => $column) : ?>
        <div class="tab-pane<?php echo $index_3 == 0 ? ' active' : ''; ?>" id="column_settings_<?php echo $index_3; ?>">
            <h3><?php echo $$column['var']; ?></h3>
            <div class="iModuleFields">
            <?php include($column['file']); ?>
            <div class="clearfix"></div>
            </div>
        </div>
        <?php $globalSubtabsIndex++; endforeach; ?>
    </div>
</div>