import java.io.Closeable;
import java.io.IOException;
import java.lang.reflect.InvocationTargetException;
import java.lang.reflect.Method;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;

import javax.servlet.jsp.jstl.sql.Result;
import javax.servlet.jsp.jstl.sql.ResultSupport;

public class DBInstance {

	private String drivers, url, username, password;

	public DBInstance(String drivers, String url, String username,
			String password) {
		this.drivers = drivers;
		this.url = url;
		this.username = username;
		this.password = password;
	}

	public Connection getConnection() {
		Connection conn = null;
		try {
			Class.forName(drivers); // ������ݿ���
			if (null == conn) {
				conn = DriverManager.getConnection(url, username, password);
			}
		} catch (ClassNotFoundException e) {
			System.out.println("Sorry,can't find the Driver!");
			e.printStackTrace();
		} catch (SQLException e) {
			e.printStackTrace();
		} catch (Exception e) {
			e.printStackTrace();
		}
		return conn;

	}

	public int execute(String sql) {
		int result = 0;
		Connection conn = null;
		Statement stmt = null;
		try {
			conn = getConnection();
			stmt = conn.createStatement();
			result = stmt.executeUpdate(sql);

		} catch (SQLException err) {
		} finally {
			close(stmt, conn);
		}
		return result;
	}

	public int execute(String sql, Object... obj) {
		int result = 0;
		Connection conn = null;
		PreparedStatement pstmt = null;
		try {
			conn = getConnection();
			pstmt = conn.prepareStatement(sql);
			for (int i = 0; i < obj.length; i++) {
				pstmt.setObject(i + 1, obj[i]);
			}
			result = pstmt.executeUpdate();
		} catch (SQLException err) {
			err.printStackTrace();
		} finally {
			close(null, pstmt, conn);
		}
		return result;

	}

	public Result executeQuery(String sql, Object... obj) {
		long start=System.currentTimeMillis();
		Connection conn = null;
		Statement stmt = null;
		ResultSet rs = null;
		PreparedStatement pstmt = null;
		Result result = null;
		try {
			conn = getConnection();
			stmt = conn.createStatement();
			if (obj==null || obj.length == 0)
			{
				rs = stmt.executeQuery(sql);
				System.out.println("query execute time:"+(System.currentTimeMillis()-start)+"---"+sql);
			}			
			else {
				pstmt = conn.prepareStatement(sql);
				for (int i = 0; i < obj.length; i++) {
					pstmt.setObject(i + 1, obj[i]);
				}
				rs = pstmt.executeQuery();
				System.out.println("query execute time:"+(System.currentTimeMillis()-start)+"---"+sql);
			}
			start=System.currentTimeMillis();
			result = ResultSupport.toResult(rs);
			System.out.println("trans execute time:"+(System.currentTimeMillis()-start));

		} catch (SQLException err) {

			err.printStackTrace();

		} finally {
			close(rs, pstmt, stmt, conn);
		}
		return result;

	}

	public static void main(String[] args) throws ClassNotFoundException,
			SQLException {
		Class.forName("com.microsoft.sqlserver.jdbc.SQLServerDriver");
		Connection con = DriverManager.getConnection(
				"jdbc:sqlserver://localhost:1433;databaseName=NewSys", "test",
				"123456");
		Statement stat = con.createStatement();
		ResultSet rs = stat
				.executeQuery("select top 1 * from StarMemberContract");
		while (rs.next()) {
			System.out.println(rs.getString("ID"));
		}
		rs.close();
		stat.close();
		con.close();

	}

	public static void close(Object... objs) {
		for (Object c : objs) {
			if (c instanceof Closeable) {
				try {
					((Closeable) c).close();
				} catch (IOException e) {
					// TODO Auto-generated catch block
					e.printStackTrace();
				}
				continue;
			}
			if (c != null) {
				Method[] methods = c.getClass().getMethods();
				for (Method method : methods) {
					if (method.getName().equals("close")) {
						try {
							method.invoke(c);
						} catch (IllegalArgumentException e) {
							e.printStackTrace();
						} catch (IllegalAccessException e) {
							e.printStackTrace();
						} catch (InvocationTargetException e) {
							e.printStackTrace();
						}
						break;
					}
				}
				c = null;
			}
		}
	}
}
