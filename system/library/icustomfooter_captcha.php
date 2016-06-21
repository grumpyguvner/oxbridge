<?php
class Captcha {
	protected $code;
	protected $width = 90;
	protected $height = 40;

	function __construct() { 
		$this->code = strtoupper(preg_replace('/[^a-np-zA-NP-Z2-9]/m', rand(2, 9), substr(sha1(mt_rand()), 16, 6))); 
	}

	function getCode(){
		return $this->code;
	}

	function showImage($escape, $transparent = false) {
		$font_dir = dirname(__FILE__) . '/icustomfooter/';
		
		$font_files = scandir($font_dir);
		
		foreach ($font_files as $index => $file) {
			if (stripos($file, '.ttf') === FALSE) unset($font_files[$index]);
		}
		$font_files = array_values($font_files);
		
        $im = imagecreatetruecolor($this->width, $this->height);
		$escapeColor = imagecolorallocate($im, $escape[0], $escape[1], $escape[2]);
		imagefilledrectangle($im, 0, 0, $this->width, $this->height, $escapeColor);
		if ($transparent) imagecolortransparent($im, $escapeColor);
		
        $width = imagesx($im); 
        $height = imagesy($im);
		
		for ($i = 0; $i < strlen($this->code); $i++) {
			$angle = rand(-21, 21);
			$font = $font_dir . $font_files[rand(0, count($font_files) - 1)];
			$font_size = rand(17, 22);
			
			$c0 = $this->getValidColor($escape[0]);
			$c1 = $this->getValidColor($escape[1]);
			$c2 = $this->getValidColor($escape[2]);
			
			$color = imagecolorallocate($im, $c0, $c1, $c2);
			
			if (function_exists('imagettftext')) {
			   imagettftext($im, $font_size, $angle, 5 + 13 * ($i), rand(22, 33), $color, $font, substr($this->code, $i, 1));
			} else {
			   imagestring($im, 5, 5 + 13 * ($i), rand(11, 22), substr($this->code, $i, 1), $color);
			}
		}
		
		
		imagefilter($im, IMG_FILTER_SMOOTH, 10);
		
		header('Content-type: image/png');
		
		imagepng($im);
		
		imagedestroy($im);		
	}
	
	function getValidColor($escape) {
		$eps = 64;
		$left = $escape - $eps < 0 ? 0 : $escape - $eps;
		$right = $escape + $eps > 255 ? 255 : $escape + $eps;
		$side = rand(0,1);
		
		if ($left == 0) $side = 0;
		if ($right == 255) $side = 1;
		return $side ? rand(0, $left) : rand($right, 255);
	}
}
?>