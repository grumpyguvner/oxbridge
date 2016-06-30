<?php echo $header; ?>
<link rel="stylesheet" href="<?php echo HTTPS_SERVER ?>/view/stylesheet/export_manager/animations.css">
<link rel="stylesheet" href="<?php echo HTTPS_SERVER ?>/view/stylesheet/export_manager/ngDialog.min.css">
<link rel="stylesheet" href="<?php echo HTTPS_SERVER ?>/view/stylesheet/export_manager/ngDialog-theme-default.css">
<link rel="stylesheet" href="<?php echo HTTPS_SERVER ?>/view/stylesheet/export_manager/ngDialog-export.css">
<link rel="stylesheet" href="<?php echo HTTPS_SERVER ?>/view/stylesheet/export_manager/nested.css">
<link rel="stylesheet" href="<?php echo HTTPS_SERVER ?>/view/stylesheet/export_manager/rzslider.css">
<link rel="stylesheet" href="<?php echo HTTPS_SERVER ?>/view/stylesheet/export_manager/ng-flat-datepicker.css">
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
<!--js-->
<script src="<?php echo HTTPS_SERVER ?>/view/javascript/export_manager/moment.min.js"></script>
<script src="<?php echo HTTPS_SERVER ?>/view/javascript/export_manager/angular.min.js"></script>
<script src="<?php echo HTTPS_SERVER ?>/view/javascript/export_manager/ngDialog.min.js"></script>
<script src="<?php echo HTTPS_SERVER ?>/view/javascript/export_manager/angular-animate.min.js"></script>
<script src="<?php echo HTTPS_SERVER ?>/view/javascript/export_manager/lodash.min.js"></script>
<script src="<?php echo HTTPS_SERVER ?>/view/javascript/export_manager/angular-drag-and-drop-lists.js"></script>
<script src="<?php echo HTTPS_SERVER ?>/view/javascript/export_manager/ui-bootstrap.min.js"></script>
<script src="<?php echo HTTPS_SERVER ?>/view/javascript/export_manager/angularjs-dropdown-multiselect.js"></script>
<script src="<?php echo HTTPS_SERVER ?>/view/javascript/export_manager/rzslider.js"></script>
<script src="<?php echo HTTPS_SERVER ?>/view/javascript/export_manager/ng-flat-datepicker.js"></script>
<?php echo $column_left; ?>
<div id="content" ng-app="ExportManagerP" ng-controller="ExportManagerPController" ng-cloak>
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <a href="" ng-click="" class="btn btn-default"><i class="fa fa-question"></i></a>
                <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="" class="btn btn-default"><i class="fa fa-reply"></i></a>
                <div class="alert alert-{{alert_color}}" ng-show="alertDialog" style="float: left; margin-right: 10px; height: 36px; padding-left: 55px; padding-right: 40px" role="alert">
                    <h4>{{alert_text}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-{{alert_icon}}"></i></h4>
                </div>
            </div>
            <h1><?php echo $heading_title_main; ?></h1>
            <ul class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="container-fluid">
        <?php if ($error_warning) { ?>
        <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <div class="panel panel-default" style="box-shadow:none;border-left:none;border-right:none">
            <div class="panel-heading">
                <h3 class="panel-title pull-left" style="padding-top: 5px"><i class="{{pageIcon}}"></i> {{pageName}}</h3>
                <div class="btn-group btn-group-sm pull-right">
                    <select style="float: left; margin: 0 15px 0 30px; border: 1px solid #111; background: ivory;width: 200px;padding: 5px;font-size: 12px;border: 1px solid #ccc;height: 28px;-webkit-appearance: none;-moz-appearance: none;appearance: none;"
                            ng-model="selectedModel" ng-options="item.name for item in loadedModels" ng-change="selectModel()">
                        <option value=""><?php echo $text_load_models; ?></option>
                    </select>
                    <button ng-click="state = 'dash';checkState()" class="btn btn-default" style="margin-left: 15px"><i class="fa fa-dashboard"></i>&nbsp;&nbsp;<?php echo $text_dashboard; ?></button>
                    <button ng-click="state = 'settings';checkState()" class="btn btn-default" style="margin-left: 8px"><i class="fa fa-gear"></i>&nbsp;&nbsp;<?php echo $text_settings; ?></button>
                    <button ng-click="exportProductsDialog()" class="btn btn-warning" style="margin-left: 8px"><i class="fa fa-external-link-square"></i>&nbsp;&nbsp;<?php echo $text_export_products; ?></button>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body" style="padding-left: 0px; padding-right: 0px">
                <div ng-show="state == 'dash'">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="panel panel-default" ng-repeat="(listName, list) in product.lists" style="padding-left: 0px; padding-right: 0px;">
                                <div class="panel-heading">
                                    <h3 class="panel-title">{{listName}}</h3>
                                </div>
                                <div class="panel-body" style="display: block; overflow: auto; height: 600px; border-collapse: collapse; padding: 0px">
                                    <ul class="list-group" dnd-list="list">
                                        <li style="cursor: all-scroll" ng-repeat="item in list"
                                            dnd-draggable="item"
                                            dnd-effect-allowed="move"
                                            dnd-moved="list.splice($index, 1)"
                                            dnd-selected="product.selected = item"
                                            class="list-group-item"
                                            ng-class="{'selected': product.selected === item}">
                                            <h5 style="margin-bottom: 2px; color: #959595"><strong>{{item.name}}</strong></h5>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9 nopadding" style=" padding: 0 15px 0 0 !important; margin: 0 !important;">
                            <div class="panel panel-default " ng-repeat="(zone, list) in model.dropzone" style="padding-left: 0px; padding-right: 0px;">
                                <div class="panel-heading" style="padding-top: 0px">
                                    <h3 class="panel-title" style="margin-top: 12px">{{zone}}</h3>
                                    <div class="pull-right">
                                        <ul class="nav nav-pills" dnd-list="[]" style="margin: 7px 45px 0 0; float: left; width: 300px">
                                            <li class="col-md-12">
                                                <div class="col-md-12" style="text-align: center; border-left: 1px solid #c5c5c5; border-right: 1px solid #c5c5c5; background-color: #ffffff">
                                                    <h4 style="color: #aaa; padding-top: 7px"><i class="fa fa-trash-o"></i><?php echo $text_drop_n_trash; ?></h4>
                                                </div>
                                            </li>
                                        </ul>
                                        <ul class="nav nav-pills" style="margin-top: 4px; float: left; height: 27px">
                                            <li style="cursor: all-scroll" ng-repeat="item in model.templates"
                                                dnd-draggable="item"
                                                dnd-effect-allowed="copy"
                                                dnd-copied="item.name"
                                                ng-if="item.type == 'subnode'">
                                                <button type="button" class="btn btn-default" disabled="disabled" style="padding: 5px 13px;font-size:11px;margin-top:4px"><i class="fa fa-arrows-alt"></i> <?php echo $text_enter; ?> {{item.type}}</button>
                                            </li>
                                        </ul>
                                        <div class="btn-group btn-group-sm">
                                            <button ng-click="saveModelDialog()" class="btn btn-info" style="margin: 8px 0 0 15px"><i class="fa fa-external-link-square"></i>&nbsp;&nbsp;<?php echo $text_save_model; ?></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body" style="display: block; overflow: auto; height: 600px; border-collapse: collapse; padding: 0px; ">
                                    <div ng-include="'list.html'" ></div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div ng-show="state == 'settings'">
                    <div class="col-md-9" style="padding-left: 0px; padding-right: 20px">
                        <div class="col-md-12" style="padding-left: 0px; padding-right: 0px">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo $text_model_list; ?></h3>
                                </div>
                                <div class="panel-body" style="display: block; overflow: auto; height: 259px; border-collapse: collapse; padding: 0px">
                                    <table class="table table-hover table-striped table-condensed">
                                        <tbody>
                                        <tr ng-repeat="item in loadedModels">
                                            <td style="width: 34px">{{ $index + 1 }}.</td>
                                            <td>{{ item.name }}</td>
                                            <td>{{ item.size / 1024 | number: 2 }} KB</td>
                                            <td>
                                                <div class="btn-group btn-group-sm pull-right">
                                                    <a href="../system/storage/download/export_manager/model/{{item.name}}.json" class="btn btn-info"><i class="fa fa-eye"></i></a>
                                                    <button ng-click="sendEmailDialog(item)" class="btn btn-primary" style="margin-left: 8px"><i class="fa fa-envelope-o"></i></button>
                                                    <button ng-click="deleteDialog(item)" class="btn btn-danger" style="margin-left: 8px"><i class="fa fa-trash-o"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-left: 0px; padding-right: 0px">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo $text_export_list; ?></h3>
                                </div>
                                <div class="panel-body" style="display: block; overflow: auto; height: 259px; border-collapse: collapse; padding: 0px">
                                    <table class="table table-hover table-striped table-condensed">
                                        <tbody>
                                        <tr ng-repeat="item in exportList">
                                            <td style="width: 34px">{{ $index + 1 }}.</td>
                                            <td>{{ item.name }}</td>
                                            <td ng-if="item.size < 1048576">{{ item.size / 1024 | number: 2 }} KB</td>
                                            <td ng-if="item.size > 1048576">{{ item.size / 1048576 | number: 2 }} <strong>MB</strong></td>
                                            <td>
                                                <div class="btn-group btn-group-sm pull-right">
                                                    <a class="btn btn-info" href="../system/storage/download/export_manager/xml/{{item.name}}"><i class="fa fa-eye"></i></a>
                                                    <button ng-click="deleteDialog(item)" class="btn btn-danger" style="margin-left: 8px"><i class="fa fa-trash-o"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3" style="padding-left: 0px; padding-right: 0px">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><?php echo $text_global_settings; ?></h3>
                            </div>
                            <div class="panel-body" style="display: block; overflow: auto; height: 207px; border-collapse: collapse; padding: 0px">
                                <div class="col-md-12" style="margin-top: 20px; padding-left: 20px">
                                    <label><?php echo $text_date_format; ?></label>
                                    <div ng-dropdown-multiselect="" options="dateFormats" selected-model="selectedDateFormat" extra-settings="dropdown_date_settings" translation-texts="dropdown_date_texts"></div>
                                </div>
                            </div>
                            <div class="panel-footer">
                                <button ng-click="SaveGlobalSettings()" class="btn btn-success btn-sm pull-right"><?php echo $text_save; ?></button>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <style>
                    .linije li:nth-child(even){background: #f3f3f3;}
                    .linije ul li:nth-child(even) {background: #f3f3f3;}
                    .linije ul li:nth-child(odd) {background: #f3f3f3;}
                    .linije li:nth-child(odd) {background: #f3f3f3;}
                    .linije ul li:nth-child(odd) {background: #f3f3f3;}
                    .linije ul li:nth-child(even) {background: #f3f3f3;}
                    .linije .form-control {height: 27px; padding: 4px 13px; border-radius:0;}
                    .linije .list-group-item {padding: 0px;}
                </style>
                <script type="text/ng-template" id="list.html">
                    <ul class="list-group linije" dnd-list="list" style="margin-bottom: 0px; border: none;min-height: 50px;">
                        <li style="cursor: all-scroll; margin: 0px; border: none" ng-repeat="item in list"
                            dnd-draggable="item"
                            dnd-effect-allowed="move"
                            dnd-moved="list.splice($index, 1)"
                            dnd-selected="model.selected = item"
                            class="list-group-item"
                            ng-class="{'selected': model.selected === item}"
                            ng-include="item.type + '.html'">
                            {{item.label}}
                        </li>
                    </ul>
                </script>
                <script type="text/ng-template" id="subnode.html">
                    <div class="container-element box box-blue"  style="background-color: #f3f3f3;">
                        <span style="float: left; width: 30px; margin-top: 15px; text-align: center"><strong><</strong></span>
                        <input type="text" class="form-control" style="float: left; width: 140px; border: none; background-color: #fff; margin: 10px 0" ng-model="item.name" placeholder="<?php echo $text_subnode_place; ?>">
                        <span style="float: left; width: 30px; margin-top: 15px; text-align: center"><strong>></strong></span>
                        <div class="clearfix"></div>
                        <div class="column" ng-repeat="list in item.columns" style="padding-left: 55px">
                            <div ng-include="'list.html'"></div>
                        </div>
                        <span style="float: left; width: 30px; margin-top: 15px; text-align: center"><strong>< &frasl;</strong></span>
                        <input type="text" class="form-control" style="float: left; width: 140px; border: none; background-color: #fff; padding-left: 5px; margin: 10px 0px " ng-model="item.name" placeholder="<?php echo $text_subnode_place; ?>">
                        <span style="float: left; width: 30px; margin-top: 15px; text-align: center"><strong>></strong></span>
                        <div class="clearfix"></div>
                    </div>
                </script>
                <script type="text/ng-template" id="node.html">
                    <div style="padding:6px 4px 4px 4px">
                        <div style="margin: 0px">
                            <span style="float: left; width: 23px; margin-top: 5px; text-align: center"><strong><</strong></span>
                            <input type="text" class="form-control" style="float: left; width: 140px; border: none; background-color: #fff; padding-left: 5px; margin: 0px" ng-model="item.nodename" id="exampleInputAmount" placeholder="<?php echo $text_node_place; ?>">
                            <span style="float: left; width: 30px; margin-top: 5px; text-align: center"><strong>></strong></span>
                        </div>
                        <div style="margin: 0px">
                            <h5 style="float: left; margin-top: 9px; color: #975386; min-width: 140px; text-align: center;font-weight:bold">{{item.name}}</h5>
                        </div>
                        <div style="margin: 0px">
                            <span style="float: left; width: 23px; margin-top: 5px; text-align: center"><strong>< &frasl;</strong></span>
                            <input type="text" class="form-control" style="float: left; width: 140px; border: none; background-color: #fff; padding-left: 5px; margin: 0px" ng-model="item.nodename" id="exampleInputAmount" placeholder="<?php echo $text_node_place; ?>">
                            <span style="float: left; width: 30px; margin-top: 5px; text-align: center"><strong>></strong></span>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </script>
                <script type="text/ng-template" id="saveModelDialog">
                    <h3 style="color: #5b93ab"><i class="fa fa-pencil-square-o"></i> <?php echo $text_save_model; ?></h3>
                    <h4 style="margin-left: 10px; margin-top: 18px"><?php echo $text_name_model; ?>:</h4>
                    <div style="margin-top: 5px; margin-left: 10px">
                        <input type="text" class="form-control" ng-model="modelName.name" placeholder="">
                    </div>
                    <div style="margin-top: 30px; margin-bottom: 20px; margin-left: 10px">
                        <a href="" ng-click="storeModel()" class="btn btn-default"><?php echo $text_save; ?></a>
                    </div>
                </script>
                <script type="text/ng-template" id="deleteItemDialog">
                    <h3 style="color: #ab0217"><i class="fa fa-pencil-square-o"></i> <?php echo $text_delete_item; ?></h3>
                    <h4 style="margin-left: 10px; margin-top: 18px"><?php echo $text_shure_delete; ?><b>&nbsp;{{sendFile.name}}</b></h4>
                    <div style="margin-top: 30px; margin-bottom: 20px; margin-left: 10px">
                        <a href="" ng-click="deleteItemFile()" class="btn btn-default"><?php echo $text_delete; ?></a>
                    </div>
                </script>
                <script type="text/ng-template" id="sendJsonDialog">
                    <h3 style="color: #5b93ab"><i class="fa fa-pencil-square-o"></i> <?php echo $text_send_email; ?></h3>
                    <h4 style="margin-left: 10px; margin-top: 18px"><?php echo $text_recipient_email; ?>:</h4>
                    <div style="margin-top: 5px; margin-left: 10px">
                        <input type="text" class="form-control" ng-model="recipient.email" placeholder="Email">
                    </div>
                    <h4 style="margin-left: 10px; margin-top: 18px"><?php echo $text_short_comment; ?>:</h4>
                    <div style="margin-top: 5px; margin-left: 10px">
                        <textarea class="form-control" rows="5" id="inputComments" placeholder="Comment" ng-model="recipient.comment"></textarea>
                    </div>
                    <div style="margin-top: 15px; margin-left: 10px">
                        <h5><i><?php echo $text_attachement; ?>: </i><b>&nbsp;&nbsp;{{sendFile.name}}.json</b>&nbsp;&nbsp;<i>{{ sendFile.size / 1000 | number: 2 }} KB</i></h5>
                    </div>
                    <div style="margin-top: 30px; margin-bottom: 20px; margin-left: 10px">
                        <a href="" ng-click="sendEmailFile()" class="btn btn-default"><?php echo $text_send_email; ?></a>
                    </div>
                </script>
                <script type="text/ng-template" id="exportProductsDialog">
                    <div class="col-md-12" style="margin-top: 11px">
                        <h3 style="color: #5b93ab"><i class="fa fa-pencil-square-o"></i> <?php echo $text_export_products; ?></h3>
                    </div>
                    <div class="col-md-4" style="margin-top: 20px">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><?php echo $text_product_export; ?></h3>
                                <h4 class="pull-right" style="color: #5b93ab"><span ng-show="spinner"><i class="fa fa-spinner fa-spin"></i></span> {{countText}}</h4>
                            </div>
                            <div class="panel-body" when-scroll-ends="GETProductsOnScrollEnd()" style="display: block; overflow: auto; height: 450px; border-collapse: collapse; padding: 0px 11px 0px 0px;">
                                <ul class="list-group">
                                    <li class="list-group-item" ng-repeat="item in productList" style="padding-bottom: 0px">
                                        <span class="badge" style="background-color: #b5b5b5; font-size: 10px">{{item.price | currency: ''}}</span>
                                        <h5>
                                            <!--{{$index + 1}}.&nbsp;&nbsp;-->{{item.name}}
                                        </h5>
                                    </li>
                                </ul>
                            </div>
                            <div class="panel-footer" style="color: #999999; text-align: right;"><?php echo $text_count_export; ?></div>
                        </div>
                    </div>
                    <div class="col-md-8" style="margin-top: 20px">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><?php echo $text_additional_conf; ?></h3>
                            </div>
                            <div class="panel-body" style="display: block; overflow: auto; height: 409px; border-collapse: collapse;">
                                <div class="col-md-6" style="margin-top: 10px">
                                    <div class="col-md-12">
                                        <label><?php echo $text_select_cat; ?></label>
                                        <div ng-dropdown-multiselect="" options="categories" selected-model="categoriesModel" extra-settings="dropdown_1_settings" events="dropdown_1_events" translation-texts="dropdown_cat_texts"></div>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 30px">
                                        <label><?php echo $text_select_manu; ?></label>
                                        <div ng-dropdown-multiselect="" options="manufacturers" selected-model="manufacturersModel" extra-settings="dropdown_1_settings" events="dropdown_1_events" translation-texts="dropdown_man_texts"></div>
                                    </div>
                                    <div class="col-md-12 center" style="margin-top: 55px">
                                        <label style="margin-bottom: 15px; text-align: center"><?php echo $text_price_range; ?></label>
                                        <rzslider rz-slider-floor="priceSlider.floor"
                                                  rz-slider-ceil="priceSlider.ceil"
                                                  rz-slider-model="priceSlider.min"
                                                  rz-slider-high="priceSlider.max"
                                                  rz-slider-precision="2"
                                                  rz-slider-on-end="priceRange_slider()"
                                                  rz-slider-step="1"
                                                  rz-slider-tpl-url="rzSliderTpl.html">
                                        </rzslider>
                                    </div>
                                </div>
                                <div class="col-md-6" style="margin-top: 10px">
                                    <div class="col-md-12">
                                        <label><?php echo $text_xml_exp; ?></label>
                                        <div class="col-md-12" style="padding-left: 0px">
                                            <input type="text" class="form-control" ng-flat-datepicker datepicker-config="datepickerConfig" ng-model="expirationDate.nodevalue" placeholder="Pick date" ng-change="dateChange(expirationDate.nodevalue)">
                                            <input type="text" class="form-control" ng-show="dateField" style="float: left; width: 100px; margin-right: 11px" ng-model="expirationDate.nodename" placeholder="Node name">
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 30px">
                                        <label><?php echo $text_give_discount; ?></label>
                                        <div class="col-md-12" style="padding-left: 0px">
                                            <input type="text" class="form-control" style="float: left; width: 45px; margin-right: 11px" ng-model="discount.percent" placeholder="%">
                                            <div style="float: left" ng-dropdown-multiselect="" options="discountChoice" selected-model="discountModel" events="dropdown_discount_events" extra-settings="dropdown_dis_settings" translation-texts="dropdown_dis_texts"></div>
                                            <input type="text" class="form-control" ng-show="discountField" style="float: left; width: 100px; margin-left: 11px" ng-model="discount.nodename" placeholder="Node name">
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 10px; margin-left: 2px">
                                        <div class="checkbox">
                                            <label><input type="checkbox" ng-model="fullUrl.value" style="margin-bottom: -2px" ng-change="fullUrlChange(fullUrl.value)">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Full url on images & thumbs</strong></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-body" style="background-color: #f9f9f9; text-align: right">
                                <div class="col-md-1 pull-right">
                                    <a href="" ng-click="exportProducts()" class="btn btn-success"><?php echo $text_save; ?></a>
                                </div>
                                <div class="col-md-4 pull-right">
                                    <input type="text" class="form-control" ng-model="modelName.name" placeholder="<?php echo $text_name_xml_2; ?>">
                                </div>
                                <div class="col-md-3 pull-right" style="padding-top: 7px; text-align: right">
                                    <label><?php echo $text_name_xml; ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </script>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript"><!--
    var app = angular.module('ExportManagerP', ['ngDialog', 'ngAnimate', 'ui.bootstrap', 'dndLists', 'angularjs-dropdown-multiselect', 'rzModule', 'ngFlatDatepicker' ]);
    app.value('view_data', {oc_token: '<?php echo $token; ?>'});
    app.service('ProductService', function( $http, view_data ) {
        return({
            GetGlobalSettings: GetGlobalSettings,
            getProduct: getProduct,
            getModels: getModels,
            getExportList: getExportList,
            getCategories: getCategories,
            getManufacturers: getManufacturers,
            getProductList: getProductList,
            getProductListCount: getProductListCount,
            storeModel: storeModel,
            SaveGlobalSettings: SaveGlobalSettings,
            EmailFile: EmailFile,
            DeleteFile: DeleteFile,
            exportProducts: exportProducts
        });
        function GetGlobalSettings() {
            var request = $http({
                method: "get",
                url: "index.php?route=module/export_manager_p/GetGlobalSettings&token=" + view_data.oc_token,
                headers : {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}
            });
            return( request.then( handleSuccess, handleError ) );
        }
        function getProduct() {
            var request = $http({
                method: "get",
                url: "index.php?route=module/export_manager_p/getProduct&token=" + view_data.oc_token,
                headers : {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}
            });
            return( request.then( handleSuccess, handleError ) );
        }
        function getModels() {
            var request = $http({
                method: "get",
                url: "index.php?route=module/export_manager_p/getModels&token=" + view_data.oc_token,
                headers : {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}
            });
            return( request.then( handleSuccess, handleError ) );
        }
        function getExportList() {
            var request = $http({
                method: "get",
                url: "index.php?route=module/export_manager_p/getExportList&token=" + view_data.oc_token,
                headers : {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}
            });
            return( request.then( handleSuccess, handleError ) );
        }
        function getCategories() {
            var request = $http({
                method: "get",
                url: "index.php?route=module/export_manager_p/getCategories&token=" + view_data.oc_token,
                headers : {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}
            });
            return( request.then( handleSuccess, handleError ) );
        }
        function getManufacturers() {
            var request = $http({
                method: "get",
                url: "index.php?route=module/export_manager_p/getManufacturers&token=" + view_data.oc_token,
                headers : {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}
            });
            return( request.then( handleSuccess, handleError ) );
        }
        function getProductList( data, start, limit ) {
            var request = $http({
                method: "post",
                url: "index.php?route=module/export_manager_p/getProductList&token=" + view_data.oc_token + "&start=" + start + "&limit=" + limit,
                data: data,
                headers : {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}
            });
            return( request.then( handleSuccess, handleError ) );
        }
        function getProductListCount( data ) {
            var request = $http({
                method: "post",
                url: "index.php?route=module/export_manager_p/getProductListCount&token=" + view_data.oc_token,
                data: data,
                headers : {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}
            });
            return( request.then( handleSuccess, handleError ) );
        }
        function storeModel( name, data ) {
            var request = $http({
                method: "post",
                url: "index.php?route=module/export_manager_p/storeModel&token=" + view_data.oc_token + "&model_name=" + name,
                data: data,
                headers : {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}
            });
            return( request.then( handleSuccess, handleError ) );
        }
        function SaveGlobalSettings( data ) {
            var request = $http({
                method: "post",
                url: "index.php?route=module/export_manager_p/SaveGlobalSettings&token=" + view_data.oc_token,
                data: data,
                headers : {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}
            });
            return( request.then( handleSuccess, handleError ) );
        }
        function EmailFile( data, recipient ) {
            var request = $http({
                method: "post",
                url: "index.php?route=module/export_manager_p/EmailFile&token=" + view_data.oc_token + "&recipient_email=" + recipient.email + "&recipient_comment=" + recipient.comment,
                data: data,
                headers : {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}
            });
            return( request.then( handleSuccess, handleError ) );
        }
        function DeleteFile( data ) {
            var request = $http({
                method: "post",
                url: "index.php?route=module/export_manager_p/DeleteFile&token=" + view_data.oc_token,
                data: data,
                headers : {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}
            });
            return( request.then( handleSuccess, handleError ) );
        }
        function exportProducts( name, data, config, discountID, discountVALUE, fullURL, count ) {
            if( discountVALUE == undefined ) {
                discountVALUE = 0;
            }
            var request = $http({
                method: "post",
                url: "index.php?route=module/export_manager_p/exportProducts&token=" + view_data.oc_token + "&model_name=" + name + "&discount_id=" + discountID + "&discount_value=" + discountVALUE + "&full_url=" + fullURL + "&count=" + count,
                data: { model: data, config: config },
                headers : {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}
            });
            return( request.then( handleSuccess, handleError ) );
        }
        function handleError( response ) {
            //console.log( "PROBLEM" );
            return( response );
        }
        function handleSuccess( response ) {
            //console.log( response );
            return( response.data );
        }
    });

    app.controller( 'ExportManagerPController', function( $scope, ProductService, ngDialog, $filter, $timeout ) {
        var global      = { title: '<?php echo $text_name; ?>', icon: 'fa fa-external_link' };
        var dashboard   = { title: '<?php echo $text_dashboard; ?>', icon: 'fa fa-dashboard' };
        var settings    = { title: '<?php echo $text_settings; ?>', icon: 'fa fa-gear' };
        $scope.state = 'dash';
        $scope.pageName = dashboard.title;
        $scope.pageIcon = dashboard.icon;
        $scope.product = {
            selected: null,
            lists: {"Product": []}
        };
        $scope.model = {
            selected: null,
            templates: [
                {type: "node", name: "", nodename: "", table: "", value: ""},
                {type: "subnode", name: "", columns: [[]]}
            ],
            dropzone: {
                "Model": [
                    {type: "subnode", name: "", columns: [[]]}
                ]
            }
        };
        $scope.alertDialog = false;
        $scope.alert_color = 'primary';
        $scope.alert_text = '';
        $scope.alert_icon = '';
        $scope.global = [{
            dateFormat: '',
            user: '',
            pass: ''
        }];
        $scope.productList = [];
        $scope.productCount = 0;
        $scope.exportList = [];
        $scope.discount = [];
        $scope.discount.id = 0;
        $scope.discount_text;
        $scope.discountField = false;
        $scope.categories = [];
        $scope.manufacturers = [];
        $scope.categoriesModel = [];
        $scope.manufacturersModel = [];
        $scope.discountChoice = [
            { id: 1, label: '<?php echo $text_embed; ?>'},
            { id: 2, label: '<?php echo $text_recalculate; ?>' }
        ];
        $scope.discountModel = [];
        $scope.expirationDate = [];
        $scope.dateFormats = [
            { id: 'DD.MM.YYYY', label: 'DD.MM.YYYY' },
            { id: 'MM/DD/YYYY', label: 'MM/DD/YYYY' },
            { id: 'YYYY-MM-DD', label: 'YYYY-MM-DD' }
        ];
        $scope.dropdown_date_settings = {
            selectionLimit: 1,
            scrollableHeight: '250px',
            smartButtonMaxItems: 1,
            showCheckAll: false,
            showUncheckAll: false,
        };
        $scope.selectedDateFormat = [{ id: 'YYYY-MM-DD' }];
        $scope.configModel = {
            categories: [{}],
            manufacturers: [{}],
            priceRange: [{}],
            expiration: [{}],
            discount: [{}]
        };
        $scope.loadedModels = [];
        $scope.strip_model = {};
        $scope.modelName = {};
        $scope.sendFile = [];
        $scope.priceSlider = {
            min: 0,
            max: 0,
            ceil: 100,
            floor: 0
        };
        $scope.datepickerConfig = {
            allowFuture: true,
            dateFormat: ''
        };
        $scope.recipient = [];
        $scope.start = 0;
        var middle = 30;
        var end = 60;
        init();
        getGlobalSettings();
        $scope.checkState = function() {
            if( $scope.state == 'dash' ) {
                $scope.pageName = dashboard.title;
                $scope.pageIcon = dashboard.icon;
            } else if ( $scope.state == 'settings' ) {
                $scope.pageName = settings.title;
                $scope.pageIcon = settings.icon;
            } else {
                $scope.pageName = global.title;
                $scope.pageIcon = global.icon;
            }
        }
        function init() {
            $scope.product = {
                selected: null,
                lists: {"Product": []}
            };
            $scope.loadedModels = [];
            $scope.exportList = [];
            ProductService.getProduct().then( function( data ) {
                console.log( data );
                angular.forEach( data, function( items ) {
                    $scope.product.lists.Product.push({ type: 'node', name: items.name, nodename: "", table: items.table, value: items.value });
                });
            });
            ProductService.getModels().then( function( data ) {
                angular.forEach( data, function( items ) {
                    $scope.loadedModels.push( items );
                });
            });
            ProductService.getExportList().then( function( data ) {
                angular.forEach( data, function( items ) {
                    $scope.exportList.push( items );
                });
            });
        }
        function getGlobalSettings() {
            ProductService.GetGlobalSettings().then( function( data ) {
                angular.forEach( data, function( items ) {
                    $scope.global.push( items );
                });
                $scope.selectedDateFormat = { id: $scope.global[1].date_format };
                $scope.datepickerConfig = {
                    allowFuture: true,
                    dateFormat: $scope.global[1].date_format
                };
            });
        }
        function isEmpty( obj ) {
            for( var prop in obj ) {
                if( obj.hasOwnProperty( prop ))
                    return false;
            }
            return true;
        }
        $scope.storeModel = function() {
            $scope.strip_model = $scope.model.dropzone;
            $scope.product = {
                selected: null,
                lists: {"Product": []}
            };
            $scope.loadedModels = [];
            ProductService.storeModel( $scope.modelName.name, $scope.strip_model ).then( function( response ) {
                ngDialog.close();
                if( response == '"success"' ) {
                    $scope.alertDialog = true;
                    $scope.alert_color = 'success';
                    $scope.alert_icon = 'check';
                    $scope.alert_text = '<?php echo $text_model_success; ?>';
                    $timeout(function() {
                        $scope.alertDialog = false;
                    }, 3000);
                } else {
                    $scope.alertDialog = true;
                    $scope.alert_color = 'danger';
                    $scope.alert_icon = 'check';
                    $scope.alert_text = '<?php echo $text_model_error; ?>';
                    $timeout(function() {
                        $scope.alertDialog = false;
                    }, 3000);
                }
            });
            init();
        }
        $scope.SaveGlobalSettings = function() {
            if( isEmpty( $scope.selectedDateFormat )) {
            } else {
                $scope.global = [{
                    dateFormat: $scope.selectedDateFormat.id
                }];
            }
            ProductService.SaveGlobalSettings( $scope.global ).then( function( response ) {
                if( response == '"success"' ) {
                    $scope.alertDialog = true;
                    $scope.alert_color = 'success';
                    $scope.alert_icon = 'check';
                    $scope.alert_text = '<?php echo $text_global_success; ?>';
                    $timeout(function() {
                        $scope.alertDialog = false;
                    }, 3000);
                } else {
                    $scope.alertDialog = true;
                    $scope.alert_color = 'danger';
                    $scope.alert_icon = 'warning';
                    $scope.alert_text = '<?php echo $text_global_error; ?>';
                    $timeout(function() {
                        $scope.alertDialog = false;
                    }, 3000);
                }
            });
        }
        $scope.sendEmailDialog = function( data ) {
            $scope.sendFile = data;
            ngDialog.open({ template: 'sendJsonDialog',
                className: 'ngdialog-theme-default',
                scope: $scope });
        }
        $scope.sendEmailFile = function() {
            ProductService.EmailFile( $scope.sendFile, $scope.recipient ).then( function( response ) {
                ngDialog.close();
                if( response == '"error"' ) {
                    $scope.alertDialog = true;
                    $scope.alert_color = 'danger';
                    $scope.alert_icon = 'warning';
                    $scope.alert_text = '<?php echo $text_email_error; ?>';
                    $timeout(function() {
                        $scope.alertDialog = false;
                    }, 3000);
                } else {
                    $scope.alertDialog = true;
                    $scope.alert_color = 'success';
                    $scope.alert_icon = 'check';
                    $scope.alert_text = '<?php echo $text_email_success; ?>';
                    $timeout(function() {
                        $scope.alertDialog = false;
                    }, 3000);
                }
            });
        }
        $scope.deleteDialog = function( data ) {
            $scope.sendFile = data;
            ngDialog.open({ template: 'deleteItemDialog',
                className: 'ngdialog-theme-default',
                scope: $scope });
        }
        $scope.deleteItemFile = function() {
            ProductService.DeleteFile( $scope.sendFile ).then( function( response ) {
                ngDialog.close();
                if( response == '"success"' ) {
                    $scope.alertDialog = true;
                    $scope.alert_color = 'success';
                    $scope.alert_icon = 'check';
                    $scope.alert_text = '<?php echo $text_file_del_success; ?>';
                    $timeout(function() {
                        $scope.alertDialog = false;
                    }, 3000);
                } else {
                    $scope.alertDialog = true;
                    $scope.alert_color = 'danger';
                    $scope.alert_icon = 'check';
                    $scope.alert_text = '<?php echo $text_file_del_error; ?>';
                    $timeout(function() {
                        $scope.alertDialog = false;
                    }, 3000);
                }
            });
            init();
        }
        $scope.exportProducts = function() {
            $scope.strip_model = $scope.model.dropzone;
            $scope.configModel = [{
                categories: [ $scope.categoriesModel ],
                manufacturers: [ $scope.manufacturersModel ],
                priceRange: [{ low: $scope.priceSlider.min, hi: $scope.priceSlider.max }],
                expiration: [{ nodename: $scope.expirationDate.nodename, nodevalue: $scope.expirationDate.nodevalue }],
                discount: [{ id: $scope.discount.id, nodename: $scope.discount.nodename, percent: $scope.discount.percent }]
            }];
            ngDialog.close();
            $scope.alertDialog = true;
            $scope.alert_color = 'warning';
            $scope.alert_icon = 'spinner fa-spin';
            $scope.alert_text = '<?php echo $text_products_collect; ?>';
            ProductService.exportProducts( $scope.modelName.name, $scope.strip_model, $scope.configModel, $scope.discount.id, $scope.discount.percent, $scope.fullUrl.value, $scope.productCount ).then( function( response ) {
                if( response == '"success"' ) {
                    $scope.alertDialog = true;
                    $scope.alert_color = 'success';
                    $scope.alert_icon = 'check';
                    $scope.alert_text = '<?php echo $text_products_success; ?>';
                    $timeout(function() {
                        $scope.alertDialog = false;
                    }, 3000);
                } else {
                    console.log(response);
                    $scope.alertDialog = true;
                    $scope.alert_color = 'danger';
                    $scope.alert_icon = 'check';
                    $scope.alert_text = '<?php echo $text_products_error; ?>';
                    $timeout(function() {
                        $scope.alertDialog = false;
                    }, 3000);
                }
            });
            init();
        }
        $scope.dateChange = function( date ) {
            if( date != '' ) {
                $scope.dateField = true;
            } else {
                $scope.dateField = false;
            }
        }
        $scope.fullUrlChange = function( selected ) {
            if( selected == true ) {
                $scope.fullUrl.value = true;
            } else {
                $scope.fullUrl.value = false;
            }
        }
        var hi = 0;
        var low = 0;
        $scope.priceRange_slider = function() {
            $scope.configModel = [{
                categories: [ $scope.categoriesModel ],
                manufacturers: [ $scope.manufacturersModel ],
                priceRange: [{ low: $scope.priceSlider.min, hi: $scope.priceSlider.max }],
                expiration: [{ nodename: $scope.expirationDate.nodename, nodevalue: $scope.expirationDate.nodevalue }],
                discount: [{}]
            }];
            $scope.spinner = true;
            $scope.countText = '<?php echo $text_loading; ?>';
            $scope.productList = [];
            ProductService.getProductList( $scope.configModel, $scope.start, end ).then( function( data ) {
                $scope.productCount = 0;
                $scope.productList = data;
                $scope.spinner = false;
                $scope.countText = '';
            });
            ProductService.getProductListCount( $scope.configModel ).then( function( data ) {
                $scope.productCount = data.count;
                hi = data.hi_price;
                low = data.low_price;
                $scope.spinner = false;
                $scope.countText = '';
            });
            $scope.discount.percent = '';
        }
        $scope.getProductList = function() {
            $scope.configModel = [{
                categories: [ $scope.categoriesModel ],
                manufacturers: [ $scope.manufacturersModel ],
                priceRange: [{ low: 0, hi: 0 }],
                expiration: [{ nodename: $scope.expirationDate.nodename, nodevalue: $scope.expirationDate.nodevalue }],
                discount: [{}]
            }];
            $scope.productCount = 0;
            $scope.spinner = true;
            $scope.countText = '<?php echo $text_loading; ?>';
            $scope.productList = [];
            $scope.start = 0;
            ProductService.getProductList( $scope.configModel, $scope.start, end ).then( function( data ) {
                $scope.productList = data;
                $scope.spinner = false;
                $scope.countText = '';
            });
            ProductService.getProductListCount( $scope.configModel ).then( function( data ) {
                $scope.productCount = data.count;
                hi = data.hi_price;
                low = data.low_price;
                $scope.priceSlider = {
                    min: low,
                    max: hi,
                    ceil: hi,
                    floor: low
                };
                $scope.spinner = false;
                $scope.countText = '';
            });
            $scope.discount = [];
            $scope.discount.id = 0;
            $scope.discount_text = '';
            $scope.discountField = false;
            $scope.discountModel = [];
        }
        $scope.GETProductsOnScrollEnd = function() {
            var end2 = end + middle;
            ProductService.getProductList( $scope.configModel, end, end2 ).then( function( data ) {
                end = end2;
                $scope.start = $scope.start + middle;
                angular.forEach( data, function ( item ) {
                    $scope.productList.push(item);
                });
            });
        }
        $scope.saveModelDialog = function() {
            $scope.modelName.name = '';
            ngDialog.open({ template: 'saveModelDialog',
                className: 'ngdialog-theme-default',
                scope: $scope });
        }
        $scope.exportProductsDialog = function() {
            $scope.productList = [];
            $scope.categories = [];
            $scope.manufacturers = [];
            $scope.categoriesModel = [];
            $scope.manufacturersModel = [];
            $scope.expirationDate.nodename = '';
            $scope.expirationDate.nodevalue = '';
            $scope.dateField = false;
            $scope.discount = [];
            $scope.discount.id = 0;
            $scope.discountField = false;
            $scope.fullUrl = { value: true };
            $scope.modelName.name = '';
            ngDialog.open({ template: 'exportProductsDialog',
                className: 'ngdialog-export',
                scope: $scope });
            ProductService.getCategories().then( function( data ) {
                angular.forEach( data, function( item ) {
                    $scope.categories.push({ id: item.category_id, label: item.name });
                });
            });
            ProductService.getManufacturers().then( function( data ) {
                angular.forEach( data, function( item ) {
                    $scope.manufacturers.push({ id: item.manufacturer_id, label: item.name });
                });
            });
            $scope.priceSlider.min = 0;
            $scope.priceSlider.max = 0;
            $scope.getProductList();
            $scope.dropdown_1_settings = {
                scrollableHeight: '225px',
                enableSearch: true,
                scrollable: true,
                smartButtonMaxItems: 5,
                showCheckAll: false,
                showUncheckAll: false,
            };
            $scope.dropdown_1_events = {
                onItemSelect: $scope.getProductList,
                onItemDeselect: $scope.getProductList,
            };
            $scope.dropdown_cat_texts = { buttonDefaultText: '<?php echo $text_all_cat; ?>' };
            $scope.dropdown_man_texts = { buttonDefaultText: '<?php echo $text_all_manu; ?>' };
            $scope.dropdown_dis_settings = {
                selectionLimit: 1,
                scrollableHeight: '100px',
                smartButtonMaxItems: 1,
                showCheckAll: false,
                showUncheckAll: false,
            };
            $scope.dropdown_discount_events = {
                onItemSelect: function(item) {
                    if(item.id == 1) {
                        $scope.discountField = true;
                        $scope.discount.id = 1;
                    } else {
                        $scope.discountField = false;
                        $scope.discount.id = 2;
                    }
                },
            };
            $scope.dropdown_dis_texts = { buttonDefaultText: '<?php echo $text_method; ?>' };
        }
        $scope.selectModel = function() {
            var str = $scope.selectedModel.data;
            var obj = JSON.parse(str);
            $scope.model = {
                selected: null,
                templates: [
                    {type: "node", name: "", nodename: "", table: "", value: ""},
                    {type: "subnode", name: "", columns: [[]]}
                ],
                dropzone: obj
            };
        }
    });
    app.directive('whenScrollEnds', function () {
        return {
            restrict: "A",
            link: function (scope, element, attrs) {
                var processingScroll = false;
                var visibleHeight = element.height();
                var threshold = 600;
                element.scrollTop(1);
                element.scroll(function () {
                    var scrollableHeight = element.prop('scrollHeight');
                    var hiddenContentHeight = scrollableHeight - visibleHeight;
                    if (hiddenContentHeight - element.scrollTop() <= 0) {
                        element.scrollTop( (scrollableHeight + hiddenContentHeight) / 2 );
                        scope.$apply(attrs.whenScrollEnds);
                    }
                });
            }
        };
    });
    //-->
</script>
<?php echo $footer; ?>