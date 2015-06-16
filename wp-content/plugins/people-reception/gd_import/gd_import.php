<?php
if(!class_exists('GD_Import'))
{
	class GD_Import
	{	
		const BILL_URL	= 'http://www.duma.gov.ru/systems/law/?deputy=99110214';
		const TRANSCRIPT_URL = 'http://www.cir.ru/duma/servlet/is4.wwwmain?FormName=ProcessQuery&Action=RunQuery&PDCList=*&QueryString=%2FGD_%C4%C5%CF%D3%D2%C0%D2%3D%22%CE%C1%D3%D5%CE%C2+%D1.%CF.%22';

		public function __construct()
		{
			//add_action('gd_import', array(&$this, 'bills_import'));
		}

		private function get_bill_list($content) {
			$data = array();
			preg_match_all('/<div class="search-block-result.*?">(.+?)<\/div>\s+<\/div>/isu', $content, $entry);
			for ($j = 0; $j < count($entry[1]); $j++) {
				$number = (preg_match('/<h3><.+>(\S+).+?<\/a><\/h3>/ui', $entry[1][$j], $matches)) ? $matches[1] : '';
				$title = (preg_match('/<h3><.+>\S+\s(.+?)<\/a><\/h3>/ui', $entry[1][$j], $matches)) ? $matches[1] : '';
				$url = (preg_match('/<h3><a href="(.+?)".+?<\/a><\/h3>/ui', $entry[1][$j], $matches)) ? $matches[1] : '';
				$pub_date = (preg_match('/Дата внесения в ГД:<\/b>\s?(.+?)</ui', $entry[1][$j], $matches)) ? $matches[1] : '';
				$pub_date = strtotime(str_ireplace(
												array('года', 'января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'),
												array('', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'),
												$pub_date));

				$data[$number]  = array(
					'number' => $number,
					'title' => $title,
					'url' => urldecode(html_entity_decode($url)),
					'pub_date' => $pub_date);
			}
			return $data;
		}

		public function get_bills($limit=20) {
			try {
				$page_content = @file_get_contents(GD_Import::BILL_URL);
			} catch (Exception $e) {
				$page_content = '';
			}

			if ($page_content) {
				return self::get_bill_list($page_content);
			}
		}

		public function bills_import() {
			// Получаем новые законопроекты с интернет-сайт ГД ФС РФ
			$bills = $this->get_bills();

			foreach ($bills as $bill) {
				// Проверяем существует ли законопроекты уже в нашей базе
				$posts_array = get_posts(array(
				'post_type' => Bill::POST_TYPE,
				'meta_query' => array(
						array(
						'key' => 'bill_number',
						'value' => $bill['number'],
						'compare' => '='
						)
					)
				));
				//print '<p>'.$bill['number'].' '.count($posts_array).'</p>';

				if (count($posts_array) == 0) {
					// Если нет законопроекта с таким номером, то добавляем
					//print '<p>insert</p>';
					$post = array(
						'post_type'		=> Bill::POST_TYPE,
						'post_title'	=> $bill['title'],
						'post_date'		=> date("Y-m-d H:i:s", $bill['pub_date']),
						'post_name'		=> $bill['number'],
						'post_excerpt'	=> '',
						'post_content'	=> '',
						'post_status'	=> 'publish',
					);  
					$ID = wp_insert_post($post, true);
					//print '<p>'.$ID.'</p>';
					add_post_meta($ID, 'bill_number', $bill['number'], true );
					add_post_meta($ID, 'bill_date', date('Ymd', $bill['pub_date']), true );
					add_post_meta($ID, 'bill_duma_url', $bill['url'], true );
					//break;
				}
			}
		}
	}
}
?>