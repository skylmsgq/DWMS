package com.geomobile.rc663;


import java.util.ArrayList;
import java.util.List;
import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONException;
import org.json.JSONObject;

import com.geomobile.rc6633.R;


import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.telephony.TelephonyManager;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;


public class login extends ScanActivity implements OnClickListener {
    /** Called when the activity is first created. */
	private static final String TAG = "rc663_15693_java";
	private Button bnlogin;
	private EditText name;
	private EditText pass;
	private String imei="";
	private IOCallback submitController = null;
	public ScanActivity my=this;
	//public String myURL = "http://202.120.58.116/test/dwms/index.php";
	public String myURL; 
	//public String myURL ="http://202.120.58.116/test/dwms/www/index.php/Home/AndroidApi/login";
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.login);
        bnlogin = (Button)findViewById(R.id.button_in);
        bnlogin.setOnClickListener(this);
        name=(EditText)findViewById(R.id.editText_name);
        pass=(EditText)findViewById(R.id.editText_pass);
        TelephonyManager telephonyManager = (TelephonyManager)getSystemService(Context.TELEPHONY_SERVICE);
        this.imei = telephonyManager.getDeviceId();
        this.myURL= getString(R.string.url_prefix) + "login";
    }

    public class SubmitCallbackController implements IOCallback {
		login activity;
    	ProgressDialog progDialog;
    	List<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>();
    	public SubmitCallbackController(login activity, JSONObject postJson) {
    		this.activity = activity;
    		NameValuePair postContent = new BasicNameValuePair("txt_json", postJson.toString());
    		nameValuePairs.add(postContent);
    		new LongRunningGetIO(activity.myURL, nameValuePairs, this).execute();
    		
    		progDialog = ProgressDialog.show(activity, "正在登录",
    	            "登录中请稍候...", true);
    	}
    	
    	public void httpRequestDidFinish(int success, String value) {
    		progDialog.dismiss();
    		if (value.equals("0"))
    		{
    			name.setText("");
				pass.setText("");
				Intent i = new Intent();
				i.setClass(my, Scan4.class);
				startActivity(i);
    		}else if(value.equals("1"))
    			DialogUtil.showDialog(my, "服务器错误", false);
    		else if(value.equals("2"))
    			DialogUtil.showDialog(my, "该设备未注册", false);
    		else if (value.equals("3"))
    			DialogUtil.showDialog(my, "用户名或密码错误", false);
    		else if (value.equals("4"))
    			DialogUtil.showDialog(my, "该帐号无在此设备上运行此软件的权限", false);
    		else
    			DialogUtil.showDialog(my, value, false);
	        activity.submitController = null;
    	}
    }
	// 对用户输入的用户名、密码进行校验
	private boolean validate()
	{
		String username = name.getText().toString().trim();
		if (username.equals(""))
		{
			DialogUtil.showDialog(this, "请填写用户名！", false);
			return false;
		}
		String pwd = pass.getText().toString().trim();
		if (pwd.equals(""))
		{
			DialogUtil.showDialog(this, "请填写密码！", false);
			return false;
		}
		return true;
	}

	@Override
	public void onClick(View arg0) {
		// TODO Auto-generated method stub		
		if(arg0 == bnlogin) {			
			//test user authentication 
			if (validate())
			{
				String username = name.getText().toString();
				String pwd = pass.getText().toString();
				JSONObject myupload = new JSONObject();
				try {
					myupload.put("user", username);
					myupload.put("pass", pwd);
					myupload.put("imei", imei);
					myupload.put("type", 4);
				} catch (JSONException e) {
					// TODO Auto-generated catch block
					e.printStackTrace();
				}
				if(submitController == null) submitController = new SubmitCallbackController(this,myupload);
			}
			
		}
	}
}