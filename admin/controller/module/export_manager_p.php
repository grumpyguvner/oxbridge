<?php
class ControllerModuleExportManagerP extends Controller {
    private $error = array();

    public function index() {

        $this->load->language('module/export_manager_p');
        $this->document->setTitle($this->language->get('heading_title_main'));

        $data['heading_title'] = $this->language->get('heading_title');
        $data['heading_title_main'] = $this->language->get('heading_title_main');

        $data['text_name'] = $this->language->get('text_name');
        $data['text_dashboard'] = $this->language->get('text_dashboard');
        $data['text_settings'] = $this->language->get('text_settings');
        $data['text_delete_item'] = $this->language->get('text_delete_item');
        $data['text_send_email'] = $this->language->get('text_send_email');
        $data['text_recipient_email'] = $this->language->get('text_recipient_email');
        $data['text_model_list'] = $this->language->get('text_model_list');
        $data['text_export_list'] = $this->language->get('text_export_list');
        $data['text_global_settings'] = $this->language->get('text_global_settings');
        $data['text_export_products'] = $this->language->get('text_export_products');
        $data['text_drop_n_trash'] = $this->language->get('text_drop_n_trash');
        $data['text_enter'] = $this->language->get('text_enter');
        $data['text_save'] = $this->language->get('text_save');
        $data['text_delete'] = $this->language->get('text_delete');
        $data['text_save_model'] = $this->language->get('text_save_model');
        $data['text_load_models'] = $this->language->get('text_load_models');
        $data['text_subnode_place'] = $this->language->get('text_subnode_place');
        $data['text_node_place'] = $this->language->get('text_node_place');
        $data['text_name_model'] = $this->language->get('text_name_model');
        $data['text_shure_delete'] = $this->language->get('text_shure_delete');
        $data['text_recipient_email'] = $this->language->get('text_recipient_email');
        $data['text_short_comment'] = $this->language->get('text_short_comment');
        $data['text_attachement'] = $this->language->get('text_attachement');
        $data['text_date_format'] = $this->language->get('text_date_format');
        $data['text_product_export'] = $this->language->get('text_product_export');
        $data['text_additional_conf'] = $this->language->get('text_additional_conf');
        $data['text_export_products'] = $this->language->get('text_export_products');
        $data['text_embed'] = $this->language->get('text_embed');
        $data['text_recalculate'] = $this->language->get('text_recalculate');
        $data['text_all_cat'] = $this->language->get('text_all_cat');
        $data['text_all_manu'] = $this->language->get('text_all_manu');
        $data['text_method'] = $this->language->get('text_method');
        $data['text_name_xml_2'] = $this->language->get('text_name_xml_2');
        $data['text_count_export'] = $this->language->get('text_count_export');
        $data['text_select_cat'] = $this->language->get('text_select_cat');
        $data['text_select_manu'] = $this->language->get('text_select_manu');
        $data['text_price_range'] = $this->language->get('text_price_range');
        $data['text_xml_exp'] = $this->language->get('text_xml_exp');
        $data['text_give_discount'] = $this->language->get('text_give_discount');
        $data['text_full_url'] = $this->language->get('text_full_url');
        $data['text_name_xml'] = $this->language->get('text_name_xml');
        $data['text_loading'] = $this->language->get('text_loading');
        $data['text_model_success'] = $this->language->get('text_model_success');
        $data['text_model_error'] = $this->language->get('text_model_error');
        $data['text_global_success'] = $this->language->get('text_global_success');
        $data['text_global_error'] = $this->language->get('text_global_error');
        $data['text_email_success'] = $this->language->get('text_email_success');
        $data['text_email_error'] = $this->language->get('text_email_error');
        $data['text_file_del_success'] = $this->language->get('text_file_del_success');
        $data['text_file_del_error'] = $this->language->get('text_file_del_error');
        $data['text_products_collect'] = $this->language->get('text_products_collect');
        $data['text_products_success'] = $this->language->get('text_products_success');
        $data['text_products_error'] = $this->language->get('text_products_error');

        /*  v2.1    */
        $data['text_attribute_format'] = $this->language->get('text_attribute_format');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['image'])) {
            $data['error_image'] = $this->error['image'];
        } else {
            $data['error_image'] = array();
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_module'),
            'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title_main'),
            'href'      => $this->url->link('module/export_manager_p', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $data['token'] = $this->session->data['token'];
        $data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');


        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('module/export_manager_p.tpl', $data));
    }

    public function GetGlobalSettings() {
        $this->load->language('module/export_manager_p');
        $this->load->model('setting/setting');

        $data['items'] = array();

        $dateFormat = $this->model_setting_setting->getSetting( 'export_manager' );

        if ( $dateFormat != null ) {
            $data['items'][] = array(
                'date_format' => $dateFormat['export_manager_date_format']
            );
        } else {
            $data['items'][] = array(
                'date_format' => 'YYYY-MM-DD'
            );
        }

        $data['global'] = json_encode( $data['items'] );
        $this->response->setOutput( $data['global'] );
    }

    public function getProduct() {
        $this->load->language('module/export_manager_p');
        $this->load->model('module/export_manager_p');

        $id = 0;

        $data['items'] = array();
        $data['product'] = array();
        $data['product_description'] = array();
        $data['product_image'] = array();
        $data['product_special'] = array();

        $product = $this->model_module_export_manager_p->getProduct();
        foreach( $product as $result ) {
            $id = $result['product_id'];

            foreach( $result as $k => $v ) {
                $data['product'][] = array(
                    'name' => $k,
                    'value'=> $v,
                    'table'=> 'product'
                );
            }
        }
        $product_description = $this->model_module_export_manager_p->getProductDescription( $id );
        foreach( $product_description as $result ) {

            foreach( $result as $k => $v ) {
                $data['product_description'][] = array(
                    'name' => $k,
                    'value'=> $v,
                    'table'=> 'product_description'
                );
            }
        }
        $data['product_attributes'][] = array( 'name' => 'attribute_group', 'value'=> '1', 'table'=> 'attribute_group_description');
        $data['product_attributes'][] = array( 'name' => 'attribute_name', 'value'=> '1', 'table'=> 'attribute_description' );
        $data['product_attributes'][] = array( 'name' => 'attribute_value', 'value'=> '1', 'table'=> 'product_attribute' );

        $product_thumbs = $this->model_module_export_manager_p->getProductThumbs();
        foreach( $product_thumbs as $result ) {

            foreach( $result as $k => $v ) {
                $data['product_image'][] = array(
                    'name' => $k,
                    'value'=> $v,
                    'table'=> 'product_image'
                );
            }
        }
        $product_special = $this->model_module_export_manager_p->getProductSpecial();
        foreach( $product_special as $result ) {

            foreach( $result as $k => $v ) {
                $data['product_special'][] = array(
                    'name' => $k,
                    'value'=> $v,
                    'table'=> 'product_special'
                );
            }
        }

        $data['items'] = array_merge( $data['product'], $data['product_description'], $data['product_image'], $data['product_special'], $data['product_attributes'] );



        $data['product'] = json_encode($data['items']);
        $this->response->setOutput($data['product']);
    }

    public function getModels() {
        $this->load->language('module/export_manager_p');

        $data['items'] = array();

        $files_raw = scandir( DIR_SYSTEM . 'storage/download/export_manager/model/' );

        $files = array_slice( $files_raw, 2 );

        foreach( $files as $file ) {

            $content = file_get_contents( DIR_SYSTEM . 'storage/download/export_manager/model/' . $file );

            $data['items'][] = array(
                'name'          => substr( $file, 0, -5 ),
                'data'          => $content,
                'size'          => filesize( DIR_SYSTEM . 'storage/download/export_manager/model/' . $file )
            );
        }

        $data['files'] = json_encode( $data['items'] );
        $this->response->setOutput( $data['files'] );
    }

    public function getExportList() {
        $this->load->language( 'module/export_manager_p' );

        $data['items'] = array();

        $files_raw = scandir( DIR_SYSTEM . 'storage/download/export_manager/xml/' );

        $files = array_slice( $files_raw, 2 );

        foreach( $files as $file ) {
            $data['items'][] = array(
                'name'          => $file,
                'size'          => filesize( DIR_SYSTEM . 'storage/download/export_manager/xml/' . $file )
            );
        }

        $data['files'] = json_encode( $data['items'] );
        $this->response->setOutput( $data['files'] );
    }

    public function getCategories() {
        $this->load->language('module/export_manager_p');
        $this->load->model('module/export_manager_p');

        $data['items'] = array();

        $categories = $this->model_module_export_manager_p->getCategories();
        foreach( $categories as $result ) {
            $data['items'][] = array(
                'category_id'   => $result['category_id'],
                'name'          => $result['name']
            );
        }

        $data['categories'] = json_encode($data['items']);
        $this->response->setOutput($data['categories']);
    }

    public function getManufacturers() {
        $this->load->language('module/export_manager_p');
        $this->load->model('module/export_manager_p');

        $data['items'] = array();

        $manufacturers = $this->model_module_export_manager_p->getManufacturers();
        foreach( $manufacturers as $result ) {
            $data['items'][] = array(
                'manufacturer_id'   => $result['manufacturer_id'],
                'name'              => $result['name']
            );
        }

        $data['manufacturers'] = json_encode($data['items']);
        $this->response->setOutput($data['manufacturers']);
    }

    public function storeModel() {
        $this->load->language('module/export_manager_p');

        $data_get = json_decode( file_get_contents( 'php://input' ));

        if ( isset( $this->request->get['model_name'] )) {
            $model_name = $this->request->get['model_name'];
        } else {
            $model_name = "";
        }

        $content = json_encode( $data_get );

        $result = file_put_contents( DIR_SYSTEM . 'storage/download/export_manager/model/' . $model_name . '.json', $content );

        if( $result === false ) {
            $result = 'error';
        } else {
            $result = 'success';
        }

        $this->response->setOutput( json_encode( $result ));
    }

    public function SaveGlobalSettings() {
        $this->load->language('module/export_manager_p');
        $this->load->model('setting/setting');

        $data_get = json_decode( file_get_contents( 'php://input' ));

        if ( isset( $data_get[0]->dateFormat )) {
            $this->model_setting_setting->editSetting('export_manager', array( 'export_manager_date_format' => $data_get[0]->dateFormat ));
            $result = 'success';
        } else {
            $result = 'error';
        }

        $this->response->setOutput( json_encode( $result ));
    }

    public function EmailFile() {
        $this->load->language('module/export_manager_p');

        $data_get = json_decode( file_get_contents( 'php://input' ));

        if ( isset( $this->request->get['recipient_email'] )) {
            $recipient_email = $this->request->get['recipient_email'];
        } else {
            $recipient_email = "";
        }
        if ( isset( $this->request->get['recipient_comment'] )) {
            $recipient_comment = $this->request->get['recipient_comment'];
        } else {
            $recipient_comment = "";
        }

        if( $recipient_email != "" ) {
            $mail = new Mail( $this->config->get( 'config_mail' ));
            $mail->setTo( $recipient_email );
            $mail->setFrom( $this->config->get( 'config_email' ));
            $mail->setSender( $this->user->getUserName() );
            $mail->setSubject( 'Store model' );
            $mail->setText( $recipient_comment );
            $mail->addAttachment( DIR_SYSTEM . 'storage/download/export_manager/model/' . $data_get->name . '.json' );
            $mail->send();
            $this->response->setOutput( json_encode( 'success' ));
        } else {
            $this->response->setOutput( json_encode( 'error' ));
        }
    }

    public function DeleteFile() {
        $this->load->language('module/export_manager_p');

        $data_get = json_decode( file_get_contents( 'php://input' ));

        if( substr( $data_get->name, -4 ) == '.xml' ) {
            if( unlink( DIR_SYSTEM . 'storage/download/export_manager/xml/' . $data_get->name )) {
                $this->response->setOutput( json_encode( 'success' ));
            } else {
                $this->response->setOutput( json_encode( 'error' ));
            }
        } else {
            if( unlink( DIR_SYSTEM . 'storage/download/export_manager/model/' . $data_get->name . '.json' )) {
                $this->response->setOutput( json_encode( 'success' ));
            } else {
                $this->response->setOutput( json_encode( 'error' ));
            }
        }
    }

    public function getProductList() {
        $this->load->language('module/export_manager_p');
        $this->load->model('module/export_manager_p');

        $data_get = json_decode( file_get_contents( 'php://input' ));

        if ( isset( $this->request->get['start'] )) {
            $start = $this->request->get['start'];
        } else {
            $start = 0;
        }
        if ( isset( $this->request->get['limit'] )) {
            $limit = $this->request->get['limit'];
        } else {
            $limit = 0;
        }

        $products = $this->model_module_export_manager_p->getProductList( $data_get[0]->manufacturers, $data_get[0]->categories, $data_get[0]->priceRange, $start, $limit );

        $count_prices = $this->model_module_export_manager_p->getProductListCount( $data_get[0]->manufacturers, $data_get[0]->categories, $data_get[0]->priceRange );

        $data['items'] = array();

        $low_price = 100000;
        $hi_price = 0;

        foreach( $products as $result ) {
            if( $result['price'] < $low_price ) {
                $low_price = $result['price'];
            } else if( $result['price'] > $hi_price ) {
                $hi_price = $result['price'];
            }
            $data['items'][] = array(
                'product_id'   => $result['product_id'],
                'name'         => $result['name'],
                'price'        => $result['price'],
                'count'        => '1',
                'hi_price'     => round($hi_price, 2),
                'low_price'    => round($low_price, 2)
            );
        }

        $data['products'] = json_encode($data['items']);
        $this->response->setOutput($data['products']);
    }

    public function getProductListCount() {
        $this->load->language('module/export_manager_p');
        $this->load->model('module/export_manager_p');

        $data_get = json_decode( file_get_contents( 'php://input' ));

        $count_prices = $this->model_module_export_manager_p->getProductListCount( $data_get[0]->manufacturers, $data_get[0]->categories, $data_get[0]->priceRange );

        $data['items'] = array();

        $low_price = 100000;
        $hi_price = 0;
        $count = 0;

        foreach( $count_prices as $result ) {
            if( $result['price'] < $low_price ) {
                $low_price = $result['price'];
            } else if( $result['price'] > $hi_price ) {
                $hi_price = $result['price'];
            }
            $count++;
        }

        $data['items'] = array(
            'count'        => $count,
            'hi_price'     => round($hi_price, 2),
            'low_price'    => round($low_price, 2)
        );

        $data['products'] = json_encode($data['items']);
        $this->response->setOutput($data['products']);
    }
    /*
     *   Export Call Methods
     */
    public function exportProducts() {

        //$this->log->resetDebug();


        $this->load->language('module/export_manager_p');
        $this->load->model('module/export_manager_p');
        $this->load->model('catalog/product');
        $this->load->model('catalog/attribute');
        $this->load->model('catalog/attribute_group');

        $data_get = json_decode( file_get_contents( 'php://input' ));

        if ( isset( $this->request->get['model_name'] )) {
            $model_name = $this->request->get['model_name'];
        } else {
            $model_name = "ExportManagerModel";
        }
        if ( isset( $this->request->get['discount_id'] )) {
            $discount_id = $this->request->get['discount_id'];
        } else {
            $discount_id = 0;
        }
        if ( isset( $this->request->get['discount_value'] )) {
            $discount_value = $this->request->get['discount_value'];
        } else {
            $discount_value = 0;
        }
        if ( isset( $this->request->get['full_url'] )) {
            $full_url = $this->request->get['full_url'];
        } else {
            $full_url = false;
        }
        if ( isset( $this->request->get['count'] )) {
            $count = $this->request->get['count'];
        } else {
            $count = 0;
        }

        $start = 0;
        $limit = 1000;
        $n = 0;

        $products = $this->model_module_export_manager_p->getProducts( $data_get->config[0]->manufacturers, $data_get->config[0]->categories, $data_get->config[0]->priceRange, $discount_id, $discount_value, $full_url, $start, $limit );

        $this->load->model('catalog/product');

        $xmlWriter = new XMLWriter();
        $xmlWriter->openMemory();
        $xmlWriter->setIndent(true);
        $xmlWriter->startDocument( '1.0', 'UTF-8' );
        $xmlWriter->startElement( $model_name );

        if( $data_get->config[0]->expiration[0]->nodename != '' ) {
            $xmlWriter->writeElement( $data_get->config[0]->expiration[0]->nodename, $data_get->config[0]->expiration[0]->nodevalue );
        };

        if( $discount_id != 1 ) {} else {
            $xmlWriter->writeElement( $data_get->config[0]->discount[0]->nodename, $data_get->config[0]->discount[0]->percent );
        };

        for( $i = 0; $i < $count - 1; $i++ ) {

            foreach( $data_get->model as $model ) {

                foreach( $model as $obj ) {

                    if( $obj->type == 'node' ) {

                        $this->nodeCreate( $xmlWriter, $obj->nodename, $products[$n][$obj->name] );
                    }

                    else if( $obj->type == 'subnode' ) {

                        $xmlWriter->startElement( $obj->name );

                        foreach( $obj->columns as $k => $v ) {
                            foreach( $v as $j => $item ) {
                                if( $item->type != 'node' ) {
                                    $this->subnodeCreate( $xmlWriter, $v[$j], $products[$n], $full_url );
                                } else {

                                    if( $item->name == 'attribute_group' ) {
                                        $attributes = $this->model_catalog_product->getProductAttributes( $products[$n]['product_id'] );
                                        $group = array();

                                        foreach( $attributes as $attribute ) {
                                            $attribute_group_id = $this->model_module_export_manager_p->getProductAttributeGroupID( $attribute['attribute_id'] );
                                            $attribute_group = $this->model_catalog_attribute_group->getAttributeGroupDescriptions( $attribute_group_id['attribute_group_id'] );
                                            array_push( $group, $attribute_group[1]['name'] );
                                        }
                                        $this->nodeCreate( $xmlWriter, $item->nodename, json_encode($group) );

                                    } elseif( $item->name == 'attribute_name' ) {
                                        $attributes = $this->model_catalog_product->getProductAttributes( $products[$n]['product_id'] );
                                        $group = array();
                                        foreach( $attributes as $attribute ) {
                                            $attribute_name = $this->model_catalog_attribute->getAttributeDescriptions( $attribute['attribute_id'] );
                                            array_push( $group, $attribute_name[1]['name'] );
                                            //$this->log->debug($attribute_name[1]['name']);
                                        }
                                        $this->nodeCreate( $xmlWriter, $item->nodename, json_encode($group) );

                                    } elseif( $item->name == 'attribute_value' ) {
                                        $attributes = $this->model_catalog_product->getProductAttributes( $products[$n]['product_id'] );
                                        $group = array();
                                        foreach( $attributes as $attribute ) {
                                            //$this->log->debug($attribute['product_attribute_description']);
                                            foreach( $attribute['product_attribute_description'] as $text ) {
                                                //$this->log->debug($text['text']);
                                                array_push( $group, $text['text'] );
                                            }

                                            //$this->log->debug($attribute_name[1]['name']);
                                        }
                                        $this->nodeCreate( $xmlWriter, $item->nodename, json_encode($group) );

                                    } elseif( $item->name == 'thumbs' ) {

                                        $thumbs = $this->model_catalog_product->getProductImages( $products[$n]['product_id'] );

                                        if( $full_url != 'false' ) {
                                            foreach( $thumbs as $thumb ) {
                                                $url = HTTP_CATALOG . $thumb['image'];
                                                $this->nodeCreate( $xmlWriter, $item->nodename, $url );
                                            }
                                        } else {
                                            foreach( $thumbs as $thumb ) {
                                                $this->nodeCreate( $xmlWriter, $item->nodename, $thumb['image'] );
                                            }
                                        }
                                    } elseif( $item->name == 'special_price' || $item->name == 'special_price_date_start' || $item->name == 'special_price_date_end' ) {
                                        $special    = false;
                                        $start      = '0000-00-00';
                                        $end        = '0000-00-00';

                                        $product_specials = $this->model_catalog_product->getProductSpecials( $products[$n]['product_id'] );

                                        foreach ( $product_specials  as $product_special ) {
                                            if ( ( $product_special[ 'date_start' ] == '0000-00-00' || strtotime( $product_special[ 'date_start' ]) < time() ) && ( $product_special[ 'date_end' ] == '0000-00-00' || strtotime( $product_special[ 'date_end' ]) > time() )) {
                                                $special = $product_special['price'];
                                                $start   = $product_special['date_start'];
                                                $end     = $product_special['date_end'];
                                                break;
                                            }
                                        }
                                        if( $item->name == 'special_price' ) {
                                            if( $special == false ) {
                                                $this->nodeCreate( $xmlWriter, $item->nodename, $products[$n]['price'] );
                                            } else {
                                                $this->nodeCreate( $xmlWriter, $item->nodename, $special );
                                            }
                                        } elseif( $item->name == 'special_price_date_start' ) {
                                            $this->nodeCreate( $xmlWriter, $item->nodename, $start );
                                        } elseif( $item->name == 'special_price_date_end' ) {
                                            $this->nodeCreate( $xmlWriter, $item->nodename, $end );
                                        }


                                    } elseif( $item->name == 'manufacturer' ) {
                                        $manufacturer = $this->model_module_export_manager_p->getManufacturer( $products[$n]['manufacturer_id'] );
                                        $this->nodeCreate( $xmlWriter, $item->nodename, $manufacturer );
                                    } else {
                                        $this->nodeCreate( $xmlWriter, $item->nodename, $products[$n][$item->name] );
                                    }
                                }
                            }
                        }
                        $xmlWriter->endElement();
                    }
                }
            }
            $n++;

            if ( $i == $limit ) {
                $bytes_xml = file_put_contents( DIR_SYSTEM . 'storage/download/export_manager/xml/' . $model_name . '.xml', $xmlWriter->flush(true), FILE_APPEND );

                $start = $limit;
                $limit = $limit + 1000;
                $n = 0;

                $products = $this->model_module_export_manager_p->getProducts( $data_get->config[0]->manufacturers, $data_get->config[0]->categories, $data_get->config[0]->priceRange, $discount_id, $discount_value, $full_url, $start, $limit );
            }
        }

        $xmlWriter->endElement();

        $bytes_xml = file_put_contents( DIR_SYSTEM . 'storage/download/export_manager/xml/' . $model_name . '.xml', $xmlWriter->flush(true), FILE_APPEND );

        if( $bytes_xml === false ) {
            $bytes_xml = 'error';
        } else {
            $bytes_xml = 'success';
        }

        $this->response->setOutput( json_encode( $bytes_xml ));
        //$this->response->setOutput( $bytes_xml / 1048576 );
    }

    private function nodeCreate( $xml, $element, $value ) {
        $xml->writeElement( $element, $value );
    }

    private function subnodeCreate( $xml, $obj, $value, $full_url ) {
        $xml->startElement( $obj->name );

        foreach( $obj->columns as $k => $v ) {
            foreach( $v as $n => $item ) {
                if( $item->type != 'node' ) {
                    $this->subnodeCreate( $xml, $v[$n], $value, $full_url );
                } else {
                    if( $item->name == 'thumbs' ) {

                        $thumbs = $this->model_catalog_product->getProductImages( $value['product_id'] );

                        if( $full_url != 'false' ) {
                            foreach( $thumbs as $thumb ) {
                                $url = HTTP_CATALOG . $thumb['image'];
                                $this->nodeCreate( $xml, $item->nodename, $url );
                            }
                        } else {
                            foreach( $thumbs as $thumb ) {
                                $this->nodeCreate( $xml, $item->nodename, $thumb['image'] );
                            }
                        }
                    } elseif( $item->name == 'special_price' || $item->name == 'special_price_date_start' || $item->name == 'special_price_date_end' ) {
                        $special    = false;
                        $start      = '0000-00-00';
                        $end        = '0000-00-00';

                        $product_specials = $this->model_catalog_product->getProductSpecials( $value['product_id'] );

                        foreach ( $product_specials  as $product_special ) {
                            if ( ( $product_special[ 'date_start' ] == '0000-00-00' || strtotime( $product_special[ 'date_start' ]) < time() ) && ( $product_special[ 'date_end' ] == '0000-00-00' || strtotime( $product_special[ 'date_end' ]) > time() )) {
                                $special = $product_special['price'];
                                $start   = $product_special['date_start'];
                                $end     = $product_special['date_end'];
                                break;
                            }
                        }
                        if( $item->name == 'special_price' ) {
                            if( $special == false ) {
                                $this->nodeCreate( $xml, $item->nodename, $value['price'] );
                            } else {
                                $this->nodeCreate( $xml, $item->nodename, $special );
                            }
                        } elseif( $item->name == 'special_price_date_start' ) {
                            $this->nodeCreate( $xml, $item->nodename, $start );
                        } elseif( $item->name == 'special_price_date_end' ) {
                            $this->nodeCreate( $xml, $item->nodename, $end );
                        }


                    } elseif( $item->name == 'manufacturer' ) {
                        $manufacturer = $this->model_module_export_manager_p->getManufacturer( $value['manufacturer_id'] );
                        $this->nodeCreate( $xml, $item->nodename, $manufacturer );
                    } else {
                        $this->nodeCreate( $xml, $item->nodename, $value[$item->name] );
                    }
                }
            }
        }
        $xml->endElement();
    }
}
?>