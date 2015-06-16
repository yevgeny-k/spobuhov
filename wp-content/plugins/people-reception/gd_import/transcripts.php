<?php
if(!class_exists('GD_Import_Transcripts'))
{
	class GD_Import_Transcripts
	{	
		const TRANSCRIPT_URL = 'http://www.cir.ru/duma/servlet/is4.wwwmain?FormName=ProcessQuery&Action=RunQuery&PDCList=*&QueryString=%2FGD_%C4%C5%CF%D3%D2%C0%D2%3D%22%CE%C1%D3%D5%CE%C2+%D1.%CF.%22';

		public function __construct()
		{
			add_action('gd_import', array(&$this, 'transcripts_import'));
		}

		private function get_transcripts_list($content, $domain='http://www.cir.ru') {
			$data = array();
			preg_match_all('/<div class="stenogram-result-item.*?">(.+?)<\/div>\s+<\/div>/isu', $content, $entry);
			for ($j = 0; $j < count($entry[1]); $j++) {
				$number = (preg_match('/\d+\/(\d+)\?QueryID/ui', $entry[1][$j], $matches)) ? $matches[1] : '';
				$desc = (preg_match('/<p>(.+?)<\/p>/ui', $entry[1][$j], $matches)) ? trim(str_replace(' ', ' ', strip_tags(html_entity_decode($matches[1])))) : '';
				$url = (preg_match('/<a href="(.+?)\?/ui', $entry[1][$j], $matches)) ? $matches[1] : '';
				$pub_date = (preg_match('/<a.+?>.+?(\d{2}\.\d{2}\.\d{4}).+?<\/a>/ui', $entry[1][$j], $matches)) ? strtotime($matches[1]) : '';

				$data[$number]  = array(
					'number' => $number,
					'description' => $desc,
					'url' => $domain . $url,
					'pub_date' => $pub_date);
			}
			return $data;
		}

		public function get_transcripts($page=0) {
			try {
				// Отключаем переходы redirect
				$aHTTP['http']['method']          = 'GET';
				$aHTTP['http']['follow_location'] = 0;
				$context = stream_context_create($aHTTP);
				@file_get_contents(self::TRANSCRIPT_URL, false, $context);

				// Получаем куки и redirect
				$redirect_url = str_ireplace('Location: ', '', $http_response_header[5]);				
				$cookie = str_ireplace(array('Set-Cookie: ', ';Path=/'), array('', ''), $http_response_header[6]);
				$aHTTP['http']['header'] = "Cookie: " . $cookie;
				$context = stream_context_create($aHTTP);
				$page_content = @file_get_contents($redirect_url, false, $context); // .'&ShowMax=50&Page=2'
				$page_content = iconv('windows-1251', 'utf-8', $page_content);
			} catch (Exception $e) {
				$page_content = '';
			}

			if ($page_content) {
				return self::get_transcripts_list($page_content);
			}
		}

		public function transcripts_import() {			
			// Получаем новые стенограммы с интернет-сайт ГД ФС РФ
			$transcripts = $this->get_transcripts();

			foreach ($transcripts as $transcript) {
				// Проверяем существует ли стенограммы уже в нашей базе
				$posts_array = get_posts(array(
				'post_type' => Transcript::POST_TYPE,
				'meta_query' => array(
						array(
						'key' => 'transcript_duma_id',
						'value' => $transcript['number'],
						'compare' => '='
						)
					)
				));

				if (count($posts_array) == 0) {
					//Если нет стенограммы с таким номером, то добавляем
					$post = array(
						'post_type'		=> Transcript::POST_TYPE,
						'post_title'	=> 'Стенограмма №'.$transcript['number'].' от '.date("d.m.Y", $transcript['pub_date']),
						'post_date'		=> date("Y-m-d H:i:s", $transcript['pub_date']),
						'post_name'		=> $transcript['number'],
						'post_excerpt'	=> '',
						'post_content'	=> $transcript['description'],
						'post_status'	=> 'publish',
					);  
					$ID = wp_insert_post($post, true);
					add_post_meta($ID, 'transcript_duma_id', $transcript['number'], true );
					add_post_meta($ID, 'transcript_date', date('Ymd', $transcript['pub_date']), true );
					add_post_meta($ID, 'transcript_duma_url', $transcript['url'], true );
				}
			}
		}
	}
}
?>