import net.sf.json.JSONObject;


public class MemberInfo {
	private String no;
	private String gender;
	private String name;
	private String tel;
	private String face;
	private String birthday;
	private String cardtype;
	private String left;
	private String mstatus;
	private String card_id;
	private String club_name;
	private String club_id;
	private String club_names;
	private String times;
	private String cometimes;
	private String club_ids;
	private String id_number;
	private String endtime;
	private int status;
	private String err;
	
	private int card_status;
	private int card_busy;
	private int card_has_num;
	private int expired;
	public static void main(String[] args) {
		MemberInfo x=new MemberInfo();
		x.setNo("123");
		System.out.println(JSONObject.fromObject(x));
	}
	public String getNo() {
		return no;
	}
	public void setNo(String no) {
		this.no = no;
	}
	public String getGender() {
		return gender;
	}
	public void setGender(String gender) {
		this.gender = gender;
	}
	public String getName() {
		return name;
	}
	public void setName(String name) {
		this.name = name;
	}
	public String getTel() {
		return tel;
	}
	public void setTel(String tel) {
		this.tel = tel;
	}
	public String getFace() {
		return face;
	}
	public void setFace(String face) {
		this.face = face;
	}
	public String getBirthday() {
		return birthday;
	}
	public void setBirthday(String birthday) {
		this.birthday = birthday;
	}
	public String getCardtype() {
		return cardtype;
	}
	public void setCardtype(String cardtype) {
		this.cardtype = cardtype;
	}
	public String getLeft() {
		return left;
	}
	public void setLeft(String left) {
		this.left = left;
	}
	public String getMstatus() {
		return mstatus;
	}
	public void setMstatus(String mstatus) {
		this.mstatus = mstatus;
	}
	public void setCard_status(int card_status) {
		this.card_status = card_status;
	}
	public int getCard_status() {
		return card_status;
	}
	public void setCard_busy(int card_busy) {
		this.card_busy = card_busy;
	}
	public int getCard_busy() {
		return card_busy;
	}
	public void setCard_has_num(int card_has_num) {
		this.card_has_num = card_has_num;
	}
	public int getCard_has_num() {
		return card_has_num;
	}
	public void setExpired(int expired) {
		this.expired = expired;
	}
	public int getExpired() {
		return expired;
	}
	public void setCard_id(String card_id) {
		this.card_id = card_id;
	}
	public String getCard_id() {
		return card_id;
	}
	public String getClub_name() {
		return club_name;
	}
	public void setClub_name(String club_name) {
		this.club_name = club_name;
	}
	public String getClub_id() {
		return club_id;
	}
	public void setClub_id(String club_id) {
		this.club_id = club_id;
	}
	public String getClub_names() {
		return club_names;
	}
	public void setClub_names(String club_names) {
		this.club_names = club_names;
	}
	public String getTimes() {
		return times;
	}
	public void setTimes(String times) {
		this.times = times;
	}
	public String getCometimes() {
		return cometimes;
	}
	public void setCometimes(String cometimes) {
		this.cometimes = cometimes;
	}
	public String getClub_ids() {
		return club_ids;
	}
	public void setClub_ids(String club_ids) {
		this.club_ids = club_ids;
	}
	public String getId_number() {
		return id_number;
	}
	public void setId_number(String id_number) {
		this.id_number = id_number;
	}
	public String getEndtime() {
		return endtime;
	}
	public void setEndtime(String endtime) {
		this.endtime = endtime;
	}
	public int getStatus() {
		return status;
	}
	public void setStatus(int status) {
		this.status = status;
	}
	public String getErr() {
		return err;
	}
	public void setErr(String err) {
		this.err = err;
	}
 
}
