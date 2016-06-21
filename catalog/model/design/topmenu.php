<?php
class ModelDesignTopmenu extends Model {
	public function getMenu($categories) {

		if (isset($this->request->get['path'])) {
			$parts = explode('_', (string)$this->request->get['path']);
		} else {
			$parts = array();
		}

		$this->load->model('catalog/product');

		$category_html = "<ul class=\"menu\">\n";
		foreach ($categories as $category)	{
			//$name	= $top_cat['name'];
			//$href	= $this->url->link('product/category', 'path=' . $top_cat['category_id']);
			$class	= (isset($category['category_id']) && in_array($category['category_id'], $parts)) ?  " class=\"active\"" : "";
			$category_html .= "<li>\n<a href=\"" . $category['href'] . "\"" . $class . ">" . $category['name'] . "</a>\n";
			$category_html .= $this->getCatTree($category['children'])."\n</li>\n";

		}

		return $category_html."\n</ul>\n";
	} 	

	function getCatTree ($categories)	{
		if (isset($this->request->get['path'])) {
			$parts = explode('_', (string)$this->request->get['path']);
		} else {
			$parts = array();
		}

		$this->load->model('catalog/product');
		$category_data = "";

		foreach ($categories as $category) {
			if (isset($category['category_id'])) {

				$data = array(
					'filter_category_id' => $category['category_id'],
					'filter_sub_category' => true
				);
				$product_total = $this->model_catalog_product->getTotalProducts($data);
				$name = $category['name'];
				$href = $this->url->link('product/category', 'path=' . $category['category_id']);
				$class = in_array($category['category_id'], $parts) ? " class=\"active\"" : "";
				$parent = $this->getCatTree($category['category_id']);
				if ($parent) {
					$class = $class ? " class=\"active\"" : " class=\"parent\"";
				}
				$category_data .= "<li>\n<a href=\"" . $href . "\"" . $class . ">" . $name . "</a>" . $parent . "\n</li>\n";

			} else {
				$name = $category['name'];
				$href = $category['href'];
				$class = "";
				$children = "";
				if (isset($category['children']) && $category['children']) {
					$class = $class ? " class=\"active\"" : " class=\"parent\"";
					$children = $this->getCatTree($category['children']);
				}

				$category_data .= "<li>\n<a href=\"" . $href . "\"" . $class . ">" . $name . "</a>" . $children . "\n</li>\n";
			}


		}

		return strlen($category_data) ? "<ul>\n".$category_data."\n</ul>\n" : "";
	}
}

?>