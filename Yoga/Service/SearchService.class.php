<?php 
namespace Service;
use Lib\Solr\CSolr;
class SearchService extends CService { 
    protected $solr;   
    public function search($solrCoreName, $query, $offset, $limit, $params = array(), $solrConfigName = 'solrServer') {
        $this->solr = new CSolr($solrConfigName); 
       	$queryId = microtime();  
        $resp = $this->solr->search($solrCoreName, $query, $offset, $limit, $params); 
        return $resp;
    }
 
    public function searchDoc($solrCoreName, $query, $offset, $limit, $params = array()) {
        $this->solr = new CSolr();
       	$queryId = microtime(); 
        $resp = $this->solr->search($solrCoreName, $query, $offset, $limit, $params); 
        if ($resp) {
            $ids = array();
            $numFound = $resp->numFound;
            if ($numFound > 0) {
                foreach ($resp->docs as $doc) {
                    $ids[] = $doc->id;
                }
                return array($ids, $numFound);
            }
        } else {
            return false;
        }
    }
   
    public function searchClub($query,$offset,$limit)
    {
         $params = array();
        $resp = $this->search('yoga_club', $query, $offset, $limit, $params);
        if ($resp) {
            $ids = array();
            $numFound = $resp->numFound;
            if ($numFound > 0) {
                foreach ($resp->docs as $doc) {
                    $ids[] = $doc->id;
                }  
            }
             return $ids;
        } else {
            return false;
        }
    }

    public function searchClub($query,$offset,$limit)
    {
         $params = array();
        $resp = $this->search('yoga_member', $query, $offset, $limit, $params);
        if ($resp) {
            $ids = array();
            $numFound = $resp->numFound;
            if ($numFound > 0) {
                foreach ($resp->docs as $doc) {
                    $ids[] = $doc->id;
                }  
            }
             return $ids;
        } else {
            return false;
        }
    }
    
    public function searchNearClub($query, $lat, $lon, $distance, $offset, $limit) {
        if (!$lat || !$lon) {
            return false;
        }
        $params = array(); 
        $pt = $lat . ',' . $lon;
        // $params['fq'] = "{!geofilt pt={$pt} sfield=store_lat_lng d={$distance}}";
        $params['fq'] = "{!geofilt}";
        $params['sfield'] = "store_lat_lng";
        $params['pt'] = $pt;
        $params['d'] = $distance;
        $params['sort'] = "geodist() asc"; 
        $resp = $this->search('yoga_club', $query, $offset, $limit, $params); 
        if ($resp) {
            $ids = array();
            $numFound = $resp->numFound;
            if ($numFound > 0) {
                foreach ($resp->docs as $doc) {
                    $ids[] = $doc->id;
                }  
            }
             return $ids;
        } else {
            return false;
        }

    } 
}