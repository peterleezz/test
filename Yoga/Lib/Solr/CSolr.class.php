<?php
namespace Lib\Solr;
require_once dirname(__FILE__) . '/Service.php'; 
/**
 * @package service
 *
 */
class CSolr {
	protected $solrhost;
	protected $port;

	public function __construct($solrConfigName = 'solrServer') {  
		$config = C($solrConfigName);
		$this->solrhost = $config['host'];
		$this->port = $config['port'];
	}

	/**
	 *
	 * search by solr server
	 * @param string $solrCoreName
	 * @param string $query
	 * @param string $sort
	 * @param int $limit
	 * @param int $num
	 *
	 * @return array | false
	 */
	public function search($solrCoreName,$query,$offset,$limit,$params = array()){
		$solrServer = new \Apache_Solr_Service($this->solrhost,$this->port, '/solr/'.$solrCoreName);

		$response = $solrServer->search( $query, $offset, $limit,$params);

		if ($response->getHttpStatus() == 200) {
			return $response->response;

		}else{
			return false;
		}
	}

}
?>
