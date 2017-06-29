package com.example.mxk1yyp.hackaton;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;

public class Main3Activity extends AppCompatActivity {
    private static Button button_order;
    private static Button button_timeSheet;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main3);
        OnClickButtonListener();
        String username = getIntent().getStringExtra("Username");

        TextView tv = (TextView)findViewById(R.id.TVusername);
        tv.setText(username);
    }
    public void OnClickButtonListener(){
        button_order = (Button)findViewById(R.id.btn_Order);
        button_timeSheet = (Button)findViewById(R.id.btn_TimeCard);
        button_order.setOnClickListener(
                new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {
                        Intent intent = new Intent("com.example.mxk1yyp.hackaton.OrderFood");
                        startActivity(intent);
                    }
                }
        );
    }
}
