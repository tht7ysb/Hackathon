package com.example.mxk1yyp.hackaton;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Spinner;

public class MainActivity extends AppCompatActivity {
    private static Button button_sign;
    private static Button button_log;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        OnClickButtonListener();
    }

    public void OnClickButtonListener() {
        button_log = (Button)findViewById(R.id.btn_Log);
       /* button_sign = (Button)findViewById(R.id.btn_Sign);

        button_sign.setOnClickListener(
                new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {
                        EditText a = (EditText)findViewById(R.id.ETusername);
                        String str = a.getText().toString();

                        Intent intent = new Intent("com.example.mxk1yyp.hackaton.Main2Activity");
                        intent.putExtra("Username",str);
                        startActivity(intent);
                    }
                }
        ); */

        button_log.setOnClickListener(
                new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {
                        Intent intent = new Intent("com.example.mxk1yyp.hackaton.Main3Activity");
                        startActivity(intent);
                    }
                }
        );
    }
}
