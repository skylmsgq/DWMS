package com.geomobile.rc663;
import android.app.Activity;
import android.app.AlertDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;

public class RC663_RFIDActivity extends Activity implements OnClickListener {
    /** Called when the activity is first created. */
	private Button start_scan4;
	private Activity activity_this=this;
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.main);
        start_scan4 = (Button)findViewById(R.id.button_scan4);
        start_scan4.setOnClickListener(this);
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
            }
        });
        builder.create().show();
    return;
    }
    
	@Override
	public void onClick(View arg0) {
		// TODO Auto-generated method stub	
		 if (arg0 == start_scan4) {
			Intent i = new Intent();
			i.setClass(this, Scan4.class);
			startActivity(i);
			//finish();
		}
	}
}