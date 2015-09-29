import java.util.List;
import java.util.Map;

import net.sf.json.JSONArray;
import net.sf.json.JSONObject;

public class Controller {
	public Ret process(Map request) throws Exception {	
		if(!request.containsKey("op")) throw new Exception("pls input correct params!");
		String cmd = request.get("op").toString();
		if (cmd.equalsIgnoreCase("get")) {
			return getMemberInfo(request);
		}
		else if (cmd.equalsIgnoreCase("in")) {
			 checkin(request);
			 return getMemberInfo(request);
		}
		else if (cmd.equalsIgnoreCase("out")) {
			 checkout(request);
			 return getMemberInfo(request);
		}

		else if (cmd.equalsIgnoreCase("query")) {
			 return query(request);
		}
		else if (cmd.equalsIgnoreCase("check")) {
			 return check(request);
		}
		else if (cmd.equalsIgnoreCase("find")) {
			 return find(request);
		}
		else if (cmd.equalsIgnoreCase("bind")) {
			 return bind(request);
		}
		throw new Exception("pls input correct params!");
	}

	public Ret getMemberInfo(Map<String,String> obj) throws Exception {
		String memberid = obj.get("no");
		String clubid=obj.get("clubid");
		Ret info = Service.getInstance().getMemberInfo(memberid,clubid);		 
		return info;
	}
	
	public void checkin(Map<String,String> obj) throws Exception {
		String memberid = obj.get("no");
		String clubid=obj.get("clubid");
		Service.getInstance().checkIn(memberid,clubid);
		
	}
	
	public void checkout(Map<String,String>  obj) throws Exception {
		String memberid = obj.get("no");
		String clubid=obj.get("clubid");
		Service.getInstance().checkOut(memberid,clubid);
	}
	
	
	public Ret query(Map<String,String>  obj) throws Exception {
		String mobile = obj.get("mobile");
		String clubid=obj.get("clubid");		 
		Ret info = Service.getInstance().query(mobile,clubid);		 
		return info;
	}
	
	public Ret find(Map<String,String>  obj) throws Exception {
		String mobile = obj.containsKey("mobile")?obj.get("mobile"):null;
		String clubid=obj.containsKey("clubid")?obj.get("clubid"):null;
		String no=obj.containsKey("no")?obj.get("no"):null;
		String name=obj.containsKey("name")?obj.get("name"):null;
		String offset=obj.containsKey("offset")?obj.get("offset"):"0";
		String num=obj.containsKey("num")?obj.get("num"):"20";
		Ret ret = Service.getInstance().find(mobile,clubid,no,name,offset,num);		 
		return ret;
	}

	public Ret bind(Map<String,String>  obj) throws Exception {
		String mobile,no,name;
		try
		{
			 mobile = obj.get("mobile");		
			 no=obj.get("no");
			 name=obj.get("name");
		}catch(Exception ex)
		{
			throw new Exception("miss params!");
		}
		Ret ret = Service.getInstance().bind(mobile,no,name);		 
		return ret;
	}
	
	public Ret check(Map<String,String>  obj) throws Exception {
		String cardid = obj.get("card");
		String time=obj.get("time");
		boolean busy = Service.getInstance().check(cardid,time);	
		Ret ret = new Ret();
		JSONObject rsp = new JSONObject();
		rsp.put("busy", busy?"0":"1");
		ret.setRes(rsp);
		return ret;
	}
}
