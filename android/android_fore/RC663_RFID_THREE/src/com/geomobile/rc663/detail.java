package com.geomobile.rc663;

import org.json.JSONException;
import org.json.JSONObject;

import com.geomobile.rc6633.R;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.text.method.ScrollingMovementMethod;
import android.widget.TextView;

public class detail extends ScanActivity {
    
    private TextView rfid;
	private TextView wrap;
	private TextView num;
	private TextView waste_code;
	private TextView waste_type;
	private TextView production;
	private TextView reception;
	private TextView transport;
	private TextView driver;
	private TextView driver_code;
	private TextView car_code;
	private TextView r_status;
	private TextView t_status;
//	private TextView permission;
	@Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
         //Get the message from the intent
        Intent intent = getIntent();
        String message = intent.getStringExtra("detail");
        setContentView(R.layout.detail);
        rfid= (TextView)findViewById(R.id.rfid);
        wrap= (TextView)findViewById(R.id.wrap);
        num= (TextView)findViewById(R.id.num);
        waste_code= (TextView)findViewById(R.id.waste_code);
        waste_type= (TextView)findViewById(R.id.waste_type);
        production= (TextView)findViewById(R.id.production);
        reception= (TextView)findViewById(R.id.reception);
        transport= (TextView)findViewById(R.id.transport);
        driver= (TextView)findViewById(R.id.driver);
        driver_code= (TextView)findViewById(R.id.driver_code);
        car_code= (TextView)findViewById(R.id.car_code);
        r_status= (TextView)findViewById(R.id.r_status);
        t_status= (TextView)findViewById(R.id.t_status);
        JSONObject jObject;
        try {
//        	this.alertMessage(message);
			jObject = new JSONObject(message);
			rfid.setText(jObject.getString("rfid"));
			wrap.setText(jObject.getString("wrap"));
			num.setText(jObject.getString("num"));
			waste_code.setText(jObject.getString("waste_code"));
			waste_type.setText(jObject.getString("waste_type"));
			if (jObject.has("production"))
				production.setText(jObject.getString("production"));
			if (jObject.has("reception"))
				reception.setText(jObject.getString("reception"));
			if (jObject.has("transport"))
				transport.setText(jObject.getString("transport"));
			if (jObject.has("driver"))
				driver.setText(jObject.getString("driver"));
			if (jObject.has("driver_code"))
				driver_code.setText(jObject.getString("driver_code"));
			if (jObject.has("car_code"))
				car_code.setText(jObject.getString("car_code"));
			//note, this is a little confusing
			if (jObject.has("r_status"))
				r_status.setText(jObject.getString("t_status"));
			if (jObject.has("t_status"))
				t_status.setText(jObject.getString("r_status"));
		} catch (JSONException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
//        permission= (TextView)findViewById(R.id.permission);
//        if (!strlist[0].equals(""))
//        	rfid.setText(strlist[0]);
//        if (!strlist[1].equals(""))
//        	wrap.setText(strlist[1]);
//        if (!strlist[2].equals(""))
//        	num.setText(strlist[2]);
//        if (!strlist[3].equals(""))
//        	waste_code.setText(strlist[3]);
//        if (!strlist[4].equals(""))
//        	type.setText(strlist[4]);
//        if (!strlist[5].equals(""))
//        	permission.setText(strlist[5]);
    }
}