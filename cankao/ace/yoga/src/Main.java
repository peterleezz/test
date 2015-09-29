import java.io.File;
import java.io.FileInputStream;
import java.util.Calendar;
import java.util.List;
import java.util.Map;
import java.util.Properties;
import java.util.SortedMap;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

import javax.servlet.jsp.jstl.sql.Result;

import net.sf.json.JSONArray;
import net.sf.json.JSONObject;

public class Main {
	

	public Main() {
		loadProperties();
		
	}

	public void test() {
		Service.getInstance().test();
	}

	public static void main(String[] args) throws Exception {
		Main main = new Main();
		System.out.println("start...");
//		 Service.getInstance().checkIn("11000018", "1002");
//		 List<MemberInfo> info = Service.getInstance().query("13601931757","1002");		  
//		 System.out.println(JSONArray.fromObject(info).toString());
		SocketService ss = new SocketService();
		ss.startHttp();
 
	}

	public void loadProperties() {
		Properties pro = new Properties();
		String file = "env.properties";
		try {
			pro.load(new FileInputStream(new File(file)));
		} catch (Exception e) {
			e.printStackTrace();
			System.exit(1);
		}
		for (Object key : pro.keySet()) {
			System.setProperty(key.toString(), pro.getProperty(key.toString()));
		}
	}

}
