<?php
namespace Shopkeeper\Controller;
use Common\Controller\BaseController;
use Service\ClassService;
class ClassController extends BaseController {
	public function indexAction()
	{
		$rooms = D("ClubClassroom")->getRooms(get_club_id());
		$pt = D("User")->getPt(get_club_id());
		$this->rooms=$rooms;
		$this->teachers=$pt;
		$this->display();
	}

	public function  editAction()
	{
		$data=I("data");
		$data=htmlspecialchars_decode($data); 
		$data=json_decode($data,true);
		$model=D("ClubSchedule");
		 
		$now = date('Y-m-d H:i:s');
		$valid_data=array();
		foreach ($data as $key => $value) {
			$start =date('Y-m-d H:i:s', strtotime($value['start']));
			if($start < $now)
			{
				continue; 
			}  
			$end =date('Y-m-d H:i:s', strtotime($value['end'])); 
			$value['start']=$start;
			$value['end']=$end;
			$valid_data[]=$value;
		}
	 	$start = date('Y-m-d H:i:s', strtotime(I('start')));
	 	$end= date('Y-m-d H:i:s', strtotime(I('end')));
	 	if($start < $now)$start=$now;
	 	$club_id=get_club_id();
	 	$model->where(array("club_id"=>$club_id, "start"=>array("between",array($start,$end))))->delete();
	 	$valid_data=array_unique_2d($valid_data);
		foreach ($valid_data as $key => $value) {
			if(!$model->create($value))
			{
				$this->error($model->getError());
			}

			$id = $model->add();  
		}
		  
		 
		$this->ajaxReturn(array("status"=>1,"info"=>"修改成功！"));
	}

	 public function queryAction()
	 {
	 	$club_id=get_club_id();
	 	$pts=D("User")->getPt();
	 	$arr=array();
	 	foreach ($pts as $key => $value) {
	 		$arr[]=$value['id'];
	 	}
		 list($page,$sidx,$limit,$sord,$start)=getRequestParams();
			$model = D("PtClassPublic"); 
			if(!empty($arr))
			$condition = array("pt_id"=>array("in",$arr)); 
			$condition[]=array("club_id"=>$club_id);
			$condition['_logic']='or';
			$map['_complex'] = $condition; 
			 $filters=I("filters",'','');
			 $filters = json_decode($filters);  
			 if($filters->groupOp=='AND')
	        {
	            $rules = $filters->rules; 
	            foreach ($rules as $key => $value) { 
	                if($value->field=="name")
	                {
	                	$v = $value->data; 
	                	$map = array_merge($map,array("_string"=>"name like '%{$v}%' or teacher_name like '%$v%'") );
	                    // $map = array_merge($map,array("name"=>array("like","%{$value->data}%")) );
	                }
	                 
	            }
	        }  
 
			$ret = $model->where($map)->order("$sidx $sord")->limit("$start,$limit")->select(); 
 
			foreach ($ret as $key => $value) {
				if(!empty($value['teacher_name']))
				{
					$ret[$key]['teacher']=$value['teacher_name'];
				}
				else
				{
					$teacher=M("UserExtension")->find($value['pt_id']);
					$ret[$key]['teacher']=$teacher['name_cn'];
				}
				
			}
			$count = $model->where($map)->count();	 
			if( $count > 0 && $limit > 0) { 
              $total_pages = ceil($count/$limit); 
			} else { 
			              $total_pages = 0; 
			} 	
			$response = array("page"=>$page,"total"=>$total_pages,"records"=>$count,"rows"=>$ret);
			$this->ajaxReturn($response); 
	 }

	public function getjsonAction()
	{ 
		$start=I("start");
	    $start=date('Y-m',$start+7*24*3600);
	    $start_time=$start."-01";
	    $end_time=$start."-31";
	    $condition=array("club_id"=>get_club_id()); 
	    $classes=D("ClubSchedule")->relation(true)->where($condition)->select();  
	     $arr=array();
	    foreach ($classes as $key => $value) {
	    	$arr[]=array("pt_id"=>$value['pt_id'], "title"=>$value['class']['name']."(".$value['class']['teacher_name'].")". '--'.$value['room']['name'],"start"=>$this->getTime($value['start']) ,"end"=>$this->getTime($value['end']),"allDay"=>false,  "id"=>$value['id'],
	    		"interval"=>$value['class']['time'],"room"=>$value['room']['name'],"name"=>$value['class']['name'],"room_id"=>$value['room_id'],"class_id"=>$value['class_id']);
	    }
	     $this->ajaxReturn(($arr));
	}

	private function getTime($time)
	{
		$timenew =  date(DATE_ISO8601,strtotime($time));
		return $timenew;
	}
	public function editoneAction()
	{
		$id = I("id");
		$now = date('Y-m-d H:i:s');
		$start = date('Y-m-d H:i:s', strtotime(I('start')));
		$end= date('Y-m-d H:i:s', strtotime(I('end')));
		$model=D("ClubSchedule");
		if($start < $now)$start=$now;
		 	$club_id=get_club_id(); 
		if(empty($id))
		{  
		    if(!$model->create())
				{
					$this->error($model->getError());
				}
			$model->start = $start;
			$model->end = $end;
			$id = $model->add();  
		}
		else
		{
			if(!$model->create())
				{
					$this->error($model->getError());
				}
			$model->start = $start;
			$model->end = $end;
			$id = $model->save();  
		}
			$this->ajaxReturn(array("status"=>1,"info"=>"修改成功！"));
	}
	function delAction($id)
 	{
 		M("ClubSchedule")->delete($id);
 		 $this->ajaxReturn(array("status"=>1,"info"=>"修改成功！"));
 	}

}