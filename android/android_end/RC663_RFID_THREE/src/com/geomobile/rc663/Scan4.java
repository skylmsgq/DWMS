package com.geomobile.rc663;

import com.android.hflibs.Iso15693_native;
import com.geomobile.rc6633.R;

import android.app.Activity;
import android.app.AlertDialog;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.DialogInterface.OnCancelListener;
import android.content.Intent;
import android.os.Bundle;
import android.telephony.TelephonyManager;
import android.text.method.ScrollingMovementMethod;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.TextView;

import java.util.ArrayList;
import java.util.List;
import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.*;

public class Scan4 extends ScanActivity implements OnClickListener {
    /** Called when the activity is first created. */	
	public final static String EXTRA_MESSAGE = "MESSAGE";
	private static final String TAG = "rc663_15693_java";
	private static final String PW_DEV = "/proc/driver/as3992";
	private Iso15693_native dev = new Iso15693_native();
	private Button get_info;
	//public TextView main_info;
	private DeviceControl power;
	public String myTitle = "环保局查看";
	public String myURL =  "";	
	private String imei = "";
	private Activity activity_this=this;
	public String sn;
	public boolean swh;
	private IOCallback submitController = null;
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        this.myURL =getString(R.string.url_prefix)+"check" ;
        setContentView(R.layout.scan34);    
        TelephonyManager telephonyManager = (TelephonyManager)getSystemService(Context.TELEPHONY_SERVICE);
        this.imei = telephonyManager.getDeviceId();
        ((TextView)findViewById(R.id.textView_addNew)).setText(myTitle);
        get_info = (Button)findViewById(R.id.button_15693_search);
        get_info.setOnClickListener(this);
        get_info.setEnabled(true);
        

       // main_info = (TextView)findViewById(R.id.textView_15693_info);
        //main_info.setMovementMethod(ScrollingMovementMethod.getInstance());
      
        power = new DeviceControl();
        if(power.DeviceOpen(PW_DEV) < 0)
        {
        	this.alertMessage(getString(R.string.msg_error_power));
        	//main_info.setText(R.string.msg_error_power);
        	return;
        }
        Log.d(TAG, "open file ok");
        
        if(power.PowerOnDevice() < 0)
        {
        	power.DeviceClose();
        	this.alertMessage(getString(R.string.msg_error_power));
//        	main_info.setText(R.string.msg_error_power);
        	return;
        }
        Log.d(TAG, "open power ok");
        
        try {
			Thread.sleep(100);
		} catch (InterruptedException e) {
			// TODO Auto-generated catch block
		}
        
        Log.d(TAG, "begin to init");
        if(dev.InitDevice() != 0)
        {
        	power.PowerOffDevice();
        	power.DeviceClose();
        	this.alertMessage(getString(R.string.msg_error_dev));
//        	main_info.setText(R.string.msg_error_dev);
        	return;
        }
        Log.d(TAG, "init ok");
        get_info.setEnabled(true);   
    }
    @Override
    public void onDestroy()
    {
    	Log.d(TAG, "on destory");
    	dev.ReleaseDevice();
    	power.PowerOffDevice();
    	power.DeviceClose();
    	super.onDestroy();
    }

    
//    public void debugMessage(String msg)
//    {
//    	//TextView main_info = (TextView)findViewById(R.id.textView_15693_info);
//	//	main_info.setText(msg);
//    }
    
    public class NullCallback implements IOCallback {
    	public void httpRequestDidFinish(int success, String value) {
    		
    	}
    }
    
    public class SubmitCallbackController implements IOCallback {
    	Scan4 activity;
    	ProgressDialog progDialog;
    	List<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>();
    	LongRunningGetIO running;
    	public SubmitCallbackController(final Scan4 activity, JSONObject postJson) {
    		this.activity = activity;
    		NameValuePair postContent = new BasicNameValuePair("txt_json", postJson.toString());
    		nameValuePairs.add(postContent);
    		running=new LongRunningGetIO(activity.myURL, nameValuePairs, this);
    		running.execute();
    		
    		progDialog = ProgressDialog.show(activity, "正在查询",
    	            "请稍候...", true, true, new OnCancelListener(){
    			public void onCancel(DialogInterface pd)
    			{
    				running.handleOnBackButton();
    				activity.submitController = null;
    			}
    		});
    	}
    	private void parseJSON(String value)
    	{
    		Log.d(TAG, value);
    		ErrorParser.parse(activity, value);
    		
    		Log.d(TAG, "finish ");
    	}
    	
    	public void httpRequestDidFinish(int success, String value) {
    		progDialog.dismiss();
    		
    		this.parseJSON(value);
    	//	main_info.setText(sn);
    		if (swh)
    		{Intent intent = new Intent(activity, show.class);
    		intent.putExtra("result", sn);
    		startActivity(intent);}
    		activity.submitController = null;
    	}
    }
    
    @Override
    public void onBackPressed() {
    	AlertDialog.Builder builder = new AlertDialog.Builder(this);
        builder.setTitle("提示")
        .setMessage("确认退出？")
        .setCancelable(false)
        .setNegativeButton("取消",new DialogInterface.OnClickListener() {
            public void onClick(DialogInterface dialog, int id) {
                dialog.cancel();
            }
        }).setPositiveButton("退出", new DialogInterface.OnClickListener() {
            public void onClick(DialogInterface dialog, int id) {
                activity_this.finish();
          //      act.finish();
            }
        });
        builder.create().show();
    return;
    }
	@Override
	public void onClick(View arg0) {
		// TODO Auto-generated method stub
		if(arg0 == get_info)
		{
			Log.d(TAG, "get_info clicked");
			swh=false;
		//	main_info.setText("");
			sn = Scanner.scan();
			if(sn == null) {
				this.alertMessage("未找到 RFID 设备");
				return;
			}
			
		    JSONObject myupload = new JSONObject();
		    try {
				myupload.put("rfid", sn);
				myupload.put("imei", this.imei);
			} catch (JSONException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
		    sn+="\n";
		   // sn="RFID: "+sn;
		    if(submitController == null) submitController = new SubmitCallbackController(this, myupload);
	
		} 
	}
    
}
