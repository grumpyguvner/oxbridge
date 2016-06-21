<div class="row">
    <div class="col-xs-2">
        <ul class="list-group column_tabs columns-switcher">
            <?php foreach($columns as $index_3 => $column) : ?>
            	<li class="list-group-item <?php echo $index_3 == 0 ? 'active' : ''; ?>" <?php if (!empty($extraColumnAttributes[$column['var']])) echo $extraColumnAttributes[$column['var']]; ?>>
                	<a data-target="#column_<?php echo $index_1; ?>_<?php echo $index_3; ?>"><?php echo $$column['var']; ?><i class="fa fa-chevron-right"></i></a>
            	</li>
            <?php endforeach; ?>
            <?php for ($i = 1; $i <= $customColumnCount; $i++) : ?>
            	<li class="list-group-item">
                	<a data-target="#column_<?php echo $index_1; ?>_<?php echo ($index_3 + $i); ?>"><?php echo $customcolumn . ' ' . $i; ?><i class="fa fa-chevron-right"></i></a>
            	</li>
            <?php endfor; ?>
        </ul>
    </div>
    <div class="col-xs-10">
        <div class="tab-content column_content">
            <?php foreach($columns as $index_3 => $column) : ?>
                <div class="tab-pane<?php echo $index_3 == 0 ? ' active' : ''; ?>" id="column_<?php echo $index_1; ?>_<?php echo $index_3; ?>">
                	<div class="panel panel-default">
                    	<div class="panel-heading"><?php echo $$column['var']; ?></div>
                        <div class="panel-body iModuleFields">
                        	<?php include($column['file']); ?>	
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            
			<?php for ($i = 1; $i <= $customColumnCount; $i++) : ?>
                <div class="tab-pane" id="column_<?php echo $index_1; ?>_<?php echo ($index_3 + $i); ?>">
                	<div class="panel panel-default">
                    	<div class="panel-heading"><?php echo $customcolumn . ' ' . $i; ?></div>
                    	<div class="panel-body iModuleFields">
                        	<?php include($dirName . 'columncustom_column.php'); ?>
                        </div>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
    </div>
</div>