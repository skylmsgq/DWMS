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

public class show extends ScanActivity implements OnClickListener {
    /** Called when the activity is first created. */	
	private Button bn_detail;
	private TextView rfid;
	private TextView wrap;
	private TextView num;
	private TextView waste_code;
	private TextView type;
	private TextView permission;
	public String detail;
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.result);
        Intent intent = getIntent();
        String message = intent.getStringExtra("result");
        String [] strlist=message.split("%");
        //this.alertMessage(message);
        detail=intent.getStringExtra("detail");
        bn_detail = (Button)findViewById(R.id.button_detail);
        bn_detail.setOnClickListener(this);
        rfid= (TextView)findViewById(R.id.rfid);
        wrap= (TextView)findViewById(R.id.wrap);
        num= (TextView)findViewById(R.id.num);
        waste_code= (TextView)findViewById(R.id.waste_code);
        type= (TextView)findViewById(R.id.waste_type);
        permission= (TextView)findViewById(R.id.permission);
        if (!strlist[0].equals(""))
        	rfid.setText(strlist[0]);
        if (!strlist[1].equals(""))
        	wrap.setText(strlist[1]);
        if (!strlist[2].equals(""))
        	num.setText(strlist[2]);
        if (!strlist[3].equals(""))
        	waste_code.setText(strlist[3]);
        if (!strlist[4].equals(""))
        	type.setText(strlist[4]);
        if (!strlist[5].equals(""))
        	permission.setText(strlist[5]);
    }

	@Override
	public void onClick(View arg0) {
		// TODO Auto-generated method stub
		if(arg0 == bn_detail)
		{
			Intent i = new Intent();
			i.putExtra("detail", detail);
			i.setClass(this, detail.class);
			startActivity(i);
		} 
	}
}
