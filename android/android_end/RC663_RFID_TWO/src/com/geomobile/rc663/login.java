package com.geomobile.rc663;


import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.apache.http.util.EntityUtils;
import org.json.JSONObject;

import android.app.Activity;
import android.app.AlertDialog;
import android.app.ProgressDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
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
	private IOCallback submitController = null;
	public ScanActivity my=this;
	public String myURL =  "http://202.120.58.116/test/index.php";;
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.login);
        bnlogin = (Button)findViewById(R.id.button_in);
        bnlogin.setOnClickListener(this);
        name=(EditText)findViewById(R.id.editText_name);
        pass=(EditText)findViewById(R.id.editText_pass);
        
    }

    public class SubmitCallbackController implements IOCallback {
		login activity;
    	ProgressDialog progDialog;
    	List<NameValuePair> nameValuePairs ;
    	public SubmitCallbackController(login activity, List<NameValuePair> np) {
    		this.activity = activity;
    		nameValuePairs=np;
    		new LongRunningGetIO(activity.myURL, nameValuePairs, this).execute();
    		
    		progDialog = ProgressDialog.show(activity, "正在登录",
    	            "登录中请稍候...", true);
    	}
    	private void parseJSON(String value)
    	{
    		Log.d(TAG, value);
    		ErrorParser.parse(activity, value);
    		
    	}
    	
    	public void httpRequestDidFinish(int success, String value) {
    		progDialog.dismiss();
    		
    		if (value.equals("yes"))
    		{
    			name.setText("");
				pass.setText("");
				Intent i = new Intent();
				i.setClass(my, RC663_RFIDActivity.class);
				startActivity(i);
    		}else
    			DialogUtil.showDialog(my, "用户名或密码错误", false);
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
				Map<String, String> map = new HashMap<String, String>();
				map.put("user", username);
				map.put("pass", pwd);
				List<NameValuePair> params = new ArrayList<NameValuePair>();
				for(String key : map.keySet())
				{
					params.add(new BasicNameValuePair(key , map.get(key)));
				}
				if(submitController == null) submitController = new SubmitCallbackController(this,params);
			}
			
		}
	}
}