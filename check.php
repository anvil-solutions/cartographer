<?php
  //error_reporting(E_ALL);
  header('Content-Type: application/json; charset=utf-8');
  if (!isset($_POST['url'])) {
    echo '[]';
    exit;
  }
  if (substr($_POST['url'], 0, 7) !== 'http://' && substr($_POST['url'], 0, 8) !== 'https://') $_POST['url'] = 'http://'.$_POST['url'];
  if (substr($_POST['url'], -1) !== '/') $_POST['url'] .= '/';
  $_POST['url'] .= 'sitemap.xml';

  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $_POST['url']);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
  $file = curl_exec($curl);
  $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
  curl_close($curl);
  if ($http_status < 200 || $http_status > 299) {
    echo '[]';
    exit;
  }

  $result = [];
  $sitemap = new SimpleXMLElement($file);

  foreach ($sitemap as $entry) {
    $url = ((array)$entry->loc)[0];
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    $file = curl_exec($curl);
    $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    if ($http_status > 199 && $http_status < 300) {
      $doc = new DOMDocument();
      $doc->loadHTML($file);

      $description = null;
      $nodeList = $doc->getElementsByTagName('meta');
      foreach($nodeList as $node) {
        if ($node->attributes->getNamedItem('name') !== null && $node->attributes->getNamedItem('name')->value === 'description') {
          $description = $node->attributes->getNamedItem('content')->value;
          break;
        }
      }

      array_push(
        $result,
        [
          'url' => $url,
          'title' => $doc->getElementsByTagName('title')->item(0)->nodeValue,
          'description' => $description
        ]
      );
    } else {
      array_push(
        $result,
        ['url' => $url]
      );
    }
  }

  usort($result, function ($a, $b) {
    return $a['url'] <=> $b['url'];
  });

  echo json_encode($result);
?>
