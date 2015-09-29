import net.sf.json.JSONObject;

public class Ret {

	private int status=0;
	private String err;
	private Object res;

	public String toString()
	{
		return JSONObject.fromObject(this).toString();
	}
	public Ret(int status, String err, Object res) {
		this.status = status;
		this.err = err;
		this.res = res;
	}
	public Ret() {	
	}

	public void setStatus(int status) {
		this.status = status;
	}

	public int getStatus() {
		return status;
	}

	public void setErr(String err) {
		this.status=-1;
		if(this.err==null)
			this.err=err;
		else
		this.err = this.err+" and "+err;
	}

	public String getErr() {
		return err;
	}

	public void setRes(Object res) {
		this.res = res;
	}

	public Object getRes() {
		return res;
	}
}
