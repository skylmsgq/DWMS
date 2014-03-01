package com.geomobile.rc663;


import android.app.Activity;
import android.app.AlertDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;

import com.geomobile.rc6631.R;

public class RC663_RFIDActivity extends Activity implements OnClickListener {
    /** Called when the activity is first created. */
	

	private Button start_scan;
	private Button start_scan2;
	private Button start_scan3;
	private Activity activity_this=this;
//	private Activity activity_father;
	//getExtras
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.main);

        start_scan = (Button)findViewById(R.id.button_ScanAndUpload);
        start_scan2 = (Button)findViewById(R.id.button_scan2);
        start_scan3 = (Button)findViewById(R.id.button_scan3);


        start_scan.setOnClickListener(this);
        start_scan2.setOnClickListener(this);
        start_scan3.setOnClickListener(this);
  //      Intent intent = getIntent();
  //      activity_father=intent.getExtras().get("father");
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
		//选择三种功能，跳转到相应界面
		if(arg0 == start_scan) {
			Intent i = new Intent();
			i.setClass(this, ScanAndUpload.class);
			startActivity(i);
			//finish();
		} else if (arg0 == start_scan2) {
			Intent i = new Intent();
			i.setClass(this, Scan2.class);
			startActivity(i);
			//finish();
		} else if (arg0 == start_scan3) {
			Intent i = new Intent();
			i.setClass(this, Scan3.class);
			startActivity(i);
			//finish();
		}
	}
}