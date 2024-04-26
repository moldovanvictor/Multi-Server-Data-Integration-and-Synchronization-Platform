<!-- <?php
$html = file_get_contents('http://localhost:4000/date.php');

$dom = new DOMDocument;
libxml_use_internal_errors(true); 
$dom->loadHTML($html);
libxml_clear_errors();

$xpath = new DOMXPath($dom);
$script_tags = $xpath->query('//script[@type="application/ld+json"]');

$json_data = $script_tags->item(0)->nodeValue;

$data = json_decode($json_data, true);

print_r($data);
?> -->
