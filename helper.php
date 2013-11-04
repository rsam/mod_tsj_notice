<?php 
defined('_JEXEC') or die;

require_once (JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_content'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'route.php');

class TSJ_Notice {
		
	public function getParams()
	{
		$params = array();

		$db	=& JFactory::getDBO();
		
		$db->setQuery( "SELECT cfg_value FROM #__tsj_cfg WHERE cfg_name = 'water_notice_first';" );
		$row =& $db->loadResult();
		// Проверка на ошибки
		if (!$result = $db->query()) {
			//echo $this->db->stderr();
			return false;
		}
		$params['water_notice_first'] = $row;
		
		$db->setQuery( "SELECT cfg_value FROM #__tsj_cfg WHERE cfg_name = 'water_notice_second';" );
		$row =& $db->loadResult();
		// Проверка на ошибки
		if (!$result = $db->query()) {
			//echo $this->db->stderr();
			return false;
		}
		$params['water_notice_second'] = $row;
		
		$db->setQuery( "SELECT cfg_value FROM #__tsj_cfg WHERE cfg_name = 'water_notice_third';" );
		$row =& $db->loadResult();
		// Проверка на ошибки
		if (!$result = $db->query()) {
			//echo $this->db->stderr();
			return false;
		}
		$params['water_notice_third'] = $row;
		
		$db->setQuery( "SELECT cfg_value FROM #__tsj_cfg WHERE cfg_name = 'gaz_notice_first';" );
		$row =& $db->loadResult();
		// Проверка на ошибки
		if (!$result = $db->query()) {
			//echo $this->db->stderr();
			return false;
		}
		$params['gaz_notice_first'] = $row;
		
		$db->setQuery( "SELECT cfg_value FROM #__tsj_cfg WHERE cfg_name = 'gaz_notice_second';" );
		$row =& $db->loadResult();
		// Проверка на ошибки
		if (!$result = $db->query()) {
			//echo $this->db->stderr();
			return false;
		}
		$params['gaz_notice_second'] = $row;
		
		$db->setQuery( "SELECT cfg_value FROM #__tsj_cfg WHERE cfg_name = 'gaz_notice_third';" );
		$row =& $db->loadResult();
		// Проверка на ошибки
		if (!$result = $db->query()) {
			//echo $this->db->stderr();
			return false;
		}
		$params['gaz_notice_third'] = $row;
		
		$db->setQuery( "SELECT cfg_value FROM #__tsj_cfg WHERE cfg_name = 'electro_notice_first';" );
		$row =& $db->loadResult();
		// Проверка на ошибки
		if (!$result = $db->query()) {
			//echo $this->db->stderr();
			return false;
		}
		$params['electro_notice_first'] = $row;
		
		$db->setQuery( "SELECT cfg_value FROM #__tsj_cfg WHERE cfg_name = 'electro_notice_second';" );
		$row =& $db->loadResult();
		// Проверка на ошибки
		if (!$result = $db->query()) {
			//echo $this->db->stderr();
			return false;
		}
		$params['electro_notice_second'] = $row;
		
		$db->setQuery( "SELECT cfg_value FROM #__tsj_cfg WHERE cfg_name = 'electro_notice_third';" );
		$row =& $db->loadResult();
		// Проверка на ошибки
		if (!$result = $db->query()) {
			//echo $this->db->stderr();
			return false;
		}
		$params['electro_notice_third'] = $row;
		
		// Общие параметры
		$db->setQuery( "SELECT cfg_value FROM #__tsj_cfg WHERE cfg_name = 'water_on';" );
		$row =& $db->loadResult();
		if (!$result = $db->query()) {
			//echo $this->db->stderr();
			return false;
		}
		$params['water_on'] = $row;
		
		$db->setQuery( "SELECT cfg_value FROM #__tsj_cfg WHERE cfg_name = 'gaz_on';" );
		$row =& $db->loadResult();
		if (!$result = $db->query()) {
			//echo $this->db->stderr();
			return false;
		}
		$params['gaz_on'] = $row;
		
		$db->setQuery( "SELECT cfg_value FROM #__tsj_cfg WHERE cfg_name = 'electro_on';" );
		$row =& $db->loadResult();
		if (!$result = $db->query()) {
			//echo $this->db->stderr();
			return false;
		}
		$params['electro_on'] = $row;
		
	return $params;
	}
	
	public function getWaterCounterData()
	{
		$db	=& JFactory::getDBO();
		
		// Чтение user id из таблицы User
		$user = &JFactory::getUser();

		$userid = $user->get('id');
		if($userid == null) $userid = 0;
		
		// Получаем даты поверки счетчиков конкретного пользователя
			$sql = " SELECT t1.office_counter_id, t2.user_id,
                        t1.counts AS wcounts,
                        t1.water_name_1, DATE_FORMAT( t1.date_in_hot_p1, '%m.%d.%Y' ) AS date_in_hot_pp1 , t1.ser_num_hot_p1 AS ser_num_hot_pp1,
                                         DATE_FORMAT( t1.date_in_cold_p1, '%m.%d.%Y' ) AS date_in_cold_pp1, t1.ser_num_cold_p1 AS ser_num_cold_pp1,
                        t1.water_name_2, DATE_FORMAT( t1.date_in_hot_p2, '%m.%d.%Y' ) AS date_in_hot_pp2, t1.ser_num_hot_p2 AS ser_num_hot_pp2,
                                         DATE_FORMAT( t1.date_in_cold_p2, '%m.%d.%Y' ) AS date_in_cold_pp2, t1.ser_num_cold_p2 AS ser_num_cold_pp2,
                        t1.water_name_3, DATE_FORMAT( t1.date_in_hot_p3, '%m.%d.%Y' ) AS date_in_hot_pp3, t1.ser_num_hot_p3 AS ser_num_hot_pp3,
                                         DATE_FORMAT( t1.date_in_cold_p3, '%m.%d.%Y' ) AS date_in_cold_pp3, t1.ser_num_cold_p3 AS ser_num_cold_pp3
                  FROM #__tsj_water_office t1
                  INNER JOIN #__tsj_account t2 ON t1.account_id = t2.account_id AND t2.user_id ='" . $userid . "'" .
                " GROUP BY t1.office_counter_id DESC limit 1;";

			// Выполнение запроса в базу данных и получения списка строк соответствующих запросу row
			$db->setQuery( $sql );
			$row =& $db->loadObject();
			//print_r($row);
			//$this->office_counter_id = $row->office_counter_id;
			//echo $office_counter_id;

			// Проверка на ошибки
			if (!$result = $db->query()) {
				//echo $this->db->stderr();
				return false;
			}

			if (empty($row))
			{
				return NULL;
			}

		return $row;
	}
	
	public function getGazCounterData()
	{
		$db	=& JFactory::getDBO();
		
		// Чтение user id из таблицы User
		$user = &JFactory::getUser();

		$userid = $user->get('id');
		if($userid == null) $userid = 0;
		
		// Получаем даты поверки счетчиков конкретного пользователя
			$sql = " SELECT t1.office_counter_id, t2.user_id,
                        t1.counts AS wcounts,
                        t1.gaz_name_1, DATE_FORMAT( t1.date_in_p1, '%m.%d.%Y' ) AS date_in_pp1, t1.ser_num_p1 AS ser_num_pp1,
                        t1.gaz_name_2, DATE_FORMAT( t1.date_in_p2, '%m.%d.%Y' ) AS date_in_pp2, t1.ser_num_p2 AS ser_num_pp2,
                        t1.gaz_name_3, DATE_FORMAT( t1.date_in_p3, '%m.%d.%Y' ) AS date_in_pp3, t1.ser_num_p3 AS ser_num_pp3
                  FROM #__tsj_gaz_office t1
                  INNER JOIN #__tsj_account t2 ON t1.account_id = t2.account_id AND t2.user_id ='" . $userid . "'" .
                " GROUP BY t1.office_counter_id DESC limit 1;";

			// Выполнение запроса в базу данных и получения списка строк соответствующих запросу row
			$db->setQuery( $sql );
			$row =& $db->loadObject();
			//print_r($row);
			//$this->office_counter_id = $row->office_counter_id;
			//echo $office_counter_id;

			// Проверка на ошибки
			if (!$result = $db->query()) {
				//echo $this->db->stderr();
				return false;
			}

			if (empty($row))
			{
				return NULL;
			}

		return $row;
	}
	
	public function getElectroCounterData()
	{
		$db	=& JFactory::getDBO();
		
		// Чтение user id из таблицы User
		$user = &JFactory::getUser();

		$userid = $user->get('id');
		if($userid == null) $userid = 0;
		
		// Получаем даты поверки счетчиков конкретного пользователя
			$sql = " SELECT t1.office_counter_id, t2.user_id,
                        t1.counts AS wcounts,
                        t1.electro_name_1, DATE_FORMAT( t1.date_in_p1, '%m.%d.%Y' ) AS date_in_pp1, t1.ser_num_p1 AS ser_num_pp1,
                        t1.electro_name_2, DATE_FORMAT( t1.date_in_p2, '%m.%d.%Y' ) AS date_in_pp2, t1.ser_num_p2 AS ser_num_pp2,
                        t1.electro_name_3, DATE_FORMAT( t1.date_in_p3, '%m.%d.%Y' ) AS date_in_pp3, t1.ser_num_p3 AS ser_num_pp3
                  FROM #__tsj_electro_office t1
                  INNER JOIN #__tsj_account t2 ON t1.account_id = t2.account_id AND t2.user_id ='" . $userid . "'" .
                " GROUP BY t1.office_counter_id DESC limit 1;";

			// Выполнение запроса в базу данных и получения списка строк соответствующих запросу row
			$db->setQuery( $sql );
			$row =& $db->loadObject();
			//print_r($row);
			//$this->office_counter_id = $row->office_counter_id;
			//echo $office_counter_id;

			// Проверка на ошибки
			if (!$result = $db->query()) {
				//echo $this->db->stderr();
				return false;
			}

			if (empty($row))
			{
				return NULL;
			}

		return $row;
	}
}

?>