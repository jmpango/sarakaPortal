<?php
include_once HOME . DS . 'model' . DS . 'buddylocation.php';
include_once HOME . DS . 'model' . DS . 'buddysearchtag.php';
include_once HOME . DS . 'model' . DS . 'mobileusage.php';

class MDashboardService extends BaseDAO{
	var $response = array();

	public function getDashboardsByUpdateDate($lastUpdateDate){
		try {
			$sql = "SELECT * FROM dashboard d WHERE d.date_last_updated >= :updateddate AND d.record_status = 1 ORDER BY d.date_last_updated DESC";
			$stmt = $this->db->prepare ($sql);
			$stmt->bindValue('updateddate', $lastUpdateDate);
			$stmt->execute();
			$results =  $stmt->fetchAll();

			$response["dashboards"] = array();
			if(!empty($results)){
				foreach ($results as $result){
					$dashboard = array();
					$dashboard["id"] = $result['id'];
					$dashboard['dname'] = $result['dname'];
					$dashboard['tagline'] = $result['tagline'];
					array_push($response["dashboards"], $dashboard);
				}
			}

			$sql = "SELECT * FROM dashboard d WHERE d.date_last_updated >= :updateddate AND d.record_status = 0 ORDER BY d.date_last_updated DESC";
			$stmt = $this->db->prepare ($sql);
			$stmt->bindValue('updateddate', $lastUpdateDate);
			$stmt->execute();
			$results =  $stmt->fetchAll();

			$response["deleteDashboard"] = array();
			if(!empty($results)){
				foreach ($results as $result){
					$dashboard = array();
					$dashboard["id"] = $result['id'];
					array_push($response["deleteDashboard"], $dashboard);
				}
			}

			$response["sucess"] = 1;
			$response["lastupdatedate"] = ''.date('Y-m-d H:i:s').'';
			return json_encode($response);

		}catch (PDOException $e){
			$response["sucess"] = 2;
			return json_encode($response);
		}
	}

	public function getDashboardCategoryByUpdateDate($dateupdated){
		try {
			$sql = "SELECT * FROM dashboardcategory d WHERE d.date_last_updated >= :updateddate AND d.record_status = 1 ORDER BY d.date_last_updated DESC";
			$stmt = $this->db->prepare ($sql);
			$stmt->bindValue('updateddate', $dateupdated);
			$stmt->execute();
			$results =  $stmt->fetchAll();

			$response["dashboardCategories"] = array();
			if(!empty($results)){
				foreach ($results as $result){
					$dcategory = array();
					$dcategory["id"] = $result['id'];
					$dcategory['cname'] = $result['cname'];
					$dcategory['dashboard_id'] = $result['dashboard_id'];
					array_push($response["dashboardCategories"], $dcategory);
				}
			}

			$sql = "SELECT * FROM dashboardcategory d WHERE d.date_last_updated >= :updateddate AND d.record_status = 0 ORDER BY d.date_last_updated DESC";
			$stmt = $this->db->prepare ($sql);
			$stmt->bindValue('updateddate', $dateupdated);
			$stmt->execute();
			$results =  $stmt->fetchAll();

			$response["deleteDashboardCategory"] = array();
			if(!empty($results)){
				foreach ($results as $result){
					$dashboardCat = array();
					$dashboardCat["id"] = $result['id'];
					array_push($response["deleteDashboardCategory"], $dashboardCat);
				}
			}

			$response["sucess"] = 1;
			$response["lastupdatedate"] = ''.date('Y-m-d H:i:s').'';
			return json_encode($response);
		}catch (PDOException $e){
			$response["sucess"] = 2;
			return json_encode($response);
		}
	}

	public function getBuddiesByUpdateDate($dateupdated){
		try {
			$sql = "SELECT * FROM buddy d WHERE d.date_last_updated > :updateddate AND d.record_status = 1 ORDER BY d.date_last_updated DESC";
			$stmt = $this->db->prepare ($sql);
			$stmt->bindValue('updateddate', $dateupdated);
			$stmt->execute();
			$results =  $stmt->fetchAll();

			$response["buddies"] = array();
			if(!empty($results)){
				foreach ($results as $result){
					$buddy = array();
					$buddy["id"] = $result['id'];
					$buddy['name'] = $result['name'];
					$buddy['tagline'] = $result['tagline'];
					$buddy['address'] = $result['address'];
					$buddy['telphone'] = $result['telphone'];
					$buddy['email'] = $result['email'];
					$buddy['fax'] = $result['fax'];
					$buddy['url'] = $result['url'];
					$buddy['dashboard_category_id'] = $result['dashboard_category_id'];
					$buddy['seed'] = $result['seed'];
					array_push($response["buddies"], $buddy);
				}
			}


			$sql = "SELECT * FROM buddy d WHERE d.date_last_updated > :updateddate AND d.record_status = 0 ORDER BY d.date_last_updated DESC";
			$stmt = $this->db->prepare ($sql);
			$stmt->bindValue('updateddate', $dateupdated);
			$stmt->execute();
			$results =  $stmt->fetchAll();

			$response["deleteBuddies"] = array();
			if(!empty($results)){
				foreach ($results as $result){
					$buddy = array();
					$buddy["id"] = $result['id'];
					array_push($response["deleteBuddies"], $buddy);
				}
			}


			$response["sucess"] = 1;
			$response["lastupdatedate"] = ''.date('Y-m-d H:i:s').'';
			return json_encode($response);
		}catch (PDOException $e){
			$response["sucess"] = 2;
			return json_encode($response);
		}
	}

	public function getBuddyLocationsByUpdateDate($dateupdated){
		try {
			$sql = "SELECT * FROM buddy_locations l WHERE l.date_last_updated > :updateddate AND l.record_status = 1 ORDER BY l.date_last_updated DESC";
			$stmt = $this->db->prepare ($sql);
			$stmt->bindValue('updateddate', $dateupdated);
			$stmt->execute();
			$results =  $stmt->fetchAll();

			$response["buddylocations"] = array();
			if(!empty($results)){
				foreach ($results as $result){
					$location = array();
					$location["id"] = $result['id'];
					$location['location_name'] = $result['location_name'];
					$location['buddy_id'] = $result['buddy_id'];

					array_push($response["buddylocations"], $location);
				}
			}

			$sql = "SELECT * FROM buddy_locations l WHERE l.date_last_updated > :updateddate AND l.record_status = 0 ORDER BY l.date_last_updated DESC";
			$stmt = $this->db->prepare ($sql);
			$stmt->bindValue('updateddate', $dateupdated);
			$stmt->execute();
			$results =  $stmt->fetchAll();

			$response["deleteBuddylocations"] = array();
			if(!empty($results)){
				foreach ($results as $result){
					$location = array();
					$location["id"] = $result['id'];
					array_push($response["deleteBuddylocations"], $location);
				}
			}



			$response["sucess"] = 1;
			$response["lastupdatedate"] = ''.date('Y-m-d H:i:s').'';
			return json_encode($response);
		}catch (PDOException $e){
			$response["sucess"] = 2;
			return json_encode($response);
		}
	}

	public function getBuddySearchTagByUpdateDate($dateupdated){
		try {
			$sql = "SELECT * FROM buddy_search_tags s WHERE s.date_last_updated > :updateddate AND s.record_status = 1 ORDER BY s.date_last_updated DESC";
			$stmt = $this->db->prepare ($sql);
			$stmt->bindValue('updateddate', $dateupdated);
			$stmt->execute();
			$results =  $stmt->fetchAll();

			$response["buddysearchtags"] = array();
			if(!empty($results)){
				foreach ($results as $result){
					$searchtag = array();
					$searchtag["id"] = $result['id'];
					$searchtag['search_value'] = $result['search_value'];
					$searchtag['buddy_id'] = $result['buddy_id'];

					array_push($response["buddysearchtags"], $searchtag);
				}
			}

			$sql = "SELECT * FROM buddy_search_tags s WHERE s.date_last_updated > :updateddate AND s.record_status = 0 ORDER BY s.date_last_updated DESC";
			$stmt = $this->db->prepare ($sql);
			$stmt->bindValue('updateddate', $dateupdated);
			$stmt->execute();
			$results =  $stmt->fetchAll();

			$response["deleteBuddysearchtags"] = array();
			if(!empty($results)){
				foreach ($results as $result){
					$searchtag = array();
					$searchtag["id"] = $result['id'];
					array_push($response["deleteBuddysearchtags"], $searchtag);
				}
			}

			$response["sucess"] = 1;
			$response["lastupdatedate"] = ''.date('Y-m-d H:i:s').'';
			return json_encode($response);
		}catch (PDOException $e){
			$response["sucess"] = 2;
			return json_encode($response);
		}
	}

	public function saveMobileUsage($hits){
		$arr = json_decode($hits, true);
		$usages = array();

		foreach ($arr['usages'] as $element) {
			$usage = new MobileUsage();

			$usage->setDateupdated(date('Y-m-d H:i:s'));
			$usage->setPageHit((int)$element['pageHit']);
			$usage->setCallHit((int)$element['callHit']);
			$usage->setUrlHit((int)$element['urlHit']);
			$usage->setEmailHit((int)$element['emailHit']);
			$usage->setRateHit((int)$element['rateHit']);
			$usage->setCommentHit((int)$element['commentHit']);
			$usage->setBuddyId((int)$element['buddyId']);

			array_push($usages, $usage);
		}

		$comments = array();

		foreach ($arr['comments'] as $element) {
			$comment = new BuddyComment();

			$comment->setPostedDate($element['postedDate']);
			$comment->setAuthor($element['owner']);
			$comment->setComment($element['comment']);
			$comment->setBuddyId($element['buddyId']);

			array_push($comments, $comment);
		}

		$rates = array();

		foreach ($arr['rates'] as $element) {
			$rate = new BuddyRate();

			$rate->setCurrentRate((int)$element['rate']);
			$rate->setBuddyId($element['buddyId']);

			array_push($rates, $rate);
		}


		try {
			$this->insertUsageData($usages);
			$this->insertCommentData($comments);
			$this->insertRateData($rates);

			$response["sucess"] = 1;
			return json_encode($response);
		}catch (PDOException $e){
			$response["sucess"] = $e;
			return json_encode($response);
		}
	}

	public function insertUsageData($usages){
		try {
			foreach ($usages as $usage){
				$month = date("m", strtotime($usage->getDateupdated()));
				$year =  date("Y", strtotime($usage->getDateupdated()));

				$sql = "SELECT * FROM buddy_usage u WHERE month(u.submitted_date) = :submitedMonth AND year(u.submitted_date) = :submittedYear AND u.buddy_id = :buddyId";
				$stmt = $this->db->prepare ($sql);
				$stmt->bindValue('submitedMonth', $month);
				$stmt->bindValue('submittedYear', $year);
				$stmt->bindValue('buddyId', $usage->buddyId);
				$stmt->execute();
				$result =  $stmt->fetch();

				if(!empty($result)){
					$existingUsage = new MobileUsage();
					$existingUsage->pageHit = (int)$result['page_hits'] + $usage->pageHit;
					$existingUsage->callHit = (int)$result['call_hits'] + $usage->callHit;
					$existingUsage->urlHit = (int)$result['url_hits'] + $usage->urlHit;
					$existingUsage->emailHit = (int)$result['email_hits'] + $usage->emailHit;
					$existingUsage->commentHit = (int)$result['comment_hits'] + $usage->commentHit;
					$existingUsage->rateHit = (int)$result['rate_hits'] + $usage->rateHit;

					$sql = "UPDATE buddy_usage set page_hits=:pagehit, call_hits=:callhit, url_hits=:urlhit, email_hits=:emailhit, comment_hits=:commenthit, rate_hits=:ratehit WHERE month(submitted_date)=:submitedMonth AND year(submitted_date)=:submittedYear AND buddy_id=:buddyId";
					$stmt = $this->db->prepare ($sql);
					$stmt->bindValue('pagehit', $existingUsage->pageHit);
					$stmt->bindValue('callhit', $existingUsage->callHit);
					$stmt->bindValue('urlhit', $existingUsage->urlHit);
					$stmt->bindValue('emailhit', $existingUsage->emailHit);
					$stmt->bindValue('ratehit', $existingUsage->rateHit);
					$stmt->bindValue('commenthit', $existingUsage->commentHit);
					$stmt->bindValue('submitedMonth', $month);
					$stmt->bindValue('submittedYear', $year);
					$stmt->bindValue('buddyId', $existingUsage->buddyId);
					$stmt->execute();

				}else{
					$sql = "INSERT INTO buddy_usage(page_hits, call_hits, url_hits, email_hits, comment_hits, rate_hits, submitted_date, buddy_id) VALUES(:pagehits, :callhits, :urlhits, :emailhits, :commentHits, :rateHits, :submittedDate, :buddyId)";
					$stmt = $this->db->prepare ($sql);
					$stmt->bindValue("pagehits", $usage->pageHit, PDO::PARAM_STR );
					$stmt->bindValue("callhits", $usage->callHit, PDO::PARAM_STR );
					$stmt->bindValue("urlhits", $usage->urlHit, PDO::PARAM_STR );
					$stmt->bindValue("emailhits", $usage->emailHit, PDO::PARAM_STR );
					$stmt->bindValue('ratehits', $usage->rateHit, PDO::PARAM_STR );
					$stmt->bindValue('commenthits', $usage->commentHit, PDO::PARAM_STR );
					$stmt->bindValue("submittedDate", $usage->dateupdated, PDO::PARAM_STR );
					$stmt->bindValue("buddyId", $usage->buddyId, PDO::PARAM_STR );
					$stmt->execute();
				}
			}
		}catch (PDOException $e){
			return new CustomException($e);
		}
	}

	public function insertCommentData($comments){
		try {
			if(!empty($comments)){
				foreach ($comments as $comment){
					$sql = "INSERT INTO buddy_comments(date_submitted, comment, author_name, buddy_id) VALUES(:datePosted, :comment, :author, :buddyId)";
					$stmt = $this->db->prepare ($sql);
					$stmt->bindValue("datePosted", $comment->postedDate, PDO::PARAM_STR );
					$stmt->bindValue("comment", $comment->comment, PDO::PARAM_STR );
					$stmt->bindValue("author", $comment->author, PDO::PARAM_STR );
					$stmt->bindValue("buddyId", $comment->buddyId, PDO::PARAM_STR );
					$stmt->execute();
				}
			}
		}catch (PDOException $e){
			return new CustomException($e);
		}
	}

	/**
	 * Responsible to insert mobile sent ratings
	 * @param Comments $comments
	 * @return CustomException
	 */
	public function insertRateData($rates){
		try {
			if(!empty($rates)){
				foreach ($rates as $rate){
						
					$sql = "SELECT * FROM buddy_ratings u WHERE u.buddy_id = :buddyId";
					$stmt = $this->db->prepare ($sql);
					$stmt->bindValue('buddyId', $rate->buddyId);
					$stmt->execute();
					$result =  $stmt->fetch();
						
					if(!empty($result)){
						$existingRate = new BuddyRate();
						$existingRate->prvRate = (int)$result['current_rate'];
						
						$sql = "UPDATE buddy_ratings set prv_rate=:prvrate, current_rate=:currentrate WHERE buddy_id=:buddyId";
						$stmt = $this->db->prepare ($sql);
						$stmt->bindValue('prvrate', (int)$existingRate->prvRate, PDO::PARAM_STR);
						$stmt->bindValue('currentrate', (int)$rate->currentRate, PDO::PARAM_STR);
						$stmt->bindValue('buddyId', $rate->buddyId, PDO::PARAM_STR);
						$stmt->execute();
							
					}else{
						$sql = "INSERT INTO buddy_ratings(prv_rate, current_rate, buddy_id) VALUES(:prvrate, :currentrate, :buddyId)";
						$stmt = $this->db->prepare ($sql);
						$rate->pageHit = 0 ;
						$stmt->bindValue("prvrate", $rate->pageHit, PDO::PARAM_STR );
						$stmt->bindValue("currentrate", $rate->currentRate, PDO::PARAM_STR );
						$stmt->bindValue("buddyId", $rate->buddyId, PDO::PARAM_STR );
						$stmt->execute();
					}
						
				}
			}
		}catch (PDOException $e){
			return new CustomException($e);
		}
	}
}
?>