package com.geomobile.rc663;


import java.util.ArrayList;
import java.util.List;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONException;
import org.json.JSONObject;

import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.SharedPreferences.Editor;
import android.os.Bundle;
import android.telephony.TelephonyManager;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.CompoundButton;
import android.widget.EditText;


public class login extends ScanActivity implements OnClickListener {
    /** Called when the activity is first created. */
	private static final String TAG = "rc663_15693_java";
	private Button bnlogin;
	private EditText name;
	private EditText pass;
	private String imei="";
	private IOCallback submitController = null;
	private CheckBox rem_pw;
	private SharedPreferences sp;  
	public ScanActivity my=this;
	public String myURL; 
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.login);
        bnlogin = (Button)findViewById(R.id.button_in);
        bnlogin.setOnClickListener(this);
        name=(EditText)findViewById(R.id.editText_name);
        pass=(EditText)findViewById(R.id.editText_pass);
        rem_pw = (CheckBox) findViewById(R.id.rmb);  
        TelephonyManager telephonyManager = (TelephonyManager)getSystemService(Context.TELEPHONY_SERVICE);
        this.imei = telephonyManager.getDeviceId();
        this.myURL= getString(R.string.url_prefix) + "login";
        sp = this.getSharedPreferences("userInfo_2", Context.MODE_PRIVATE);
        if(sp.getBoolean("ISCHECK", false))  
        {
        	 rem_pw.setChecked(true);  
             name.setText(sp.getString("USER_NAME", ""));  
             pass.setText(sp.getString("PASSWORD", ""));  
        }
        rem_pw.setOnCheckedChangeListener(new CheckBox.OnCheckedChangeListener() {  
            public void onCheckedChanged(CompoundButton buttonView,boolean isChecked) {  
                if (rem_pw.isChecked()) {   
                   // System.out.println("记住密码已选中");  
                    sp.edit().putBoolean("ISCHECK", true).commit();  
                }else {  
                   // System.out.println("记住密码没有选中");  
                    sp.edit().putBoolean("ISCHECK", false).commit();  
                }  
            }  
        });
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
    		//判断后台返回的状态
    		if (value.equals("0"))
    		{
    			if(rem_pw.isChecked())  
                {  
                 //记住用户名、密码、  
                  Editor editor = sp.edit();  
                  editor.putString("USER_NAME", name.getText().toString());  
                  editor.putString("PASSWORD",pass.getText().toString());  
                  editor.commit();  
                } 
				else
				{name.setText("");
				pass.setText("");}
				Intent i = new Intent();
				i.setClass(my, RC663_RFIDActivity.class);
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
					//生产企业的type为7
					myupload.put("type", 7);
				} catch (JSONException e) {
					// TODO Auto-generated catch block
					e.printStackTrace();
				}
				if(submitController == null) submitController = new SubmitCallbackController(this,myupload);
			}
			
		}
	}
}