import java.sql.Timestamp;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import java.util.SortedMap;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

import javax.servlet.jsp.jstl.sql.Result;

import net.sf.json.JSONObject;

public class Service {
	public static void main(String[] args) throws Exception {
		Main main = new Main();
 System.out.println("2015-01-01 00:00:00.0".replaceAll("\\s.*", ""));
		 Service.getInstance().test();
 
 
	}
	
	private DBInstance db;

	public Service() {
		db = new DBInstance(System.getProperty("db.drivers"),
				System.getProperty("db.url"),
				System.getProperty("db.username"),
				System.getProperty("db.password"));
	}

	public void test() {
		Map[]maps=(queryMemberCard("","1002","","李","11","20"));
		for(Map map:maps)
		{
			System.out.println(map);
		}
	}

	public Map getOneMap(Result rs) {
		for (SortedMap item : rs.getRows()) {
			return item;
		}
		return null;
	}

	public Map[] getMaps(Result rs) {
		return rs.getRows();
	}

	public static Service getInstance() {
		return InstanceHelper.instance;
	}

	private static class InstanceHelper {
		private static Service instance = new Service();
	}

	public boolean check(String cardid,String time) throws Exception
	{
		if(empty(cardid))
		{
			throw new Exception("please input cardid!");
		}
		if(empty(time))
		{
			throw new Exception("please input time!");
		}
		long lt=Long.parseLong(time)*1000;
		Calendar cal = Calendar.getInstance();
		cal.setTimeInMillis(lt);
		Map card=getMemberCard(cardid);
		return checkBusy(card,cal);
	}
	
	private Map orgs=new HashMap<String,String>();
	private Map<String ,String >getAllOrgName()
	{
		String sql="select OrgName,OrgID from DBOrg";
		Result rs=db.executeQuery(sql);
		Map[]maps=getMaps(rs);
		Map ret=new HashMap<String,String>();
		for(Map map:maps)
		{
			ret.put(map.get("OrgID").toString(), map.get("OrgName").toString());
		}
		return ret;
	}
	
	private Map cardType=new HashMap<String,Map>();
	private Map<String ,Map >getAllCardType()
	{
		String sql="select * from DBCardType";
		Result rs=db.executeQuery(sql);
		Map[]maps=getMaps(rs);
		Map ret=new HashMap<String,Map>();
		for(Map map:maps)
		{
			ret.put(map.get("CardTypeId").toString(), map);
		}
		return ret;
	}
	private Map getCardType(String cardId)
	{
		if(!cardType.containsKey(cardId))
			cardType=getAllCardType();
		return (Map) cardType.get(cardId);
	}
	
	
	private String getOrgName(String id)
	{
		if(!orgs.containsKey(id))
			orgs=getAllOrgName();
		return orgs.get(id).toString();
	}
	/**
	 * 电话约课查询
	 * 
	 * @param mobile
	 * @param clubid
	 * @throws Exception 
	 */
	public Ret  query(String mobile, String clubid) throws Exception {
		if(empty(mobile))
		{
			throw new Exception("please input mobile!");
		}
		if(empty(clubid))
		{
			throw new Exception("please input clubid!");
		}
		Ret ret = new Ret();
		Map[] records = queryFromMemberAnd(mobile,null,null);
		List<MemberInfo> list = new ArrayList<MemberInfo>();
		for (Map record : records) {
			Map[] cards = getAllCardBymemberid(record.get("memberid").toString());
//			for (Map card : cards) {
//				try {
//					Ret mi = getMemberInfo(card.get("membercard")
//							.toString(), clubid);
//					if(mi.getStatus()==0)
//					{
//						list.add((MemberInfo) mi.getRes());
//						break;
//					}
//					
//				} catch (Exception ex) {
//
//				}
//			}
			
			if(cards!=null)
				for (int i=0;i<cards.length;i++) {
					Map card =cards[i];
					try {
						Ret mi = getMemberInfo(card.get("membercard")
								.toString(), clubid);
						if(mi.getStatus()==0)
						{
							list.add((MemberInfo) mi.getRes());
							break;
						}
						else if(i==cards.length-1)
						{
							list.add((MemberInfo) mi.getRes());						 
						}
						
					} catch (Exception ex) {

					}
				}
		}
		ret.setRes(list);
		return ret;
	}
	
	private Map[] queryMemberCard(String mobile,String clubid,String no,String name,String offset,String num)
	{
		String sql = "select memberid from StarMember ";
		String condition=" where 1=0 ";
		if (mobile!=null && !mobile.trim().equals("")) {
			condition = condition + " or MemberPhone='" + mobile + "'";
		}
		
		if (no!=null && !no.trim().equals("")) {
			condition = condition + " or MemberIDCard='" + no + "'";
		}
		if (name!=null && !name.trim().equals("")) {
			condition = condition + " or MemberName like '%" + name + "%'";
		}	
		sql=sql+condition;
//		if(!offset.endsWith("0"))
//			sql=sql+" and MemberID not in (select top "+offset+" MemberID from StarMember "+condition+")";
//	    sql="select distinct top "+num+"  membercard from starmembercard where useshop='"+clubid+"' and memberid in ("+sql+")";
		
		 sql="select  top "+num+" * from starmembercard where useshop='"+clubid+"' and memberid in ("+sql+")  and membercard not in ("+"select distinct top "+offset+" membercard from starmembercard where useshop='"+clubid+"' and memberid in ("+sql+"))";
	    Result rs = db.executeQuery(sql);
		return getMaps(rs);
	}
	
	public Ret find(String mobile,String clubid,String no,String name,String offset,String num) {
		Ret ret = new Ret();
		long start=System.currentTimeMillis();
		Map[] cards = queryMemberCard(mobile,clubid,no,name,offset,num);
		System.out.println("xxx--query:"+(System.currentTimeMillis()-start));start=System.currentTimeMillis();
		Map<String, MemberInfo> list= new  HashMap<String,MemberInfo>();
			if(cards!=null)
				for (int i=0;i<cards.length;i++) {
					Map card =cards[i];
					try {
						String cardid=card.get("membercard")
								.toString(); 
						MemberInfo info = new MemberInfo();
						info.setCard_id(cardid);
						 
						if (!checkClubid(card, clubid)) {
							info.setErr(
									"cardid do exist,but can not be used this shop!");
							info.setStatus(2);
						}
						if (!checkValid(card)) {
							info.setErr("invalid!");
							info.setCard_status(0);
							info.setStatus(3);
						}
						if (!checkExpired(card)) {
							info.setErr("expired card,or not active!");
							info.setExpired(1);
							info.setStatus(4);
						}
						if (!checkTimes(card)) {
							info.setCard_has_num(0);
							info.setErr("times out!");
							info.setStatus(5);
						}
						if (!checkBusy(card,null)) {
							info.setErr("busy time!");
							info.setCard_busy(1);
							info.setStatus(6);
						}
						
						
						String memberid = card.get("MemberID").toString();
						String sql = "select * from StarMember where MemberID=?";
						Result rs = db.executeQuery(sql, memberid);
						Map member = getOneMap(rs);
						 
						info.setId_number(member.get("MemberIDCard").toString());
						info.setClub_id(card.get("SaleShop").toString());
						info.setClub_name(getOrgName(card.get("SaleShop").toString()));
						info.setClub_ids(card.get("UseShop").toString());
						info.setTimes(card.get("CountNum").toString());
						info.setCometimes(card.get("CheckinAmount").toString());
						info.setEndtime(card.get("EndDate").toString().replaceAll("\\s.*",""));
						info.setNo(cardid);
						info.setGender(member.get("MemberSex").toString().equals("1") ? "female"
								: "male");
						info.setName(member.get("MemberName").toString());
						info.setTel(member.get("MemberPhone").toString());
						String face = member.containsKey("MemberPhoto") &&   member.get("MemberPhoto")!=null? "http://114.80.208.206:8995/images/memberphoto/"
								+ member.get("MemberPhoto").toString()
								+ "?p="
								+ System.currentTimeMillis()
								: "http://114.80.208.206:8995/images/noimg.gif";
						info.setFace(face);
						SimpleDateFormat sdf = new SimpleDateFormat("yyyyMMdd");
						SimpleDateFormat sdf1 = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss.S");
						if(member.get("MemberBirthday")!=null)
						info.setBirthday(sdf.format(sdf1.parse(member.get("MemberBirthday")
								.toString())));
						info.setCardtype(card.get("isnumcard").toString().equals("1") ? "次数卡"
								: "时间卡");
						info.setLeft(card.get("isnumcard").toString().equals("1") ? ((Integer) card
								.get("CountNum") - (Integer) card.get("CheckinAmount") + "")
								: "-1");
						info.setMstatus(isCheckin(cardid) ? "in" : "out");
						 
						if(list.containsKey(memberid))
						{
							MemberInfo old=list.get(memberid);
							if(old.getStatus()==0)continue;
							else if(old.getStatus()!=0 && info.getStatus()==0)list.put(memberid, info);
							else if(old.getStatus()!=0 && info.getStatus()!=0)
							{								
								if( old.getEndtime().compareTo(info.getEndtime())<0 )
								{
									list.put(memberid, info);
								}
								else
								{
									continue;
								}
							}
						}
						else
						{
							list.put(memberid, info);
						}
						
					} catch (Exception ex) {
						ex.printStackTrace();
					}
				}
		List<MemberInfo> members=new ArrayList<MemberInfo> ();
		for(Map.Entry<String, MemberInfo> entry:list.entrySet())
		 {
			members.add(entry.getValue());
		 }
		System.out.println("xxx--querydetail:"+(System.currentTimeMillis()-start));start=System.currentTimeMillis();
		ret.setRes(members);
		return ret;
	}

	public Ret bind(String mobile,String no,String name) throws Exception {
		Ret ret = new Ret();
		Map[] records = queryFromMemberAnd(mobile,no,name);
		List<JSONObject> list = new ArrayList<JSONObject>();
		for (Map record : records) {
			Map[] cards = getAllCardBymemberid(record.get("memberid").toString());
			for (Map card : cards) {
				 JSONObject obj=new JSONObject();
				 obj.put("card_id", card.get("MemberCard").toString());
				 obj.put("club_id", card.get("UseShop").toString());
				 list.add(obj);
			}
		}
		ret.setRes(list);
		return ret;
	}
	
	public void checkIn(String cardid, String clubid) throws Exception {
		if(empty(cardid))
		{
			throw new Exception("please input cardid!");
		}
		if(empty(clubid))
		{
			throw new Exception("please input clubid!");
		}
		Ret mi = getMemberInfo(cardid, clubid);
		if(mi.getStatus()==-1)
		{
			throw new Exception(mi.getErr());
		}
		// 看今天有没有过checkin,没有的话，次数+1;
		SimpleDateFormat sdf = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss.S");
		String sql = "select  * from StarBook where MemberCardNo=? and CheckInTime > ?";
		Calendar cal = Calendar.getInstance();
		cal.set(Calendar.HOUR_OF_DAY, 0);
		cal.set(Calendar.MINUTE, 0);
		cal.set(Calendar.SECOND, 0);
		Result rs = db.executeQuery(sql, cardid, sdf.format(cal.getTime()));
		Map map = getOneMap(rs);
		if (map == null) {
			Map card = getMemberCard(cardid);
			sql = "update StarMemberCard  set CheckinAmount=CheckinAmount+1 where ID=?";
			db.execute(sql, card.get("ID").toString());
		}

		sql = "select * from StarMemberCard where membercard=? order by StartDate desc";
		rs = db.executeQuery(sql, cardid);
		map = getOneMap(rs);
		sql = "insert into StarBook(BookID,BookType,OrgID,MemberID,MemberCardNo,MemberCardId,IsSocietyfriend,CabinetNo,CheckInTime,CheckOutTime,IsCheckOut,GuestName,GuestIDCard,Deposit,ShouldPay,RealPay,OperatorIn,OperatorOut,MainCard) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
		// id 自己算，算个不重复的出来...艹
		String id = System.currentTimeMillis() + "-"
				+ Math.round(Math.random() * 10000);

		db.execute(sql, id, 1, clubid, map.get("MemberID").toString(), cardid,
				map.get("ID"), 0, "", sdf.format(new Date()), null, 0, null,
				null, "卡号:[" + cardid + "]", 0, 0, null, null, 1);
	}

	public void checkOut(String cardid, String clubid) throws Exception {
		if(empty(cardid))
		{
			throw new Exception("please input cardid!");
		}
		if(empty(clubid))
		{
			throw new Exception("please input clubid!");
		}
		
		SimpleDateFormat sdf = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss.S");
		String time = sdf.format(new Date());
		String sql = "update  StarBook set CheckOutTime=? ,IsCheckOut=1 where bookid in (select top 1 bookid from StarBook where MemberCardNo=? and OrgID=? order by CheckInTime desc)";
		db.execute(sql, time, cardid, clubid);
	}

	
	/**
	 * 尼玛一张卡可能有两条记录...  那就根据时间查！如果有合适的就返回第一个合适的，如果没有就返回最后一张卡。
	 * @param cardid
	 * @return
	 * @throws ParseException 
	 */
	public Map getMemberCard(String cardid) throws ParseException {
		String sql = "select StarMemberCard.*,DBOrg.OrgName from StarMemberCard,DBOrg where DBOrg.OrgID=StarMemberCard.SaleShop and membercard=? order by StartDate";
		Result rs = db.executeQuery(sql, cardid);
		Map[] map = getMaps(rs);
		System.out.println(map.length);
		if(map==null || map.length==0) return null;
		for(Map value:map)
		{
			System.out.println(value.toString());
			if (checkValid(value) && checkExpired(value) && checkTimes(value)) {
				System.out.println("check passed"+value.toString());
				return value;
			}
			
		}
		System.out.println("all fucking invalid!");
		return map[map.length-1];
	}

	public Map[] queryFromMemberOr(String mobile,String no,String name,String offset,String num) {
		String sql = "select top "+num+" memberid from StarMember ";
		String condition=" where 1=0 ";
		if (mobile!=null && !mobile.trim().equals("")) {
			condition = condition + " or MemberPhone='" + mobile + "'";
		}
		
		if (no!=null && !no.trim().equals("")) {
			condition = condition + " or MemberIDCard='" + no + "'";
		}
		if (name!=null && !name.trim().equals("")) {
			condition = condition + " or MemberName like '%" + name + "%'";
		}		
		
		sql=sql+condition+" and MemberID not in (select top "+offset+" MemberID from StarMember "+condition+")";
		Result rs = db.executeQuery(sql);
		return getMaps(rs);
	}
	
	private boolean empty(String value)
	{
		return value==null || value.trim().equals("");
	}
	public Map[] queryFromMemberAnd(String mobile,String no,String name) throws Exception {
		String sql = "select * from StarMember where 1=1 ";
		if(empty(mobile) && empty(no) && empty(name))
		{
			throw new Exception("pls input 1 param at least!!");
		}
		if (mobile!=null && !mobile.trim().equals("")) {
			sql = sql + " and MemberPhone='" + mobile + "'";
		}
		
		if (no!=null && !no.trim().equals("")) {
			sql = sql + " and MemberIDCard='" + no + "'";
		}
		if (name!=null && !name.trim().equals("")) {
			sql = sql + " and MemberName='" + name + "'";
		}		
		
		Result rs = db.executeQuery(sql);
		return getMaps(rs);
	}

	public Ret getMemberInfo(String cardid, String clubid)
			throws Exception {
		if (cardid == null || cardid.trim().equals(""))
			return null;
		Map map = getMemberCard(cardid);
		MemberInfo info = new MemberInfo();
		info.setCard_id(cardid);
		Ret ret = new Ret();
		if (map == null)
		{
			ret.setErr("this card does not exist!");
			info.setStatus(1);
			return ret;	
		}
		
		if (!checkClubid(map, clubid)) {
			ret.setErr(
					"cardid do exist,but can not be used this shop!");
			info.setStatus(2);
		}
		if (!checkValid(map)) {
			ret.setErr("invalid!");
			info.setCard_status(0);
			info.setStatus(3);
		}
		if (!checkExpired(map)) {
			ret.setErr("expired card,or not active!");
			info.setExpired(1);
			info.setStatus(4);
		}
		if (!checkTimes(map)) {
			info.setCard_has_num(0);
			ret.setErr("times out!");
			info.setStatus(5);
		}
		if (!checkBusy(map,null)) {
			ret.setErr("busy time!");
			info.setCard_busy(1);
			info.setStatus(6);
		}

		String memberid = map.get("MemberID").toString();
		String sql = "select * from StarMember where MemberID=?";
		Result rs = db.executeQuery(sql, memberid);
		Map member = getOneMap(rs);

		if (member == null)
		{
			ret.setErr("this member does not exist!");
			return ret;
		} 
		
		info.setErr(ret.getErr());
		info.setId_number(member.get("MemberIDCard").toString());
		info.setClub_id(map.get("SaleShop").toString());
		info.setClub_name(map.get("OrgName").toString());
		info.setClub_ids(map.get("UseShop").toString());
		info.setTimes(map.get("CountNum").toString());
		info.setCometimes(map.get("CheckinAmount").toString());
		info.setEndtime(map.get("EndDate").toString().replaceAll("\\s.*",""));
		info.setNo(cardid);
		info.setGender(member.get("MemberSex").toString().equals("1") ? "female"
				: "male");
		info.setName(member.get("MemberName").toString());
		info.setTel(member.get("MemberPhone").toString());
		String face = member.containsKey("MemberPhoto") &&   member.get("MemberPhoto")!=null? "http://114.80.208.206:8995/images/memberphoto/"
				+ member.get("MemberPhoto").toString()
				+ "?p="
				+ System.currentTimeMillis()
				: "http://114.80.208.206:8995/images/noimg.gif";
		info.setFace(face);
		SimpleDateFormat sdf = new SimpleDateFormat("yyyyMMdd");
		SimpleDateFormat sdf1 = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss.S");
		if(member.get("MemberBirthday")!=null)
		info.setBirthday(sdf.format(sdf1.parse(member.get("MemberBirthday")
				.toString())));
		info.setCardtype(map.get("isnumcard").toString().equals("1") ? "次数卡"
				: "时间卡");
		info.setLeft(map.get("isnumcard").toString().equals("1") ? ((Integer) map
				.get("CountNum") - (Integer) map.get("CheckinAmount") + "")
				: "-1");
		info.setMstatus(isCheckin(cardid) ? "in" : "out");
		ret.setRes(info) ;
		return ret;

	}

	private boolean isCheckin(String cardid) {
		String sql = "select top 1 * from StarBook where MemberCardNo=?";
		Result rs = db.executeQuery(sql, cardid);
		Map map = getOneMap(rs);
		if (map == null || map.size() == 0)
			return false;
		String checkStatus = map.get("IsCheckOut").toString();
		String checkInTime = map.get("CheckInTime").toString();
		SimpleDateFormat sdf = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss.S");
		long in = 0;
		try {
			in = sdf.parse(checkInTime).getTime();
		} catch (ParseException e) {
			return false;
		}
		return checkStatus.equals("0")
				&& (System.currentTimeMillis() - in) < 5 * 60 * 60 * 1000;
	}

	private boolean checkClubid(Map map, String clubid) {
		String[] useShops = map.get("UseShop").toString().split(",");
		for (String shop : useShops) {
			if (shop.trim().equals(clubid)) {
				return true;
			}
		}
		return false;
	}

	/**
	 * 是否過期
	 * 
	 * @param map
	 * @return
	 * @throws ParseException
	 */
	private boolean checkExpired(Map map) throws ParseException {
		SimpleDateFormat sdf = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss.S");
		Date startTime = sdf.parse(map.get("StartDate").toString());
		Date endTime = sdf.parse(map.get("EndDate").toString());
		Date now = new Date();
		System.out.println("time:"+startTime+"   "+now+"   "+endTime);
		return startTime.getTime() < now.getTime()
				&& endTime.getTime() > now.getTime();
	}

	/**
	 * 是否有效
	 * 
	 * @param map
	 * @return
	 */
	private boolean checkValid(Map map) {
		System.out.println("valid:"+ map.get("Flag").toString().trim()+"  ret:"+map.get("Flag").toString().trim().equals("1"));
		return map.get("Flag").toString().trim().equals("1");
	}

	private boolean checkTimes(Map map) {
		String cardTypeId = map.get("CardTypeID").toString();
		Map cardType = getCardType(cardTypeId);
		int isTimeCard = Integer.parseInt(cardType.get("IsTimesCard")
				.toString());
		map.put("isnumcard", isTimeCard);
		int totalCount = (Integer) map.get("CountNum");
		int checkinCount = (Integer) map.get("CheckinAmount");
		System.out.println("times:istimecard--"+ isTimeCard+" total-- "+totalCount+" checkin--  "+checkinCount+"   ret:"+(isTimeCard == 1 && totalCount <= checkinCount));
		if (isTimeCard == 1 && totalCount <= checkinCount) {
			return false;
		}
		return true;
	}

	public boolean checkBusy(Map map,Calendar time) {
		String cardTypeId = map.get("CardTypeID").toString();
		Map cardType = getCardType(cardTypeId);
		int isBusyCard = Integer
				.parseInt(cardType.get("IsBusyCard").toString());
		map.put("isbusycard", isBusyCard);
		if (isBusyCard != 1)
			return true;
		String busyTime = map.get("BusyTime").toString();
		busyTime = "1,17-18|1,18-19|1,19-20|1,20-21|1,21-22|2,23-24|1,23-24|1,22-23|2,22-23|2,21-22|2,20-21|2,19-20|2,18-19|2,17-18|3,17-18|3,18-19|3,19-20|3,20-21|3,21-22|3,23-24|3,22-23|4,17-18|4,18-19|4,19-20|4,20-21|4,21-22|4,22-23|4,23-24|5,23-24|5,22-23|5,21-22|5,20-21|5,19-20|5,18-19|5,17-18|6,17-18|6,18-19|7,17-18|7,18-19|7,19-20|7,20-21|7,21-22|7,22-23|7,23-24|6,23-24|6,22-23|6,21-22|6,20-21|6,19-20|";
		String regx = "(\\d),(\\d+)-(\\d+)\\|";
		Pattern pattern = Pattern.compile(regx);
		Matcher matcher = pattern.matcher(busyTime);
		System.out.println(matcher.matches());
		Calendar cal = Calendar.getInstance();
		if(time!=null)
		{
			cal=time;
		}
		int day = cal.get(Calendar.DAY_OF_WEEK) - 1;
		int hour = cal.get(Calendar.HOUR_OF_DAY);
		day = day == 0 ? 7 : day;
		while (matcher.find()) {
			int dayofweek = Integer.parseInt(matcher.group(1));
			if (dayofweek == day) {
				int hourstart = Integer.parseInt(matcher.group(2));
				int hourend = Integer.parseInt(matcher.group(3));
				if (hour > hourstart && hour < hourend) {
					return false;
				}
			}
		}
		return true;
	}

	public Map[] getAllCardBymemberid(String memberid) {
		String sql = "select * from  StarMemberCard   where   MemberID=? order by StartDate;";
		Result rs = db.executeQuery(sql, memberid);
		return getMaps(rs);
	}

	public Map isAllowed(String memberid) throws Exception {
		Map[] maps = getAllCardBymemberid(memberid);
		String failreason = "overdue card!";
		boolean flag = false;
		for (Map map : maps) {
			try {
				flag = checkCard(map);
				if (flag) {
					return map;
				}
			} catch (Exception ex) {
				failreason = ex.getMessage();
			}
		}
		throw new Exception(failreason);
	}

	public boolean checkCard(Map map) throws Exception {
		String cardTypeId = map.get("CardTypeID").toString();
		Map cardType = getCardType(cardTypeId);
		int isTimeCard = Integer.parseInt(cardType.get("IsTimesCard")
				.toString());
		if (isTimeCard == 1 && !checkTimes(map)) {
			throw new Exception("times out!");
		}
		int isBusyCard = Integer
				.parseInt(cardType.get("IsBusyCard").toString());
		if (isBusyCard == 1 && !checkBusy(map,null))
			throw new Exception("busy time!");
		return true;
	}

//	public Map getCardType(String cardTypeId) {
//		String sql = "select IsBusyCard,IsTimesCard  from DBCardType where CardTypeId=?";
//		Result rs = db.executeQuery(sql, cardTypeId);
//		return getOneMap(rs);
//	}

	public void print(Result rs) {
		for (Map map : rs.getRows()) {
			System.out.println(map);
		}
	}

	// public int checkin(String memberid) throws Exception {
	// Map map = isAllowed(memberid);
	// String id=map.get("id").toString();
	// String sql =
	// "update StarMemberCard set CheckinAmount=CheckinAmount-1 where id=?";
	// db.execute(sql, id);
	// sql =
	// "insert into  StarBook set CheckinAmount=CheckinAmount-1 where id=?";
	// db.execute(sql, id);
	// }
	//
	// public Map query(String memberid, String name) {
	//
	// }
}
