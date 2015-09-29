import static org.jboss.netty.handler.codec.http.HttpHeaders.Names.CONTENT_TYPE;
import static org.jboss.netty.handler.codec.http.HttpResponseStatus.BAD_REQUEST;
import static org.jboss.netty.handler.codec.http.HttpResponseStatus.INTERNAL_SERVER_ERROR;
import static org.jboss.netty.handler.codec.http.HttpResponseStatus.OK;
import static org.jboss.netty.handler.codec.http.HttpVersion.HTTP_1_1;

import java.io.ByteArrayOutputStream;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.InputStream;
import java.io.OutputStream;
import java.net.URLDecoder;
import java.net.URLEncoder;
import java.util.Arrays;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import java.util.Map.Entry;

import net.sf.json.JSONObject;
import net.sf.json.util.JSONBuilder;

import org.apache.log4j.Logger;
import org.jboss.netty.buffer.ChannelBuffer;
import org.jboss.netty.buffer.ChannelBuffers;
import org.jboss.netty.buffer.DynamicChannelBuffer;
import org.jboss.netty.channel.Channel;
import org.jboss.netty.channel.ChannelFuture;
import org.jboss.netty.channel.ChannelFutureListener;
import org.jboss.netty.channel.ChannelHandlerContext;
import org.jboss.netty.channel.ExceptionEvent;
import org.jboss.netty.channel.MessageEvent;
import org.jboss.netty.channel.SimpleChannelUpstreamHandler;
import org.jboss.netty.handler.codec.base64.Base64Decoder;
import org.jboss.netty.handler.codec.frame.TooLongFrameException;

import org.jboss.netty.handler.codec.http.DefaultHttpResponse;

import org.jboss.netty.handler.codec.http.HttpMethod;

import org.jboss.netty.handler.codec.http.DefaultHttpDataFactory;
import org.jboss.netty.handler.codec.http.HttpPostRequestDecoder;
import org.jboss.netty.handler.codec.http.HttpRequest;
import org.jboss.netty.handler.codec.http.HttpResponse;
import org.jboss.netty.handler.codec.http.HttpResponseStatus;
import org.jboss.netty.handler.codec.http.InterfaceHttpData;
import org.jboss.netty.handler.codec.http.MixedAttribute;
import org.jboss.netty.handler.codec.http.QueryStringDecoder;

import org.jboss.netty.util.CharsetUtil;

/**
 * @author
 */

public class HttpHandler extends SimpleChannelUpstreamHandler {
	Logger logger = Logger.getLogger(HttpHandler.class);
	@Override
	public void messageReceived(ChannelHandlerContext ctx, MessageEvent e)
			throws Exception {
		long start=System.currentTimeMillis();
		try {
			HttpRequest request = (HttpRequest) e.getMessage();
			HttpMethod method = request.getMethod();
			String data = null;
			Map<String, String> datas = new HashMap<String, String>();
			Map<String, byte[]> files = new HashMap<String, byte[]>();
			if (method.equals(HttpMethod.POST)) {
				HttpPostRequestDecoder postRequestDecoder = new HttpPostRequestDecoder(
						new DefaultHttpDataFactory(
								DefaultHttpDataFactory.MINSIZE), request,
						CharsetUtil.UTF_8);
				List<InterfaceHttpData> dataList = postRequestDecoder
						.getBodyHttpDatas();
				for (InterfaceHttpData d : dataList) {
					String name = d.getName();
					String value = null;
					if (InterfaceHttpData.HttpDataType.Attribute == d
							.getHttpDataType()) {
						MixedAttribute attribute = (MixedAttribute) d;
						attribute.setCharset(CharsetUtil.UTF_8);
						value = attribute.getValue();
						datas.put(name, value);
						if (name.equals("json")) {
							data = value;
						}
					}
				}
			} else {
				data = request.getUri();
				logger.debug(data);
				QueryStringDecoder queryStringDecoder = new QueryStringDecoder(
						request.getUri());
				Map<String, List<String>> params = queryStringDecoder
						.getParameters();
				Map<String,String> values=new HashMap<String,String>();
				if (!params.isEmpty()) {
					for (Entry<String, List<String>> p : params.entrySet()) {
						String key = p.getKey();
						List<String> vals = p.getValue();					 
						for (String val : vals) {
							values.put(key, val);						
						}
					}					 
						Controller controller = new Controller();
						Ret result = controller.process(values);
						if(result==null)
						{
							response(new Ret(-1,"can't get any result!","").toString(), e);			
						}
						else
						{
							response(result.toString(), e);			
						}
								 
				}
				else
				{
					response((new Ret(-1,"pls input correct params!","")).toString(), e);			 
				}
			}
		} catch (Exception ex) {		
			response((new Ret(-1,ex.getMessage(),"")).toString(), e);
		}
		finally
		{
			logger.info("time: "+(System.currentTimeMillis()-start));
		}
	}

	
	public void response(String value, MessageEvent e) {
		HttpResponse response = new DefaultHttpResponse(HTTP_1_1, OK);		
		response.setContent(ChannelBuffers.copiedBuffer(value,
				CharsetUtil.UTF_8));
		response.setHeader("Content-Type", "text/plain; charset=UTF-8");
		response.setHeader("Content-Length", response.getContent()
				.readableBytes());
		Channel ch = e.getChannel();
		ch.write(response).addListener(ChannelFutureListener.CLOSE);
	}

	@Override
	public void exceptionCaught(ChannelHandlerContext ctx, ExceptionEvent e)
			throws Exception {
		Channel ch = e.getChannel();
		Throwable cause = e.getCause();
		if (cause instanceof TooLongFrameException) {
			sendError(ctx, BAD_REQUEST);
			return;
		}

		cause.printStackTrace();
		if (ch.isConnected()) {
			sendError(ctx, INTERNAL_SERVER_ERROR);
		}
	}

	private void sendError(ChannelHandlerContext ctx, HttpResponseStatus status) {
		HttpResponse response = new DefaultHttpResponse(HTTP_1_1, status);
		response.setHeader(CONTENT_TYPE, "text/plain; charset=UTF-8");
		response.setContent(ChannelBuffers.copiedBuffer(
				"Failure: " + status.toString() + "\r\n", CharsetUtil.UTF_8));
		// Close the connection as soon as the error message is sent.
		ctx.getChannel().write(response)
				.addListener(ChannelFutureListener.CLOSE);
	}
}