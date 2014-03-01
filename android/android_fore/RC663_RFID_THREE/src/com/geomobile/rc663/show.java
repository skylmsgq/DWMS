package com.geomobile.rc663;

import com.geomobile.rc6633.R;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.text.method.ScrollingMovementMethod;
import android.widget.TextView;

public class show extends Activity {
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        // Get the message from the intent
        Intent intent = getIntent();
        String message = intent.getStringExtra("result");
        // Create the text view
        TextView textView = new TextView(this);
        textView.setTextSize(20);
        textView.setText(message);
        textView.setMovementMethod(new ScrollingMovementMethod());
        // Set the text view as the activity layout
        setContentView(textView);
    }
}