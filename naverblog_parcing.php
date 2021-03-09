<?php	
	function readHtmlFile($url) {
		$info = parse_url($url);					   
		$host = $info["host"];
		$port = $info["port"];
		if ($port == 0) $port = 80;
	 
   
		$path = $info["path"];
		if ($info["query"] != "") $path .= "?" . $info["query"];
		$out = "GET $path HTTP/1.0\r\nHost: $host\r\n\r\n";
		$fp = fsockopen($host, $port, $errno, $errstr, 30);
		if (!$fp) {
			echo "$errstr ($errno) <br>\n";
				}
	   
			else {
				
				fputs($fp, $out);
				$start = false;
				$retVal = "";
	   
				while(!feof($fp)) {
					$tmp = fgets($fp, 1024);
					if ($start == true) $retVal .= $tmp;
					if ($tmp == "\r\n") $start = true;
				}								   
				fclose($fp);
				// echo $retVal;
				return $retVal;
			}
		}
		// 파싱할 네이버 블로그 주소 입력
		$xml_string = "파싱할 블로그 주소";

		$xmlstr = readHtmlFile($xml_string);
		$xml = simplexml_load_string(trim($xmlstr));
 
	// 파싱할 블로그 글 개수 제한
	for ($i=0;$i<5;$i++) {
		// 블로그 글 제목에 링크 달기
		echo '<li><a
		href="'.$xml->channel->item[$i]->link . '">';
		// 블로그 글 제목
		echo '<span class="txt">'.$xml->channel->item[$i]->title . '</span>';
		// 블로그 글 작성 날짜 -> pubDate 형식
		$pubDate = $xml->channel->item[$i]->pubDate . "</span>";
		// Y.m.d : 21.02.03 형식으로 날짜 바꿔주기
		$splitDate = substr($pubDate,5,11);
		echo '<span class="date">'.$newDate = date('Y.m.d', strtotime($splitDate)) .'</span></a></li>';
		}
?>