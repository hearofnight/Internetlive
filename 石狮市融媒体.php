
<?php
#抓取地方台官网的直播源m3u8，当天能用，隔天就失效了，源地址带key，每次抓取都不一样，这个怎么解，每天替换也是很麻烦的。https://live.chinashishi.net/ssxwzh/playlist.m3u8?auth_key=1708168223-0-0-905a7236cd6673032b15ed294e9ae43d
header("Content-type:text/json;charset=utf-8");

$header = array(
  'Referer: https://www.chinashishi.net/',
  'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.4951.64 Safari/537.36',
);

$data = get_data('https://mapi--chinashishi--net--0107mpr3abd0f.wsipv6.com/api/v1/program.php?&zone=0&channel_id=12',$header);

foreach (json_decode($data) as $m3u8){
  if(strpos($m3u8->m3u8,'playlist') !== false){
    $playurl = $m3u8->m3u8;
    break;
  }
}

header('Location:'.$playurl);

function get_data($url,$header){
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
  $data = curl_exec($ch);
  curl_close($ch);
  return $data;
}
