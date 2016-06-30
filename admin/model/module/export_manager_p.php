<?php
class ModelModuleExportManagerP extends Model {

    public function getModels() {
        $sql  = "SELECT * FROM " . DB_PREFIX . "xml_export_model";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getCategories() {
        $sql  = "SELECT * FROM " . DB_PREFIX . "category_description cd WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getManufacturers() {
        $sql  = "SELECT * FROM " . DB_PREFIX . "manufacturer ";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getManufacturer( $id ) {
        $sql  = "SELECT m.name FROM " . DB_PREFIX . "manufacturer m WHERE m.manufacturer_id = " . $id;
        $query = $this->db->query($sql);
        return $query->row['name'];
    }

    public function getProductList( $manufacturers, $categories, $priceRange, $start, $limit ) {

        $sql = "SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_category pc ON (p.product_id = pc.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

        foreach( $manufacturers as $manu ) {
            if( empty( $manu )) {
                //return;
            } else {
                $sql .= " AND (";
                foreach( $manu as $k => $m_id ) {

                    $sql .= "p.manufacturer_id = '" . (int)$m_id->id . "' OR ";
                }
                $sql = substr( $sql, 0, -4 );
                $sql .= ")";
            }
        }

        foreach( $categories as $cat ) {
            if( empty( $cat )) {
                //return;
            } else {
                $sql .= " AND (";
                foreach( $cat as $k => $c_id ) {

                    $sql .= "pc.category_id = '" . (int)$c_id->id . "' OR ";
                }
                $sql = substr( $sql, 0, -4 );
                $sql .= ")";
            }
        }

        if( $priceRange[0]->hi > 0 &&  $priceRange[0]->low > 0 ) {
            $sql .= " AND p.price <= '" . (int)$priceRange[0]->hi . "'";
            $sql .= " AND p.price >= '" . (int)$priceRange[0]->low . "'";
        }

        $sql .= " GROUP BY p.product_id";
        $sql .= " ORDER BY pd.name";
        $sql .= " LIMIT " . $start . "," . $limit;

        $query = $this->db->query( $sql );
        return $query->rows;
    }

    public function getProductListCount( $manufacturers, $categories, $priceRange ) {
        $product_data = array();

        $sql = "SELECT COUNT(DISTINCT p.product_id) AS total, p.price, p.manufacturer_id, pc.category_id, pd.name FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_category pc ON (p.product_id = pc.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

        foreach( $manufacturers as $manu ) {
            if( empty( $manu )) {
                //return;
            } else {
                $sql .= " AND (";
                foreach( $manu as $k => $m_id ) {

                    $sql .= "p.manufacturer_id = '" . (int)$m_id->id . "' OR ";
                }
                $sql = substr( $sql, 0, -4 );
                $sql .= ")";
            }
        }

        foreach( $categories as $cat ) {
            if( empty( $cat )) {
                //return;
            } else {
                $sql .= " AND (";
                foreach( $cat as $k => $c_id ) {

                    $sql .= "pc.category_id = '" . (int)$c_id->id . "' OR ";
                }
                $sql = substr( $sql, 0, -4 );
                $sql .= ")";
            }
        }

        if( $priceRange[0]->hi > 0 &&  $priceRange[0]->low > 0 ) {
            $sql .= " AND p.price <= '" . (int)$priceRange[0]->hi . "'";
            $sql .= " AND p.price >= '" . (int)$priceRange[0]->low . "'";
        }

        $sql .= " GROUP BY p.product_id";
        $sql .= " ORDER BY pd.name";

        $query = $this->db->query( $sql );

        foreach ($query->rows as $result) {
            $product_data[] = array(
                'count' => $result['total'],
                'price' => $result['price'],
            );
        }

        return $product_data;
    }

    public function getProducts( $manufacturers, $categories, $priceRange, $discount_id, $discount_value, $full_url, $start, $limit ) {

        $data         = array();
        $thumbs       = array();
        $special      = array();
        $manufacturer = array();

        $product_data       = array();
        $thumbs_data        = array();
        $special_data       = array();
        $manufacturer_data  = array();

        $sql_product = "SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_category pc ON (p.product_id = pc.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

        foreach( $manufacturers as $manu ) {
            if( !empty( $manu )) {
                $sql_product .= " AND (";
                foreach( $manu as $k => $m_id ) {

                    $sql_product .= "p.manufacturer_id = '" . (int)$m_id->id . "' OR ";
                }
                $sql_product = substr( $sql_product, 0, -4 );
                $sql_product .= ")";
            }
        }

        foreach( $categories as $cat ) {
            if( !empty( $cat )) {
                $sql_product .= " AND (";
                foreach( $cat as $k => $c_id ) {

                    $sql_product .= "pc.category_id = '" . (int)$c_id->id . "' OR ";
                }
                $sql_product = substr( $sql_product, 0, -4 );
                $sql_product .= ")";
            }
        }

        if( $priceRange[0]->hi > 0 &&  $priceRange[0]->low > 0 ) {
            $sql_product .= " AND p.price <= '" . (int)$priceRange[0]->hi . "'";
            $sql_product .= " AND p.price >= '" . (int)$priceRange[0]->low . "'";
        }

        $sql_product .= " GROUP BY p.product_id";
        $sql_product .= " ORDER BY pd.name";

        $sql_product .= " LIMIT " . $start . "," . $limit;

        $query_product = $this->db->query($sql_product);

        foreach ($query_product->rows as $result) {

            if( $discount_id == 2 ) {
                $p = $discount_value / 100 * $result['price'];
                $price = $result['price'] - $p;
            } else {
                $price = $result['price'];
            }


            if( $full_url != 'false' ) {
                $url = HTTP_CATALOG . $result['image'];
            } else {
                $url = $result['image'];
            }

            $product_data[] = array(
                'product_id'    => $result['product_id'],
                'product_url'   => HTTP_CATALOG . 'index.php?route=product/product&product_id=' . $result['product_id'],
                'model'         => $result['model'],
                'sku'           => $result['sku'],
                'upc'           => $result['upc'],
                'ean'           => $result['ean'],
                'jan'           => $result['jan'],
                'isbn'          => $result['isbn'],
                'mpn'           => $result['mpn'],
                'quantity'      => $result['quantity'],
                'image'         => $url,
                'price'         => $price,
                'weight'        => $result['weight'],
                'length'        => $result['length'],
                'width'         => $result['width'],
                'height'        => $result['height'],
                'manufacturer_id'=>$result['manufacturer_id'],
                'status'        => $result['status'],
                'name'              => $result['name'],
                'description'       => $result['description'],
                'tag'               => $result['tag'],
                'meta_title'        => $result['meta_title'],
                'meta_description'  => $result['meta_description'],
                'meta_keyword'      => $result['meta_keyword'],
            );
        }
        return $product_data;
    }

    public function getProduct() {
        $data = array();

        $sql  = "SELECT * FROM " . DB_PREFIX . "product LIMIT 1";
        $query = $this->db->query($sql);

        foreach ($query->rows as $result) {
            $data[] = array(
                'product_id'    => $result['product_id'],
                'product_url'   => HTTP_CATALOG . 'index.php?route=product/product&product_id=' . $result['product_id'],
                'model'         => $result['model'],
                'manufacturer'  => $result['manufacturer_id'],
                'sku'           => $result['sku'],
                'upc'           => $result['upc'],
                'ean'           => $result['ean'],
                'jan'           => $result['jan'],
                'isbn'          => $result['isbn'],
                'mpn'           => $result['mpn'],
                'quantity'      => $result['quantity'],
                'image'         => $result['image'],
                'price'         => $result['price'],
                'weight'        => $result['weight'],
                'length'        => $result['length'],
                'width'         => $result['width'],
                'height'        => $result['height'],
                'status'        => $result['status'],
            );
        }
        return $data;
    }

    public function getProductDescription( $id ) {
        $data = array();

        $sql  = "SELECT * FROM " . DB_PREFIX . "product_description pd WHERE pd.product_id = '" . (int)$id . "' LIMIT 1";
        $query = $this->db->query($sql);

        foreach ($query->rows as $result) {
            $data[] = array(
                'name'              => $result['name'],
                'description'       => $result['description'],
                'tag'               => $result['tag'],
                'meta_title'        => $result['meta_title'],
                'meta_description'  => $result['meta_description'],
                'meta_keyword'      => $result['meta_keyword'],
            );
        }
        return $data;
    }

    public function getProductAttributeGroupID( $attribute_id ) {
        $data = array();
        $sql  = "SELECT * FROM " . DB_PREFIX . "attribute a WHERE a.attribute_id = '" . (int)$attribute_id . "' LIMIT 1";
        $query = $this->db->query($sql);

        //$this->log->debug($query->row);

        return $query->row;
    }

    public function getProductThumbs() {
        $data = array();

        $sql  = "SELECT * FROM " . DB_PREFIX . "product_image LIMIT 1";
        $query = $this->db->query($sql);

        foreach ($query->rows as $result) {
            $data[] = array(
                'thumbs' => $result['image'],
            );
        }
        return $data;
    }

    public function getProductSpecial() {
        $data = array();

        $sql  = "SELECT * FROM " . DB_PREFIX . "product_special LIMIT 1";
        $query = $this->db->query($sql);

        foreach ($query->rows as $result) {
            $data[] = array(
                'special_price'               => $result['price'],
                'special_price_date_start'    => $result['date_start'],
                'special_price_date_end'      => $result['date_end'],
            );
        }
        return $data;
    }

    public function storeModel( $name, $model ) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "xml_export_model SET name = '" . $this->db->escape( $name ) . "', data = '" . json_encode($model) . "'");
    }
}
?>